<!DOCTYPE html>
<html lang="es">
<?php
    $route = "../../../";
    $title = "Consultar Empleado";
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
        <div class="col-md-8 pb-5">
            <div class="mb-3">
                <label for="consulta_id" class="form-label"><strong>ID de Empleado:</strong></label>
                <input type="text" class="form-control" id="consulta_id" placeholder="Escribe un ID y presiona Enter...">
            </div>
            <div class="mb-3">
                <label for="consulta_nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="consulta_nombre" readonly>
            </div>
            <div class="mb-3">
                <label for="consulta_apellido" class="form-label">Apellido:</label>
                <input type="text" class="form-control" id="consulta_apellido" readonly>
            </div>
            <div class="mb-3">
                <label for="consulta_email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="consulta_email" readonly>
            </div>
            <div class="mb-3">
                <label for="consulta_rol" class="form-label">Rol:</label>
                <input type="text" class="form-control" id="consulta_rol" readonly>
            </div>

            <div class="mt-4">
                <a href="listar.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i> Regresar</a>
            </div>
        </div>
    </div>
</div>

<?php include("../../template/footer.php"); ?>



</body>
</html>
