<?php
include "../template/loadclass.php";

if (isset($_POST["valor"])) {
    $valor = $_POST["valor"];
    $crud = new CRUDRegistrosMantenimiento();
    $crud->FiltrarMantenimientos($valor);
} else {
    echo '<div class="alert alert-danger">Error: No se especificó un valor de búsqueda.</div>';
}
?>
