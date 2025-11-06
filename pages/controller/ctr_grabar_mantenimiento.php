<?php
include "../template/loadclass.php"; 

$crudMantenimiento = new CRUDRegistrosMantenimiento();
$mantenimiento = new RegistroMantenimiento();

if (isset($_POST["txt_tipo"])) {
    
    $tipo = $_POST["txt_tipo"]; 
    
    // Captura de datos comunes a Registro y Edición
    $mantenimiento->id_activo = (int)$_POST["cmb_activo"];
    $mantenimiento->fecha_servicio = $_POST["txt_fecha_servicio"];
    $mantenimiento->descripcion = $_POST["txt_descripcion"];
    $mantenimiento->costo = (float)$_POST["txt_costo"];
    $mantenimiento->realizado_por = (int)$_POST["cmb_empleado"];

    $success = false;
    if ($tipo == "r") {
        // OPERACIÓN: REGISTRO (Create)
        $crudMantenimiento->RegistrarMantenimiento($mantenimiento);
        $success = true;
    
    } elseif ($tipo == "e") {
        // OPERACIÓN: EDICIÓN (Update)
        $mantenimiento->id_mantenimiento = (int)$_POST["txt_id_mant"];
        $crudMantenimiento->EditarMantenimiento($mantenimiento);
        $success = true;
    }

    // Finalizar la operación
    if (isset($_POST['is_ajax']) && $_POST['is_ajax'] == '1') {
        header('Content-Type: application/json');
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Operación completada con éxito.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Ocurrió un error.']); 
        }
        exit();
    } else {
        // Redirección para formularios no-AJAX
        $param = ($tipo == 'e') ? 'edicion=exito' : 'registro=exito';
        header("location: ../view/mantenimiento/listar_mantenimientos.php?" . $param);
        exit();
    }

} else {
    header("location: ../view/mantenimiento/listar_mantenimientos.php");
    exit();
}
?>
