<?php
$route = "../../..";
$title = "Consultar Activos";
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header>
        <h3 class="text-info"><i class="fas fa-search"></i> Consultar Activo</h3>
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
                    <form id="frm_consultar_act" name="frm_consultar_act" method="post" autocomplete="off">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="number" class="form-control" id="txt_id_activo" name="txt_id_activo" 
                                   placeholder="Escriba el ID del activo a buscar..." autofocus>
                            
                            <button class="btn btn-outline-info" type="button" id="btn_consultar_activo" name="btn_consultar_activo">
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
</div>

<?php
include("../../template/footer.php");
?>