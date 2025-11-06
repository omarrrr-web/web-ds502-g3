<!DOCTYPE html>
<html lang="es">
<?php
$route = "../../..";
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");

// 1. Capturar el ID de la asignación
if (!isset($_GET['idasig'])) {
    header("location: listar_asignaciones.php"); // Redirigir al listado si no hay ID
    exit();
}

$id_asig = $_GET['idasig'];
$crud_asig = new CRUDAsignaciones();
$asignacion_actual = $crud_asig->BuscarAsignacionesPorId($id_asig);

// Verificar si existe
if (!$asignacion_actual) {
    echo '<div class="alert alert-danger text-center mt-4">Asignación no encontrada.</div>';
    exit();
}

?>

<div class="container mt-3">
    <header>
        <h3 class="text-primary">
            <i class="fas fa-edit"></i> Editar Asignación
        </h3>
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
                <div class="card col-md-8 shadow-sm">
                    <div class="card-body">
                        <form id="frm_editar_asig" name="frm_editar_asig" method="post" 
                              action="../../controller/ctr_grabar_asignacion.php" autocomplete="off">
                              
                            <!-- Tipo de operación -->
                            <input type="hidden" id="txt_tipo" name="txt_tipo" value="e">
                            <!-- ID -->
                            <input type="hidden" id="txt_id_asig" name="txt_id_asig" value="<?= $asignacion_actual->id_asignacion ?>">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="txt_id_activo" class="form-label">ID Activo</label>
                                    <input type="number" class="form-control" id="txt_id_activo" name="txt_id_activo"
                                           required value="<?= $asignacion_actual->id_activo ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="txt_id_empleado" class="form-label">ID Empleado</label>
                                    <input type="number" class="form-control" id="txt_id_empleado" name="txt_id_empleado"
                                           required value="<?= $asignacion_actual->id_empleado ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="txt_fecha_asignacion" class="form-label">Fecha de Asignación</label>
                                    <input type="datetime-local" class="form-control" id="txt_fecha_asignacion" 
                                           name="txt_fecha_asignacion" 
                                           value="<?= date('Y-m-d\TH:i', strtotime($asignacion_actual->fecha_asignacion)) ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="txt_fecha_devolucion" class="form-label">Fecha de Devolución</label>
                                    <input type="datetime-local" class="form-control" id="txt_fecha_devolucion" 
                                           name="txt_fecha_devolucion" 
                                           value="<?= $asignacion_actual->fecha_devolucion ? date('Y-m-d\TH:i', strtotime($asignacion_actual->fecha_devolucion)) : '' ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="txt_notas" class="form-label">Notas</label>
                                <textarea class="form-control" id="txt_notas" name="txt_notas" rows="3"
                                          placeholder="Agregue observaciones o comentarios..."><?= $asignacion_actual->notas ?></textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-outline-primary" id="btn_editar" name="btn_editar">
                                    <i class="fas fa-sync-alt"></i> Actualizar Información
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


</html>