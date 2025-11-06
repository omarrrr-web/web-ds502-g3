<?php
$route = "../../..";
$title = "Registrar Asignación";
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
        <h3 class="text-success"><i class="fas fa-plus-circle"></i> Registrar Asignación</h3>
        <hr/>
    </header>

    <nav class="mb-3">
        <a href="listar_asignaciones.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-circle-left"></i> Regresar
        </a>
    </nav>

    <section>
        <article>
            <div class="row justify-content-center">
                <div class="card col-md-8">
                    <div class="card-body">
                        <form id="frm_registrar_asig" name="frm_registrar_asig" method="post" action="../../controller/ctr_grabar_asignacion.php" autocomplete="off">

                            <input type="hidden" id="txt_tipo" name="txt_tipo" value="r">

                            <!-- Selección del empleado -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="cmb_empleado" class="form-label">Empleado</label>
                                    <select class="form-select" id="cmb_empleado" name="cmb_empleado" required>
                                        <option value="">-- Seleccione --</option>
                                            <?php foreach ($empleados as $emp): ?>
                                                <option value="<?= $emp->id_empleado ?>">
                                                    <?= $emp->nombre . ' ' . $emp->apellido ?>
                                                </option>
                                            <?php endforeach; ?>

                                    </select>
                                </div>

                                <!-- Selección del activo -->
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
                            </div>

                            <!-- Fecha de devolución -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="txt_fecha_devolucion" class="form-label">Fecha de Devolución</label>
                                    <input type="date" class="form-control" id="txt_fecha_devolucion" name="txt_fecha_devolucion">

                                </div>

                                <!-- Notas -->
                                <div class="col-md-6">
                                    <label for="txt_notas" class="form-label">Notas</label>
                                    <textarea class="form-control" id="txt_notas" name="txt_notas" rows="2" placeholder="Ingrese observaciones..."></textarea>
                                </div>
                            </div>

                            <div class="text-center">
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

