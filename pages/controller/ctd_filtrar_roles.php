<?php
    include("../template/loadclass.php");

    $crudrol = new CRUDRol();
    $termino_busqueda = $_POST['termino_busqueda'] ?? '';

    $roles = [];
    if (!empty($termino_busqueda)) {
        $roles = $crudrol->FiltrarRoles($termino_busqueda);
    } else {
        
    }

    include("../view/rol/_tabla_roles.php");
?>
