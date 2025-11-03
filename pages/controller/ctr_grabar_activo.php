<?php
// Incluir el autoloader para cargar CRUDActivos, Activo y Conexion
include "../template/loadclass.php"; 

$crudactivos = new CRUDActivos();
$activo = new Activo();

// 1. Verificar si se ha enviado el formulario (usamos txt_tipo que existe en ambos formularios)
if (isset($_POST["txt_tipo"])) {
    
    $tipo = $_POST["txt_tipo"]; 
    
    // 2. Captura de datos comunes a Registro y Edición
    // Nota: El modelo espera que el ID de categoría sea un entero (int), ya que en la BD es INT.
    $activo->id_categoria = (int)$_POST["cbo_id_cat"]; 
    $activo->serial_number = $_POST["txt_serial"];
    $activo->marca = $_POST["txt_marca"];
    $activo->modelo = $_POST["txt_modelo"];
    $activo->fecha_compra = $_POST["txt_fecha_compra"];
    $activo->precio = (float)$_POST["txt_precio"];
    $activo->estado = $_POST["cbo_estado"];

    
    if ($tipo == "r") {
        // OPERACIÓN: REGISTRO (Create)
        $crudactivos->RegistrarActivo($activo);
    
    } elseif ($tipo == "e") {
        // OPERACIÓN: EDICIÓN (Update)
        
        // 3. Captura del ID que se va a editar
        $activo->id_activo = (int)$_POST["txt_id_act"];
        
        $crudactivos->EditarActivo($activo);
    }

    // 4. Redirigir al listado de activos después de la operación (ruta ajustada)
    // Ruta: Sube de 'controller' (../) y entra a 'view/activos/'
    header("location: ../view/activos/listar_activos.php");
    exit();
} else {
    // Si se accede directamente al controlador sin datos POST, redirigir al listado
    header("location: ../view/activos/listar_activos.php");
    exit();
}
?>