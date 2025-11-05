<?php
include "../template/loadclass.php"; 

$crudcategoria = new CRUDCategoria();

if (isset($_POST["txt_valor"])) {
    $valor = $_POST["txt_valor"];
    // Llama al método que devuelve la tabla HTML directamente
    $crudcategoria->FiltrarCategoria($valor);
}
?>