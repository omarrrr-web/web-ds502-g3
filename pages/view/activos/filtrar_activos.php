<?php
// Define la ruta DE DOS NIVELES (o tres si esa es la que funciona para estáticos)
$route = "../../.."; 
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header>
        <h3 class="text-warning"><i class="fas fa-filter"></i> Filtrar Activos de TI</h3>
        <hr/>
    </header>
    
    <nav class="mb-3">
        <a href="listar_activos.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-circle-left"></i> Regresar
        </a>
    </nav>
    
    <section>
        <article>
            <div class="row justify-content-center mt-3">
                <div class="col-md-6">
                    <form id="frm_filtrar_act" name="frm_filtrar_act" method="post" autocomplete="off">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            
                            <input type="text" class="form-control" id="txt_valor" name="txt_valor" 
                                   maxlength="100" placeholder="Buscar por Serial, Marca o Modelo..." autofocus>
                            
                            <button class="btn btn-outline-success" type="button" id="btn_filtrar" name="btn_filtrar">
                                Filtrar
                            </button>
                            <a class="btn btn-outline-primary" href="filtrar_activos.php">Nuevo</a>
                        </div>
                    </form>
                </div>
            </div>
        </article>
    </section>
    
    <section class="mt-3">
        <h4>Resultados:</h4>
        <div id="tabla_resultados_act">
            <div class="alert alert-info text-center">Ingrese un valor para iniciar la búsqueda.</div>
        </div>
    </section>
    <?php include("../../template/footer.php"); ?>
</div>

<?php
include("../../template/footer.php");
?>