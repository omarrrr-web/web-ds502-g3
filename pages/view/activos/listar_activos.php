<?php
$route = "../../..";
$title = "Listar Activos";
// Incluir el autoloader y los templates
include("../../template/loadclass.php");
include("../../template/header.php"); // header incluye el inicio de HTML y el head
include("../../template/menubar.php"); // menubar incluye la navegación

// Lógica PHP para obtener los datos
$crudactivo = new CRUDActivos();
$rs_act = $crudactivo->ListarActivos();
?>

<div class="container mt-3">
    <header>
        <h3 class="text-primary"><i class="fas fa-list-alt"></i> Lista de Activos</h3>
        <hr />
    </header>

    <nav class="mb-3">
        <div class="btn-group" role="group">
            <a href="registrar_activos.php" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i> Registrar</a>
            <a href="consultar_activos.php" class="btn btn-outline-primary"><i class="fa fa-search"></i> Consultar</a>
            <a href="filtrar_activos.php" class="btn btn-outline-primary"><i class="fa fa-filter"></i> Filtrar</a>
        </div>
    </nav>

    <section>
        <article>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <table class="table table-hover table-sm table-warning table-striped">
                        <tr class="table-dark">
                            <th>N°</th>
                            <th>ID</th>
                            <th>Categoría</th>
                            <th colspan="3">Acciones</th>
                        </tr>
                        <?php
                        $i = 0;
                        foreach ($rs_act as $act) {
                            $i++;
                        ?>
                            <tr class="reg_activo">
                                <td><?php echo $i ?></td>
                                <td class="codact"><?php echo $act->id_activo ?></td>
                                <td><?php echo $act->nombre_categoria ?></td>
                                <td>
                                    <button class="btn btn-outline-info btn-sm btn_mostrar" data-id="<?= $act->id_activo ?>" title="Mostrar">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn_editar_modal btn btn-outline-success btn-sm" title="Editar"
                                            data-bs-toggle="modal" data-bs-target="#md_editar_activo" 
                                            data-idact="<?php echo $act->id_activo ?>">
                                        <i class="fas fa-pen-square"></i>
                                    </button>
                                </td>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#md_borrar_act"
                                        data-id="<?php echo $act->id_activo ?>"
                                        data-serial="<?php echo $act->serial_number ?>"
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
        </article>
    </section>
</div>

<div class="modal fade" id="md_borrar_act" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger"><i class="fas fa-trash-alt"></i> Borrar Activo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h5>¿Seguro de borrar el registro?</h5>
                <p>
<<<<<<< HEAD
                    <span class="lbl_nombre_act text-bold"></span>
=======
                    <span class="lbl_nombre_act text-bold"></span> 
>>>>>>> 8470d5f326203cb86d6172987a53f9866bb2e416
                    <span class="lbl_id_act text-muted"></span>
                </p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="#" class="btn_confirmar_borrar btn btn-outline-danger">Borrar</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="md_mostrar_detalle" data-bs-backdrop="static" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info"><i class="fas fa-info-circle"></i> Detalles del Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="contenido_modal_detalle">
                <div class="text-center">
                    <div class="spinner-border text-info" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p>Cargando información...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="md_editar_activo" data-bs-backdrop="static" tabindex="-1" aria-labelledby="editarActivoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="editarActivoModalLabel"><i class="fas fa-pen-square"></i> Editar Activo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editar_activo_content">
                <!-- El formulario de edición se cargará aquí vía AJAX -->
                <div class="text-center">
                    <div class="spinner-border text-success" role="status"></div>
                    <p>Cargando formulario...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("../../template/footer.php");
?>
