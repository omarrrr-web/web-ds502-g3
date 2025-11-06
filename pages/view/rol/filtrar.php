<!DOCTYPE html>
<html lang="es">

<?php
    $route = "../../../";
    $title = "Filtrar Roles";
    include("../../template/header.php");
?>

<body>
    <?php
        include("../../template/menubar.php");
    ?>
    <div class="container mt-3">
        <header class="mb-3">
            <h1><i class="fas fa-filter me-2"></i><?= $title ?></h1>
            <div class="d-flex justify-content-center">
                <div class="input-group mb-3 mt-3" style="max-width: 650px; width: 100%;">
                    <input type="text" class="form-control form-control-lg" placeholder="Buscar rol por nombre..." id="input-filtro-rol">
                    <button class="btn btn-outline-secondary btn-sm" type="button" id="btn-aplicar-filtro-rol">
                        <i class="fas fa-search me-1"></i> Buscar
                    </button>
                    <button class="btn btn-outline-danger btn-sm" type="button" id="btn-limpiar-filtro-rol">
                        <i class="fas fa-times me-1"></i> Limpiar
                    </button>
                </div>
            </div>

            <a href="listar.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Regresar a la Lista de Roles
            </a>
        </header>

        <section>
            <article>
                <div class="row">
                    <div class="col-md-12">
                        <div id="tabla_roles_filtrados">
                            <!-- La tabla de roles filtrados se cargará aquí mediante AJAX -->
                            <p class="text-center">Utiliza el campo de búsqueda para filtrar roles.</p>
                        </div>
                    </div>
                </div>
            </article>
        </section>
        <?php include("../../template/footer.php"); ?>
    </div>

</body>

</html>
