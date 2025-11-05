<?php
$route = "../../..";
$title = "Filtrar Categorías";
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header>
        <h3 class="text-secondary"><i class="fas fa-filter"></i> Filtrar Categorías de Activo</h3>
        <hr/>
    </header>
    
    <nav class="mb-3">
        <a href="listar_categoria.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-circle-left"></i> Regresar
        </a>
    </nav>
    
    <section>
        <article>
            <div class="row justify-content-center mt-3">
                <div class="col-md-6">
                    <form id="frm_filtrar_cat" name="frm_filtrar_cat" method="post" autocomplete="off">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" id="txt_valor" name="txt_valor" 
                                   maxlength="100" placeholder="Escriba el nombre a buscar..." autofocus>
                            
                            <button class="btn btn-outline-success" type="button" id="btn_filtrar" name="btn_filtrar">
                                Filtrar
                            </button>
                            <a class="btn btn-outline-primary" href="filtrar_categoria.php">Nuevo</a>
                        </div>
                    </form>
                </div>
            </div>
        </article>
    </section>
    
    <section class="mt-3">
        <h4>Resultados:</h4>
        <div id="tabla_resultados">
            </div>
    </section>
</div>

<?php
include("../../template/footer.php");
?>