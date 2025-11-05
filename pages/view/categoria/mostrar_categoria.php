<!DOCTYPE html>
<html lang="es">
<?php
// Define la ruta relativa a la raíz para las inclusiones estáticas
$route = "../../.."; 

// Incluimos el autoloader y los templates
include("../../template/loadclass.php");
$title = "Información de Categoría";
include("../../template/header.php");
?>
<body>
<?php
include("../../template/menubar.php");

// 1. Lógica PHP para obtener la categoría
if (isset($_GET['idcat'])) {
    $id_categoria = $_GET['idcat'];
    
    // USAR LA CLASE CORRECTA: CRUDCategoria (no CRUDActivos)
    $crud_cat = new CRUDCategoria(); 
    
    // USAR EL MÉTODO CORRECTO: BuscarCategoriaPorId (no BuscarActivoPorID)
    $categoria = $crud_cat->BuscarCategoriaPorId($id_categoria);
    
} else {
    // Si no se especificó el ID en la URL
    $id_categoria = null;
    $categoria = null;
}
?>

<div class="container mt-4">
    <div class="d-flex align-items-center mb-3">
        <i class="fas fa-info-circle text-info fs-3 me-2"></i>
        <h3 class="text-info fw-bold mb-0">Información de la Categoría</h3>
    </div>

    <a href="listar_categoria.php" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left me-1"></i> Regresar
    </a>

    <?php if ($categoria): ?>
    <div class="card col-md-8 mx-auto shadow-sm border-0">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <h5 class="card-title">ID Categoría</h5>
                    <p class="card-text"><?= $categoria->id_categoria ?></p>
                </div>
                <div class="col-md-8">
                    <h5 class="card-title">Nombre Categoría</h5>
                    <p class="card-text"><?= $categoria->nombre_categoria ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="alert alert-danger mt-3 text-center">
            La categoría con código <b><?= $id_categoria ?></b> no existe.
        </div>
    <?php endif; ?>
</div>

<?php include("../../template/footer.php"); ?>
</body>
</html>