CREATE DATABASE IF NOT EXISTS bd_GATI_ds502;
USE bd_GATI_ds502;

-- =================================================================================
-- ESTRUCTURA DE TABLAS
-- =================================================================================

CREATE TABLE IF NOT EXISTS `roles` (
  `id_rol` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre_rol` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `empleados` (
  `id_empleado` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(100) NOT NULL,
  `apellido` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `activo` TINYINT(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `categorias_activo` (
  `id_categoria` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre_categoria` VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `empleado_rol` (
  `id_empleado` INT NOT NULL,
  `id_rol` INT NOT NULL,
  PRIMARY KEY (`id_empleado`, `id_rol`),
  FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE,
  FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `activos` (
  `id_activo` INT AUTO_INCREMENT PRIMARY KEY,
  `id_categoria` INT NULL,
  `serial_number` VARCHAR(255) NOT NULL UNIQUE,
  `marca` VARCHAR(100) NULL,
  `modelo` VARCHAR(100) NULL,
  `fecha_compra` DATE NULL,
  `precio` DECIMAL(10, 2) NULL,
  `estado` ENUM('En uso', 'Almacenado', 'Mantenimiento', 'Baja') DEFAULT 'Almacenado',
  CONSTRAINT `fk_activos_categorias_set_null` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_activo` (`id_categoria`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `licencias_software` (
  `id_licencia` INT AUTO_INCREMENT PRIMARY KEY,
  `id_categoria` INT NULL,
  `nombre_software` VARCHAR(150) NOT NULL,
  `clave_licencia` VARCHAR(255) NOT NULL,
  `fecha_expiracion` DATE NULL,
  `cantidad_usuarios` INT DEFAULT 1,
  CONSTRAINT `fk_licencias_categorias_set_null` FOREIGN KEY (`id_categoria`) REFERENCES `categorias_activo` (`id_categoria`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `asignaciones` (
  `id_asignacion` INT AUTO_INCREMENT PRIMARY KEY,
  `id_activo` INT NOT NULL,
  `id_empleado` INT NOT NULL,
  `fecha_asignacion` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `fecha_devolucion` DATETIME NULL,
  `notas` TEXT NULL,
  FOREIGN KEY (`id_activo`) REFERENCES `activos` (`id_activo`),
  FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `registros_mantenimiento` (
  `id_mantenimiento` INT AUTO_INCREMENT PRIMARY KEY,
  `id_activo` INT NOT NULL,
  `fecha_servicio` DATE NOT NULL,
  `descripcion` TEXT NOT NULL,
  `costo` DECIMAL(10, 2) DEFAULT 0.00,
  `realizado_por` INT NOT NULL,
  FOREIGN KEY (`id_activo`) REFERENCES `activos` (`id_activo`),
  FOREIGN KEY (`realizado_por`) REFERENCES `empleados` (`id_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =================================================================================
-- INSERCIÓN DE DATOS DE EJEMPLO
-- =================================================================================

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Empleado'),
(3, 'Tecnico_TI');

INSERT INTO `categorias_activo` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'Laptop'),
(2, 'Monitor'),
(3, 'Software'),
(4, 'Móvil'),
(5, 'Periférico');

INSERT INTO `empleados` (`id_empleado`, `nombre`, `apellido`, `email`, `password`, `activo`) VALUES
(1, 'Ana', 'Torres', 'ana.torres@consultoria.com', 'hash_pass_123', 1),
(2, 'Carlos', 'Luna', 'carlos.luna@consultoria.com', 'hash_pass_456', 1),
(3, 'Beatriz', 'Franco', 'beatriz.franco@consultoria.com', 'hash_pass_789', 1),
(4, 'David', 'Salas', 'david.salas@consultoria.com', 'hash_pass_101', 1),
(5, 'Elena', 'Vera', 'elena.vera@consultoria.com', 'hash_pass_112', 0);

INSERT INTO `empleado_rol` (`id_empleado`, `id_rol`) VALUES
(1, 1),
(2, 3),
(2, 2),
(3, 2),
(4, 2),
(5, 2);

INSERT INTO `activos` (`id_activo`, `id_categoria`, `serial_number`, `marca`, `modelo`, `fecha_compra`, `precio`, `estado`) VALUES
(1, 1, 'SN_DELL_001', 'Dell', 'XPS 15', '2024-01-10', 1800.00, 'En uso'),
(2, 1, 'SN_LEN_002', 'Lenovo', 'ThinkPad X1', '2024-02-15', 1650.00, 'Almacenado'),
(3, 2, 'SN_SAM_003', 'Samsung', 'Odyssey G5', '2023-11-20', 350.00, 'En uso'),
(4, 4, 'SN_APP_004', 'Apple', 'iPhone 13', '2022-05-01', 900.00, 'Baja'),
(5, 5, 'SN_LOG_005', 'Logitech', 'MX Keys', '2024-03-05', 150.00, 'Almacenado'),
(6, 2, 'SN_DELL_006', 'Dell', 'Ultrasharp 27', '2023-01-01', 450.00, 'Mantenimiento');

INSERT INTO `licencias_software` (`id_licencia`, `id_categoria`, `nombre_software`, `clave_licencia`, `fecha_expiracion`, `cantidad_usuarios`) VALUES
(1, 3, 'Microsoft 365 E5', 'M365-XXXX-YYYY-ZZZZ', '2025-12-31', 50),
(2, 3, 'JetBrains PhpStorm', 'JET-AAAA-BBBB-CCCC', '2025-06-15', 10),
(3, 3, 'Adobe Photoshop CC', 'ADO-1111-2222-3333', '2025-01-01', 5),
(4, 3, 'Slack Pro (Workspace)', 'SLK-7777-8888-9999', '2025-10-30', 50),
(5, 3, 'Windows 11 Pro OEM', 'WIN-QWER-TYUI-OPAS', NULL, 1);

INSERT INTO `asignaciones` (`id_asignacion`, `id_activo`, `id_empleado`, `fecha_asignacion`, `fecha_devolucion`, `notas`) VALUES
(1, 1, 3, '2024-01-20 09:00:00', NULL, 'Laptop asignada a Beatriz Franco.'),
(2, 3, 3, '2024-01-20 09:01:00', NULL, 'Monitor principal para Beatriz Franco.'),
(3, 2, 1, '2024-02-20 10:00:00', NULL, 'Laptop asignada a Admin Ana Torres.'),
(4, 5, 4, '2024-03-10 15:30:00', NULL, 'Teclado para David Salas.'),
(5, 4, 5, '2022-05-05 11:00:00', '2024-05-01 17:00:00', 'Móvil asignado a Elena Vera. Devuelto por baja de empleada.');

INSERT INTO `registros_mantenimiento` (`id_mantenimiento`, `id_activo`, `fecha_servicio`, `descripcion`, `costo`, `realizado_por`) VALUES
(1, 6, '2025-10-30', 'Monitor (SN_DELL_006) no enciende. Se envía a diagnóstico.', 0.00, 2),
(2, 1, '2024-06-15', 'Limpieza interna de ventiladores y cambio de pasta térmica (SN_DELL_001).', 50.00, 2),
(3, 2, '2024-02-18', 'Instalación de imagen corporativa (formateo) (SN_LEN_002).', 0.00, 2),
(4, 4, '2024-04-20', 'Diagnóstico de batería hinchada (SN_APP_004). Se determina como BAJA.', 0.00, 2),
(5, 6, '2025-10-31', 'Reemplazo de panel LCD dañado (SN_DELL_006).', 150.00, 2);

-- =================================================================================
-- PROCEDIMIENTOS ALMACENADOS
-- =================================================================================

-- ---------------------------------------------------------------------------------
-- TABLA: ROLES
-- ---------------------------------------------------------------------------------
DELIMITER $$

-- [ROLES] Listar todos los roles
CREATE PROCEDURE sp_listar_roles()
BEGIN
    SELECT id_rol, nombre_rol FROM roles ORDER BY nombre_rol ASC;
END $$

-- [ROLES] Buscar un rol por su ID
CREATE PROCEDURE sp_buscar_rol_por_id(IN p_id_rol INT)
BEGIN
    SELECT id_rol, nombre_rol FROM roles WHERE id_rol = p_id_rol;
END $$

-- [ROLES] Registrar un nuevo rol
CREATE PROCEDURE sp_registrar_rol(IN p_nombre_rol VARCHAR(100))
BEGIN
    INSERT INTO roles(nombre_rol) VALUES(p_nombre_rol);
END $$

-- [ROLES] Editar el nombre de un rol
CREATE PROCEDURE sp_editar_rol(IN p_id_rol INT, IN p_nombre_rol VARCHAR(50))
BEGIN
    UPDATE roles SET nombre_rol = p_nombre_rol WHERE id_rol = p_id_rol;
END $$

-- [ROLES] Eliminar un rol (Borrado físico)
CREATE PROCEDURE sp_eliminar_rol(IN p_id_rol INT)
BEGIN
    DELETE FROM roles WHERE id_rol = p_id_rol;
END $$

-- [ROLES] Filtrar roles por un término de búsqueda
CREATE PROCEDURE sp_filtrar_roles(IN p_termino VARCHAR(50))
BEGIN
    SELECT id_rol, nombre_rol
    FROM roles
    WHERE nombre_rol LIKE CONCAT('%', p_termino, '%')
    ORDER BY nombre_rol ASC;
END $$

-- ---------------------------------------------------------------------------------
-- TABLA: EMPLEADOS
-- ---------------------------------------------------------------------------------

-- [EMPLEADOS] Listar todos los empleados activos
CREATE PROCEDURE sp_listar_empleados()
BEGIN
    SELECT
        e.id_empleado,
        e.nombre,
        e.apellido,
        e.email,
        e.activo,
        GROUP_CONCAT(r.nombre_rol SEPARATOR ', ') AS roles
    FROM empleados e
    LEFT JOIN empleado_rol er ON e.id_empleado = er.id_empleado
    LEFT JOIN roles r ON er.id_rol = r.id_rol
    WHERE e.activo = 1
    GROUP BY e.id_empleado
    ORDER BY e.apellido, e.nombre;
END $$

-- [EMPLEADOS] Buscar un empleado por su ID
CREATE PROCEDURE sp_buscar_empleado_por_id(IN p_id_empleado INT)
BEGIN
    SELECT
        e.id_empleado,
        e.nombre,
        e.apellido,
        e.email,
        e.password,
        e.activo,
        er.id_rol AS id_rol,
        r.nombre_rol AS nombre_rol
    FROM empleados e
    LEFT JOIN empleado_rol er ON e.id_empleado = er.id_empleado
    LEFT JOIN roles r ON er.id_rol = r.id_rol
    WHERE e.id_empleado = p_id_empleado;
END $$

-- [EMPLEADOS] Registrar un nuevo empleado y asignarle un rol
CREATE PROCEDURE sp_registrar_empleado(
    IN p_nombre VARCHAR(100),
    IN p_apellido VARCHAR(100),
    IN p_email VARCHAR(255),
    IN p_password VARCHAR(255),
    IN p_id_rol INT
)
BEGIN
    DECLARE nuevo_empleado_id INT;
    START TRANSACTION;
    INSERT INTO empleados(nombre, apellido, email, password)
    VALUES(p_nombre, p_apellido, p_email, p_password);
    SET nuevo_empleado_id = LAST_INSERT_ID();
    INSERT INTO empleado_rol(id_empleado, id_rol)
    VALUES(nuevo_empleado_id, p_id_rol);
    COMMIT;
END $$

-- [EMPLEADOS] Editar los datos de un empleado y su rol
CREATE PROCEDURE sp_editar_empleado(
    IN p_id_empleado INT,
    IN p_nombre VARCHAR(100),
    IN p_apellido VARCHAR(100),
    IN p_email VARCHAR(255),
    IN p_activo TINYINT(1),
    IN p_id_rol INT
)
BEGIN
    UPDATE empleados
    SET nombre = p_nombre, apellido = p_apellido, email = p_email
    WHERE id_empleado = p_id_empleado;
    DELETE FROM empleado_rol WHERE id_empleado = p_id_empleado;
    INSERT INTO empleado_rol(id_empleado, id_rol)
    VALUES(p_id_empleado, p_id_rol);
END $$

-- [EMPLEADOS] Desactivar un empleado (Borrado lógico)
CREATE PROCEDURE sp_desactivar_empleado(IN p_id_empleado INT)
BEGIN
    UPDATE empleados SET activo = 0 WHERE id_empleado = p_id_empleado;
END $$

-- [EMPLEADOS] Activar un empleado
CREATE PROCEDURE sp_activar_empleado(IN p_id_empleado INT)
BEGIN
    UPDATE empleados SET activo = 1 WHERE id_empleado = p_id_empleado;
END $$

-- [EMPLEADOS] Listar empleados inactivos
CREATE PROCEDURE sp_listar_empleados_inactivos()
BEGIN
    SELECT
        e.id_empleado,
        e.nombre,
        e.apellido,
        e.email,
        e.activo,
        r.nombre_rol AS roles
    FROM empleados e
    LEFT JOIN empleado_rol er ON e.id_empleado = er.id_empleado
    LEFT JOIN roles r ON er.id_rol = r.id_rol
    WHERE e.activo = 0
    ORDER BY e.apellido, e.nombre;
END $$

-- [EMPLEADOS] Filtrar empleados activos por un término de búsqueda
CREATE PROCEDURE sp_filtrar_empleados(IN p_termino VARCHAR(255))
BEGIN
    SELECT
        e.id_empleado,
        e.nombre,
        e.apellido,
        e.email,
        e.activo,
        r.nombre_rol AS roles
    FROM empleados e
    LEFT JOIN empleado_rol er ON e.id_empleado = er.id_empleado
    LEFT JOIN roles r ON er.id_rol = r.id_rol
    WHERE e.activo = 1 AND (
        e.nombre LIKE CONCAT(p_termino, '%') OR
        e.apellido LIKE CONCAT(p_termino, '%') OR
        e.email LIKE CONCAT(p_termino, '%')
    )
    ORDER BY e.apellido, e.nombre;
END $$

-- ---------------------------------------------------------------------------------
-- TABLA: CATEGORIAS_ACTIVO
-- ---------------------------------------------------------------------------------

-- [CATEGORIAS] Listar todas las categorías de activos
CREATE PROCEDURE sp_listar_categorias()
BEGIN
    SELECT id_categoria, nombre_categoria
    FROM categorias_activo
    ORDER BY nombre_categoria ASC;
END $$

-- [CATEGORIAS] Buscar una categoría por su ID
CREATE PROCEDURE sp_buscar_categoria_por_id(IN p_id_categoria INT)
BEGIN
    SELECT id_categoria, nombre_categoria
    FROM categorias_activo
    WHERE id_categoria = p_id_categoria;
END $$

-- [CATEGORIAS] Filtrar categorías por un término de búsqueda
CREATE PROCEDURE sp_filtrar_categorias(IN p_termino VARCHAR(100))
BEGIN
    SELECT id_categoria, nombre_categoria
    FROM categorias_activo
    WHERE nombre_categoria LIKE CONCAT('%', p_termino, '%')
    ORDER BY nombre_categoria ASC;
END $$

-- [CATEGORIAS] Editar el nombre de una categoría
CREATE PROCEDURE sp_editar_categoria(IN p_id_categoria INT, IN p_nombre_categoria VARCHAR(100))
BEGIN
    UPDATE categorias_activo SET nombre_categoria = p_nombre_categoria WHERE id_categoria = p_id_categoria;
END $$

-- [CATEGORIAS] Registrar una nueva categoría
CREATE PROCEDURE sp_registrar_categoria(IN p_nombre VARCHAR(100))
BEGIN
    INSERT INTO categorias_activo(nombre_categoria)
    VALUES(p_nombre);
END $$

-- [CATEGORIAS] Editar el nombre de una categoría (duplicado, se mantiene por compatibilidad)
CREATE PROCEDURE sp_editar_categorias_activo(IN p_id_categoria INT, IN p_nombre_categoria VARCHAR(100))
BEGIN
    UPDATE categorias_activo SET nombre_categoria = p_nombre_categoria WHERE id_categoria = p_id_categoria;
END $$

-- [CATEGORIAS] Filtrar categorías por nombre (duplicado, se mantiene por compatibilidad)
CREATE PROCEDURE sp_filtrar_categorias_por_nombre(IN nom_categoria VARCHAR(100))
BEGIN
    SELECT c.id_categoria, c.nombre_categoria
    FROM categorias_activo c
    WHERE c.nombre_categoria LIKE CONCAT('%', nom_categoria, '%');
END $$

-- [CATEGORIAS] Eliminar una categoría (Borrado físico)
CREATE PROCEDURE sp_borrar_categoria(IN p_id INT)
BEGIN
    DELETE FROM categorias_activo WHERE id_categoria = p_id;
END $$

-- ---------------------------------------------------------------------------------
-- TABLA: ACTIVOS
-- ---------------------------------------------------------------------------------

-- [ACTIVOS] Listar todos los activos (sin filtrar por estado)
CREATE PROCEDURE sp_listar_activos()
BEGIN
    SELECT a.*, c.nombre_categoria
    FROM activos a
    LEFT JOIN categorias_activo c ON a.id_categoria = c.id_categoria
    ORDER BY a.id_activo;
END $$

-- [ACTIVOS] Buscar un activo por su ID
CREATE PROCEDURE sp_buscar_activo_por_id(IN p_id_activo INT)
BEGIN
    SELECT a.*, c.nombre_categoria
    FROM activos a
    LEFT JOIN categorias_activo c ON a.id_categoria = c.id_categoria
    WHERE a.id_activo = p_id_activo;
END $$

-- [ACTIVOS] Filtrar activos por un término (sin filtrar por estado)
CREATE PROCEDURE sp_filtrar_activos(IN p_termino VARCHAR(255))
BEGIN
    SELECT a.*, c.nombre_categoria
    FROM activos a
    LEFT JOIN categorias_activo c ON a.id_categoria = c.id_categoria
    WHERE a.serial_number LIKE CONCAT('%', p_termino, '%')
       OR a.marca LIKE CONCAT('%', p_termino, '%')
       OR a.modelo LIKE CONCAT('%', p_termino, '%')
    ORDER BY a.id_activo;
END $$

-- [ACTIVOS] Registrar un nuevo activo
CREATE PROCEDURE sp_registrar_activo(
    IN p_id_categoria INT,
    IN p_serial_number VARCHAR(255),
    IN p_marca VARCHAR(100),
    IN p_modelo VARCHAR(100),
    IN p_fecha_compra DATE,
    IN p_precio DECIMAL(10, 2),
    IN p_estado ENUM('En uso', 'Almacenado', 'Mantenimiento', 'Baja')
)
BEGIN
    INSERT INTO activos (id_categoria, serial_number, marca, modelo, fecha_compra, precio, estado)
    VALUES (p_id_categoria, p_serial_number, p_marca, p_modelo, p_fecha_compra, p_precio, p_estado);
END $$

-- [ACTIVOS] Editar los datos de un activo
CREATE PROCEDURE sp_editar_activo(
    IN p_id_activo INT,
    IN p_id_categoria INT,
    IN p_serial_number VARCHAR(255),
    IN p_marca VARCHAR(100),
    IN p_modelo VARCHAR(100),
    IN p_fecha_compra DATE,
    IN p_precio DECIMAL(10, 2),
    IN p_estado ENUM('En uso', 'Almacenado', 'Mantenimiento', 'Baja')
)
BEGIN
    UPDATE activos
    SET 
        id_categoria = p_id_categoria,
        serial_number = p_serial_number,
        marca = p_marca,
        modelo = p_modelo,
        fecha_compra = p_fecha_compra,
        precio = p_precio,
        estado = p_estado
    WHERE id_activo = p_id_activo;
END $$

-- [ACTIVOS] Dar de baja un activo (Borrado lógico)
CREATE PROCEDURE sp_baja_activo(IN p_id_activo INT)
BEGIN
    UPDATE activos
    SET estado = 'Baja'
    WHERE id_activo = p_id_activo;
END $$

-- [ACTIVOS] Reactivar un activo (lo pone en estado 'Almacenado')
CREATE PROCEDURE sp_alta_activo(IN p_id_activo INT)
BEGIN
    UPDATE activos
    SET estado = 'Almacenado'
    WHERE id_activo = p_id_activo;
END $$

-- [ACTIVOS] Listar solo activos que NO están de baja
CREATE PROCEDURE sp_listar_activos_activos()
BEGIN
    SELECT a.*, c.nombre_categoria
    FROM activos a
    LEFT JOIN categorias_activo c ON a.id_categoria = c.id_categoria
    WHERE a.estado <> 'Baja'
    ORDER BY a.id_activo;
END $$

-- [ACTIVOS] Filtrar solo activos que NO están de baja
CREATE PROCEDURE sp_filtrar_activos_activos(IN p_valor VARCHAR(100))
BEGIN
    SELECT a.*, c.nombre_categoria
    FROM activos a
    LEFT JOIN categorias_activo c ON a.id_categoria = c.id_categoria
    WHERE 
        a.estado <> 'Baja' AND 
        (
            a.serial_number LIKE CONCAT('%', p_valor, '%') OR
            a.marca LIKE CONCAT('%', p_valor, '%') OR
            a.modelo LIKE CONCAT('%', p_valor, '%') OR
            c.nombre_categoria LIKE CONCAT('%', p_valor, '%')
        )
    ORDER BY a.id_activo;
END $$

-- [ACTIVOS] Filtrar solo activos que SÍ están de baja
CREATE PROCEDURE sp_filtrar_activos_desactivados(IN p_valor VARCHAR(100))
BEGIN
    SELECT a.*, c.nombre_categoria
    FROM activos a
    LEFT JOIN categorias_activo c ON a.id_categoria = c.id_categoria
    WHERE 
        a.estado = 'Baja' AND 
        (
            a.serial_number LIKE CONCAT('%', p_valor, '%') OR
            a.marca LIKE CONCAT('%', p_valor, '%') OR
            a.modelo LIKE CONCAT('%', p_valor, '%') OR
            c.nombre_categoria LIKE CONCAT('%', p_valor, '%')
        )
    ORDER BY a.id_activo;
END $$

-- ---------------------------------------------------------------------------------
-- TABLA: LICENCIAS_SOFTWARE
-- ---------------------------------------------------------------------------------

-- [LICENCIAS] Listar todas las licencias
CREATE PROCEDURE sp_listar_licencias()
BEGIN
    SELECT l.*, c.nombre_categoria
    FROM licencias_software l
    LEFT JOIN categorias_activo c ON l.id_categoria = c.id_categoria
    ORDER BY l.id_licencia;
END $$

-- [LICENCIAS] Buscar una licencia por su ID
CREATE PROCEDURE sp_buscar_licencia_por_id(IN p_id_licencia INT)
BEGIN
    SELECT l.*, c.nombre_categoria
    FROM licencias_software l
    LEFT JOIN categorias_activo c ON l.id_categoria = c.id_categoria
    WHERE l.id_licencia = p_id_licencia;
END $$

-- [LICENCIAS] Filtrar licencias por un término de búsqueda
CREATE PROCEDURE sp_filtrar_licencias(IN p_termino VARCHAR(150))
BEGIN
    SELECT l.*, c.nombre_categoria
    FROM licencias_software l
    LEFT JOIN categorias_activo c ON l.id_categoria = c.id_categoria
    WHERE l.nombre_software LIKE CONCAT('%', p_termino, '%')
    ORDER BY l.id_licencia;
END $$

-- [LICENCIAS] Registrar una nueva licencia
CREATE PROCEDURE sp_registrar_licencia(
    IN p_id_categoria INT,
    IN p_nombre_software VARCHAR(150),
    IN p_clave_licencia VARCHAR(255),
    IN p_fecha_expiracion DATE,
    IN p_cantidad_usuarios INT
)
BEGIN
    INSERT INTO licencias_software (id_categoria, nombre_software, clave_licencia, fecha_expiracion, cantidad_usuarios)
    VALUES (p_id_categoria, p_nombre_software, p_clave_licencia, p_fecha_expiracion, p_cantidad_usuarios);
END $$

-- [LICENCIAS] Editar los datos de una licencia
CREATE PROCEDURE sp_editar_licencia(
    IN p_id_licencia INT,
    IN p_id_categoria INT,
    IN p_nombre_software VARCHAR(150),
    IN p_clave_licencia VARCHAR(255),
    IN p_fecha_expiracion DATE,
    IN p_cantidad_usuarios INT
)
BEGIN
    UPDATE licencias_software
    SET 
        id_categoria = p_id_categoria,
        nombre_software = p_nombre_software,
        clave_licencia = p_clave_licencia,
        fecha_expiracion = p_fecha_expiracion,
        cantidad_usuarios = p_cantidad_usuarios
    WHERE id_licencia = p_id_licencia;
END $$

-- [LICENCIAS] Eliminar una licencia (Borrado físico)
CREATE PROCEDURE sp_borrar_licencia(IN p_id INT)
BEGIN
    DELETE FROM licencias_software WHERE id_licencia = p_id;
END $$

DELIMITER ;


--ASignaciones 

DELIMITER $$
CREATE PROCEDURE sp_listar_asignaciones()
BEGIN
    SELECT a.id_asignacion,
           e.nombre AS empleado_nombre,
           ac.serial_number AS activo_nombre,
           a.fecha_asignacion,
           a.fecha_devolucion,
           a.notas
    FROM asignaciones a
    INNER JOIN empleados e ON a.id_empleado = e.id_empleado
    INNER JOIN activos ac ON a.id_activo = ac.id_activo
    ORDER BY a.id_asignacion DESC;
END$$
DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_buscar_asignacion_por_id(IN p_id INT)
BEGIN
    SELECT 
        a.id_asignacion,
        a.id_activo,
        a.id_empleado,
        a.fecha_asignacion,
        a.fecha_devolucion,
        a.notas,
        CONCAT(e.nombre, ' ', e.apellido) AS nombre_empleado,
        -- Construimos un "nombre" legible del activo: Marca Modelo (Serial)
        CONCAT(IFNULL(ac.marca,''), ' ', IFNULL(ac.modelo,''), ' (', IFNULL(ac.serial_number,''), ')') AS nombre_activo
    FROM asignaciones a
    LEFT JOIN empleados e ON a.id_empleado = e.id_empleado
    LEFT JOIN activos ac   ON a.id_activo   = ac.id_activo
    WHERE a.id_asignacion = p_id;
END$$
DELIMITER ;



DELIMITER $$
CREATE PROCEDURE sp_registrar_asignacion(
    IN p_id_empleado INT,
    IN p_id_activo INT,
    IN p_fecha_devolucion DATETIME,
    IN p_notas TEXT
)
BEGIN
    INSERT INTO asignaciones(id_empleado,id_activo,fecha_devolucion,notas)
    VALUES(p_id_empleado,p_id_activo,p_fecha_devolucion,p_notas);

    UPDATE activos SET estado='En uso'
    WHERE id_activo = p_id_activo;
END$$
DELIMITER ;

DELIMITER $$

CREATE PROCEDURE sp_editar_asignacion(
    IN p_id_asignacion INT,
    IN p_id_empleado INT,
    IN p_id_activo INT,
    IN p_fecha_asignacion DATETIME,
    IN p_fecha_devolucion DATETIME,
    IN p_notas TEXT
)
BEGIN
    -- Actualizar la asignación sin cambios adicionales de estado de activo
    UPDATE asignaciones
    SET id_empleado = p_id_empleado,
        id_activo = p_id_activo,
        fecha_asignacion = p_fecha_asignacion,
        fecha_devolucion = p_fecha_devolucion,
        notas = p_notas
    WHERE id_asignacion = p_id_asignacion;
END$$

DELIMITER ;


DELIMITER $$
CREATE PROCEDURE sp_borrar_asignacion(IN p_id INT)
BEGIN
    DECLARE idA INT;

    SELECT id_activo INTO idA
    FROM asignaciones
    WHERE id_asignacion = p_id;

    DELETE FROM asignaciones WHERE id_asignacion = p_id;

    UPDATE activos SET estado='Almacenado'
    WHERE id_activo = idA;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sp_filtrar_asignaciones(IN p_filtro VARCHAR(100))
BEGIN
    SELECT a.id_asignacion,
           CONCAT(e.nombre,' ',e.apellido) AS empleado_nombre,
           ac.serial_number AS activo_nombre,
           a.fecha_devolucion,
           a.notas
    FROM asignaciones a
    INNER JOIN empleados e ON a.id_empleado = e.id_empleado
    INNER JOIN activos ac ON a.id_activo = ac.id_activo
    WHERE e.nombre LIKE CONCAT(p_filtro,'%')
       OR e.apellido LIKE CONCAT(p_filtro,'%')
       OR ac.serial_number LIKE CONCAT(p_filtro,'%')
    ORDER BY a.id_asignacion DESC;
END$$
DELIMITER ;


-- ---------------------------------------------------------------------------------
-- TABLA: REGISTROS_MANTENIMIENTO
-- ---------------------------------------------------------------------------------

-- [MANTENIMIENTO] Listar todos los registros de mantenimiento
DELIMITER $$
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
DELIMITER ;

-- [MANTENIMIENTO] Buscar un registro de mantenimiento por su ID
DELIMITER $$
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
DELIMITER ;

-- [MANTENIMIENTO] Registrar un nuevo registro de mantenimiento
DELIMITER $$
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
DELIMITER ;

-- [MANTENIMIENTO] Editar un registro de mantenimiento
DELIMITER $$
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
DELIMITER ;

-- [MANTENIMIENTO] Eliminar un registro de mantenimiento (Borrado físico)
DELIMITER $$
CREATE PROCEDURE sp_borrar_mantenimiento(IN p_id_mantenimiento INT)
BEGIN
    DELETE FROM registros_mantenimiento WHERE id_mantenimiento = p_id_mantenimiento;
END $$
DELIMITER ;

-- [MANTENIMIENTO] Filtrar registros de mantenimiento por término de búsqueda
DELIMITER $$
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

