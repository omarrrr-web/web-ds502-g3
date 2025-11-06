<!DOCTYPE html>
<html lang="es">

<?php
    $route = "../../../";
    $title = "Consultar Rol";
    include("../../template/header.php");
?>

<body>
    <?php
        include("../../template/menubar.php");
    ?>
    <div class="container mt-3">
        <header class="mb-4">
            <h1><i class="fas fa-search me-2"></i> <?= $title ?></h1>
        </header>

        <div class="row justify-content-center">
            <div class="col-md-6 pb-5">
                <div class="mb-3">
                    <label for="consulta_id_rol" class="form-label"><strong>ID de Rol:</strong></label>
                    <input type="text" class="form-control" id="consulta_id_rol" placeholder="Escribe un ID y presiona Enter...">
                </div>
                <div class="mb-3">
                    <label for="consulta_nombre_rol" class="form-label">Nombre del Rol:</label>
                    <input type="text" class="form-control" id="consulta_nombre_rol" readonly>
                </div>

                <div class="mt-4">
                    <a href="listar.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i> Regresar</a>
                </div>
            </div>
        </div>
        <?php include("../../template/footer.php"); ?>
    </div>

</body>

</html>
