<?php
    include("../template/loadclass.php");

    if (isset($_POST["id_rol"])) {
        $id_rol = $_POST["id_rol"];

        $crud = new CRUDRol();
        $res = $crud->EliminarRol($id_rol);

        header('Content-Type: application/json');
        if ($res) {
            echo json_encode(["status" => "success", "message" => "Rol eliminado correctamente."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al eliminar el rol."]);
        }
        exit();
    }
?>