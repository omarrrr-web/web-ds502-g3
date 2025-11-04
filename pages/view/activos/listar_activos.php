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
        <hr/>
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
                <div class="col-md-10">
                    <table class="table table-hover table-sm table-warning table-striped">
                        <tr class="table-dark">
                            <th>N°</th>
                            <th>ID</th>
                            <th>Categoría</th>
                            <th>Serial</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Fecha Compra</th>
                            <th>Precio</th>
                            <th>Estado</th>
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
                            <td class="serialact"><?php echo $act->serial_number ?></td>
                            <td><?php echo $act->marca ?></td>
                            <td><?php echo $act->modelo ?></td>
                            <td><?php echo $act->fecha_compra ?></td>
                            <td><?php echo $act->precio ?></td>
                            <td><?php echo $act->estado ?></td>
                            <td>
                                    <a href="mostrar_activos.php?idcat=<?= $act->id_activo ?>" class="btn btn-outline-info btn-sm" title="Mostrar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            <td>
                                <a href="editar_activos.php?idact=<?php echo $act->id_activo ?>" class="btn_editar btn btn-outline-success btn-sm" title="Editar">
                                    <i class="fas fa-pen-square"></i>
                                </a>
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
                    <span class="lbl_nombre_act text-bold"></span> 
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

<?php
include("../../template/footer.php");
?>
