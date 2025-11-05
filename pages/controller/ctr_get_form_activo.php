<?php
// Incluir el autoloader para cargar las clases necesarias
include "../template/loadclass.php";

// Verificar si se recibió el ID del activo por POST
if (!isset($_POST['idact'])) {
    echo '<div class="alert alert-danger">Error: No se proporcionó un ID de activo.</div>';
    exit();
}

// --- Lógica para obtener los datos ---
$id_act = $_POST['idact'];
$crudactivos = new CRUDActivos();
$crudcategoria = new CRUDCategoria();

$activo_actual = $crudactivos->BuscarActivoPorId($id_act);
$rs_categorias = $crudcategoria->ListarCategoria();

if (!$activo_actual) {
    echo '<div class="alert alert-danger">Activo no encontrado.</div>';
    exit();
}

// --- Generar el HTML del Formulario ---
?>
<form id="frm_editar_activo_modal" name="frm_editar_activo_modal" method="post" action="../../controller/ctr_grabar_activo.php" autocomplete="off">
    
    <input type="hidden" name="txt_tipo" value="e">
    <input type="hidden" name="txt_id_act" value="<?= $activo_actual->id_activo ?>">
    <input type="hidden" name="is_ajax" value="1"> <!-- Importante para el controlador de guardado -->

    <div class="row g-3">
        
        <div class="col-md-6">
            <label for="txt_serial_modal" class="form-label">Número de Serie</label>
            <input type="text" class="form-control" id="txt_serial_modal" name="txt_serial" readonly value="<?= htmlspecialchars($activo_actual->serial_number) ?>">
        </div>

        <div class="col-md-6">
            <label for="cbo_id_cat_modal" class="form-label">Categoría</label>
            <select class="form-select" id="cbo_id_cat_modal" name="cbo_id_cat" required>
                <option value="">Seleccione Categoría</option>
                <?php 
                foreach ($rs_categorias as $cat) {
                    $selected = ($cat->id_categoria == $activo_actual->id_categoria) ? 'selected' : '';
                    echo "<option value=\"{$cat->id_categoria}\" {$selected}>" . htmlspecialchars($cat->nombre_categoria) . "</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="col-md-4">
            <label for="txt_marca_modal" class="form-label">Marca</label>
            <input type="text" class="form-control" id="txt_marca_modal" name="txt_marca" maxlength="100" value="<?= htmlspecialchars($activo_actual->marca) ?>">
        </div>

        <div class="col-md-4">
            <label for="txt_modelo_modal" class="form-label">Modelo</label>
            <input type="text" class="form-control" id="txt_modelo_modal" name="txt_modelo" maxlength="100" value="<?= htmlspecialchars($activo_actual->modelo) ?>">
        </div>
        
        <div class="col-md-4">
            <label for="cbo_estado_modal" class="form-label">Estado Actual</label>
            <select class="form-select" id="cbo_estado_modal" name="cbo_estado" required>
                <?php 
                $estados = ['En uso', 'Almacenado', 'Mantenimiento', 'Baja'];
                foreach ($estados as $estado) {
                    $selected = ($estado == $activo_actual->estado) ? 'selected' : '';
                    echo "<option value=\"{$estado}\" {$selected}>" . htmlspecialchars($estado) . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-6">
            <label for="txt_fecha_compra_modal" class="form-label">Fecha de Compra</label>
            <input type="date" class="form-control" id="txt_fecha_compra_modal" name="txt_fecha_compra" value="<?= htmlspecialchars($activo_actual->fecha_compra) ?>">
        </div>
        
        <div class="col-md-6">
            <label for="txt_precio_modal" class="form-label">Precio (S/)</label>
            <input type="number" step="0.01" class="form-control" id="txt_precio_modal" name="txt_precio" min="0" value="<?= htmlspecialchars($activo_actual->precio) ?>">
        </div>

    </div>

    <div class="modal-footer mt-4">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success" id="btn_actualizar_modal"><i class="fas fa-sync-alt"></i> Actualizar</button>
    </div>
</form>
