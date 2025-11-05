'use strict';

/**
 * ==================================================================================
 * INICIALIZACIÓN PRINCIPAL
 * Se ejecuta cuando el DOM está completamente cargado.
 * ==================================================================================
 */
$(document).ready(function() {
    // Inicializa los módulos principales de la aplicación
    helpers.init();
    moduloActivo.init();
    moduloAsignacion.init(); // <--- AÑADIDO
    moduloCategoria.init();
    moduloEmpleado.init();
    moduloLicencia.init();
    moduloRol.init();
});


/**
 * ==================================================================================
 * HELPERS (Funciones de Ayuda Genéricas)
 * Objeto con funciones reutilizables en toda la aplicación.
 * ==================================================================================
 */
const helpers = {
    /**
     * Inicializa los manejadores de eventos globales y la lógica de la página.
     */
    init: function() {
        this.vincularEventosGlobales();
        this.procesarParametrosUrl();
    },

    /**
     * Vincula eventos a elementos que pueden existir en cualquier página.
     */
    vincularEventosGlobales: function() {
        // Maneja la carga de detalles en el modal de "Mostrar" de Categorías
        $('#md_mostrar_cat').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id_cat = button.data('idcat');
            const modalBody = $('#categoria_details_content');
            modalBody.html('<div class="text-center"><div class="spinner-border text-info" role="status"></div><p>Cargando detalles...</p></div>');
            helpers.realizarAjax("../../controller/ctr_mostrar_categoria.php", { idcat: id_cat }, 'html')
                .done(function(response) {
                    modalBody.html(response);
                })
                .fail(function() {
                    modalBody.html('<div class="alert alert-danger">Error al cargar los detalles.</div>');
                });
        });

        // Maneja la carga de detalles en el modal de "Mostrar" de Licencias
        $('#md_mostrar_lic').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id_lic = button.data('idlic');
            const modalBody = $('#licencia_details_content');
            modalBody.html('<div class="text-center"><div class="spinner-border text-info" role="status"></div><p>Cargando detalles...</p></div>');
            helpers.realizarAjax("../../controller/ctr_mostrar_licencia.php", { idlic: id_lic }, 'html')
                .done(function(response) {
                    modalBody.html(response);
                })
                .fail(function() {
                    modalBody.html('<div class="alert alert-danger">Error al cargar los detalles.</div>');
                });
        });
    },

    /**
     * Procesa los parámetros de la URL para mostrar notificaciones de éxito o error.
     */
    procesarParametrosUrl: function() {
        const urlParams = new URLSearchParams(window.location.search);
        const registroExitoso = urlParams.get('registro') === 'exito';
        const edicionExitosa = urlParams.get('edicion') === 'exito';
        const borradoExitoso = urlParams.get('delete') === 'exito';
        const errorFK = urlParams.get('error') === 'fk';

        if (registroExitoso || edicionExitosa) {
            const mensaje = registroExitoso ? 'El registro ha sido creado correctamente.' : 'El registro ha sido actualizado correctamente.';
            this.mostrarModal('¡Éxito!', mensaje, 'success');
            this.limpiarUrl();
        }

        if (borradoExitoso) {
            this.mostrarModal('Borrado Completado', 'El registro ha sido eliminado correctamente.', 'success');
            this.limpiarUrl();
        }

        if (errorFK) {
            const mensaje = 'No se puede eliminar el registro porque está siendo utilizado por otros elementos (por ejemplo, un activo o una licencia asociados a esta categoría).';
            this.mostrarModal('Error de Borrado', mensaje, 'danger');
            this.limpiarUrl();
        }
    },

    /**
     * Realiza una petición AJAX genérica.
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
     * Muestra un modal genérico para notificaciones y confirmaciones.
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
     * Carga contenido HTML en un div mediante AJAX.
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
     * Limpia los parámetros de la URL sin recargar la página.
     */
    limpiarUrl: function() {
        const cleanURL = `${window.location.protocol}//${window.location.host}${window.location.pathname}`;
        window.history.replaceState({ path: cleanURL }, '', cleanURL);
    },

    /**
     * Carga detalles en un modal genérico. Usado por el botón "Mostrar" de Activos.
     */
    loadDetailModal: function(controllerPath, idKey, idValue, modalTitle) {
        $("#detalleModalLabel").text(modalTitle);
        $("#contenido_modal_detalle").html('<div class="text-center"><div class="spinner-border text-info" role="status"></div><p>Cargando información...</p></div>');
        $("#md_mostrar_detalle").modal("show");

        $.ajax({
            url: controllerPath,
            type: "POST",
            data: { [idKey]: idValue, action: 'show_detail' },
            success: function(html_response) {
                $("#contenido_modal_detalle").html(html_response);
            },
            error: function() {
                $("#contenido_modal_detalle").html('<div class="alert alert-danger">Error al cargar el detalle del servidor.</div>');
            }
        });
    }
};


/**
 * ==================================================================================
 * MÓDULO DE ACTIVOS
 * ==================================================================================
 */
const moduloActivo = {
    init: function() {
        this.vincularEventos();
    },

    vincularEventos: function() {
        const self = this;

        // Cargar formulario de edición en el modal
        $('#md_editar_activo').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id_act = button.data('idact');
            const modalBody = $('#editar_activo_content');
            helpers.realizarAjax("../../controller/ctr_get_form_activo.php", { idact: id_act }, 'html')
                .done(function(response) {
                    modalBody.html(response);
                })
                .fail(function() {
                    modalBody.html('<div class="alert alert-danger">Error al cargar el formulario de edición.</div>');
                });
        });

        // Manejar el envío del formulario de edición
        $(document).on('submit', '#frm_editar_activo_modal', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const form = $(this);
            form.find('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Actualizando...');
            helpers.realizarAjax($(this).attr('action'), formData, 'json')
                .done(function(response) {
                    if (response.success) {
                        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('md_editar_activo'));
                        modalInstance.hide();
                        helpers.mostrarModal('¡Éxito!', 'El activo ha sido actualizado correctamente.', 'success');
                        setTimeout(function() { location.reload(); }, 1500);
                    } else {
                        alert('Error: ' + (response.message || 'No se pudo actualizar el activo.'));
                    }
                })
                .fail(function() {
                    alert('Error de comunicación. No se pudo enviar el formulario.');
                })
                .always(function() {
                    form.find('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-sync-alt"></i> Actualizar');
                });
        });

        // Botones de la tabla de activos
        $(document).on('click', '.btn-desactivar-activo', function() { self.desactivarActivo($(this).data('id')); });
        $(document).on('click', '.btn-activar-activo', function() { self.activarActivo($(this).data('id')); });
    },

    desactivarActivo: function(id) {
        const callback = () => {
            helpers.realizarAjax('../../controller/ctd_desactivar_activo.php', { id_activo: id }, 'json')
                .done(response => {
                    if (response.status === 'success') {
                        bootstrap.Modal.getInstance(document.getElementById('modalGenerico')).hide();
                        helpers.mostrarModal('¡Éxito!', 'El activo ha sido desactivado correctamente.', 'success');
                        location.reload();
                    } else {
                        helpers.mostrarModal('Error', response.message || 'Error al desactivar el activo.', 'danger');
                    }
                })
                .fail(() => {
                    helpers.mostrarModal('Error', 'Error de comunicación al intentar desactivar el activo.', 'danger');
                });
        };
        helpers.mostrarModal('Confirmar Desactivación', '¿Estás seguro de que deseas desactivar este activo? Esta acción se puede revertir.', 'confirm', callback);
    },

    activarActivo: function(id) {
        const callback = () => {
            helpers.realizarAjax('../../controller/ctd_activar_activo.php', { id_activo: id }, 'json')
                .done(response => {
                    if (response.status === 'success') {
                        bootstrap.Modal.getInstance(document.getElementById('modalGenerico')).hide();
                        helpers.mostrarModal('¡Éxito!', 'El activo ha sido reactivado correctamente.', 'success');
                        location.reload();
                    } else {
                        helpers.mostrarModal('Error', response.message || 'Error al reactivar el activo.', 'danger');
                    }
                })
                .fail(() => {
                    helpers.mostrarModal('Error', 'Error de comunicación al intentar reactivar el activo.', 'danger');
                });
        };
        helpers.mostrarModal('Confirmar Reactivación', '¿Estás seguro de que deseas reactivar este activo?', 'confirm', callback);
    }
};

/**
 * ==================================================================================
 * MÓDULO DE ASIGNACIONES
 * ==================================================================================
 */
const moduloAsignacion = {
    init: function() {
        this.vincularEventos();
    },

    vincularEventos: function() {
        // Maneja el modal de confirmación de borrado
        $('#md_borrar_asig').on('show.bs.modal', function(event){
            let boton = event.relatedTarget;
            let idasig = $(boton).data('id');
            
            let modal = $(this);
            modal.find('.lbl_id_asig').text("ID: " + idasig);
            
            // Usamos .one() para evitar múltiples eventos si el modal se abre y cierra varias veces
            modal.find('.btn_confirmar_borrar').one('click', function() {
                window.location.href = "borrar_asignacion.php?idasig=" + idasig;
            });
        });
    }
};


/**
 * ==================================================================================
 * MÓDULO DE CATEGORÍAS
 * ==================================================================================
 */
const moduloCategoria = {
    init: function() {
        this.vincularEventos();
    },

    vincularEventos: function() {
        // Cargar formulario de edición en el modal
        $('#md_editar_cat').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id_cat = button.data('idcat');
            const modalBody = $('#editar_cat_content');
            modalBody.html('<div class="text-center"><div class="spinner-border text-success" role="status"></div><p>Cargando formulario...</p></div>');
            helpers.realizarAjax("../../controller/ctr_get_form_categoria.php", { idcat: id_cat }, 'html')
                .done(function(response) {
                    modalBody.html(response);
                })
                .fail(function() {
                    modalBody.html('<div class="alert alert-danger">Error al cargar el formulario de edición.</div>');
                });
        });

        // Manejar el envío del formulario de edición
        $(document).on('submit', '#frm_editar_cat_modal', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const form = $(this);
            form.find('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Actualizando...');
            helpers.realizarAjax($(this).attr('action'), formData, 'json')
                .done(function(response) {
                    if (response.success) {
                        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('md_editar_cat'));
                        modalInstance.hide();
                        helpers.mostrarModal('¡Éxito!', 'La categoría ha sido actualizada correctamente.', 'success');
                        setTimeout(function() { location.reload(); }, 1500);
                    } else {
                        alert('Error: ' + (response.message || 'No se pudo actualizar la categoría.'));
                    }
                })
                .fail(function() {
                    alert('Error de comunicación. No se pudo enviar el formulario.');
                })
                .always(function() {
                    form.find('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-sync-alt"></i> Actualizar');
                });
        });
    }
};


/**
 * ==================================================================================
 * MÓDULO DE EMPLEADOS
 * ==================================================================================
 */
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
        $(document).on('click', '.btn-mostrar', function() { self.mostrarEmpleado($(this).data('id')); });
        $(document).on('click', '.btn-desactivar', function() { self.desactivarEmpleado($(this).data('id')); });
        $(document).on('click', '.btn-activar', function() { self.activarEmpleado($(this).data('id')); });
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
                const cuerpo = `<h5><strong>${empleado.nombre} ${empleado.apellido}</strong></h5><hr><p><strong>ID:</strong> ${empleado.id_empleado}</p><p><strong>Email:</strong> ${empleado.email}</p><p><strong>Estado:</strong> ${estado}</p><p><strong>Rol:</strong> ${empleado.nombre_rol}</p>`;
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


/**
 * ==================================================================================
 * MÓDULO DE LICENCIAS
 * ==================================================================================
 */
const moduloLicencia = {
    init: function() {
        // Cargar formulario de edición en el modal
        $('#md_editar_licencia').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id_lic = button.data('idlic');
            const modalBody = $('#editar_licencia_content');
            modalBody.html('<div class="text-center"><div class="spinner-border text-success" role="status"></div><p>Cargando formulario...</p></div>');
            helpers.realizarAjax("../../controller/ctr_get_form_licencia.php", { idlic: id_lic }, 'html')
                .done(function(response) {
                    modalBody.html(response);
                })
                .fail(function() {
                    modalBody.html('<div class="alert alert-danger">Error al cargar el formulario de edición.</div>');
                });
        });

        // Manejar el envío del formulario de edición
        $(document).on('submit', '#frm_editar_licencia_modal', function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const form = $(this);
            form.find('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Actualizando...');
            helpers.realizarAjax($(this).attr('action'), formData, 'json')
                .done(function(response) {
                    if (response.success) {
                        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('md_editar_licencia'));
                        modalInstance.hide();
                        helpers.mostrarModal('¡Éxito!', 'La licencia ha sido actualizada correctamente.', 'success');
                        setTimeout(function() { location.reload(); }, 1500);
                    } else {
                        alert('Error: ' + (response.message || 'No se pudo actualizar la licencia.'));
                    }
                })
                .fail(function() {
                    alert('Error de comunicación. No se pudo enviar el formulario.');
                })
                .always(function() {
                    form.find('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-sync-alt"></i> Actualizar');
                });
        });
    }
};


/**
 * ==================================================================================
 * MÓDULO DE ROLES
 * ==================================================================================
 */
const moduloRol = {
    init: function() {
        this.cargarTabla();
        this.vincularEventos();
    },

    cargarTabla: function() {
        helpers.cargarContenido('#tabla_roles', '../../controller/ctd_tabla_roles.php');
    },

    vincularEventos: function() {
        const self = this;
        $(document).on('click', '.btn-mostrar-rol', function() { self.mostrarRol($(this).data('id')); });
        $(document).on('click', '.btn-eliminar', function() { self.eliminarRol($(this).data('id')); });
        $('#consulta_id_rol').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                self.consultarRol($(this).val());
            }
        });
        $('#input-filtro-rol').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#btn-aplicar-filtro-rol').click();
            }
        });
        $('#btn-aplicar-filtro-rol').on('click', function() { self.filtrarRoles($('#input-filtro-rol').val()); });
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
                        this.cargarTabla();
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


/**
 * ==================================================================================
 * CÓDIGO HEREDADO (Legacy)
 * Manejadores de eventos para páginas y funcionalidades antiguas.
 * ==================================================================================
 */
$(function () {

    // --- Evento: MOSTRAR ACTIVO (Botón de la tabla) ---
    $(document).on("click", ".reg_activo .btn_mostrar", function(e) {
        e.preventDefault();
        let id_act = $(this).data("id"); 
        helpers.loadDetailModal(
            "../../controller/ctr_mostrar_activo.php",
            "idact", 
            id_act, 
            "Detalles del Activo ID: " + id_act
        );
    });

    // --- BORRAR CATEGORÍA (Modal y JS) ---
    $(document).on("click", ".reg_categoria .btn_borrar", function(e) {
        e.preventDefault();
        const id_cat = $(this).data("id");
        const nombre_cat = $(this).data("nombre");
        const modal = $('#md_borrar_cat');
        modal.find('.lbl_nombre_cat').text(nombre_cat);
        modal.find('.lbl_id_cat').text("(" + id_cat + ")");
        const delete_url = "../../controller/ctr_borrar_categoria.php?id_cat=" + id_cat;
        
        // Asignar el evento de clic al botón de confirmación
        modal.find('.btn_confirmar_borrar').one('click', function() {
            window.location.href = delete_url;
        });
        
        modal.modal('show');
    });

    // --- BORRAR LICENCIA (Modal y JS) ---
    $(document).on("click", ".reg_licencia .btn_borrar", function(e) {
        e.preventDefault();
        const id_lic = $(this).data("id");
        const nombre_lic = $(this).data("nombre");
        const modal = $('#md_borrar_lic');
        modal.find('.lbl_nombre_lic').text(nombre_lic);
        modal.find('.lbl_id_lic').text("(" + id_lic + ")");
        const delete_url = "../../controller/ctr_borrar_licencia.php?idlic=" + id_lic;
        
        // Asignar el evento de clic al botón de confirmación
        modal.find('.btn_confirmar_borrar').one('click', function() {
            window.location.href = delete_url;
        });
        
        modal.modal('show');
    });

    // --- PÁGINA: CONSULTAR CATEGORÍA (AJAX) ---
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
                        // Usar el helper para mostrar el modal
                        helpers.mostrarModal('Detalles de Categoría', html, 'info');
                    } else {
                        // Usar el helper para mostrar un modal de advertencia
                        helpers.mostrarModal('Búsqueda sin Resultados', 'No se encontró ninguna categoría con el ID ' + id_cat + '.', 'warning');
                    }
                },
                error: function() {
                    // Usar el helper para mostrar un modal de error
                    helpers.mostrarModal('Error', 'Error de comunicación al consultar el servidor.', 'danger');
                }
            });
        } else {
            // Usar el helper para mostrar un modal de información
            helpers.mostrarModal('Información', 'Por favor, ingrese un ID de Categoría.', 'info');
        }
    });

    // --- PÁGINA: FILTRAR CATEGORÍA (AJAX) ---
    $("#frm_filtrar_cat #btn_filtrar").on("click", function (e) {
        e.preventDefault();
        var valor = $("#txt_valor").val();
        if (valor !== "") {
            $.post("../../controller/ctr_filtrar_categoria.php", { txt_valor: valor }, function (rpta) {
                $("#tabla_resultados").html(rpta);
            });
        } else {
            $("#tabla_resultados").html('<div class="alert alert-warning">Escriba un valor para filtrar...</div>');
            $("#txt_valor").focus();
        }
    });

    // --- PÁGINA: CONSULTAR LICENCIA (AJAX) ---
    $("#txt_id_lic").focusout(function(e) {
        e.preventDefault();
        let id_lic = $("#txt_id_lic").val();
        if (id_lic !== "") {
            $.ajax({
                url: "../../controller/ctr_consultar_licencia.php",
                type: "POST",
                data: { id_lic: id_lic },
                dataType: 'json',
                success: function(response) {
                    if (response && response.id_licencia) {
                        var html = '<div class="card p-3">';
                        html += '<table class="table table-sm">';
                        html += '<tr><th>Software</th><td>' + response.nombre_software + '</td></tr>';
                        html += '<tr><th>Clave Licencia</th><td class="fw-bold">' + response.clave_licencia + '</td></tr>';
                        html += '<tr><th>Usuarios</th><td>' + response.cantidad_usuarios + '</td></tr>';
                        html += '<tr><th>Expira</th><td>' + (response.fecha_expiracion ? response.fecha_expiracion : 'PERPETUA') + '</td></tr>';
                        html += '<tr><th>ID Categoría</th><td>' + response.id_categoria + '</td></tr>';
                        html += '</table></div>';
                        helpers.mostrarModal('Detalles de la Licencia', html, 'info');
                    } else {
                        helpers.mostrarModal('Búsqueda sin Resultados', 'No se encontró ninguna licencia con el ID ' + id_lic + '.', 'warning');
                    }
                },
                error: function() {
                    helpers.mostrarModal('Error', 'Error de comunicación al consultar el servidor.', 'danger');
                }
            });
        } else {
            helpers.mostrarModal('Información', 'Por favor, ingrese un ID de Licencia.', 'info');
        }
    });

    // --- PÁGINA: FILTRAR LICENCIAS (AJAX) ---
    $("#frm_filtrar_lic #btn_filtrar_lic").on("click", function(e) {
        e.preventDefault();
        var valor = $("#txt_valor_lic").val();
        if (valor !== "") {
            $.post("../../controller/ctr_filtrar_licencia.php", { valor: valor }, function(rpta) {
                $("#tabla_resultados_lic").html(rpta); 
            });
        } else {
            $("#tabla_resultados_lic").html('<div class="alert alert-warning">Escriba un valor para filtrar...</div>');
            $("#txt_valor_lic").focus();
        }
    });

    // --- PÁGINA: FILTRAR ACTIVOS (AJAX) ---
    $("#frm_filtrar_act #btn_filtrar").on("click", function(e) {
        e.preventDefault();
        var valor = $("#txt_valor").val();
        if (valor !== "") {
            $.post("../../controller/ctr_filtrar_activo.php", { valor: valor }, function(rpta) {
                $("#tabla_resultados_act").html(rpta); 
            });
        } else {
            $("#tabla_resultados_act").html('<div class="alert alert-warning">Escriba un valor para filtrar...</div>');
            $("#txt_valor").focus();
        }
    });
    
    // --- PÁGINA: CONSULTAR ACTIVO (AJAX) ---
    $('#btn_consultar_activo').on('click', function() {
        let id_act = $('#txt_id_activo').val();
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
                        // Usar el helper para mostrar el modal
                        helpers.mostrarModal('Detalles del Activo', html, 'info');
                    } else {
                        // Usar el helper para mostrar un modal de advertencia
                        helpers.mostrarModal('Búsqueda sin Resultados', 'No se encontró ningún activo con el ID ' + id_act + '.', 'warning');
                    }
                },
                error: function() {
                    // Usar el helper para mostrar un modal de error
                    helpers.mostrarModal('Error', 'Error de comunicación al consultar el servidor.', 'danger');
                }
            });
        } else {
            // Usar el helper para mostrar un modal de información
            helpers.mostrarModal('Información', 'Por favor, ingrese un ID de Activo.', 'info');
        }
    });
});