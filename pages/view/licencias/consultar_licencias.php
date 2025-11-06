<?php
// Define la ruta DE DOS NIVELES
$route = "../../.."; 
include("../../template/loadclass.php");
$title = "Consultar Licencia";
include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header>
        <h3 class="text-info"><i class="fa fa-search"></i> Consultar Licencia por ID</h3>
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
                <div class="card col-md-6">
                    <div class="card-body">
                        <form id="frm_consultar_lic" name="frm_consultar_lic" method="post" autocomplete="off">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="txt_id_lic" class="form-label">ID Licencia</label>
                                    <input type="number" class="form-control" id="txt_id_lic" name="txt_id_lic" 
                                           placeholder="ID a buscar" autofocus min="1">
                                </div>
                            </div>
                        </form>
                        
                        <div class="mt-4 p-3 border rounded">
                            <h5>Detalles:</h5>
                            <div id="resultado_consulta_lic">
                                <div class="alert alert-info">Ingrese un ID para ver los detalles de la licencia.</div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="consultar_licencias.php" class="btn btn-outline-primary"><i class="fa fa-file"></i> Nueva Consulta</a>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </section>
    <?php include("../../template/footer.php"); ?>
</div>
