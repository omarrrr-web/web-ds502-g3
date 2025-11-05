<?php
include "../template/loadclass.php"; 

$crudAsignacion = new CRUDAsignaciones();
$asignacion = new Asignacion();

if (isset($_POST["txt_tipo"])) {
    $tipo = $_POST["txt_tipo"];

    // Asignar valores del formulario
    $asignacion->id_empleado = $_POST["cmb_empleado"];
    $asignacion->id_activo = $_POST["cmb_activo"];
    $asignacion->fecha_devolucion = !empty($_POST["txt_fecha_devolucion"]) ? $_POST["txt_fecha_devolucion"] : null;
    $asignacion->notas = $_POST["txt_notas"];

    if ($tipo == "r") {
        // Registrar nueva asignación
        $crudAsignacion->RegistrarAsignacion($asignacion);

    } elseif ($tipo == "e") {
        // Editar asignación existente
        $asignacion->id_asignacion = $_POST["txt_id_asignacion"];
        $crudAsignacion->EditarAsignacion($asignacion);
    }

    // Redirigir al listado después de guardar
    header("location: ../view/asignaciones/listar_asignaciones.php");
    exit();
}
?>
