<?php 
$route = "../../../";
$title = "Registrar Producto";
include("../../template/header.php");
?>

<body>
<?php
include("../../template/menubar.php");
include("../../template/loadclass.php");

// Cargar datos de marca y categoría
$crud_mar = new CRUDMarca();
$crud_cat = new CRUDCategoria();

$rs_mar = $crud_mar->ListarMarca();
$rs_cat = $crud_cat->ListarCategoria();

// Si se envió el formulario
if (isset($_POST["btn_grabar"])) {
    $producto = new Producto();
    $producto->codigo_producto = $_POST["txt_cod_prod"];
    $producto->producto = $_POST["txt_prod"];
    $producto->stock = $_POST["txt_stk"];
    $producto->costo = $_POST["txt_cst"];
    $producto->ganancia = $_POST["txt_gnc"] / 100; // convertir %
    $producto->producto_codigo_marca = $_POST["cbo_cod_mar"];
    $producto->producto_codigo_categoria = $_POST["cbo_cod_cat"];

    $crud_prod = new CRUDProducto();
    $crud_prod->RegistrarProducto($producto);

    header("location: listar.php");
    exit;
}
?>

<div class="container mt-4">
    <h3 class="text-success mb-3">
        <i class="fas fa-plus-circle"></i> Registrar Producto
    </h3>

    <form method="post" autocomplete="off">
        <div class="row g-3">
            <div class="col-md-4">
                <label>Código</label>
                <input type="text" name="txt_cod_prod" class="form-control" maxlength="5" required autofocus>
            </div>
            <div class="col-md-8">
                <label>Producto</label>
                <input type="text" name="txt_prod" class="form-control" maxlength="40" required>
            </div>
            <div class="col-md-4">
                <label>Stock</label>
                <input type="number" name="txt_stk" class="form-control" maxlength="5" required>
            </div>
            <div class="col-md-4">
                <label>Costo</label>
                <input type="number" name="txt_cst" class="form-control" step="0.01" maxlength="8" required>
            </div>
            <div class="col-md-4">
                <label>% Ganancia</label>
                <input type="number" name="txt_gnc" class="form-control" step="0.01" maxlength="5" required>
            </div>

            <div class="col-md-6">
                <label>Marca</label>
                <select name="cbo_cod_mar" class="form-select" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($rs_mar as $mar) { ?>
                        <option value="<?= $mar->codigo_marca ?>"><?= $mar->marca ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-6">
                <label>Categoría</label>
                <select name="cbo_cod_cat" class="form-select" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($rs_cat as $cat) { ?>
                        <option value="<?= $cat->codigo_categoria ?>"><?= $cat->categoria ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="text-center mt-3">
                <button type="submit" name="btn_grabar" class="btn btn-success">
                    <i class="fas fa-save"></i> Grabar Información
                </button>
                <a href="listar.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>
        </div>
    </form>

    <div class="mt-4 p-3 bg-light text-center border rounded">
        <small class="text-muted">© Desarrollo de Aplicaciones Web</small>
    </div>
</div>

<?php include("../../template/footer.php"); ?>
</body>
</html>
