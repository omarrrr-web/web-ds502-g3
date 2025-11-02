CREATE DATABASE IF NOT EXISTS bd_GATI_ds502;
USE bd_GATI_ds502;

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
  `id_categoria` INT NOT NULL,
  `serial_number` VARCHAR(255) NOT NULL UNIQUE,
  `marca` VARCHAR(100) NULL,
  `modelo` VARCHAR(100) NULL,
  `fecha_compra` DATE NULL,
  `precio` DECIMAL(10, 2) NULL,
  `estado` ENUM('En uso', 'Almacenado', 'Mantenimiento', 'Baja') DEFAULT 'Almacenado',
  FOREIGN KEY (`id_categoria`) REFERENCES `categorias_activo` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `licencias_software` (
  `id_licencia` INT AUTO_INCREMENT PRIMARY KEY,
  `id_categoria` INT NOT NULL,
  `nombre_software` VARCHAR(150) NOT NULL,
  `clave_licencia` VARCHAR(255) NOT NULL,
  `fecha_expiracion` DATE NULL,
  `cantidad_usuarios` INT DEFAULT 1,
  FOREIGN KEY (`id_categoria`) REFERENCES `categorias_activo` (`id_categoria`)
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

DELIMITER $$
CREATE PROCEDURE sp_listar_roles()
BEGIN
    SELECT id_rol, nombre_rol FROM roles ORDER BY nombre_rol ASC;
END$$
DELIMITER ;

DELIMITER $$
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
END$$
DELIMITER ;

DELIMITER $$
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
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sp_registrar_empleado(
    IN p_nombre VARCHAR(100),
    IN p_apellido VARCHAR(100),
    IN p_email VARCHAR(255),
    IN p_password VARCHAR(255),
    IN p_id_rol INT
)
BEGIN
    DECLARE last_id_empleado INT;

    INSERT INTO empleados(nombre, apellido, email, password, activo)
    VALUES(p_nombre, p_apellido, p_email, p_password, 1);

    SET last_id_empleado = LAST_INSERT_ID();

    INSERT INTO empleado_rol(id_empleado, id_rol)
    VALUES(last_id_empleado, p_id_rol);
END$$
DELIMITER ;

DELIMITER $$
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
    SET
        nombre = p_nombre,
        apellido = p_apellido,
        email = p_email
    WHERE id_empleado = p_id_empleado;

    DELETE FROM empleado_rol WHERE id_empleado = p_id_empleado;

    INSERT INTO empleado_rol(id_empleado, id_rol)
    VALUES(p_id_empleado, p_id_rol);
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sp_desactivar_empleado(IN p_id_empleado INT)
BEGIN
    UPDATE empleados
    SET activo = 0
    WHERE id_empleado = p_id_empleado;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE sp_activar_empleado(IN p_id_empleado INT)
BEGIN
    UPDATE empleados
    SET activo = 1
    WHERE id_empleado = p_id_empleado;
END$$
DELIMITER ;

DELIMITER $$
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
END$$
DELIMITER ;

-- 9. Filtrar Empleados
DELIMITER $$
CREATE PROCEDURE sp_filtrar_empleados(
    IN p_termino VARCHAR(255)
)
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
END$$
DELIMITER ;

