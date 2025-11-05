<?php
include "../template/loadclass.php"; 

$crudcategoria = new CRUDCategoria();

if (isset($_GET["id_cat"])) {
    $id_categoria = $_GET["id_cat"];
    $resultado = $crudcategoria->BorrarCategoria($id_categoria);
    
    if ($resultado) {
        // Redirige con parámetro de éxito
        header("location: ../view/categoria/listar_categoria.php?delete=exito"); 
    } else {
        // Redirige con parámetro de error de clave foránea
        header("location: ../view/categoria/listar_categoria.php?error=fk"); 
    }
}
?>