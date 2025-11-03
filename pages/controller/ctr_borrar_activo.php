<?php
// Incluir el autoloader para cargar CRUDActivos y Conexion
include "../template/loadclass.php"; 

// 1. Usar la clase CRUDActivos
$crudactivos = new CRUDActivos();

// 2. Verificar si se recibió el ID del activo por URL (GET)
//    La clave esperada es 'idact'
if (isset($_GET["idact"])) {
    
    // Capturar la variable del Activo
    $id_activo = $_GET["idact"];
    
    // 3. Llamar al método del Modelo: BorrarActivo
    $crudactivos->BorrarActivo($id_activo);
    
    // 4. Redirigir al listado de activos
    //    Ruta: Sube de 'controller' (../) y entra a 'view/activos/'
    header("location: ../view/activos/listar_activos.php");
    exit();
} else {
    // Si no se recibe el ID, redirigir al listado
    header("location: ../view/activos/listar_activos.php");
    exit();
}
?>