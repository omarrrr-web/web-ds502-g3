<!DOCTYPE html>
<html lang="es">
<?php
    $route = "../../../";
    $title = "Filtrar Empleados";
    include("../../template/header.php");
?>
<body>
<?php
    include("../../template/menubar.php");
?>
<div class="container mt-3">
    <header class="mb-3">
        <h1><i class="fas fa-filter me-2"></i><?= $title ?></h1>
        <div class="input-group mb-3 mt-3">
            <input type="text" class="form-control" placeholder="Buscar empleado por nombre, apellido o email..." id="input-filtro-filtrar">
            <button class="btn btn-outline-secondary" type="button" id="btn-aplicar-filtro-filtrar"><i class="fas fa-search me-1"></i> Buscar</button>
            <button class="btn btn-outline-danger" type="button" id="btn-limpiar-filtro-filtrar"><i class="fas fa-times me-1"></i> Limpiar</button>
        </div>
        <a href="listar.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Regresar a Empleados Activos
        </a>
    </header>

    <section>
        <article>
            <div class="row">
                <div class="col-md-12">
                    <div id="tabla_empleados_filtrados">
                        <!-- La tabla de empleados filtrados se cargará aquí mediante AJAX -->
                        <p class="text-center">Utiliza el campo de búsqueda para filtrar empleados.</p>
                    </div>
                </div>
            </div>
        </article>
    </section>

    <?php include("../../template/footer.php"); ?>
</div>



</body>
</html>
