<!DOCTYPE html>
<html lang="es">
<?php
// Define la ruta relativa a la raíz para las inclusiones estáticas
$route = "../../.."; 

// Incluimos el autoloader y los templates
include("../../template/loadclass.php");
$title = "Información del Activo";
include("../../template/header.php");
?>
<body>
<?php
include("../../template/menubar.php");

$id_activo = null;
$activo = null;

// 1. Lógica PHP para obtener el activo
if (isset($_GET['idcat'])) {
    $id_activo = $_GET['idcat'];
    
    // USAR LA CLASE CORRECTA: CRUDActivos
    $crud_act = new CRUDActivos(); 
    
    // USAR EL MÉTODO CORRECTO: BuscarActivoPorId
    $activo = $crud_act->BuscarActivoPorId($id_activo);
    
    // Para mostrar el nombre de la Categoría, necesitamos otra consulta (o usar el SP que lista completo)
    // El SP de listar completo ya trae el nombre: sp_listar_activos. Si usamos BuscarActivoPorId
    // necesitamos el CRUDCategoria. Para simplicidad, se muestra el ID de categoría. 
    // Si tu SP de búsqueda devuelve también el nombre de la categoría, úsalo aquí.
    
}
?>

<div class="container mt-4">
    <header>
        <div class="d-flex align-items-center mb-3">
            <i class="fas fa-info-circle text-info fs-3 me-2"></i>
            <h3 class="text-info fw-bold mb-0">Información del Activo</h3>
        </div>
        <hr/>
    </header>

    <a href="listar_activos.php" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left me-1"></i> Regresar
    </a>

    <?php if ($activo): ?>
    <div class="card col-md-10 mx-auto shadow-sm border-0">
        <div class="card-body">
            <div class="row g-3">
                
                <div class="col-md-3">
                    <h5 class="card-title text-muted">ID Activo</h5>
                    <p class="card-text text-dark fw-bold"><?= $activo->id_activo ?></p>
                </div>
                <div class="col-md-5">
                    <h5 class="card-title text-muted">Número de Serie</h5>
                    <p class="card-text text-dark"><?= $activo->serial_number ?></p>
                </div>
                <div class="col-md-4">
                    <h5 class="card-title text-muted">ID Categoría</h5>
                    <p class="card-text text-dark"><?= $activo->id_categoria ?></p>
                </div>
                
                <hr class="my-3">
                
                <div class="col-md-4">
                    <h5 class="card-title text-muted">Marca</h5>
                    <p class="card-text text-dark"><?= $activo->marca ?></p>
                </div>
                <div class="col-md-4">
                    <h5 class="card-title text-muted">Modelo</h5>
                    <p class="card-text text-dark"><?= $activo->modelo ?></p>
                </div>
                <div class="col-md-4">
                    <h5 class="card-title text-muted">Estado Actual</h5>
                    <p class="card-text text-danger fw-bold"><?= $activo->estado ?></p>
                </div>

                <hr class="my-3">

                <div class="col-md-4">
                    <h5 class="card-title text-muted">Fecha Compra</h5>
                    <p class="card-text text-dark"><?= $activo->fecha_compra ?></p>
                </div>
                <div class="col-md-4">
                    <h5 class="card-title text-muted">Precio de Compra</h5>
                    <p class="card-text text-dark">S/ <?= number_format($activo->precio, 2) ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="alert alert-danger mt-3 text-center">
            El activo con código <b><?= htmlspecialchars($id_activo) ?></b> no existe o no fue especificado.
        </div>
    <?php endif; ?>
</div>

<?php include("../../template/footer.php"); ?>
</body>
</html>