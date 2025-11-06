<?php

require_once 'BaseController.php';

class EmpleadoController extends BaseController {
    public function __construct($pdo) {
        parent::__construct($pdo, 'empleados', 'id_empleado');
    }

    protected function delete($id) {
        $sql = "UPDATE {$this->table} SET activo = 0 WHERE {$this->primary_key} = ?";
        $stmt = $this->pdo->prepare($sql);
        
        if ($stmt->execute([$id])) {
            if ($stmt->rowCount() > 0) {
                $this->sendResponse(200, ["message" => "Registro desactivado (borrado lógico) exitosamente."]);
            } else {
                $this->sendResponse(404, ["error" => "Registro no encontrado para desactivar."]);
            }
        } else {
            $this->sendResponse(500, ["error" => "Error al desactivar el registro."]);
        }
    }
}
