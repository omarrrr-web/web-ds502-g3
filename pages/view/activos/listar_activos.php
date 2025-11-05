<?php
$route = "../../..";
$title = "Gestión de Activos";
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header class="mb-3">
        <h1><i class="fas fa-box-open me-2"></i><?= $title ?></h1>
        <div class="btn-group" role="group" aria-label="Opciones de Activos">
            <a href="registrar_activos.php" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Registrar
            </a>
            <a href="consultar_activos.php" class="btn btn-outline-secondary">
                <i class="fas fa-search me-1"></i> Consultar
            </a>
            <a href="filtrar_activos.php" class="btn btn-outline-secondary">
                <i class="fas fa-filter me-1"></i> Filtrar
            </a>
            <a href="listar_inactivos.php" class="btn btn-outline-info">
                <i class="fas fa-trash-alt me-1"></i> Ver Inactivos
            </a>
        </div>
    </header>

    <section>
        <article>
            <div class="row">
                <div class="col-md-12">
                    <div id="tabla_activos">
                        <!-- La tabla de activos se cargará aquí mediante AJAX -->
                    </div>
                </div>
            </div>
        </article>
    </section>
</div>


<!-- Modal Genérico para Confirmaciones y Notificaciones -->
<div class="modal fade" id="modalGenerico" tabindex="-1" aria-labelledby="modalGenericoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="modalGenericoHeader">
                <h5 class="modal-title" id="modalGenericoTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalGenericoBody">
            </div>
            <div class="modal-footer" id="modalGenericoFooter">
            </div>
        </div>
    </div>
</div>

<!-- Modal Genérico para Mostrar Detalles -->
<div class="modal fade" id="md_mostrar_detalle" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="detalleModalLabel">Detalles</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="contenido_modal_detalle">
        <!-- El contenido se cargará aquí vía AJAX -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Editar Activo -->
<div class="modal fade" id="md_editar_activo" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Editar Activo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="editar_activo_content">
                    <!-- El formulario de edición se cargará aquí -->
                </div>
            </div>
        </div>
    </div>
    
</div>

<?php include("../../template/footer.php"); ?>


<script>
    // Función para cargar la tabla de activos
    function cargarTablaActivos() {
        $.ajax({
            url: '../../controller/ctr_filtrar_activo.php',
            type: 'POST',
            data: { valor: '' }, // Envía un valor vacío para obtener todos los activos activos
            success: function(response) {
                $('#tabla_activos').html(response);
            },
            error: function() {
                $('#tabla_activos').html('<div class="alert alert-danger">Error al cargar la tabla.</div>');
            }
        });
    }

    // Cargar la tabla al iniciar la página
    $(document).ready(function() {
        cargarTablaActivos();


    });
</script>

