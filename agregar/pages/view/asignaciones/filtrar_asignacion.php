<?php
$route = "../../..";
$title = "Filtrar Asignaciones";
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header>
        <h3 class="text-secondary"><i class="fas fa-filter"></i> Filtrar Asignaciones</h3>
        <hr/>
    </header>
    
    <nav class="mb-3">
        <a href="listar_asignaciones.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-circle-left"></i> Regresar
        </a>
    </nav>
    
    <section>
        <article>
            <div class="row justify-content-center mt-3">
                <div class="col-md-6">
                    <form id="frm_filtrar_asig" name="frm_filtrar_asig" method="post" autocomplete="off">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" id="txt_valor" name="txt_valor" 
                                   maxlength="100" placeholder="Escriba el nombre del empleado o ID de activo..." autofocus>
                            

                            <button class="btn btn-outline-success" type="submit" id="btn_filtrar" name="btn_filtrar">
                                Filtrar
                            </button>
                            <a class="btn btn-outline-primary" href="filtrar_asignacion.php">Nuevo</a>
                        </div>
                    </form>
                </div>
            </div>
        </article>
    </section>
    
    <section class="mt-3">
        <h4>Resultados:</h4>
        <div id="tabla_resultados">
            <?php
            if (isset($_POST["txt_valor"])) {
                $valor = $_POST["txt_valor"];
                // Llama al método para filtrar asignaciones
                $crudAsignaciones = new CRUDAsignaciones();
                $crudAsignaciones->FiltrarAsignaciones($valor);
            }
            ?>
        </div>
    </section>
</div>

<?php
include("../../template/footer.php");
?>
