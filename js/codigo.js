// --- CÓDIGO PARA EL MÓDULO DE EMPLEADOS ---

// Función de ayuda para el modal genérico
function mostrarModal(titulo, cuerpo, tipo = 'primary') {
    const modal = $('#modalGenerico');
    const header = $('#modalGenericoHeader');
    const footer = $('#modalGenericoFooter');

    // Limpiar clases de color anteriores
    header.removeClass('bg-success bg-warning bg-danger bg-info bg-primary');
    header.addClass(`bg-${tipo}`);

    // Asignar contenido
    modal.find('#modalGenericoTitle').text(titulo);
    modal.find('#modalGenericoBody').html(cuerpo);

    // Limpiar y configurar botones del footer
    footer.empty();
    if (tipo === 'confirm') {
        footer.append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>');
        footer.append('<button type="button" class="btn btn-danger" id="btn-confirmar-accion">Confirmar</button>');
    } else {
        footer.append('<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>');
    }

    // Mostrar el modal
    const modalInstance = new bootstrap.Modal(document.getElementById('modalGenerico'));
    modalInstance.show();
}

// Nueva función genérica para cargar tablas
function cargarTablaGenerica(divId, data = {}) {
    const $tablaDiv = $(divId);
    if ($tablaDiv.length) {
        $tablaDiv.html("<p class='text-center'>Cargando datos...</p>");
        $.ajax({
            url: '../../controller/ctd_tabla_empleados.php', // URL unificada
            type: "POST",
            data: data,
            success: function(response) {
                $tablaDiv.html(response);
                // Lógica para el modal de "Sin Resultados" en la página de filtro
                if (data.accion === 'filtrar' && data.termino_busqueda && response.includes("No se encontraron empleados")) {
                    mostrarModal('Búsqueda sin Resultados', 'No se encontraron empleados que coincidan con el término de búsqueda.', 'warning');
                }
            }
        });
    }
}

$(document).ready(function(){
    // --- Lógica para mostrar modal de éxito ---
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('registro') === 'exito' || urlParams.get('edicion') === 'exito') {
        const mensaje = urlParams.get('registro') === 'exito' ? 'El empleado ha sido registrado correctamente.' : 'El empleado ha sido actualizado correctamente.';
        mostrarModal('¡Éxito!', mensaje, 'success');
        const cleanURL = window.location.protocol + "//" + window.location.host + window.location.pathname;
        window.history.replaceState({path: cleanURL}, '', cleanURL);
    }

    // Cargas iniciales de tablas
    cargarTablaGenerica('#tabla_empleados', { accion: 'listar_activos' });
    cargarTablaGenerica('#tabla_empleados_inactivos', { accion: 'listar_inactivos' });

    // Carga inicial para la página de filtro
    if ($("#tabla_empleados_filtrados").length) {
        const terminoInicial = urlParams.get('termino') || '';
        $("#input-filtro-filtrar").val(terminoInicial);
        if (terminoInicial) {
            cargarTablaGenerica('#tabla_empleados_filtrados', { accion: 'filtrar', termino_busqueda: terminoInicial });
        } else {
            $("#tabla_empleados_filtrados").html("<p class='text-center'>Utiliza el campo de búsqueda para filtrar empleados.</p>");
        }
    }

    // Evento para el botón Mostrar
    $(document).on("click", ".btn-mostrar", function(){
        let id_empleado = $(this).data("id");

        $.ajax({
            url: "../../controller/ctd_buscar_empleado.php",
            type: "POST",
            dataType: "json",
            data: { id_empleado: id_empleado },
            success: function(empleado){
                const cuerpo = `<h5><strong>${empleado.nombre} ${empleado.apellido}</strong></h5>
                                <hr>
                                <p><strong>ID:</strong> ${empleado.id_empleado}</p>
                                <p><strong>Email:</strong> ${empleado.email}</p>
                                <p><strong>Estado:</strong> ${empleado.activo == 1 ? "<span class='badge bg-success'>Activo</span>" : "<span class='badge bg-danger'>Inactivo</span>"}</p>
                                <p><strong>Rol:</strong> ${empleado.nombre_rol}</p>`;
                mostrarModal('Detalles del Empleado', cuerpo, 'info');
            }
        });
    });

    // Evento para el botón Desactivar
    let id_empleado_a_desactivar = null;
    $(document).on("click", ".btn-desactivar", function(){
        id_empleado_a_desactivar = $(this).data("id");
        mostrarModal('Confirmar Desactivación', '¿Estás seguro de que deseas desactivar a este empleado?', 'confirm');
    });

    // Evento para el botón de confirmación final en el modal de desactivar
    $(document).on("click", "#btn-confirmar-accion", function(){
        if (id_empleado_a_desactivar) {
            $.ajax({
                url: "../../controller/ctd_desactivar_empleado.php",
                type: "POST",
                dataType: "json",
                data: { id_empleado: id_empleado_a_desactivar },
                success: function(response){
                    if(response.status === 'success'){
                        bootstrap.Modal.getInstance(document.getElementById('modalGenerico')).hide();
                        cargarTablaGenerica('#tabla_empleados', { accion: 'listar_activos' }); // Recargar tabla de activos
                        id_empleado_a_desactivar = null;
                    } else {
                        mostrarModal('Error', 'Error al desactivar el empleado.', 'danger');
                    }
                }
            });
        }
    });

    // Evento para el botón Buscar en la página de filtrar
    $(document).on("click", "#btn-aplicar-filtro-filtrar", function(){
        let termino = $("#input-filtro-filtrar").val();
        cargarTablaGenerica('#tabla_empleados_filtrados', { accion: 'filtrar', termino_busqueda: termino });
        const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + (termino ? '?termino=' + encodeURIComponent(termino) : '');
        window.history.replaceState({path: newUrl}, '', newUrl);
    });

    // Evento para el botón Limpiar en la página de filtrar
    $(document).on("click", "#btn-limpiar-filtro-filtrar", function(){
        $("#input-filtro-filtrar").val('');
        $("#tabla_empleados_filtrados").html("<p class='text-center'>Utiliza el campo de búsqueda para filtrar empleados.</p>");
        const cleanURL = window.location.protocol + "//" + window.location.host + window.location.pathname;
        window.history.replaceState({path: cleanURL}, '', cleanURL);
    });

    // Evento para el botón Activar
    $(document).on("click", ".btn-activar", function(){
        let id_empleado = $(this).data("id");
        $.ajax({
            url: "../../controller/ctd_activar_empleado.php",
            type: "POST",
            dataType: "json",
            data: { id_empleado: id_empleado },
            success: function(response){
                if(response.status === 'success'){
                    mostrarModal('¡Éxito!', 'El empleado ha sido activado correctamente y ahora aparecerá en la lista principal.', 'success');
                    cargarTablaGenerica('#tabla_empleados_inactivos', { accion: 'listar_inactivos' }); // Recargar tabla de inactivos
                } else {
                    mostrarModal('Error', 'Error al activar el empleado.', 'danger');
                }
            }
        });
    });

    // --- CÓDIGO PARA LA PÁGINA DE CONSULTA DE EMPLEADOS ---
    if ($("#consulta_id").length) {
        $("#consulta_id").on("keypress", function(e) {
            if (e.which == 13) { // 13 es el código de la tecla Enter
                e.preventDefault();
                let id_empleado = $(this).val();

                if (id_empleado === '') return;

                $.ajax({
                    url: "../../controller/ctd_buscar_empleado.php",
                    type: "POST",
                    dataType: "json",
                    data: { id_empleado: id_empleado },
                    success: function(empleado){
                        $("#consulta_nombre").val(empleado.nombre);
                        $("#consulta_apellido").val(empleado.apellido);
                        $("#consulta_email").val(empleado.email);
                        $("#consulta_rol").val(empleado.nombre_rol);
                    },
                    error: function(){
                        mostrarModal('Error en la Búsqueda', 'No se encontró ningún empleado con el ID proporcionado.', 'warning');
                        // Limpiar campos
                        $("#consulta_nombre").val('');
                        $("#consulta_apellido").val('');
                        $("#consulta_email").val('');
                        $("#consulta_rol").val('');
                    }
                });
            }
        });
    }
});