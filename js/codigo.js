$(function () {

    // --- CONSULTAR CATEGORÍA (AJAX) ---
    $('#btn_consultar').on('click', function() {
        var id_cat = $('#txt_id_cat').val();
        if (id_cat) {
            $.ajax({
                url: '../../controller/ctr_consultar_categoria.php',
                type: 'POST',
                data: {
                    id_cat: id_cat
                },
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        var html = '<table class="table table-bordered">';
                        html += '<tr><th>ID Categoría</th><td>' + response.id_categoria + '</td></tr>';
                        html += '<tr><th>Nombre Categoría</th><td>' + response.nombre_categoria + '</td></tr>';
                        html += '</table>';
                        $('#resultado_consulta').html(html);
                    } else {
                        $('#resultado_consulta').html('<div class="alert alert-warning">No se encontraron resultados para el ID ' + id_cat + '.</div>');
                    }
                },
                error: function() {
                    $('#resultado_consulta').html('<div class="alert alert-danger">Error al realizar la consulta.</div>');
                }
            });
        } else {
            $('#resultado_consulta').html('<div class="alert alert-info">Por favor, ingrese un ID de categoría.</div>');
        }
    });

    // --- FILTRAR CATEGORÍA (AJAX) ---
    $("#frm_filtrar_cat #btn_filtrar").on("click", function (e) {
        e.preventDefault();
        var valor = $("#txt_valor").val();

        if (valor !== "") {
            $.post(
                "../../controller/ctr_filtrar_categoria.php",
                { txt_valor: valor },
                function (rpta) {
                    $("#tabla_resultados").html(rpta);
                }
            );
        } else {
            $("#tabla_resultados").html('<div class="alert alert-warning">Escriba un valor para filtrar...</div>');
            $("#txt_valor").focus();
        }
    });

    // --- BORRAR CATEGORÍA (Modal y JS) ---
    $(document).on("click", ".reg_categoria .btn_borrar", function (e) {
        e.preventDefault();

        // 1. Capturar ID y Nombre de los data attributes del botón
        let id_cat = $(this).data("id");
        let nombre_cat = $(this).data("nombre");

        // 2. Llenar el modal con la información
        $("#md_borrar_cat .lbl_nombre_cat").text(nombre_cat);
        $("#md_borrar_cat .lbl_id_cat").text("(" + id_cat + ")");

        // 3. Crear el enlace de borrado que apunta al controlador
        let delete_url = "../../controller/ctr_borrar_categoria.php?id_cat=" + id_cat;
        $("#md_borrar_cat .btn_confirmar_borrar").attr("href", delete_url);

        // 4. Mostrar el modal (asumiendo Bootstrap 5)
        $("#md_borrar_cat").modal("show");
    });

    // --- BORRAR ACTIVO (Modal y JS) ---
    $(document).on("click", ".reg_activo .btn_borrar", function (e) {
        e.preventDefault();

        // 1. Capturar ID y Serial de los data attributes del botón
        let id_act = $(this).data("id");
        let serial_act = $(this).data("serial");

        // 2. Llenar el modal con la información
        $("#md_borrar_act .lbl_nombre_act").text(serial_act);
        $("#md_borrar_act .lbl_id_act").text("(" + id_act + ")");

        // 3. Crear el enlace de borrado que apunta al controlador
        let delete_url = "../../controller/ctr_borrar_activo.php?idact=" + id_act;
        $("#md_borrar_act .btn_confirmar_borrar").attr("href", delete_url);

        // 4. Mostrar el modal (asumiendo Bootstrap 5)
        $("#md_borrar_act").modal("show");
    });
    // --- FILTRAR ACTIVOS (AJAX) ---
    $("#frm_filtrar_act #btn_filtrar").on("click", function(e) {
        e.preventDefault();
        
        var valor = $("#txt_valor").val();
    
        if (valor !== "") {
            $.post(
                // RUTA AJUSTADA: Sale de view/activos/ y entra a controller/
                "../../controller/ctr_filtrar_activo.php", 
                { valor: valor }, // Parámetro de búsqueda
                function(rpta) {
                    // El controlador devuelve la tabla HTML completa
                    $("#tabla_resultados_act").html(rpta); 
                }
            );
        } else {
            $("#tabla_resultados_act").html('<div class="alert alert-warning">Escriba un valor para filtrar...</div>');
            $("#txt_valor").focus();
        }
    });
    
        // --- CONSULTAR ACTIVO POR BOTON (AJAX) ---
        $('#btn_consultar_activo').on('click', function() {
            let id_act = $('#txt_id_activo').val();
            let resultado_div = $('#resultado_consulta');
    
            resultado_div.html(''); // Limpiar resultados anteriores
    
            if (id_act) {
                $.ajax({
                    url: '../../controller/ctr_consultar_activo.php',
                    type: 'POST',
                    data: { id_act: id_act },
                    dataType: 'json',
                    success: function(response) {
                        if (response && response.id_activo) {
                            var html = '<div class="card p-3">';
                            html += '<table class="table table-sm">';
                            html += '<tr><th>ID Activo</th><td>' + response.id_activo + '</td></tr>';
                            html += '<tr><th>Serial Number</th><td>' + response.serial_number + '</td></tr>';
                            html += '<tr><th>Marca / Modelo</th><td>' + response.marca + ' / ' + response.modelo + '</td></tr>';
                            html += '<tr><th>ID Categoría</th><td>' + response.id_categoria + '</td></tr>';
                            html += '<tr><th>Fecha Compra</th><td>' + response.fecha_compra + '</td></tr>';
                            html += '<tr><th>Precio (S/)</th><td>' + parseFloat(response.precio).toFixed(2) + '</td></tr>';
                            html += '<tr><th>Estado</th><td class="fw-bold text-danger">' + response.estado + '</td></tr>';
                            html += '</table></div>';
                            resultado_div.html(html);
                        } else {
                            resultado_div.html('<div class="alert alert-warning">No se encontró ningún activo con el ID ' + id_act + '.</div>');
                        }
                    },
                    error: function() {
                        resultado_div.html('<div class="alert alert-danger">Error de comunicación al consultar el servidor.</div>');
                    }
                });
            } else {
                resultado_div.html('<div class="alert alert-info">Por favor, ingrese un ID de Activo.</div>');
            }
        });
});