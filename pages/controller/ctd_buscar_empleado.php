<?php
    include "../template/loadclass.php";

    if (isset($_POST["id_empleado"])){
        $id_empleado = $_POST["id_empleado"];

        $crudempleado = new CRUDEmpleado();
        $empleado = $crudempleado->BuscarEmpleadoPorId($id_empleado);

        // Se devuelven los datos en formato JSON
        if ($empleado){
            header('Content-Type: application/json');
            echo json_encode($empleado);
        } else {
            // En caso de no encontrar el empleado
            header("HTTP/1.1 404 Not Found");
            echo json_encode(["error" => "Empleado no encontrado"]);
        }
    }
?>