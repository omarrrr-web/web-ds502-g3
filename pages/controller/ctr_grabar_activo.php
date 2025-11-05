<?php
// Incluir el autoloader para cargar CRUDActivos, Activo y Conexion
include "../template/loadclass.php"; 

$crudactivos = new CRUDActivos();
$activo = new Activo();

// 1. Verificar si se ha enviado el formulario (usamos txt_tipo que existe en ambos formularios)
if (isset($_POST["txt_tipo"])) {
    
    $tipo = $_POST["txt_tipo"]; 
    
    // 2. Captura de datos comunes a Registro y Edición
    $activo->id_categoria = (int)$_POST["cbo_id_cat"]; 
    $activo->serial_number = $_POST["txt_serial"];
    $activo->marca = $_POST["txt_marca"];
    $activo->modelo = $_POST["txt_modelo"];
    $activo->fecha_compra = $_POST["txt_fecha_compra"];
    $activo->precio = (float)$_POST["txt_precio"];
    $activo->estado = $_POST["cbo_estado"];

    $success = false;
    if ($tipo == "r") {
        // OPERACIÓN: REGISTRO (Create)
        $crudactivos->RegistrarActivo($activo);
        $success = true;
    
    } elseif ($tipo == "e") {
        // OPERACIÓN: EDICIÓN (Update)
        $activo->id_activo = (int)$_POST["txt_id_act"];
        $crudactivos->EditarActivo($activo);
        $success = true;
    }

    // 4. Finalizar la operación
    if (isset($_POST['is_ajax']) && $_POST['is_ajax'] == '1') {
        header('Content-Type: application/json');
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Operación completada con éxito.']);
        } else {
            // Aunque en esta lógica simple siempre es exitoso, se prepara para el futuro
            echo json_encode(['success' => false, 'message' => 'Ocurrió un error.']); 
        }
        exit();
    } else {
        // Redirección para formularios no-AJAX
        $param = ($tipo == 'e') ? 'edicion=exito' : 'registro=exito';
        header("location: ../view/activos/listar_activos.php?" . $param);
        exit();
    }

} else {
    // Si se accede directamente al controlador sin datos POST, redirigir al listado
    header("location: ../view/activos/listar_activos.php");
    exit();
}
?>