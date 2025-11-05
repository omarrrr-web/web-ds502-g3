<?php
include "../template/loadclass.php"; 

if (isset($_POST['idact'])) {
    $id_act = $_POST['idact'];
    $crud_act = new CRUDActivos(); 
    $activo = $crud_act->BuscarActivoPorId($id_act); 
    
    // Aquí se genera el HTML de la tarjeta de detalles
    if ($activo) {
        // En lugar de incluir mostrar_activo.php, generamos el HTML de la tarjeta
        $html = '<table class="table table-sm table-bordered">';
        $html .= '<tr><th>ID</th><td>' . $activo->id_activo . '</td></tr>';
        $html .= '<tr><th>Serial</th><td>' . $activo->serial_number . '</td></tr>';
        $html .= '<tr><th>Marca/Modelo</th><td>' . $activo->marca . ' / ' . $activo->modelo . '</td></tr>';
        $html .= '<tr><th>Estado</th><td><span class="badge bg-warning text-dark">' . $activo->estado . '</span></td></tr>';
        $html .= '<tr><th>Fecha Compra</th><td>' . $activo->fecha_compra . '</td></tr>';
        $html .= '<tr><th>Precio</th><td>S/ ' . number_format($activo->precio, 2) . '</td></tr>';
        $html .= '</table>';
        
        echo $html;
    } else {
        echo '<div class="alert alert-warning">Activo no encontrado.</div>';
    }
}
?>