<?php
    $route = "../../../";
    $title = "Activos en Baja";
    include("../../template/loadclass.php");
    include("../../template/header.php");
    include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header class="mb-3">
        <h1><i class="fas fa-trash-alt me-2"></i><?= $title ?></h1>
        <div class="btn-group" role="group">
            <a href="listar_activos.php" class="btn btn-outline-primary">
                <i class="fas fa-box-open me-1"></i> Ver Activos
            </a>
        </div>
    </header>

    <section>
        <article>
            <div class="row">
                <div class="col-md-12">
                    <div id="tabla_activos_inactivos">
                        
                    </div>
                </div>
            </div>
        </article>
    </section>
    <?php include("../../template/footer.php"); ?>
</div>



<script>
    
    function cargarTablaInactivos() {
        $.ajax({
            url: '../../controller/ctr_filtrar_activos_desactivados.php', 
            type: 'POST',
            data: { valor: '' },
            success: function(response) {
                $('#tabla_activos_inactivos').html(response);
            },
            error: function() {
                $('#tabla_activos_inactivos').html('<div class="alert alert-danger">Error al cargar la tabla.</div>');
            }
        });
    }

    $(document).ready(function() {
        cargarTablaInactivos();


    });
</script>
