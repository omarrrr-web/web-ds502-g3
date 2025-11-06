<?php
$route = "../../..";
$title = "Detalles del Mantenimiento";
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");

if (!isset($_GET['idmant'])) {
    header("Location: listar_mantenimientos.php");
    exit();
}

$id_mant = (int)$_GET['idmant'];
$crud_mant = new CRUDRegistrosMantenimiento();
$mantenimiento = $crud_mant->BuscarMantenimientoPorId($id_mant);

if (!$mantenimiento) {
    header("Location: listar_mantenimientos.php");
    exit();
}
?>

<div class="container mt-3">
    <header>
        <h3 class="text-info"><i class="fas fa-eye"></i> Detalles del Mantenimiento</h3>
        <hr/>
    </header>

    <nav class="mb-3">
        <a href="listar_mantenimientos.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-circle-left"></i> Regresar
        </a>
        <a href="editar_mantenimiento.php?idmant=<?= $mantenimiento->id_mantenimiento ?>" class="btn btn-outline-warning btn-sm">
            <i class="fas fa-edit"></i> Editar
        </a>
    </nav>

    <section>
        <article>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Información del Mantenimiento</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">ID Mantenimiento</th>
                                    <td><?= $mantenimiento->id_mantenimiento ?></td>
                                </tr>
                                <tr>
                                    <th>Activo</th>
                                    <td><?= $mantenimiento->activo_nombre ?></td>
                                </tr>
                                <tr>
                                    <th>Serial Number</th>
                                    <td><?= $mantenimiento->serial_number ?></td>
                                </tr>
                                <tr>
                                    <th>Fecha de Servicio</th>
                                    <td><?= $mantenimiento->fecha_servicio ?></td>
                                </tr>
                                <tr>
                                    <th>Descripción</th>
                                    <td><?= nl2br($mantenimiento->descripcion) ?></td>
                                </tr>
                                <tr>
                                    <th>Costo</th>
                                    <td><strong>S/ <?= number_format($mantenimiento->costo, 2) ?></strong></td>
                                </tr>
                                <tr>
                                    <th>Realizado Por</th>
                                    <td><?= $mantenimiento->empleado_nombre ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </section>
</div>

<?php
include("../../template/footer.php");
?>
