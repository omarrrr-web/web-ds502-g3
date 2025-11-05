<?php
// Incluir el autoloader para cargar las clases necesarias
include "../template/loadclass.php";

// Verificar que se reciba el ID del activo por POST
if (!isset($_POST['idact'])) {
    die("<div class='alert alert-danger'>No se proporcionó un ID de activo.</div>");
}

$id_act = $_POST['idact'];

// Instanciar los CRUDs
$crudactivos = new CRUDActivos();
$crudcategoria = new CRUDCategoria();

// Buscar el activo y la lista de categorías
$activo_actual = $crudactivos->BuscarActivoPorId($id_act);
$rs_categorias = $crudcategoria->ListarCategoria();

// Si el activo no se encuentra, mostrar un error
if (!$activo_actual) {
    die("<div class='alert alert-danger'>Activo no encontrado.</div>");
}

// Generar el HTML del formulario (sin la página completa)
?>
<form id="frm_editar_activo_modal" name="frm_editar_activo_modal" method="post" action="../../controller/ctr_grabar_activo.php" autocomplete="off">
    
    <input type="hidden" name="txt_tipo" value="e">
    <input type="hidden" name="txt_id_act" value="<?= $activo_actual->id_activo ?>">
    <input type="hidden" name="is_ajax" value="1">  <!-- Campo clave para la respuesta JSON -->

    <div class="row g-3">
        
        <div class="col-md-6">
            <label for="txt_serial" class="form-label">Número de Serie</label>
            <input type="text" class="form-control" id="txt_serial" name="txt_serial" 
                   maxlength="255" readonly 
                   value="<?= $activo_actual->serial_number ?>">
        </div>

        <div class="col-md-6">
            <label for="cbo_id_cat" class="form-label">Categoría</label>
            <select class="form-select" id="cbo_id_cat" name="cbo_id_cat" required>
                <option value="">Seleccione Categoría</option>
                <?php 
                foreach ($rs_categorias as $cat) {
                    $selected = ($cat->id_categoria == $activo_actual->id_categoria) ? 'selected' : '';
                    echo "<option value=\"{$cat->id_categoria}\" {$selected}>{$cat->nombre_categoria}</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="col-md-4">
            <label for="txt_marca" class="form-label">Marca</label>
            <input type="text" class="form-control" id="txt_marca" name="txt_marca" 
                   maxlength="100" value="<?= $activo_actual->marca ?>">
        </div>

        <div class="col-md-4">
            <label for="txt_modelo" class="form-label">Modelo</label>
            <input type="text" class="form-control" id="txt_modelo" name="txt_modelo" 
                   maxlength="100" value="<?= $activo_actual->modelo ?>">
        </div>
        
        <div class="col-md-4">
            <label for="cbo_estado" class="form-label">Estado Actual</label>
            <select class="form-select" id="cbo_estado" name="cbo_estado" required>
                <?php 
                $estados = ['En uso', 'Almacenado', 'Mantenimiento', 'Baja'];
                foreach ($estados as $estado) {
                    $selected = ($estado == $activo_actual->estado) ? 'selected' : '';
                    echo "<option value=\"{$estado}\" {$selected}>{$estado}</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-6">
            <label for="txt_fecha_compra" class="form-label">Fecha de Compra</label>
            <input type="date" class="form-control" id="txt_fecha_compra" name="txt_fecha_compra"
                   value="<?= $activo_actual->fecha_compra ?>">
        </div>
        
        <div class="col-md-6">
            <label for="txt_precio" class="form-label">Precio (S/)</label>
            <input type="number" step="0.01" class="form-control" id="txt_precio" name="txt_precio" 
                   min="0" value="<?= $activo_actual->precio ?>">
        </div>

    </div>

    <div class="modal-footer mt-4">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success" id="btn_actualizar_modal">
            <i class="fas fa-sync-alt"></i> Actualizar
        </button>
    </div>
</form>