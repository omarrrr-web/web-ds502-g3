<?php
// Incluir el autoloader para cargar CRUDLicencia y CRUDCategoria
include "../template/loadclass.php"; 

$crudlicencia = new CRUDLicencia();
$crudcategoria = new CRUDCategoria(); 

// 1. Verificar si se recibió el ID de la licencia por POST (clave: 'idlic')
if (isset($_POST['idlic'])) {
    
    $id_licencia = $_POST['idlic'];
    
    // 2. Buscar la licencia por ID
    $licencia = $crudlicencia->BuscarLicenciaPorId($id_licencia);
    
    // 3. Generar el HTML de la tarjeta de detalles
    if ($licencia) {
        
        // Buscar el nombre de la categoría (necesario para mostrar la relación)
        $categoria = $crudcategoria->BuscarCategoriaPorId($licencia->id_categoria);
        $nombre_categoria = $categoria->nombre_categoria ?? 'No Asignada';
        
        // Determinar el estado de la fecha de expiración para el formato
        $expira = $licencia->fecha_expiracion;
        $clase_exp = '';
        
        if ($expira) {
            $estado_expira = date('d/m/Y', strtotime($expira));
            
            // Si expira en los próximos 6 meses, marcar con advertencia
            if (strtotime($expira) < strtotime('+6 months')) {
                $clase_exp = 'fw-bold text-warning';
            }
        } else {
            $estado_expira = 'PERPETUA / INDEFINIDA';
        }


        // Generación de la tabla HTML para el modal
        $html = '<table class="table table-sm table-striped">';
        
        $html .= '<tr><th style="width:35%;">ID Licencia</th><td>' . $licencia->id_licencia . '</td></tr>';
        $html .= '<tr><th>Software</th><td>' . $licencia->nombre_software . '</td></tr>';
        $html .= '<tr><th>Clave Licencia</th><td class="fw-bold">' . $licencia->clave_licencia . '</td></tr>';
        $html .= '<tr><th>Categoría</th><td>' . $nombre_categoria . '</td></tr>';
        $html .= '<tr><th>Usuarios/Asientos</th><td>' . $licencia->cantidad_usuarios . '</td></tr>';
        $html .= '<tr><th>Fecha Expiración</th><td class="' . $clase_exp . '">' . $estado_expira . '</td></tr>';
        
        $html .= '</table>';
        
        echo $html;
    } else {
        // Mensaje si no se encuentra la licencia
        echo '<div class="alert alert-warning">Licencia ID ' . $id_licencia . ' no encontrada.</div>';
    }
}
?>