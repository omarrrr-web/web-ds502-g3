<?php
// Incluir el autoloader para cargar CRUDCategoria
include "../template/loadclass.php"; 

$crudcategoria = new CRUDCategoria(); 

// 1. Verificar si se recibió el ID de la categoría por POST (clave: 'idcat')
if (isset($_POST['idcat'])) {
    
    $id_categoria = $_POST['idcat'];
    
    // 2. Buscar la categoría por ID
    $categoria = $crudcategoria->BuscarCategoriaPorId($id_categoria);
    
    // 3. Generar el HTML de la tarjeta de detalles
    if ($categoria) {
        // Generación de la tabla HTML para el modal
        $html = '<table class="table table-sm table-striped">';
        
        $html .= '<tr><th style="width:35%;">ID Categoría</th><td>' . $categoria->id_categoria . '</td></tr>';
        $html .= '<tr><th>Nombre Categoría</th><td>' . $categoria->nombre_categoria . '</td></tr>';
        
        $html .= '</table>';
        
        echo $html;
    } else {
        // Mensaje si no se encuentra la categoría
        echo '<div class="alert alert-warning">Categoría ID ' . htmlspecialchars($id_categoria) . ' no encontrada.</div>';
    }
}
?>