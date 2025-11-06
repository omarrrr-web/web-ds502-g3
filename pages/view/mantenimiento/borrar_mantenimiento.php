<?php
include("../../template/loadclass.php");

if (!isset($_GET['idmant'])) {
    header("Location: listar_mantenimientos.php");
    exit();
}

$id_mant = (int)$_GET['idmant'];
$crud_mant = new CRUDRegistrosMantenimiento();

try {
    $crud_mant->BorrarMantenimiento($id_mant);
    header("Location: listar_mantenimientos.php?borrado=exito");
} catch (Exception $e) {
    header("Location: listar_mantenimientos.php?borrado=error");
}
exit();
?>
