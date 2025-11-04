<?php
    include("../template/loadclass.php");

    $crudrol = new CRUDRol();
    $roles = [];
    $accion = $_POST['accion'] ?? 'listar_roles';

    switch ($accion) {
        case 'listar_roles':
        default:
            $roles = $crudrol->ListarRoles();
            break;
    }

    // Incluimos la vista parcial que generará la tabla.
    // La vista espera que la variable $roles esté definida.
    include("../view/rol/_tabla_roles.php");
?>