<?php
// -----------------------------------------------------------------------------
// CONTROLADOR: ctr_grabar_prod.php
// Descripción: Recibe los datos del formulario de producto y los envía a CRUD.
// Adaptado al formato del profesor, compatible con tus clases y métodos.
// -----------------------------------------------------------------------------

include("../template/loadclass.php");

$crudproducto = new CRUDProducto();

// Validar que el formulario se haya enviado correctamente
if (isset($_POST["btn_registrar_prod"])) {

    // Crear el objeto producto y asignar los valores del formulario
    $producto = new Producto();
    $producto->codigo_producto = $_POST["txt_cod_prod"];
    $producto->producto = $_POST["txt_prod"];
    $producto->stock = $_POST["txt_stk"];
    $producto->costo = $_POST["txt_cst"];
    $producto->ganancia = $_POST["txt_gnc"] / 100; // porcentaje → decimal
    $producto->producto_codigo_marca = $_POST["cbo_cod_mar"];
    $producto->producto_codigo_categoria = $_POST["cbo_cod_cat"];

    // Determinar tipo de acción (registrar o editar)
    $tipo = isset($_POST["txt_tipo"]) ? $_POST["txt_tipo"] : "r";

    try {
        if ($tipo == "r") {
            $crudproducto->RegistrarProducto($producto);
        } elseif ($tipo == "e") {
            $crudproducto->EditarProducto($producto);
        }

        // Redirigir al listado de productos
        header("Location: ../view/producto/listar.php");
        exit;
    } catch (PDOException $ex) {
        echo "<div style='margin:20px; padding:10px; color:red; font-family:Arial;'>
                <b>Error:</b> No se pudo registrar el producto.<br>
                <small>Detalle técnico: " . $ex->getMessage() . "</small>
              </div>";
    }
} else {
    echo "<div style='margin:20px; padding:10px; color:red; font-family:Arial;'>
            <b>Acceso no permitido.</b> Por favor ingrese desde el formulario.
          </div>";
}
?>
