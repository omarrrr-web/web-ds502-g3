<?php
// Incluir el autoloader para cargar CRUDLicencia y Conexion
include "../template/loadclass.php"; 

// 1. Usar la clase CRUDLicencia
$crudlicencia = new CRUDLicencia();

// 2. Verificar si se recibió el ID de la licencia por URL (GET)
if (isset($_GET["idlic"])) {
    
    // Capturar la variable de la Licencia
    $id_licencia = $_GET["idlic"];
    
    // 3. Llamar al método del Modelo y capturar el resultado
    $resultado = $crudlicencia->BorrarLicencia($id_licencia);
    
    // 4. Redirigir según el resultado
    if ($resultado) {
        header("location: ../view/licencias/listar_licencias.php?delete=exito");
    } else {
        header("location: ../view/licencias/listar_licencia.php?error=fk");
    }
    exit();
} else {
    // Si no se recibe el ID, redirigir al listado
    header("location: ../view/licencias/listar_licencias.php");
    exit();
}
?>