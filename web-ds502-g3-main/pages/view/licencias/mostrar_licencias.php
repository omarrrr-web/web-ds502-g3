<!DOCTYPE html>
<html lang="es">
<?php
// Definir la ruta de dos niveles
$route = "../../.."; 

// Incluimos el autoloader y los templates
include("../../template/loadclass.php");

// Instanciamos el CRUD Categoria para obtener el nombre de la categoría (si no viene en la búsqueda principal)
$crudcategoria = new CRUDCategoria(); 

$title = "Detalle de Licencia";
include("../../template/header.php");
?>
<body>
<?php
include("../../template/menubar.php");

// 1. Lógica PHP para obtener la licencia
$id_licencia = null;
$licencia = null;

if (isset($_GET['idlic'])) {
    $id_licencia = $_GET['idlic'];
    
    // USAR LA CLASE CORRECTA: CRUDLicencia
    $crud_lic = new CRUDLicencia(); 
    
    // 2. Buscar la licencia por ID
    $licencia = $crud_lic->BuscarLicenciaPorId($id_licencia);
    
    // 3. Si la licencia existe, buscar el nombre de la categoría
    if ($licencia) {
        $categoria = $crudcategoria->BuscarCategoriaPorId($licencia->id_categoria);
        // Añadir el nombre de la categoría al objeto licencia para mostrar
        $licencia->nombre_categoria = $categoria->nombre_categoria ?? 'Desconocida';
    }
}
?>

<div class="container mt-4">
    <header>
        <div class="d-flex align-items-center mb-3">
            <i class="fas fa-info-circle text-info fs-3 me-2"></i>
            <h3 class="text-info fw-bold mb-0">Detalles de Licencia de Software</h3>
        </div>
        <hr/>
    </header>

    <a href="listar_licencias.php" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left me-1"></i> Regresar
    </a>

    <?php if ($licencia): ?>
    <div class="card col-md-10 mx-auto shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><?= $licencia->nombre_software ?></h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                
                <div class="col-md-4">
                    <h5 class="card-title text-muted">ID Licencia</h5>
                    <p class="card-text text-dark fw-bold"><?= $licencia->id_licencia ?></p>
                </div>
                <div class="col-md-8">
                    <h5 class="card-title text-muted">Clave de Licencia</h5>
                    <p class="card-text text-dark fw-bold"><?= $licencia->clave_licencia ?></p>
                </div>
                
                <hr class="my-3">
                
                <div class="col-md-6">
                    <h5 class="card-title text-muted">Categoría</h5>
                    <p class="card-text text-dark"><?= $licencia->nombre_categoria ?></p>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title text-muted">Usuarios/Asientos</h5>
                    <p class="card-text text-dark"><?= $licencia->cantidad_usuarios ?></p>
                </div>

                <hr class="my-3">

                <div class="col-md-12">
                    <h5 class="card-title text-muted">Fecha de Expiración</h5>
                    <?php 
                    $expira = $licencia->fecha_expiracion;
                    $estado_exp = ($expira && strtotime($expira) < strtotime('today')) ? 'text-danger' : 'text-success';
                    ?>
                    <p class="card-text fw-bold <?= $estado_exp ?>">
                        <?= $expira ? date('d/m/Y', strtotime($expira)) : 'PERPETUA / INDEFINIDA' ?>
                    </p>
                </div>

            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="alert alert-danger mt-3 text-center">
            La licencia con ID <b><?= $id_licencia ?></b> no existe o no fue especificada.
        </div>
    <?php endif; ?>
</div>

<?php include("../../template/footer.php"); ?>
</body>
</html>