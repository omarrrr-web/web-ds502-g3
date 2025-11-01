<!DOCTYPE html>
<html lang="es">
<?php
    $route = "../../../";
    $title = "Información del Producto";
    include("../../template/header.php");
?>
<body>
<?php
    include("../../template/menubar.php");
    include("../../template/loadclass.php");

    if (isset($_GET['cod'])) {
        $codigo = $_GET['cod'];
        $crud_prod = new CRUDProducto();
        $producto = $crud_prod->BuscarProductoPorCodigo($codigo);
    } else {
        die("<div class='alert alert-danger'>Código de producto no especificado.</div>");
    }
?>
<div class="container mt-4">
    <div class="d-flex align-items-center mb-3">
        <i class="fas fa-info-circle text-info fs-3 me-2"></i>
        <h3 class="text-info fw-bold mb-0">Información del Producto</h3>
    </div>

    <a href="listar.php" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left me-1"></i> Regresar
    </a>

    <?php if ($producto): ?>
    <div class="card col-md-10 mx-auto shadow-sm border-0">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <h5 class="card-title">Código</h5>
                    <p class="card-text"><?= $producto->codigo_producto ?></p>
                </div>
                <div class="col-md-4">
                    <h5 class="card-title">Producto</h5>
                    <p class="card-text"><?= $producto->producto ?></p>
                </div>
                <div class="col-md-4">
                    <h5 class="card-title">Stock disponible</h5>
                    <p class="card-text"><?= $producto->stock ?></p>
                </div>

                <div class="col-md-4">
                    <h5 class="card-title">Costo</h5>
                    <p class="card-text">S/ <?= number_format($producto->costo, 2) ?></p>
                </div>
                <div class="col-md-4">
                    <h5 class="card-title">% Ganancia</h5>
                    <p class="card-text"><?= $producto->ganancia ?></p>
                </div>
                <div class="col-md-4">
                    <h5 class="card-title">Precio</h5>
                    <p class="card-text">S/ <?= number_format($producto->precio, 2) ?></p>
                </div>

                <div class="col-md-6">
                    <h5 class="card-title">Marca</h5>
                    <p class="card-text"><?= $producto->presentacion_marca ?></p>
                </div>
                <div class="col-md-6">
                    <h5 class="card-title">Categoría</h5>
                    <p class="card-text"><?= $producto->categoria ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="alert alert-danger mt-3 text-center">
            El producto con código <b><?= $codigo ?></b> no existe.
        </div>
    <?php endif; ?>
</div>
<br>
<?php include("../../template/footer.php"); ?>
</body>
</html>
