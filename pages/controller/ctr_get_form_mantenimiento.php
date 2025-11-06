<?php
include "../template/loadclass.php";

if (isset($_POST['idmant'])) {
    $id_mant = (int)$_POST['idmant'];
    $crud_mant = new CRUDRegistrosMantenimiento();
    $mantenimiento = $crud_mant->BuscarMantenimientoPorId($id_mant);
    
    $crudActivo = new CRUDActivos();
    $crudEmpleado = new CRUDEmpleado();
    $activos = $crudActivo->ListarActivos();
    $empleados = $crudEmpleado->ListarEmpleados();
    
    if ($mantenimiento) {
        ?>
        <form id="frm_editar_mant" name="frm_editar_mant" method="post" action="../../controller/ctr_grabar_mantenimiento.php" autocomplete="off">
            <input type="hidden" id="txt_tipo" name="txt_tipo" value="e">
            <input type="hidden" id="txt_id_mant" name="txt_id_mant" value="<?= $mantenimiento->id_mantenimiento ?>">

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="cmb_activo" class="form-label">Activo</label>
                    <select class="form-select" id="cmb_activo" name="cmb_activo" required>
                        <option value="">-- Seleccione --</option>
                        <?php foreach ($activos as $act): ?>
                            <option value="<?= $act->id_activo ?>" <?= ($act->id_activo == $mantenimiento->id_activo) ? 'selected' : '' ?>>
                                <?= $act->marca . ' ' . $act->modelo . ' (' . $act->serial_number . ')' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="txt_fecha_servicio" class="form-label">Fecha de Servicio</label>
                    <input type="date" class="form-control" id="txt_fecha_servicio" name="txt_fecha_servicio" value="<?= $mantenimiento->fecha_servicio ?>" required>
                </div>

                <div class="col-md-12">
                    <label for="txt_descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="txt_descripcion" name="txt_descripcion" rows="3" required><?= $mantenimiento->descripcion ?></textarea>
                </div>

                <div class="col-md-6">
                    <label for="txt_costo" class="form-label">Costo (S/)</label>
                    <input type="number" step="0.01" class="form-control" id="txt_costo" name="txt_costo" value="<?= $mantenimiento->costo ?>" min="0" required>
                </div>

                <div class="col-md-6">
                    <label for="cmb_empleado" class="form-label">Realizado Por</label>
                    <select class="form-select" id="cmb_empleado" name="cmb_empleado" required>
                        <option value="">-- Seleccione --</option>
                        <?php foreach ($empleados as $emp): ?>
                            <option value="<?= $emp->id_empleado ?>" <?= ($emp->id_empleado == $mantenimiento->realizado_por) ? 'selected' : '' ?>>
                                <?= $emp->nombre . ' ' . $emp->apellido ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success" id="btn_actualizar" name="btn_actualizar">
                    <i class="fas fa-save"></i> Actualizar Información
                </button>
            </div>
        </form>
        <?php
    } else {
        echo '<div class="alert alert-danger">No se encontró el registro.</div>';
    }
}
?>
