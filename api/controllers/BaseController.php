<?php

abstract class BaseController {
    protected $pdo;
    protected $table;
    protected $primary_key;

    public function __construct($pdo, $table, $primary_key) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primary_key = $primary_key;
    }

    public function handleGet($id) {
        if ($id) {
            $this->getById($id);
        } else {
            $this->getAll();
        }
    }

    public function handlePost() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data)) {
            $this->sendResponse(400, ["error" => "No se recibieron datos para crear el registro."]);
            return;
        }
        $this->create($data);
    }

    public function handlePut($id) {
        if (!$id) {
            $this->sendResponse(400, ["error" => "ID no especificado para actualizar."]);
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data)) {
            $this->sendResponse(400, ["error" => "No se recibieron datos para actualizar el registro."]);
            return;
        }
        $this->update($id, $data);
    }

    public function handleDelete($id) {
        if (!$id) {
            $this->sendResponse(400, ["error" => "ID no especificado para eliminar."]);
            return;
        }
        $this->delete($id);
    }

    protected function getAll() {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->sendResponse(200, $results);
    }

    protected function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$this->primary_key} = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->sendResponse(200, $result);
        } else {
            $this->sendResponse(404, ["error" => "Registro no encontrado."]);
        }
    }

    protected function create($data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        $values = array_values($data);
        
        if ($stmt->execute($values)) {
            $lastId = $this->pdo->lastInsertId();
            $this->sendResponse(201, ["message" => "Registro creado exitosamente.", "id" => $lastId]);
        } else {
            $this->sendResponse(500, ["error" => "Error al crear el registro."]);
        }
    }

    protected function update($id, $data) {
        $set_clauses = [];
        $values = [];
        foreach ($data as $column => $value) {
            $set_clauses[] = "$column = ?";
            $values[] = $value;
        }
        $values[] = $id;

        $sql = "UPDATE {$this->table} SET " . implode(', ', $set_clauses) . " WHERE {$this->primary_key} = ?";
        $stmt = $this->pdo->prepare($sql);
        
        if ($stmt->execute($values)) {
            $this->sendResponse(200, ["message" => "Registro actualizado exitosamente."]);
        } else {
            $this->sendResponse(500, ["error" => "Error al actualizar el registro."]);
        }
    }

    protected function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primary_key} = ?";
        $stmt = $this->pdo->prepare($sql);
        
        if ($stmt->execute([$id])) {
            if ($stmt->rowCount() > 0) {
                $this->sendResponse(200, ["message" => "Registro eliminado exitosamente."]);
            } else {
                $this->sendResponse(404, ["error" => "Registro no encontrado para eliminar."]);
            }
        } else {
            $this->sendResponse(500, ["error" => "Error al eliminar el registro."]);
        }
    }

    protected function sendResponse($statusCode, $data) {
        http_response_code($statusCode);
        echo json_encode($data);
    }
}
