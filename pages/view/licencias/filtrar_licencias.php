<?php
// Define la ruta DE DOS NIVELES
$route = "../../.."; 
include("../../template/loadclass.php");
$title = "Filtrar Licencias";
include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header>
        <h3 class="text-info"><i class="fas fa-filter"></i> Filtrar Licencias</h3>
        <hr/>
    </header>
    
    <nav class="mb-3">
        <a href="listar_licencias.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-circle-left"></i> Regresar
        </a>
    </nav>
    
    <section>
        <article>
            <div class="row justify-content-center mt-3">
                <div class="col-md-6">
                    <form id="frm_filtrar_lic" name="frm_filtrar_lic" method="post" autocomplete="off">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            
                            <input type="text" class="form-control" id="txt_valor_lic" name="txt_valor_lic" 
                                   maxlength="150" placeholder="Buscar por Nombre o Clave de Licencia..." autofocus>
                            
                            <button class="btn btn-outline-success" type="button" id="btn_filtrar_lic" name="btn_filtrar_lic">
                                Filtrar
                            </button>
                            <a class="btn btn-outline-primary" href="filtrar_licencias.php">Nuevo</a>
                        </div>
                    </form>
                </div>
            </div>
        </article>
    </section>
    
    <section class="mt-3">
        <h4>Resultados:</h4>
        <div id="tabla_resultados_lic">
            <div class="alert alert-info text-center">Ingrese un valor para iniciar la búsqueda.</div>
        </div>
    </section>
    <?php include("../../template/footer.php"); ?>
</div>

