<?php
$route = "../../..";
$title = "Registrar Mantenimiento";
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");

$crudActivo = new CRUDActivos();
$crudEmpleado = new CRUDEmpleado();

$activos = $crudActivo->ListarActivos();
$empleados = $crudEmpleado->ListarEmpleados();
?>

<div class="container mt-3">
    <header>
        <h3 class="text-success"><i class="fas fa-plus-circle"></i> Registrar Mantenimiento</h3>
        <hr/>
    </header>

    <nav class="mb-3">
        <a href="listar_mantenimientos.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-circle-left"></i> Regresar
        </a>
    </nav>

    <section>
        <article>
            <div class="row justify-content-center">
                <div class="card col-md-8">
                    <div class="card-body">
                        <form id="frm_registrar_mant" name="frm_registrar_mant" method="post" action="../../controller/ctr_grabar_mantenimiento.php" autocomplete="off">

                            <input type="hidden" id="txt_tipo" name="txt_tipo" value="r">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="cmb_activo" class="form-label">Activo</label>
                                    <select class="form-select" id="cmb_activo" name="cmb_activo" required>
                                        <option value="">-- Seleccione --</option>
                                        <?php foreach ($activos as $act): ?>
                                            <option value="<?= $act->id_activo ?>">
                                                <?= $act->marca . ' ' . $act->modelo . ' (' . $act->serial_number . ')' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="txt_fecha_servicio" class="form-label">Fecha de Servicio</label>
                                    <input type="date" class="form-control" id="txt_fecha_servicio" name="txt_fecha_servicio" required>
                                </div>

                                <div class="col-md-12">
                                    <label for="txt_descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="txt_descripcion" name="txt_descripcion" rows="3" placeholder="Describa el trabajo realizado..." required></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label for="txt_costo" class="form-label">Costo (S/)</label>
                                    <input type="number" step="0.01" class="form-control" id="txt_costo" name="txt_costo" placeholder="0.00" min="0" value="0.00" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="cmb_empleado" class="form-label">Realizado Por</label>
                                    <select class="form-select" id="cmb_empleado" name="cmb_empleado" required>
                                        <option value="">-- Seleccione --</option>
                                        <?php foreach ($empleados as $emp): ?>
                                            <option value="<?= $emp->id_empleado ?>">
                                                <?= $emp->nombre . ' ' . $emp->apellido ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-outline-success" id="btn_registrar" name="btn_registrar">
                                    <i class="fas fa-save"></i> Grabar Información
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </article>
    </section>
    <?php include("../../template/footer.php"); ?>
</div>


