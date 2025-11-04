<?php
    include("../template/loadclass.php");

    if (isset($_POST["btn_registrar"])) {
        $nombre_rol = $_POST["nombre_rol"];

        $rol = new Rol();
        $rol->setNombre_rol($nombre_rol);

        $crud = new CRUDRol();
        $res = $crud->RegistrarRol($rol);

        if ($res) {
            header("Location: ../view/rol/listar.php?registro=exito");
        } else {
            header("Location: ../view/rol/listar.php?registro=error");
        }
        exit();
    }
?>