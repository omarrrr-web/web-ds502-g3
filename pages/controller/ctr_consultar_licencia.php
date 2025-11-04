<?php
// Incluir el autoloader para cargar CRUDLicencia y Conexion
include "../template/loadclass.php"; 

$crudlicencia = new CRUDLicencia();

// 1. Verificar si se recibió el ID de la licencia por POST (enviado por JavaScript)
if (isset($_POST["id_lic"])) {
    
    $id_licencia = $_POST["id_lic"];
    
    // 2. Llamar al método del Modelo que imprime la respuesta JSON directamente
    // Nota: Este método debe existir en crudlicencia.php
    $crudlicencia->ConsultarLicenciaPorId($id_licencia);
}
?>