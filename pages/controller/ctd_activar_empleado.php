<?php
    include "../template/loadclass.php";

    if (isset($_POST["id_empleado"])){
        $id_empleado = $_POST["id_empleado"];

        $crud = new CRUDEmpleado();
        $crud->ActivarEmpleado($id_empleado);

        // Enviar una respuesta de éxito
        echo json_encode(["status" => "success"]);
    } 
?>