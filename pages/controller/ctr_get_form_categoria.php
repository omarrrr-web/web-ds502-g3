<?php
// Incluir el autoloader para cargar las clases necesarias
include "../template/loadclass.php";

// Verificar que se reciba el ID de la categoría por POST
if (!isset($_POST['idcat'])) {
    die("<div class='alert alert-danger'>No se proporcionó un ID de categoría.</div>");
}

$id_cat = $_POST['idcat'];

// Instanciar el CRUD
$crudcategoria = new CRUDCategoria();

// Buscar la categoría
$categoria_actual = $crudcategoria->BuscarCategoriaPorId($id_cat);

// Si la categoría no se encuentra, mostrar un error
if (!$categoria_actual) {
    die("<div class='alert alert-danger'>Categoría no encontrada.</div>");
}

// Generar el HTML del formulario
?>
<form id="frm_editar_cat_modal" name="frm_editar_cat_modal" method="post" action="../../controller/ctr_grabar_categoria.php" autocomplete="off">
    
    <input type="hidden" name="txt_tipo" value="e">
    <input type="hidden" name="txt_id_cat" value="<?= $categoria_actual->id_categoria ?>">
    <input type="hidden" name="is_ajax" value="1"> <!-- Campo clave para la respuesta JSON -->

    <div class="row mb-3">
        <div class="col-md-12">
            <label for="txt_nombre_cat_modal" class="form-label">Nombre Categoría</label>
            <input type="text" class="form-control" id="txt_nombre_cat_modal" name="txt_nombre_cat" 
                   placeholder="Ej: Laptop" maxlength="100" required autofocus 
                   value="<?= $categoria_actual->nombre_categoria ?>">
        </div>
    </div>

    <div class="modal-footer mt-4">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success" id="btn_actualizar_cat_modal">
            <i class="fas fa-sync-alt"></i> Actualizar
        </button>
    </div>
</form>
