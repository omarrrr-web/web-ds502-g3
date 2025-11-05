<?php
include "../template/loadclass.php"; 

$crudAsignacion = new CRUDAsignaciones();
$asignacion = new Asignacion();

if (isset($_POST["txt_tipo"])) {
    $tipo = $_POST["txt_tipo"];

    if ($tipo == "r") {
        // Registrar nueva asignación
        $asignacion->id_empleado = $_POST["cmb_empleado"];
        $asignacion->id_activo = $_POST["cmb_activo"];
        $asignacion->fecha_devolucion = !empty($_POST["txt_fecha_devolucion"]) ? $_POST["txt_fecha_devolucion"] : null;
        $asignacion->notas = $_POST["txt_notas"];
        $crudAsignacion->RegistrarAsignacion($asignacion);
        header("location: ../view/asignacion/listar_asignaciones.php?registro=exito");

    } elseif ($tipo == "e") {
        // Editar asignación existente
        $asignacion->id_asignacion = $_POST["txt_id_asig"];
        $asignacion->id_empleado = $_POST["txt_id_empleado"];
        $asignacion->id_activo = $_POST["txt_id_activo"];
        $asignacion->fecha_asignacion = $_POST["txt_fecha_asignacion"];
        $asignacion->fecha_devolucion = !empty($_POST["txt_fecha_devolucion"]) ? $_POST["txt_fecha_devolucion"] : null;
        $asignacion->notas = $_POST["txt_notas"];
        $crudAsignacion->EditarAsignacion($asignacion);
        header("location: ../view/asignacion/listar_asignaciones.php?edicion=exito");
    }

    exit();
}
?>