<?php
// Incluir el autoloader para cargar CRUDLicencia y Conexion
include "../template/loadclass.php"; 

// 1. Usar la clase CRUDLicencia
$crudlicencia = new CRUDLicencia();

// 2. Verificar si se recibió el ID de la licencia por URL (GET)
if (isset($_GET["id_lic"])) {
    
    // Capturar la variable de la Licencia
    $id_licencia = $_GET["id_lic"];
    
    // 3. Llamar al método del Modelo: BorrarLicencia
    $crudlicencia->BorrarLicencia($id_licencia);
    
    // 4. Redirigir al listado de licencias
    header("location: ../view/licencias/listar_licencias.php");
    exit();
} else {
    // Si no se recibe el ID, redirigir al listado
    header("location: ../view/licencias/listar_licencias.php");
    exit();
}
?>