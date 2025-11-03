<?php
    include("../template/loadclass.php");

    if (isset($_POST["btn_editar"])) {
        $id_rol = $_POST["id_rol"];
        $nombre_rol = $_POST["nombre_rol"];

        $rol = new Rol();
        $rol->setId_rol($id_rol);
        $rol->setNombre_rol($nombre_rol);

        $crud = new CRUDRol();
        $res = $crud->EditarRol($rol);

        if ($res) {
            header("Location: ../view/rol/listar.php?edicion=exito");
        } else {
            header("Location: ../view/rol/listar.php?edicion=error");
        }
        exit();
    }
?>