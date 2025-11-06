<?php
$route = "../../..";
$title = "Filtrar Mantenimientos";
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header>
        <h3 class="text-primary"><i class="fas fa-filter"></i> Filtrar Mantenimientos</h3>
        <hr/>
    </header>

    <nav class="mb-3">
        <a href="listar_mantenimientos.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-circle-left"></i> Regresar
        </a>
    </nav>

    <section>
        <article>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <form id="frm_filtrar_mant" autocomplete="off">
                                <div class="row g-3">
                                    <div class="col-md-10">
                                        <label for="txt_filtro" class="form-label">Buscar por Serial, Activo, Empleado o Descripción</label>
                                        <input type="text" class="form-control" id="txt_filtro" name="txt_filtro" 
                                               placeholder="Ingrese término de búsqueda..." autofocus>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-search"></i> Filtrar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div id="tabla_mantenimientos">
                        <!-- La tabla se cargará aquí mediante AJAX -->
                    </div>
                </div>
            </div>
        </article>
    </section>
</div>

<!-- Modal para Borrar -->
<div class="modal fade" id="md_borrar_mant" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger"><i class="fas fa-trash-alt"></i> Borrar Registro de Mantenimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h5>¿Seguro de borrar este registro?</h5>
                <p><span class="lbl_id_mant text-muted"></span></p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="#" class="btn_confirmar_borrar btn btn-outline-danger">Borrar</a>
            </div>
        </div>
    </div>
</div>

<?php include("../../template/footer.php"); ?>

<script>
$(document).ready(function() {
    // Cargar todos los registros al inicio
    cargarTabla('');
    
    // Filtrar al enviar el formulario
    $('#frm_filtrar_mant').on('submit', function(e) {
        e.preventDefault();
        var filtro = $('#txt_filtro').val();
        cargarTabla(filtro);
    });
    
    // Función para cargar la tabla
    function cargarTabla(valor) {
        $.ajax({
            url: '../../controller/ctr_filtrar_mantenimiento.php',
            type: 'POST',
            data: { valor: valor },
            success: function(response) {
                $('#tabla_mantenimientos').html(response);
                
                // Configurar eventos de borrado después de cargar la tabla
                $('.btn_borrar').on('click', function() {
                    var id = $(this).data('id');
                    $('.lbl_id_mant').text('ID: ' + id);
                    $('.btn_confirmar_borrar').attr('href', 'borrar_mantenimiento.php?idmant=' + id);
                });
            },
            error: function() {
                $('#tabla_mantenimientos').html('<div class="alert alert-danger">Error al cargar los datos.</div>');
            }
        });
    }
});
</script>
