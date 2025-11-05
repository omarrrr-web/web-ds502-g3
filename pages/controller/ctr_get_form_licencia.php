<?php
// Incluir el autoloader para cargar las clases necesarias
include "../template/loadclass.php";

// Verificar si se recibió el ID de la licencia por POST
if (!isset($_POST['idlic'])) {
    echo '<div class="alert alert-danger">Error: No se proporcionó un ID de licencia.</div>';
    exit();
}

// --- Lógica para obtener los datos ---
$id_lic = $_POST['idlic'];
$crudlicencia = new CRUDLicencia();
$crudcategoria = new CRUDCategoria();

$licencia_actual = $crudlicencia->BuscarLicenciaPorId($id_lic);
$rs_categorias = $crudcategoria->ListarCategoria();

if (!$licencia_actual) {
    echo '<div class="alert alert-danger">Licencia no encontrada.</div>';
    exit();
}

// --- Generar el HTML del Formulario ---
?>
<form id="frm_editar_licencia_modal" name="frm_editar_licencia_modal" method="post" action="../../controller/ctr_grabar_licencia.php" autocomplete="off">
    
    <input type="hidden" name="txt_tipo" value="e">
    <input type="hidden" name="txt_id_lic" value="<?= $licencia_actual->id_licencia ?>">
    <input type="hidden" name="is_ajax" value="1"> <!-- Importante para el controlador de guardado -->

    <div class="row g-3">
        
        <div class="col-md-6">
            <label for="txt_nombre_software_modal" class="form-label">Nombre del Software</label>
            <input type="text" class="form-control" id="txt_nombre_software_modal" name="txt_nombre_software" readonly value="<?= htmlspecialchars($licencia_actual->nombre_software) ?>">
        </div>

        <div class="col-md-6">
            <label for="cbo_id_cat_modal" class="form-label">Categoría</label>
            <select class="form-select" id="cbo_id_cat_modal" name="cbo_id_cat" required>
                <option value="">Seleccione Categoría</option>
                <?php 
                foreach ($rs_categorias as $cat) {
                    $selected = ($cat->id_categoria == $licencia_actual->id_categoria) ? 'selected' : '';
                    echo "<option value=\"{$cat->id_categoria}\" {$selected}>" . htmlspecialchars($cat->nombre_categoria) . "</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="col-md-12">
            <label for="txt_clave_licencia_modal" class="form-label">Clave de Licencia</label>
            <input type="text" class="form-control" id="txt_clave_licencia_modal" name="txt_clave_licencia" maxlength="100" value="<?= htmlspecialchars($licencia_actual->clave_licencia) ?>">
        </div>

        <div class="col-md-6">
            <label for="txt_fecha_expiracion_modal" class="form-label">Fecha de Expiración</label>
            <input type="date" class="form-control" id="txt_fecha_expiracion_modal" name="txt_fecha_expiracion" value="<?= htmlspecialchars($licencia_actual->fecha_expiracion) ?>">
        </div>
        
        <div class="col-md-6">
            <label for="txt_cantidad_usuarios_modal" class="form-label">Cantidad de Usuarios</label>
            <input type="number" class="form-control" id="txt_cantidad_usuarios_modal" name="txt_cantidad_usuarios" min="1" value="<?= htmlspecialchars($licencia_actual->cantidad_usuarios) ?>">
        </div>

    </div>

    <div class="modal-footer mt-4">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success" id="btn_actualizar_modal"><i class="fas fa-sync-alt"></i> Actualizar</button>
    </div>
</form>
