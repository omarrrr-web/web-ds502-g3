<?php
include "../template/loadclass.php"; 

if (isset($_POST['idmant'])) {
    $id_mant = $_POST['idmant'];
    $crud_mant = new CRUDRegistrosMantenimiento(); 
    $mantenimiento = $crud_mant->BuscarMantenimientoPorId($id_mant); 
    
    if ($mantenimiento) {
        $html = '<table class="table table-sm table-bordered">';
        $html .= '<tr><th>ID Mantenimiento</th><td>' . $mantenimiento->id_mantenimiento . '</td></tr>';
        $html .= '<tr><th>Activo</th><td>' . $mantenimiento->activo_nombre . '</td></tr>';
        $html .= '<tr><th>Serial</th><td>' . $mantenimiento->serial_number . '</td></tr>';
        $html .= '<tr><th>Fecha Servicio</th><td>' . $mantenimiento->fecha_servicio . '</td></tr>';
        $html .= '<tr><th>Descripción</th><td>' . nl2br($mantenimiento->descripcion) . '</td></tr>';
        $html .= '<tr><th>Costo</th><td>S/ ' . number_format($mantenimiento->costo, 2) . '</td></tr>';
        $html .= '<tr><th>Realizado Por</th><td>' . $mantenimiento->empleado_nombre . '</td></tr>';
        $html .= '</table>';
        
        echo $html;
    } else {
        echo '<div class="alert alert-warning">Registro de mantenimiento no encontrado.</div>';
    }
}
?>
