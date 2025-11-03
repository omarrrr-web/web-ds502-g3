<?php
$route = "../../..";
$title = "Consultar Categoría";
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header>
        <h3 class="text-info"><i class="fas fa-search"></i> Consultar Categoría de Activo</h3>
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
                    <form id="frm_consultar_cat" name="frm_consultar_cat" method="post" autocomplete="off">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="number" class="form-control" id="txt_id_cat" name="txt_id_cat" 
                                   placeholder="Escriba el ID de la categoría a buscar..." autofocus>
                            
                            <button class="btn btn-outline-info" type="button" id="btn_consultar" name="btn_consultar">
                                Consultar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </article>
    </section>
    
    <section class="mt-3">
        <h4>Resultados:</h4>
        <div id="resultado_consulta">
            <!-- Aquí se mostrarán los resultados -->
        </div>
    </section>
</div>

<?php
include("../../template/footer.php");
?>