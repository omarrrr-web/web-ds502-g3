<?php
    include "../../template/loadclass.php";

    if(isset($_POST["btn_editar_asignacion"])){

        $id_asignacion      = $_POST["id_asignacion"];
        $id_empleado        = $_POST["id_empleado"];
        $id_activo          = $_POST["id_activo"];
        $fecha_asignacion   = $_POST["fecha_asignacion"];
        $fecha_devolucion   = $_POST["fecha_devolucion"];
        $notas              = $_POST["notas"];

        $crud = new CRUDAsignaciones();
        $crud->EditarAsignacion($id_asignacion, $id_empleado, $id_activo, $fecha_asignacion, $fecha_devolucion, $notas);

        // redirige a la lista con parametro de exito
        header("location: ../view/asignacion/listar_asignaciones.php?edicion=exito");
    }
?>