<?php
    $route = "../../../";
    include("../../template/loadclass.php");
?>
<!DOCTYPE html>
<html lang="es">

<?php
    $title = "Listado de Roles";
    include("../../template/header.php");
?>

<body>
    <?php
        include("../../template/menubar.php");
    ?>
    <div class="container mt-3">
        <header class="mb-4">
            <h1><i class="fas fa-user-tag me-2"></i> <?= $title ?></h1>
            <div class="btn-group" role="group">
                <a href="form_rol.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Registrar</a>
                <a href="consultar.php" class="btn btn-outline-secondary"><i class="fas fa-search me-2"></i> Consultar</a>
                <a href="filtrar.php" class="btn btn-outline-secondary"><i class="fas fa-filter me-2"></i> Filtrar</a>
            </div>
        </header>

        <div id="tabla_roles">
            <!-- La tabla de roles se cargará aquí vía AJAX -->
            <p class="text-center">Cargando roles...</p>
        </div>
    </div>

    <?php include("../../template/footer.php"); ?>
</body>

</html>