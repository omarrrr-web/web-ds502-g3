<?php
    include("../template/loadclass.php");

    header('Content-Type: application/json');
    $response = [];

    if (isset($_POST["id_rol"])) {
        $id_rol = $_POST["id_rol"];
        $crud = new CRUDRol();
        $rol = $crud->BuscarRolPorId($id_rol);

        if ($rol) {
            $response['success'] = true;
            $response['rol'] = $rol;
        } else {
            $response['success'] = false;
        }
    } else {
        $response['success'] = false;
    }

    echo json_encode($response);
?>