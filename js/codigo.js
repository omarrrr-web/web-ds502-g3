'use strict';

$(document).ready(function() {
    moduloRol.init();
    moduloEmpleado.init();

    const urlParams = new URLSearchParams(window.location.search);
    const registroExitoso = urlParams.get('registro') === 'exito';
    const edicionExitosa = urlParams.get('edicion') === 'exito';

    if (registroExitoso || edicionExitosa) {
        const mensaje = registroExitoso ? 'El registro ha sido creado correctamente.' : 'El registro ha sido actualizado correctamente.';
        helpers.mostrarModal('¡Éxito!', mensaje, 'success');
        helpers.limpiarUrl();
    }
});

// ==================================================================================
// HELPERS (Funciones de Ayuda Genéricas)
// ==================================================================================
const helpers = {
    /**
     * Realiza una petición AJAX genérica.
     * @param {string} url - La URL a la que se enviará la petición.
     * @param {object} data - Los datos a enviar.
     * @param {string} dataType - El tipo de datos esperado en la respuesta ('json', 'html', etc.).
     * @returns {Promise} - Una promesa de jQuery.
     */
    realizarAjax: function(url, data, dataType = 'json') {
        return $.ajax({
            url: url,
            type: 'POST',
            dataType: dataType,
            data: data,
        });
    },

    /**
     * Muestra un modal genérico con contenido dinámico.
     */
    mostrarModal: function(titulo, cuerpo, tipo = 'primary', callbackConfirmacion = null) {
        const modal = $('#modalGenerico');
        const header = $('#modalGenericoHeader');
        const footer = $('#modalGenericoFooter');

        header.removeClass('bg-success bg-warning bg-danger bg-info bg-primary').addClass(`bg-${tipo}`);
        modal.find('#modalGenericoTitle').text(titulo);
        modal.find('#modalGenericoBody').html(cuerpo);
        footer.empty();

        if (tipo === 'confirm') {
            footer.append('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>');
            const btnConfirmar = $('<button type="button" class="btn btn-danger" id="btn-confirmar-accion">Confirmar</button>');
            
            if (callbackConfirmacion) {
                btnConfirmar.off('click').on('click', callbackConfirmacion);
            }
            footer.append(btnConfirmar);
        } else {
            footer.append('<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>');
        }

        new bootstrap.Modal(document.getElementById('modalGenerico')).show();
    },

    /**
     */
    cargarContenido: function(divId, url, data = {}) {
        const $div = $(divId);
        if ($div.length) {
            $div.html("<p class='text-center'>Cargando datos...</p>");
            this.realizarAjax(url, data, 'html')
                .done(response => {
                    $div.html(response);
                })
                .fail(() => {
                    $div.html("<p class='text-center text-danger'>Error al cargar los datos.</p>");
                });
        }
    },

    /**
     * Limpia los parámetros de la URL.
     */
    limpiarUrl: function() {
        const cleanURL = `${window.location.protocol}//${window.location.host}${window.location.pathname}`;
        window.history.replaceState({ path: cleanURL }, '', cleanURL);
    }
};

// ==================================================================================
// MÓDULO DE ROLES
// ==================================================================================
const moduloRol = {
    init: function() {
        this.cargarTabla();
        this.vincularEventos();
    },

    cargarTabla: function() {
        helpers.cargarContenido('#tabla_roles', '../../controller/ctd_tabla_roles.php');
    },

    vincularEventos: function() {
        const self = this; // Guardar referencia para usar dentro de los callbacks

        // --- Eventos Comunes de la Tabla ---
        $(document).on('click', '.btn-mostrar-rol', function() {
            self.mostrarRol($(this).data('id'));
        });

        $(document).on('click', '.btn-eliminar', function() {
            self.eliminarRol($(this).data('id'));
        });

        // --- Eventos de la Página de Consulta ---
        $('#consulta_id_rol').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                self.consultarRol($(this).val());
            }
        });

        // --- Eventos de la Página de Filtro ---
        $('#input-filtro-rol').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#btn-aplicar-filtro-rol').click();
            }
        });

        $('#btn-aplicar-filtro-rol').on('click', function() {
            self.filtrarRoles($('#input-filtro-rol').val());
        });

        $('#btn-limpiar-filtro-rol').on('click', function() {
            $('#input-filtro-rol').val('');
            $('#tabla_roles_filtrados').html("<p class='text-center'>Utiliza el campo de búsqueda para filtrar roles.</p>");
        });
    },

    mostrarRol: function(id) {
        helpers.realizarAjax('../../controller/ctd_buscar_rol.php', { id_rol: id })
            .done(response => {
                if (response.success) {
                    const rol = response.rol;
                    const cuerpo = `<h5><strong>${rol.nombre_rol}</strong></h5><hr><p><strong>ID:</strong> ${rol.id_rol}</p>`;
                    helpers.mostrarModal('Detalles del Rol', cuerpo, 'info');
                }
            });
    },

    eliminarRol: function(id) {
        const callback = () => {
            helpers.realizarAjax('../../controller/ctd_eliminar_rol.php', { id_rol: id })
                .done(response => {
                    if (response.status === 'success') {
                        bootstrap.Modal.getInstance(document.getElementById('modalGenerico')).hide();
                        this.cargarTabla(); // Recargar tabla principal
                        // Si estamos en la página de filtro, también recargamos esa tabla
                        if ($('#tabla_roles_filtrados').length) {
                            this.filtrarRoles($('#input-filtro-rol').val());
                        }
                    } else {
                        helpers.mostrarModal('Error', 'Error al eliminar el rol.', 'danger');
                    }
                });
        };
        helpers.mostrarModal('Confirmar Eliminación', '¿Estás seguro de que deseas eliminar este rol? Esta acción es irreversible.', 'confirm', callback);
    },

    consultarRol: function(id) {
        if (!id) return;
        helpers.realizarAjax('../../controller/ctd_buscar_rol.php', { id_rol: id })
            .done(response => {
                if (response.success) {
                    $('#consulta_nombre_rol').val(response.rol.nombre_rol);
                } else {
                    helpers.mostrarModal('Error en la Búsqueda', 'No se encontró ningún rol con el ID proporcionado.', 'warning');
                    $('#consulta_nombre_rol').val('');
                }
            });
    },

    filtrarRoles: function(termino) {
        helpers.realizarAjax('../../controller/ctd_filtrar_roles.php', { termino_busqueda: termino }, 'html')
            .done(response => {
                $('#tabla_roles_filtrados').html(response);
                if (termino && response.includes("No se encontraron roles")) {
                    helpers.mostrarModal('Búsqueda sin Resultados', 'No se encontraron roles que coincidan con el término de búsqueda.', 'warning');
                }
            });
    }
};

// ==================================================================================
// MÓDULO DE EMPLEADOS
// ==================================================================================
const moduloEmpleado = {
    init: function() {
        this.cargarTablas();
        this.vincularEventos();
        this.logicaFiltroInicial();
    },

    cargarTablas: function() {
        helpers.cargarContenido('#tabla_empleados', '../../controller/ctd_tabla_empleados.php', { accion: 'listar_activos' });
        helpers.cargarContenido('#tabla_empleados_inactivos', '../../controller/ctd_tabla_empleados.php', { accion: 'listar_inactivos' });
    },

    logicaFiltroInicial: function() {
        if ($("#tabla_empleados_filtrados").length) {
            const urlParams = new URLSearchParams(window.location.search);
            const terminoInicial = urlParams.get('termino') || '';
            $("#input-filtro-filtrar").val(terminoInicial);
            if (terminoInicial) {
                this.filtrarEmpleados(terminoInicial);
            } else {
                $("#tabla_empleados_filtrados").html("<p class='text-center'>Utiliza el campo de búsqueda para filtrar empleados.</p>");
            }
        }
    },

    vincularEventos: function() {
        const self = this;

        $(document).on('click', '.btn-mostrar', function() {
            self.mostrarEmpleado($(this).data('id'));
        });

        $(document).on('click', '.btn-desactivar', function() {
            self.desactivarEmpleado($(this).data('id'));
        });

        $(document).on('click', '.btn-activar', function() {
            self.activarEmpleado($(this).data('id'));
        });

        $('#btn-aplicar-filtro-filtrar').on('click', function() {
            const termino = $('#input-filtro-filtrar').val();
            self.filtrarEmpleados(termino);
            const newUrl = `${window.location.pathname}${termino ? '?termino=' + encodeURIComponent(termino) : ''}`;
            window.history.replaceState({ path: newUrl }, '', newUrl);
        });

        $('#btn-limpiar-filtro-filtrar').on('click', function() {
            $('#input-filtro-filtrar').val('');
            $('#tabla_empleados_filtrados').html("<p class='text-center'>Utiliza el campo de búsqueda para filtrar empleados.</p>");
            helpers.limpiarUrl();
        });

        $('#consulta_id').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                self.consultarEmpleado($(this).val());
            }
        });
    },

    mostrarEmpleado: function(id) {
        helpers.realizarAjax('../../controller/ctd_buscar_empleado.php', { id_empleado: id })
            .done(empleado => {
                const estado = empleado.activo == 1 ? "<span class='badge bg-success'>Activo</span>" : "<span class='badge bg-danger'>Inactivo</span>";
                const cuerpo = `<h5><strong>${empleado.nombre} ${empleado.apellido}</strong></h5><hr>
                                <p><strong>ID:</strong> ${empleado.id_empleado}</p>
                                <p><strong>Email:</strong> ${empleado.email}</p>
                                <p><strong>Estado:</strong> ${estado}</p>
                                <p><strong>Rol:</strong> ${empleado.nombre_rol}</p>`;
                helpers.mostrarModal('Detalles del Empleado', cuerpo, 'info');
            });
    },

    desactivarEmpleado: function(id) {
        const callback = () => {
            helpers.realizarAjax('../../controller/ctd_desactivar_empleado.php', { id_empleado: id })
                .done(response => {
                    if (response.status === 'success') {
                        bootstrap.Modal.getInstance(document.getElementById('modalGenerico')).hide();
                        this.cargarTablas();
                    } else {
                        helpers.mostrarModal('Error', 'Error al desactivar el empleado.', 'danger');
                    }
                });
        };
        helpers.mostrarModal('Confirmar Desactivación', '¿Estás seguro de que deseas desactivar a este empleado?', 'confirm', callback);
    },

    activarEmpleado: function(id) {
        helpers.realizarAjax('../../controller/ctd_activar_empleado.php', { id_empleado: id })
            .done(response => {
                if (response.status === 'success') {
                    helpers.mostrarModal('¡Éxito!', 'El empleado ha sido activado correctamente.', 'success');
                    this.cargarTablas();
                } else {
                    helpers.mostrarModal('Error', 'Error al activar el empleado.', 'danger');
                }
            });
    },

    consultarEmpleado: function(id) {
        if (!id) return;
        helpers.realizarAjax('../../controller/ctd_buscar_empleado.php', { id_empleado: id })
            .done(empleado => {
                $('#consulta_nombre').val(empleado.nombre);
                $('#consulta_apellido').val(empleado.apellido);
                $('#consulta_email').val(empleado.email);
                $('#consulta_rol').val(empleado.nombre_rol);
            })
            .fail(() => {
                helpers.mostrarModal('Error en la Búsqueda', 'No se encontró ningún empleado con el ID proporcionado.', 'warning');
                $('#consulta_nombre, #consulta_apellido, #consulta_email, #consulta_rol').val('');
            });
    },

    filtrarEmpleados: function(termino) {
        helpers.cargarContenido('#tabla_empleados_filtrados', '../../controller/ctd_tabla_empleados.php', { accion: 'filtrar', termino_busqueda: termino });
    }
};

// ==================================================================================
// CÓDIGO DE LA CARPETA ADAPTAR
// ==================================================================================

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