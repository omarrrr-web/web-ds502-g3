<?php
    $route = "../../../";
    $title = "Gestión de Empleados";
    include("../../template/header.php");
    include("../../template/menubar.php");
?>
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="text-primary mb-0"><i class="fas fa-users me-2"></i><?= $title ?></h3>
        </div>
        <div class="card-body">
            <div class="btn-group mb-4" role="group" aria-label="Opciones de Empleados">
                <a href="form_empleado.php" class="btn btn-outline-primary"><i class="fas fa-plus-circle me-1"></i> Registrar</a>
                <a href="consultar.php" class="btn btn-outline-info"><i class="fas fa-search me-1"></i> Consultar</a>
                <a href="filtrar.php" class="btn btn-outline-secondary"><i class="fas fa-filter me-1"></i> Filtrar</a>
                <a href="listar_inactivos.php" class="btn btn-outline-warning"><i class="fas fa-user-slash me-1"></i> Ver Inactivos</a>
            </div>

            <div id="tabla_empleados">
                <!-- La tabla de empleados se cargará aquí mediante AJAX -->
            </div>
        </div>
    </div>
    <?php include("../../template/footer.php"); ?>
</div>

<!-- Modal Genérico para Notificaciones y Confirmaciones -->
<div class="modal fade" id="modalGenerico" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" id="modalGenericoHeader">
                <h1 class="modal-title fs-5" id="modalGenericoTitle"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalGenericoBody"></div>
            <div class="modal-footer" id="modalGenericoFooter"></div>
        </div>
    </div>
</div>

