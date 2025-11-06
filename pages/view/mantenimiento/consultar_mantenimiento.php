<?php
$route = "../../..";
$title = "Consultar Mantenimiento";
include("../../template/loadclass.php");
include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header>
        <h3 class="text-primary"><i class="fas fa-search"></i> Consultar Mantenimiento</h3>
        <hr/>
    </header>

    <nav class="mb-3">
        <a href="listar_mantenimientos.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-circle-left"></i> Regresar
        </a>
    </nav>

    <section>
        <article>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <form id="frm_consultar_mant" autocomplete="off">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label for="txt_id_mant" class="form-label">ID del Mantenimiento</label>
                                        <input type="number" class="form-control" id="txt_id_mant" name="txt_id_mant" 
                                               placeholder="Ingrese el ID" min="1" required autofocus>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div id="resultado_consulta" class="mt-4">
                        <!-- Aquí se mostrará el resultado -->
                    </div>
                </div>
            </div>
        </article>
    </section>
</div>

<?php include("../../template/footer.php"); ?>

<script>
$(document).ready(function() {
    $('#frm_consultar_mant').on('submit', function(e) {
        e.preventDefault();
        
        var idMant = $('#txt_id_mant').val();
        
        if (!idMant || idMant <= 0) {
            $('#resultado_consulta').html('<div class="alert alert-warning">Por favor, ingrese un ID válido.</div>');
            return;
        }
        
        $.ajax({
            url: '../../controller/ctr_consultar_mantenimiento.php',
            type: 'POST',
            data: { idmant: idMant },
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    $('#resultado_consulta').html('<div class="alert alert-danger">' + data.error + '</div>');
                } else {
                    var html = '<div class="card">';
                    html += '<div class="card-header bg-info text-white"><h5 class="mb-0">Resultado de la Búsqueda</h5></div>';
                    html += '<div class="card-body">';
                    html += '<table class="table table-bordered">';
                    html += '<tr><th width="30%">ID Mantenimiento</th><td>' + data.id_mantenimiento + '</td></tr>';
                    html += '<tr><th>Activo</th><td>' + data.activo_nombre + '</td></tr>';
                    html += '<tr><th>Serial</th><td>' + data.serial_number + '</td></tr>';
                    html += '<tr><th>Fecha Servicio</th><td>' + data.fecha_servicio + '</td></tr>';
                    html += '<tr><th>Descripción</th><td>' + data.descripcion.replace(/\n/g, '<br>') + '</td></tr>';
                    html += '<tr><th>Costo</th><td>S/ ' + parseFloat(data.costo).toFixed(2) + '</td></tr>';
                    html += '<tr><th>Realizado Por</th><td>' + data.empleado_nombre + '</td></tr>';
                    html += '</table>';
                    html += '<div class="text-center mt-3">';
                    html += '<a href="editar_mantenimiento.php?idmant=' + data.id_mantenimiento + '" class="btn btn-warning"><i class="fas fa-edit"></i> Editar</a> ';
                    html += '<a href="mostrar_mantenimiento.php?idmant=' + data.id_mantenimiento + '" class="btn btn-info"><i class="fas fa-eye"></i> Ver Detalles</a>';
                    html += '</div>';
                    html += '</div></div>';
                    
                    $('#resultado_consulta').html(html);
                }
            },
            error: function() {
                $('#resultado_consulta').html('<div class="alert alert-danger">Error al consultar el registro.</div>');
            }
        });
    });
});
</script>
