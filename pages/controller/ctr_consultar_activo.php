<?php
// Incluir el autoloader para cargar CRUDActivos y Conexion
include "../template/loadclass.php"; 

$crudactivos = new CRUDActivos();

// 1. Verificar si se recibió el ID del activo por POST (enviado por JavaScript)
if (isset($_POST["id_act"])) {
    
    $id_activo = $_POST["id_act"];
    
    // 2. Llamar al método del Modelo que imprime la respuesta JSON directamente
    // Nota: El método ConsultarActivoPorId en el Modelo ya hace el 'echo json_encode($data);'
    $crudactivos->ConsultarActivoPorId($id_activo);
}
// Importante: No hay redirección (header) porque la respuesta debe ir a la función AJAX.
?>