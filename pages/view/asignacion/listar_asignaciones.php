<?php
$route = "../../..";
$title = "Listar Asignaciones";
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");

$crud_asig = new CRUDAsignaciones();
$rs_asig = $crud_asig->ListarAsignaciones();
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="text-primary mb-0"><i class="fas fa-tasks me-2"></i> Lista de Asignaciones</h3>
        </div>
        <div class="card-body">
            <nav class="mb-4">
                <div class="btn-group" role="group">
                    <a href="registrar_asignacion.php" class="btn btn-outline-primary"><i class="fas fa-plus-circle me-1"></i> Registrar</a>
                    <a href="consultar_asignacion.php" class="btn btn-outline-info"><i class="fa fa-search me-1"></i> Consultar</a>
                    <a href="filtrar_asignacion.php" class="btn btn-outline-secondary"><i class="fa fa-filter me-1"></i> Filtrar</a>
                </div>
            </nav>

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Empleado</th>
                            <th>Fecha Asignación</th>
                            <th>Fecha Devolución</th>
                            <th>Notas</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if (count($rs_asig) > 0) {
                        $i = 0;
                        foreach ($rs_asig as $asig) { 
                            $i++;
                    ?>
                        <tr class="align-middle">
                            <td class="text-center"><?= $i ?></td>
                            <td><?= $asig->empleado_nombre ?></td>
                            <td><?= date("d/m/Y", strtotime($asig->fecha_asignacion)) ?></td>
                            <td><?= $asig->fecha_devolucion ? date("d/m/Y", strtotime($asig->fecha_devolucion)) : '<span class="badge bg-secondary">Sin devolver</span>' ?></td>
                            <td><?= $asig->notas ?></td>
                            <td class="text-center">
                                <a href="mostrar_asignacion.php?idasig=<?= $asig->id_asignacion ?>" class="btn btn-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="editar_asignacion.php?idasig=<?= $asig->id_asignacion ?>" class="btn btn-success btn-sm" title="Editar">
                                    <i class="fas fa-pen-square"></i>
                                </a>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#md_borrar_asig" 
                                   data-id="<?= $asig->id_asignacion ?>" 
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
                            <td colspan="6" class="text-center">No hay asignaciones registradas.</td>
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

<!-- Modal Genérico para Notificaciones -->
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

<!-- Modal para Borrar Asignación -->
<div class="modal fade" id="md_borrar_asig" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-trash-alt me-2"></i> Borrar Asignación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="fs-5">¿Seguro de borrar este registro?</p>
                <p class="text-muted">ID de Asignación: <span class="lbl_id_asig"></span></p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" class="btn btn-danger btn_confirmar_borrar">Confirmar Borrado</a>
            </div>
        </div>
    </div>
</div>

