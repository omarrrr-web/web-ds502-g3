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
        $success = true;
    
    } elseif ($tipo == "e") {
        // Lógica de EDICIÓN: Necesita el ID de la categoría
        $categoria->id_categoria = $_POST["txt_id_cat"];
        $crudcategoria->EditarCategoria($categoria);
        $success = true;
    }

    // Finalizar la operación
    if (isset($_POST['is_ajax']) && $_POST['is_ajax'] == '1') {
        header('Content-Type: application/json');
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Operación completada con éxito.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Ocurrió un error.']); 
        }
        exit();
    } else {
        // Redirección para formularios no-AJAX
        $param = ($tipo == 'e') ? 'edicion=exito' : 'registro=exito';
        header("location: ../view/categoria/listar_categoria.php?" . $param);
        exit();
    }
}
?>