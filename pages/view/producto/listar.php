<!DOCTYPE html>
<html lang="es">
<?php
    $route = "../../../";
    $title = "Lista de Productos";
    include("../../template/header.php");
?>
<body>
<?php
    include("../../template/menubar.php");
    include("../../template/loadclass.php");

    $crud_prod = new CRUDProducto();
    $productos = $crud_prod->ListarProducto();
?>
<div class="container mt-3">
    <header class="mb-3">
        <h1><i class="fas fa-list text-dark me-2"></i><?= $title ?></h1>
        <!-- Barra de botones -->
        <div class="btn-group" role="group" aria-label="Opciones">
            <a href="registrar.php" class="btn btn-outline-primary">
                <i class="fas fa-plus-circle me-1"></i> Registrar
            </a>
            <a href="consultar.php" class="btn btn-outline-primary">
                <i class="fas fa-search me-1"></i> Consultar
            </a>
            <a href="filtrar.php" class="btn btn-outline-primary">
                <i class="fas fa-filter me-1"></i> Filtrar
            </a>
        </div>
    </header>

    <section>
        <article>
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <table class="table table-striped">
                        <thead class="table-danger">
                            <tr>
                                <th>N°</th>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Costo</th>
                                <th>Stock</th>
                                <th colspan="3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($productos)) {
                                $i = 0;
                                foreach ($productos as $prod) {
                                    $i++;
                            ?>
                            <!-- Fila base para JS -->
                            <tr class="reg_producto">
                                <td><?= $i ?></td>
                                <td class="codprod"><?= $prod->codigo_producto ?></td>
                                <td class="prod"><?= $prod->producto ?></td>
                                <td><?= $prod->costo ?></td>
                                <td><?= $prod->stock ?></td>
                                <td>
                                    <a href="mostrar.php?cod=<?= $prod->codigo_producto ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Mostrar
                                    </a>
                                </td>
                                <td>
                                    <a href="editar.php?cod=<?= $prod->codigo_producto ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                </td>
                                <td>
                                    <a href="borrar.php?cod=<?= $prod->codigo_producto ?>" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Borrar
                                    </a>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>No hay productos registrados.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </article>
    </section>

    <?php include("../../template/footer.php"); ?>
</div>
</body>
</html>
