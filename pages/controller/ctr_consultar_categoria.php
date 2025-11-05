<?php
include "../template/loadclass.php"; 

$crudcategoria = new CRUDCategoria();

if (isset($_POST["id_cat"])) {
    $id_categoria = $_POST["id_cat"];
    // Llama al método que devuelve JSON directamente
    $crudcategoria->ConsultarCategoriaPorId($id_categoria); 
}
?>