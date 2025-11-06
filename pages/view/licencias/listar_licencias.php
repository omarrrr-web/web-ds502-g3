<?php
$route = "../../.."; 
include("../../template/loadclass.php");

$crudlicencia = new CRUDLicencia(); 
$rs_licencias = $crudlicencia->ListarLicencias(); 

$title = "Lista de Licencias";
include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="text-primary mb-0"><i class="fas fa-id-badge me-2"></i> Lista de Licencias de Software</h3>
        </div>
        <div class="card-body">
            <nav class="mb-4">
                <div class="btn-group" role="group">
                    <a href="registrar_licencias.php" class="btn btn-outline-primary"><i class="fas fa-plus-circle me-1"></i> Registrar</a>
                    <a href="consultar_licencias.php" class="btn btn-outline-info"><i class="fa fa-search me-1"></i> Consultar</a>
                    <a href="filtrar_licencias.php" class="btn btn-outline-secondary"><i class="fa fa-filter me-1"></i> Filtrar</a>
                </div>
            </nav>
            
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">N°</th>
                            <th>Software</th>
                            <th>Categoría</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (count($rs_licencias) > 0) {
                            $i = 0;
                            foreach ($rs_licencias as $lic) { 
                                $i++;
                                $fecha_exp = $lic->fecha_expiracion;
                                $row_class = ($fecha_exp && strtotime($fecha_exp) < strtotime('+6 months')) ? 'table-warning' : '';
                        ?>
                            <tr class="reg_licencia align-middle <?= $row_class ?>">
                                <td class="text-center"><?= $i ?></td>
                                <td class="nombrelic"><?= $lic->nombre_software ?></td>
                                <td><?= $lic->nombre_categoria ?></td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-info btn-sm" title="Mostrar"
                                       data-bs-toggle="modal" data-bs-target="#md_mostrar_lic" data-idlic="<?= $lic->id_licencia ?>">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-success btn-sm" title="Editar"
                                       data-bs-toggle="modal" data-bs-target="#md_editar_licencia" data-idlic="<?= $lic->id_licencia ?>">
                                        <i class="fas fa-pen-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm btn_borrar" title="Borrar" 
                                       data-id="<?= $lic->id_licencia ?>" 
                                       data-nombre="<?= $lic->nombre_software ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="4" class="text-center">No hay licencias registradas.</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php   include("../../template/footer.php");?>
            

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

<!-- Modal para Borrar Licencia -->
<div class="modal fade" id="md_borrar_lic" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-trash-alt me-2"></i> Borrar Licencia</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="fs-5">¿Seguro de borrar la licencia?</p>
                <h4 class="lbl_nombre_lic text-primary"></h4>
                <p class="text-muted">(ID: <span class="lbl_id_lic"></span>)</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger btn_confirmar_borrar">Confirmar Borrado</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Mostrar Detalles -->
<div class="modal fade" id="md_mostrar_lic" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i> Detalles de Licencia</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="licencia_details_content">
                <!-- Content will be loaded here via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Licencia -->
<div class="modal fade" id="md_editar_licencia" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Editar Licencia</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editar_licencia_content">
                <!-- El formulario de edición se cargará aquí -->
            </div>
        </div>
    </div>
</div>

