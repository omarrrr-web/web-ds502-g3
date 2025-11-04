// pages/view/registrar_categoria.php
<?php
$route = "../../..";
$title = "Registrar Categoría";
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");

// Instanciamos el modelo solo si fuera necesario (aquí no se necesita)
//$crudcategoria = new CRUDCategoria(); 
?>

<div class="container mt-3">
    <header>
        <h3 class="text-success"><i class="fas fa-plus-circle"></i> Registrar Categoría de Activo</h3>
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
                        <form id="frm_registrar_cat" name="frm_registrar_cat" method="post" action="../../controller/ctr_grabar_categoria.php" autocomplete="off">
                            
                            <input type="hidden" id="txt_tipo" name="txt_tipo" value="r">

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="txt_nombre_cat" class="form-label">Nombre Categoría</label>
                                    <input type="text" class="form-control" id="txt_nombre_cat" name="txt_nombre_cat" 
                                           placeholder="Ej: Laptop" maxlength="100" required autofocus>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-outline-success" id="btn_registrar" name="btn_registrar">
                                    <i class="fas fa-save"></i> Grabar Información
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