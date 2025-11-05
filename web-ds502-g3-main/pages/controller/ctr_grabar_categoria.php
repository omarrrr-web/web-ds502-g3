<?php
include "../template/loadclass.php"; 

$crudcategoria = new CRUDCategoria();
$categoria = new Categoria();

if (isset($_POST["txt_tipo"])) { // Usamos txt_tipo ya que está presente en ambos formularios
    
    $tipo = $_POST["txt_tipo"]; 
    $categoria->nombre_categoria = $_POST["txt_nombre_cat"];

    if ($tipo == "r") {
        // Lógica de Registro
        $crudcategoria->RegistrarCategoria($categoria);
    
    } elseif ($tipo == "e") {
        // Lógica de EDICIÓN: Necesita el ID de la categoría
        $categoria->id_categoria = $_POST["txt_id_cat"];
        $crudcategoria->EditarCategoria($categoria);
    }

    // Redirigir al listado después de la operación (ruta ajustada)
    header("location: ../view/categoria/listar_categoria.php");
    exit();
}
?>