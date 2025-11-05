<!DOCTYPE html>
<html lang="es">
<?php
    $route = "../../../";
    $title = "Empleados Inactivos";
    include("../../template/header.php");
?>
<body>
<?php
    include("../../template/menubar.php");
?>
<div class="container mt-3">
    <header class="mb-3">
        <h1><i class="fas fa-user-slash me-2"></i><?= $title ?></h1>
        <a href="listar.php" class="btn btn-primary">
            <i class="fas fa-arrow-left me-1"></i> Volver a Empleados Activos
        </a>
    </header>

    <section>
        <article>
            <div class="row">
                <div class="col-md-12">
                    <div id="tabla_empleados_inactivos">
                        <!-- La tabla se cargará aquí -->
                    </div>
                </div>
            </div>
        </article>
    </section>

    <?php include("../../template/footer.php"); ?>
</div>



</body>
</html>
