<?php
$route = "../../.."; 
include("../../template/loadclass.php");

// 1. Lógica PHP para obtener los datos
$crudlicencia = new CRUDLicencia(); 
$rs_licencias = $crudlicencia->ListarLicencias(); 

$title = "Lista de Licencias";
include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header>
        <h3 class="text-info"><i class="fas fa-tags"></i> Lista de Licencias de Software</h3>
        <hr/>
    </header>
    
    <nav class="mb-3">
        <div class="btn-group" role="group">
            <a href="registrar_licencias.php" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i> Registrar</a>
            <a href="consultar_licencias.php" class="btn btn-outline-primary"><i class="fa fa-search"></i> Consultar</a>
            <a href="filtrar_licencias.php" class="btn btn-outline-primary"><i class="fa fa-filter"></i> Filtrar</a>
        </div>
    </nav>
    
    <section>
        <article>
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm table-info table-striped">
                            <tr class="table-dark">
                                <th>N°</th>
                                <th>Software</th>
                                <th>Categoría</th>
                                <th colspan="3">Acciones</th>
                            </tr>
                            <?php 
                            $i = 0;
                            foreach ($rs_licencias as $lic) { 
                                $i++;
                                // Determinar la clase de la fila si la licencia está por expirar
                                $fecha_exp = $lic->fecha_expiracion;
                                $row_class = ($fecha_exp && strtotime($fecha_exp) < strtotime('+6 months')) ? 'table-warning' : '';
                            ?>
                            <tr class="reg_licencia <?= $row_class ?>">
                                <td><?= $i ?></td>
                                <td class="nombrelic"><?= $lic->nombre_software ?></td>
                                <td><?= $lic->nombre_categoria ?></td>
                                
                                <td>
                                    <a href="#" class="btn_mostrar_licencia btn btn-outline-info btn-sm" title="Mostrar"
                                       data-bs-toggle="modal" data-bs-target="#md_mostrar_lic" data-idlic="<?= $lic->id_licencia ?>">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="btn_editar_licencia btn btn-outline-success btn-sm" title="Editar"
                                       data-bs-toggle="modal" data-bs-target="#md_editar_licencia" data-idlic="<?= $lic->id_licencia ?>">
                                        <i class="fas fa-pen-square"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#md_borrar_lic" 
                                       data-id="<?= $lic->id_licencia ?>" 
                                       data-nombre="<?= $lic->nombre_software ?>" 
                                       class="btn_borrar btn btn-outline-danger btn-sm" title="Borrar">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </article>
    </section>
</div>

<div class="modal fade" id="md_borrar_lic" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger"><i class="fas fa-trash-alt"></i> Borrar Licencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h5>¿Seguro de borrar la licencia?</h5>
                <p>
                    Software: <span class="lbl_nombre_lic text-bold"></span> 
                    (ID: <span class="lbl_id_lic text-muted"></span>)
                </p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="#" class="btn_confirmar_borrar btn btn-outline-danger">Borrar</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="md_mostrar_lic" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info"><i class="fas fa-info-circle"></i> Detalles de Licencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Content will be loaded here via AJAX -->
                <div id="licencia_details_content">
                    <p>Cargando detalles de la licencia...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Licencia -->
<div class="modal fade" id="md_editar_licencia" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success"><i class="fas fa-edit"></i> Editar Licencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="editar_licencia_content">
                    <!-- El formulario de edición se cargará aquí -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("../../template/footer.php");
?>