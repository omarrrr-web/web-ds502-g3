<?php
// Incluir el autoloader para cargar CRUDLicencia y Conexion
include "../template/loadclass.php"; 

$crudlicencia = new CRUDLicencia();

// 1. Verificar si se recibió el valor de filtro por POST (enviado por JavaScript)
if (isset($_POST["valor"])) {
    
    $valor_filtro = $_POST["valor"];
    
    // 2. Llamar al método del Modelo que genera y devuelve el HTML de la tabla
    // El método FiltrarLicencias en el Modelo ya hace el 'echo $html;'
    $crudlicencia->FiltrarLicencias($valor_filtro);
}
// Nota: No hay redirección (header) porque la respuesta debe ir a la función AJAX.
?>

<?php include("../template/footer.php"); ?>