<?php
// Incluir el autoloader para cargar las clases
include "../template/loadclass.php";

// Verificar si se recibió el parámetro 'valor' por POST
if (isset($_POST["valor"])) {
    
    // Capturar el valor de búsqueda
    $valor = $_POST["valor"];
    
    // Crear una instancia de CRUDActivos
    $crud = new CRUDActivos();
    
    // Llamar al método de filtrado, que ya imprime la tabla HTML
    $crud->FiltrarActivos($valor);
    
} else {
    // Si no se recibe el parámetro, mostrar un mensaje de error
    echo '<div class="alert alert-danger">Error: No se especificó un valor de búsqueda.</div>';
}
?>