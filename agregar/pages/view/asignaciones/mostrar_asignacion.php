<!DOCTYPE html>
<html lang="es">
<?php
$route = "../../.."; 
include("../../template/loadclass.php");
$title = "Detalle de Asignación";
include("../../template/header.php");
?>
<body>
<?php
include("../../template/menubar.php");

// Obtener la asignación
if (isset($_GET['idasig'])) {
    $id_asignacion = $_GET['idasig'];
    $crud_asig = new CRUDAsignaciones(); 
    $asignacion = $crud_asig->BuscarAsignacionesPorId($id_asignacion);
} else {
    $id_asignacion = null;
    $asignacion = null;
}
?>

<div class="container mt-4">
    <header>
        <div class="d-flex align-items-center mb-3">
            <i class="fas fa-info-circle text-info fs-3 me-2"></i>
            <h3 class="text-info fw-bold mb-0">Detalles de la Asignación</h3>
        </div>
        <hr/>
    </header>

    <a href="listar_asignaciones.php" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left me-1"></i> Regresar
    </a>

    <?php if ($asignacion): ?>
    <div class="card col-md-10 mx-auto shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Asignación ID <?= $asignacion->id_asignacion ?></h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <h6 class="text-muted">ID Activo</h6>
                    <p class="fw-bold"><?= $asignacion->id_activo ?></p>
                </div>
                <div class="col-md-8">
                    <h6 class="text-muted">Nombre Activo</h6>
                    <p class="fw-bold"><?= $asignacion->nombre_activo ?></p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-muted">ID Empleado</h6>
                    <p class="fw-bold"><?= $asignacion->id_empleado ?></p>
                </div>
                <div class="col-md-8">
                    <h6 class="text-muted">Empleado</h6>
                    <p class="fw-bold"><?= $asignacion->nombre_empleado ?></p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Fecha de Asignación</h6>
                    <p class="fw-bold"><?= $asignacion->fecha_asignacion ?></p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Fecha de Devolución</h6>
                    <p class="fw-bold"><?= $asignacion->fecha_devolucion ?? "NO DEVUELTO" ?></p>
                </div>

                <div class="col-12">
                    <h6 class="text-muted">Notas</h6>
                    <p class="fw-bold"><?= $asignacion->notas ?></p>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="editar_asignacion.php?idasig=<?= $asignacion->id_asignacion ?>" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i> Editar
                </a>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="alert alert-danger mt-3 text-center">
            La asignación con código <b><?= $id_asignacion ?></b> no existe.
        </div>
    <?php endif; ?>
</div>

<?php include("../../template/footer.php"); ?>
</body>
</html>
