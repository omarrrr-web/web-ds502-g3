<?php
// Incluir el autoloader para cargar CRUDLicencia, Licencia y Conexion
include "../template/loadclass.php"; 

$crudlicencia = new CRUDLicencia();
$licencia = new Licencia();

// 1. Verificar si se ha enviado el formulario (usamos txt_tipo para saber si es Registro o Edición)
if (isset($_POST["txt_tipo"])) {
    
    $tipo = $_POST["txt_tipo"]; 
    
    // 2. Captura de datos comunes a Registro y Edición
    // Se convierten los IDs y cantidades a enteros para mayor seguridad
    $licencia->id_categoria = (int)$_POST["cbo_id_cat"]; 
    $licencia->nombre_software = $_POST["txt_nombre"];
    $licencia->clave_licencia = $_POST["txt_clave"];
    $licencia->cantidad_usuarios = (int)$_POST["txt_cantidad"];
    
    // La fecha de expiración puede ser NULL si es perpetua. 
    // Si el campo está vacío, enviamos NULL al modelo.
    $licencia->fecha_expiracion = empty($_POST["txt_expiracion"]) ? NULL : $_POST["txt_expiracion"];

    
    if ($tipo == "r") {
        // OPERACIÓN: REGISTRO (Create)
        $crudlicencia->RegistrarLicencia($licencia);
    
    } elseif ($tipo == "e") {
        // OPERACIÓN: EDICIÓN (Update)
        
        // 3. Captura del ID que se va a editar
        $licencia->id_licencia = (int)$_POST["txt_id_lic"]; // Asumiendo que el campo oculto se llamará txt_id_lic
        
        $crudlicencia->EditarLicencia($licencia);
    }

    // 4. Redirigir al listado de licencias después de la operación
    // Ruta: Sube de 'controller' (../) y entra a 'view/licencias/'
    header("location: ../view/licencias/listar_licencias.php");
    exit();
} else {
    // Si se accede directamente al controlador sin datos POST, redirigir al listado
    header("location: ../view/licencias/listar_licencias.php");
    exit();
}
?>