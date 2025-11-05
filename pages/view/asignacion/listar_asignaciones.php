<?php
$route = "../../..";
$title = "Listar Asignaciones";
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");

$crud_asig = new CRUDAsignaciones();
$rs_asig = $crud_asig->ListarAsignaciones();
?>

<div class="container mt-3">
    <header>
        <h3 class="text-primary"><i class="fas fa-list-alt"></i> Lista de Asignaciones</h3>
        <hr/>
    </header>

    <nav class="mb-3">
        <a href="registrar_asignacion.php" class="btn btn-outline-primary">
            <i class="fas fa-plus-circle"></i> Registrar
        </a>
         <a href="consultar_asignacion.php" class="btn btn-outline-primary"><i class="fa fa-search"></i> Consultar</a>
            <a href="filtrar_asignacion.php" class="btn btn-outline-primary"><i class="fa fa-filter"></i> Filtrar</a>
    </nav>

    <section>
        <article>
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <table class="table table-hover table-sm table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Empleado</th>
                                <th>Fecha Asignación</th>
                                <th>Fecha Devolución</th>
                                <th>Notas</th>
                                <th colspan="3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $i = 0;
                        foreach ($rs_asig as $asig) { 
                            $i++;
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $asig->empleado_nombre ?></td>
                            <td><?= $asig->fecha_asignacion ?></td>
                            <td><?= $asig->fecha_devolucion ?></td>
                            <td><?= $asig->notas ?></td>

                            <td>
                                <a href="mostrar_asignacion.php?idasig=<?= $asig->id_asignacion ?>" class="btn btn-outline-info btn-sm" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                            <td>
                                <a href="editar_asignacion.php?idasig=<?= $asig->id_asignacion ?>" class="btn btn-outline-success btn-sm" title="Editar">
                                    <i class="fas fa-pen-square"></i>
                                </a>
                            </td>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#md_borrar_asig" 
                                   data-id="<?= $asig->id_asignacion ?>" 
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

<div class="modal fade" id="md_borrar_asig" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger"><i class="fas fa-trash-alt"></i> Borrar Asignación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h5>¿Seguro de borrar este registro?</h5>
                <p><span class="lbl_id_asig text-muted"></span></p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="#" class="btn_confirmar_borrar btn btn-outline-danger">Borrar</a>
            </div>
        </div>
    </div>
</div>

<?php include("../../template/footer.php"); ?>