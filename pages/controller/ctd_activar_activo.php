<?php
    include "../template/loadclass.php";

    if (isset($_POST["id_activo"])){
        $id_activo = $_POST["id_activo"];

        $crud = new CRUDActivos();
        $crud->ActivarActivo($id_activo);

        // Enviar una respuesta de éxito
        echo json_encode(["status" => "success"]);
    } else {
        // Enviar una respuesta de error
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(["status" => "error", "message" => "ID de activo no proporcionado"]);
    }
?>