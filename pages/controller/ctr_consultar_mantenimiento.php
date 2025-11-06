<?php
include "../template/loadclass.php";

if (isset($_POST['idmant'])) {
    $id_mant = (int)$_POST['idmant'];
    $crud = new CRUDRegistrosMantenimiento();
    $mantenimiento = $crud->BuscarMantenimientoPorId($id_mant);
    
    if ($mantenimiento) {
        echo json_encode($mantenimiento);
    } else {
        echo json_encode(['error' => 'No se encontró el registro']);
    }
} else {
    echo json_encode(['error' => 'ID no especificado']);
}
?>
