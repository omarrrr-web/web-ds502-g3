<?php
    include "../template/loadclass.php";

    if (isset($_POST["id_empleado"])){
        $id_empleado = $_POST["id_empleado"];

        $crud = new CRUDEmpleado();
        $crud->DesactivarEmpleado($id_empleado);

        // Enviar una respuesta de éxito
        echo json_encode(["status" => "success"]);
    } else {
        // Enviar una respuesta de error
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(["status" => "error", "message" => "ID de empleado no proporcionado"]);
    }
?>