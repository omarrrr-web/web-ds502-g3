<?php
include "../template/loadclass.php"; 

$crudcategoria = new CRUDCategoria();

if (isset($_GET["id_cat"])) {
    $id_categoria = $_GET["id_cat"];
    $crudcategoria->BorrarCategoria($id_categoria);
    
    // Redirige al listado
    header("location: ../view/categoria/listar_categoria.php"); 
}
?>