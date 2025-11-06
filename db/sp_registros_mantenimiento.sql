-- =================================================================================
-- PROCEDIMIENTOS ALMACENADOS PARA TABLA: REGISTROS_MANTENIMIENTO
-- =================================================================================

DELIMITER $$

-- [MANTENIMIENTO] Listar todos los registros de mantenimiento
CREATE PROCEDURE sp_listar_mantenimientos()
BEGIN
    SELECT 
        rm.id_mantenimiento,
        rm.id_activo,
        rm.fecha_servicio,
        rm.descripcion,
        rm.costo,
        rm.realizado_por,
        a.serial_number,
        CONCAT(a.marca, ' ', a.modelo) AS activo_nombre,
        CONCAT(e.nombre, ' ', e.apellido) AS empleado_nombre
    FROM registros_mantenimiento rm
    INNER JOIN activos a ON rm.id_activo = a.id_activo
    INNER JOIN empleados e ON rm.realizado_por = e.id_empleado
    ORDER BY rm.fecha_servicio DESC, rm.id_mantenimiento DESC;
END $$

-- [MANTENIMIENTO] Buscar un registro de mantenimiento por su ID
CREATE PROCEDURE sp_buscar_mantenimiento_por_id(IN p_id_mantenimiento INT)
BEGIN
    SELECT 
        rm.id_mantenimiento,
        rm.id_activo,
        rm.fecha_servicio,
        rm.descripcion,
        rm.costo,
        rm.realizado_por,
        a.serial_number,
        CONCAT(a.marca, ' ', a.modelo) AS activo_nombre,
        CONCAT(e.nombre, ' ', e.apellido) AS empleado_nombre
    FROM registros_mantenimiento rm
    INNER JOIN activos a ON rm.id_activo = a.id_activo
    INNER JOIN empleados e ON rm.realizado_por = e.id_empleado
    WHERE rm.id_mantenimiento = p_id_mantenimiento;
END $$

-- [MANTENIMIENTO] Registrar un nuevo registro de mantenimiento
CREATE PROCEDURE sp_registrar_mantenimiento(
    IN p_id_activo INT,
    IN p_fecha_servicio DATE,
    IN p_descripcion TEXT,
    IN p_costo DECIMAL(10, 2),
    IN p_realizado_por INT
)
BEGIN
    INSERT INTO registros_mantenimiento (id_activo, fecha_servicio, descripcion, costo, realizado_por)
    VALUES (p_id_activo, p_fecha_servicio, p_descripcion, p_costo, p_realizado_por);
END $$

-- [MANTENIMIENTO] Editar un registro de mantenimiento
CREATE PROCEDURE sp_editar_mantenimiento(
    IN p_id_mantenimiento INT,
    IN p_id_activo INT,
    IN p_fecha_servicio DATE,
    IN p_descripcion TEXT,
    IN p_costo DECIMAL(10, 2),
    IN p_realizado_por INT
)
BEGIN
    UPDATE registros_mantenimiento
    SET 
        id_activo = p_id_activo,
        fecha_servicio = p_fecha_servicio,
        descripcion = p_descripcion,
        costo = p_costo,
        realizado_por = p_realizado_por
    WHERE id_mantenimiento = p_id_mantenimiento;
END $$

-- [MANTENIMIENTO] Eliminar un registro de mantenimiento (Borrado físico)
CREATE PROCEDURE sp_borrar_mantenimiento(IN p_id_mantenimiento INT)
BEGIN
    DELETE FROM registros_mantenimiento WHERE id_mantenimiento = p_id_mantenimiento;
END $$

-- [MANTENIMIENTO] Filtrar registros de mantenimiento por término de búsqueda
CREATE PROCEDURE sp_filtrar_mantenimientos(IN p_termino VARCHAR(255))
BEGIN
    SELECT 
        rm.id_mantenimiento,
        rm.id_activo,
        rm.fecha_servicio,
        rm.descripcion,
        rm.costo,
        rm.realizado_por,
        a.serial_number,
        CONCAT(a.marca, ' ', a.modelo) AS activo_nombre,
        CONCAT(e.nombre, ' ', e.apellido) AS empleado_nombre
    FROM registros_mantenimiento rm
    INNER JOIN activos a ON rm.id_activo = a.id_activo
    INNER JOIN empleados e ON rm.realizado_por = e.id_empleado
    WHERE 
        a.serial_number LIKE CONCAT('%', p_termino, '%') OR
        a.marca LIKE CONCAT('%', p_termino, '%') OR
        a.modelo LIKE CONCAT('%', p_termino, '%') OR
        e.nombre LIKE CONCAT('%', p_termino, '%') OR
        e.apellido LIKE CONCAT('%', p_termino, '%') OR
        rm.descripcion LIKE CONCAT('%', p_termino, '%')
    ORDER BY rm.fecha_servicio DESC, rm.id_mantenimiento DESC;
END $$

DELIMITER ;
