<?php
$route = "../../..";
$title = "Gestión de Mantenimientos";
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");

$crud_mant = new CRUDRegistrosMantenimiento();
$rs_mant = $crud_mant->ListarMantenimientos();
?>

<div class="container mt-3">
    <header class="mb-3">
        <h1><i class="fas fa-tools me-2"></i><?= $title ?></h1>
        <div class="btn-group" role="group" aria-label="Opciones de Mantenimientos">
            <a href="registrar_mantenimiento.php" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Registrar
            </a>
            <a href="consultar_mantenimiento.php" class="btn btn-outline-secondary">
                <i class="fas fa-search me-1"></i> Consultar
            </a>
            <a href="filtrar_mantenimiento.php" class="btn btn-outline-secondary">
                <i class="fas fa-filter me-1"></i> Filtrar
            </a>
        </div>
    </header>

    <section>
        <article>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover table-sm table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Activo</th>
                                <th>Serial</th>
                                <th>Fecha Servicio</th>
                                <th>Descripción</th>
                                <th>Costo</th>
                                <th>Realizado Por</th>
                                <th colspan="3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $i = 0;
                        foreach ($rs_mant as $mant) { 
                            $i++;
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $mant->activo_nombre ?></td>
                            <td><?= $mant->serial_number ?></td>
                            <td><?= $mant->fecha_servicio ?></td>
                            <td><?= substr($mant->descripcion, 0, 50) . (strlen($mant->descripcion) > 50 ? '...' : '') ?></td>
                            <td>S/ <?= number_format($mant->costo, 2) ?></td>
                            <td><?= $mant->empleado_nombre ?></td>

                            <td>
                                <a href="mostrar_mantenimiento.php?idmant=<?= $mant->id_mantenimiento ?>" class="btn btn-outline-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                            <td>
                                <a href="editar_mantenimiento.php?idmant=<?= $mant->id_mantenimiento ?>" class="btn btn-outline-success btn-sm" title="Editar">
                                    <i class="fas fa-pen-square"></i>
                                </a>
                            </td>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#md_borrar_mant" 
                                   data-id="<?= $mant->id_mantenimiento ?>" 
                                   class="btn_borrar btn btn-outline-danger btn-sm" title="Borrar">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </article>
    </section>
</div>

<!-- Modal para Borrar -->
<div class="modal fade" id="md_borrar_mant" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger"><i class="fas fa-trash-alt"></i> Borrar Registro de Mantenimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h5>¿Seguro de borrar este registro?</h5>
                <p><span class="lbl_id_mant text-muted"></span></p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="#" class="btn_confirmar_borrar btn btn-outline-danger">Borrar</a>
            </div>
        </div>
    </div>
</div>

<?php include("../../template/footer.php"); ?>

<script>
$(document).ready(function() {
    // Capturar el ID cuando se abre el modal de borrar
    $('.btn_borrar').on('click', function() {
        var id = $(this).data('id');
        $('.lbl_id_mant').text('ID: ' + id);
        $('.btn_confirmar_borrar').attr('href', 'borrar_mantenimiento.php?idmant=' + id);
    });
});
</script>
