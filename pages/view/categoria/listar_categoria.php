<?php
$route = "../../..";
$title = "Listar Categorías";
// Incluir el autoloader y los templates
include("../../template/loadclass.php");
include("../../template/header.php"); // header incluye el inicio de HTML y el head
include("../../template/menubar.php"); // menubar incluye la navegación

// Lógica PHP para obtener los datos
$crudcategoria = new CRUDCategoria();
$rs_cat = $crudcategoria->ListarCategoria();
?>

<div class="container mt-3">
    <header>
        <h3 class="text-primary"><i class="fas fa-list-alt"></i> Lista de Categorías de Activo</h3>
        <hr />
    </header>

    <nav class="mb-3">
        <div class="btn-group" role="group">
            <a href="registrar_categoria.php" class="btn btn-outline-primary"><i class="fas fa-plus-circle"></i> Registrar</a>
            <a href="consultar_categoria.php" class="btn btn-outline-primary"><i class="fa fa-search"></i> Consultar</a>
            <a href="filtrar_categoria.php" class="btn btn-outline-primary"><i class="fa fa-filter"></i> Filtrar</a>
        </div>
    </nav>

    <section>
        <article>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <table class="table table-hover table-sm table-success table-striped">
                        <tr class="table-primary">
                            <th>N°</th>
                            <th>ID Categoría</th>
                            <th>Nombre Categoría</th>
                            <th colspan="3">Acciones</th>
                        </tr>
                        <?php
                        $i = 0;
                        foreach ($rs_cat as $cat) {
                            $i++;
                        ?>
                            <tr class="reg_categoria">
                                <td><?= $i ?></td>
                                <td class="codcat"><?= $cat->id_categoria ?></td>
                                <td class="nombrecat"><?= $cat->nombre_categoria ?></td>
                                <td>
                                    <a href="#" class="btn_mostrar_categoria btn btn-outline-info btn-sm" title="Mostrar"
                                       data-bs-toggle="modal" data-bs-target="#md_mostrar_cat" data-idcat="<?= $cat->id_categoria ?>">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="btn_editar btn btn-outline-success btn-sm" title="Editar"
                                       data-bs-toggle="modal" data-bs-target="#md_editar_cat" data-idcat="<?= $cat->id_categoria ?>">
                                        <i class="fas fa-pen-square"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#md_borrar_cat"
                                        data-id="<?= $cat->id_categoria ?>"
                                        data-nombre="<?= $cat->nombre_categoria ?>"
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

<div class="modal fade" id="md_borrar_cat" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger"><i class="fas fa-trash-alt"></i> Borrar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h5>¿Seguro de borrar el registro?</h5>
                <p>
                    <span class="lbl_nombre_cat text-bold"></span>
                    <span class="lbl_id_cat text-muted"></span>
                </p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn_confirmar_borrar btn btn-outline-danger">Borrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="md_mostrar_cat" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info"><i class="fas fa-info-circle"></i> Detalles de Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="categoria_details_content">
                    <p>Cargando detalles de la categoría...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Categoría -->
<div class="modal fade" id="md_editar_cat" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Editar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="editar_cat_content">
                    <!-- El formulario de edición se cargará aquí -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include("../../template/footer.php");
?>