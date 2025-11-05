<?php
// Define la ruta relativa a la raíz para las inclusiones estáticas
$route = "../../..";
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");

// 1. Capturar el ID y buscar el registro
if (!isset($_GET['idcat'])) {
    // Si no hay ID, redirigir al listado (manejo de error básico)
    header("location: listar_categoria.php");
    exit();
}

$id_cat = $_GET['idcat'];
$crudcategoria = new CRUDCategoria();
$categoria_actual = $crudcategoria->BuscarCategoriaPorId($id_cat);

// Verificar si la categoría existe (manejo de error)
if (!$categoria_actual) {
    echo '<div class="alert alert-danger">Categoría no encontrada.</div>';
    exit();
}
?>

<div class="container mt-3">
    <header>
        <h3 class="text-success"><i class="fas fa-pen-square"></i> Editar Categoría de Activo</h3>
        <hr/>
    </header>
    <nav class="mb-3">
        <a href="listar_categoria.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-circle-left"></i> Regresar
        </a>
    </nav>
    
    <section>
        <article>
            <div class="row justify-content-center">
                <div class="card col-md-6">
                    <div class="card-body">
                        <form id="frm_editar_cat" name="frm_editar_cat" method="post" action="../../controller/ctr_grabar_categoria.php" autocomplete="off">
                            
                            <input type="hidden" id="txt_tipo" name="txt_tipo" value="e">
                            
                            <input type="hidden" id="txt_id_cat" name="txt_id_cat" value="<?= $categoria_actual->id_categoria ?>">

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="txt_nombre_cat" class="form-label">Nombre Categoría</label>
                                    <input type="text" class="form-control" id="txt_nombre_cat" name="txt_nombre_cat" 
                                           placeholder="Ej: Laptop" maxlength="100" required autofocus 
                                           
                                           value="<?= $categoria_actual->nombre_categoria ?>">
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-outline-success" id="btn_editar" name="btn_editar">
                                    <i class="fas fa-sync-alt"></i> Actualizar Información
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </section>
</div>

<?php
include("../../template/footer.php");
?>