<?php
// Incluir el autoloader para cargar CRUDLicencia, Licencia y Conexion
include "../template/loadclass.php"; 

$crudlicencia = new CRUDLicencia();
$licencia = new Licencia();

// 1. Verificar si se ha enviado el formulario (usamos txt_tipo para saber si es Registro o Edición)
if (isset($_POST["txt_tipo"])) {
    
    $tipo = $_POST["txt_tipo"]; 
    $is_ajax = isset($_POST['is_ajax']) && $_POST['is_ajax'] == 1;

    // 2. Captura de datos
    if ($is_ajax) {
        // Datos desde el modal AJAX
        $licencia->id_categoria = (int)$_POST["cbo_id_cat"]; 
        $licencia->nombre_software = $_POST["txt_nombre_software"];
        $licencia->clave_licencia = $_POST["txt_clave_licencia"];
        $licencia->cantidad_usuarios = (int)$_POST["txt_cantidad_usuarios"];
        $licencia->fecha_expiracion = empty($_POST["txt_fecha_expiracion"]) ? NULL : $_POST["txt_fecha_expiracion"];
    } else {
        // Datos desde el formulario tradicional
        $licencia->id_categoria = (int)$_POST["cbo_id_cat"]; 
        $licencia->nombre_software = $_POST["txt_nombre"];
        $licencia->clave_licencia = $_POST["txt_clave"];
        $licencia->cantidad_usuarios = (int)$_POST["txt_cantidad"];
        $licencia->fecha_expiracion = empty($_POST["txt_expiracion"]) ? NULL : $_POST["txt_expiracion"];
    }

    if ($tipo == "r") {
        // OPERACIÓN: REGISTRO (Create)
        $crudlicencia->RegistrarLicencia($licencia);
    
    } elseif ($tipo == "e") {
        // OPERACIÓN: EDICIÓN (Update)
        $licencia->id_licencia = (int)$_POST["txt_id_lic"];
        $crudlicencia->EditarLicencia($licencia);
    }

    // 4. Responder
    if ($is_ajax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit();
    } else {
        // Redirigir al listado de licencias después de la operación
        header("location: ../view/licencias/listar_licencias.php");
        exit();
    }

} else {
    // Si se accede directamente al controlador sin datos POST, redirigir al listado
    header("location: ../view/licencias/listar_licencias.php");
    exit();
}
?>