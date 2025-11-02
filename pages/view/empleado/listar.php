<!DOCTYPE html>
<html lang="es">
<?php
    $route = "../../../";
    $title = "Gestión de Empleados";
    include("../../template/header.php");
?>
<body>
<?php
    include("../../template/menubar.php");
?>
<div class="container mt-3">
    <header class="mb-3">
        <h1><i class="fas fa-users me-2"></i><?= $title ?></h1>
        <!-- Barra de botones -->
        <div class="btn-group" role="group" aria-label="Opciones de Empleados">
            <a href="form_empleado.php" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Registrar
            </a>
            <a href="consultar.php" class="btn btn-outline-secondary">
                <i class="fas fa-search me-1"></i> Consultar
            </a>
            <a href="filtrar.php" class="btn btn-outline-secondary">
                <i class="fas fa-filter me-1"></i> Filtrar
            </a>
            <a href="listar_inactivos.php" class="btn btn-outline-info">
                <i class="fas fa-user-slash me-1"></i> Ver Inactivos
            </a>
        </div>
    </header>

    <section>
        <article>
            <div class="row">
                <div class="col-md-12">
                    <div id="tabla_empleados">
                        <!-- La tabla de empleados se cargará aquí mediante AJAX -->
                    </div>
                </div>
            </div>
        </article>
    </section>



    <?php include("../../template/footer.php"); ?>
</div>



</body>
</html>
