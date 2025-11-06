<?php
$route = "../../..";
$title = "Gestión de Mantenimientos";
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");

$crud_mant = new CRUDRegistrosMantenimiento();
$rs_mant = $crud_mant->ListarMantenimientos();
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="text-primary mb-0"><i class="fas fa-tools me-2"></i><?= $title ?></h3>
        </div>
        <div class="card-body">
            <div class="btn-group mb-4" role="group" aria-label="Opciones de Mantenimientos">
                <a href="registrar_mantenimiento.php" class="btn btn-outline-primary"><i class="fas fa-plus-circle me-1"></i> Registrar</a>
                <a href="consultar_mantenimiento.php" class="btn btn-outline-info"><i class="fas fa-search me-1"></i> Consultar</a>
                <a href="filtrar_mantenimiento.php" class="btn btn-outline-secondary"><i class="fas fa-filter me-1"></i> Filtrar</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Activo</th>
                            <th>Serial</th>
                            <th>Fecha Servicio</th>
                            <th>Descripción</th>
                            <th>Costo</th>
                            <th>Realizado Por</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (count($rs_mant) > 0) {
                            $i = 0;
                            foreach ($rs_mant as $mant) { 
                                $i++;
                        ?>
                        <tr class="align-middle">
                            <td class="text-center"><?= $i ?></td>
                            <td><?= $mant->activo_nombre ?></td>
                            <td><?= $mant->serial_number ?></td>
                            <td><?= date("d/m/Y", strtotime($mant->fecha_servicio)) ?></td>
                            <td><?= substr($mant->descripcion, 0, 50) . (strlen($mant->descripcion) > 50 ? '...' : '') ?></td>
                            <td>S/ <?= number_format($mant->costo, 2) ?></td>
                            <td><?= $mant->empleado_nombre ?></td>

                            <td class="text-center">
                                <a href="mostrar_mantenimiento.php?idmant=<?= $mant->id_mantenimiento ?>" class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="editar_mantenimiento.php?idmant=<?= $mant->id_mantenimiento ?>" class="btn btn-success btn-sm" title="Editar">
                                    <i class="fas fa-pen-square"></i>
                                </a>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#md_borrar_mant" 
                                   data-id="<?= $mant->id_mantenimiento ?>" 
                                   class="btn btn-danger btn-sm" title="Borrar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="8" class="text-center">No hay registros de mantenimiento.</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include("../../template/footer.php"); ?>
</div>

<!-- MODALES -->

<div class="modal fade" id="modalGenerico" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="modalGenericoHeader">
                <h1 class="modal-title fs-5" id="modalGenericoTitle"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalGenericoBody"></div>
            <div class="modal-footer" id="modalGenericoFooter"></div>
        </div>
    </div>
</div>


<div class="modal fade" id="md_borrar_mant" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-trash-alt me-2"></i> Borrar Registro de Mantenimiento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="fs-5">¿Seguro de borrar este registro de mantenimiento?</p>
                <p class="text-muted">ID de Mantenimiento: <span class="lbl_id_mant"></span></p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" class="btn btn-danger btn_confirmar_borrar">Confirmar Borrado</a>
            </div>
        </div>
    </div>
</div>

