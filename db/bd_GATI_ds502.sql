create database bd_GATI_ds502;

use bd_GATI_ds502;
-- -----------------------------------------------------
-- Esquema de Base de Datos para GATI
-- Empresa: Consultoría Ágil S.A.
-- -----------------------------------------------------

-- Deshabilitar la verificación de claves foráneas temporalmente
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;

-- -----------------------------------------------------
-- I. TABLAS DE GESTIÓN DE USUARIOS Y ROLES
-- -----------------------------------------------------

-- 1. Tabla: roles
-- Define los permisos (Admin vs Empleado)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `roles` (
  `id_rol` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre_rol` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tabla: empleados
-- Usuarios del sistema (tanto admins como normales)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `empleados` (
  `id_empleado` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(100) NOT NULL,
  `apellido` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE COMMENT 'Usado para el login',
  `password` VARCHAR(255) NOT NULL COMMENT 'Almacenar siempre hasheado (ej. bcrypt)',
  `activo` TINYINT(1) DEFAULT 1 COMMENT '0 = Inactivo, 1 = Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabla: empleado_rol (Relación Muchos a Muchos)
-- Asigna los roles a los empleados
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `empleado_rol` (
  `id_empleado` INT NOT NULL,
  `id_rol` INT NOT NULL,
  PRIMARY KEY (`id_empleado`, `id_rol`),
  FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE,
  FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- -----------------------------------------------------
-- II. TABLAS DE GESTIÓN DE ACTIVOS (CORE CRUD)
-- -----------------------------------------------------

-- 4. Tabla: categorias_activo
-- Clasifica el tipo de activo (Hardware, Software, etc.)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `categorias_activo` (
  `id_categoria` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre_categoria` VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Tabla: activos
-- El inventario principal de hardware
-- -----------------------------------------------------
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

-- 6. Tabla: licencias_software
-- Inventario de software (activos no físicos)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `licencias_software` (
  `id_licencia` INT AUTO_INCREMENT PRIMARY KEY,
  `id_categoria` INT NOT NULL COMMENT 'FK a categoria "Software"',
  `nombre_software` VARCHAR(150) NOT NULL,
  `clave_licencia` VARCHAR(255) NOT NULL,
  `fecha_expiracion` DATE NULL,
  `cantidad_usuarios` INT DEFAULT 1,
  FOREIGN KEY (`id_categoria`) REFERENCES `categorias_activo` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- -----------------------------------------------------
-- III. TABLAS DE RELACIÓN Y MOVIMIENTO
-- -----------------------------------------------------

-- 7. Tabla: asignaciones
-- Registra qué empleado tiene qué activo
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `asignaciones` (
  `id_asignacion` INT AUTO_INCREMENT PRIMARY KEY,
  `id_activo` INT NOT NULL,
  `id_empleado` INT NOT NULL,
  `fecha_asignacion` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `fecha_devolucion` DATETIME NULL COMMENT 'Cuando es NULO, el activo sigue asignado',
  `notas` TEXT NULL,
  FOREIGN KEY (`id_activo`) REFERENCES `activos` (`id_activo`),
  FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. Tabla: registros_mantenimiento
-- Historial de servicio de cada activo
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `registros_mantenimiento` (
  `id_mantenimiento` INT AUTO_INCREMENT PRIMARY KEY,
  `id_activo` INT NOT NULL,
  `fecha_servicio` DATE NOT NULL,
  `descripcion` TEXT NOT NULL,
  `costo` DECIMAL(10, 2) DEFAULT 0.00,
  `realizado_por` INT NOT NULL COMMENT 'FK al empleado (Técnico de T.I.) que hizo el servicio',
  FOREIGN KEY (`id_activo`) REFERENCES `activos` (`id_activo`),
  FOREIGN KEY (`realizado_por`) REFERENCES `empleados` (`id_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------
-- INSERTS INICIALES (Datos Semilla)
-- -----------------------------------------------------
INSERT INTO `roles` (`nombre_rol`) VALUES ('Administrador'), ('Empleado');
INSERT INTO `categorias_activo` (`nombre_categoria`) VALUES ('Laptop'), ('Monitor'), ('Software'), ('Móvil');
-- -----------------------------------------------------
-- INSERCIÓN DE DATOS SEMILLA PARA GATI
-- -----------------------------------------------------

-- Deshabilitar la verificación de claves foráneas para la inserción masiva
SET FOREIGN_KEY_CHECKS=0;

-- 1. Tabla: roles
-- (Insertamos 3 roles clave)
INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Empleado'),
(3, 'Tecnico_TI');

-- 2. Tabla: categorias_activo
-- (Insertamos 5 categorías de ejemplo)
INSERT INTO `categorias_activo` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'Laptop'),
(2, 'Monitor'),
(3, 'Software'),
(4, 'Móvil'),
(5, 'Periférico');

-- 3. Tabla: empleados
-- (Insertamos 5 empleados. Las IDs auto-incrementales serán 1, 2, 3, 4, 5)
-- (Las contraseñas deben ser hasheadas en una aplicación real)
INSERT INTO `empleados` (`id_empleado`, `nombre`, `apellido`, `email`, `password`, `activo`) VALUES
(1, 'Ana', 'Torres', 'ana.torres@consultoria.com', 'hash_pass_123', 1),
(2, 'Carlos', 'Luna', 'carlos.luna@consultoria.com', 'hash_pass_456', 1),
(3, 'Beatriz', 'Franco', 'beatriz.franco@consultoria.com', 'hash_pass_789', 1),
(4, 'David', 'Salas', 'david.salas@consultoria.com', 'hash_pass_101', 1),
(5, 'Elena', 'Vera', 'elena.vera@consultoria.com', 'hash_pass_112', 0);

-- 4. Tabla: empleado_rol (Relación)
-- (Asignamos roles a los empleados creados)
INSERT INTO `empleado_rol` (`id_empleado`, `id_rol`) VALUES
(1, 1), -- Ana es Administradora
(2, 3), -- Carlos es Tecnico_TI
(2, 2), -- Carlos también es Empleado
(3, 2), -- Beatriz es Empleada
(4, 2), -- David es Empleado
(5, 2); -- Elena es Empleada (aunque inactiva)

-- 5. Tabla: activos
-- (Insertamos 6 activos de hardware. IDs auto-incrementales 1-6)
INSERT INTO `activos` (`id_activo`, `id_categoria`, `serial_number`, `marca`, `modelo`, `fecha_compra`, `precio`, `estado`) VALUES
(1, 1, 'SN_DELL_001', 'Dell', 'XPS 15', '2024-01-10', 1800.00, 'En uso'),
(2, 1, 'SN_LEN_002', 'Lenovo', 'ThinkPad X1', '2024-02-15', 1650.00, 'Almacenado'),
(3, 2, 'SN_SAM_003', 'Samsung', 'Odyssey G5', '2023-11-20', 350.00, 'En uso'),
(4, 4, 'SN_APP_004', 'Apple', 'iPhone 13', '2022-05-01', 900.00, 'Baja'),
(5, 5, 'SN_LOG_005', 'Logitech', 'MX Keys', '2024-03-05', 150.00, 'Almacenado'),
(6, 2, 'SN_DELL_006', 'Dell', 'Ultrasharp 27', '2023-01-01', 450.00, 'Mantenimiento');

-- 6. Tabla: licencias_software
-- (Insertamos 5 licencias, todas en la categoría 3: Software)
INSERT INTO `licencias_software` (`id_licencia`, `id_categoria`, `nombre_software`, `clave_licencia`, `fecha_expiracion`, `cantidad_usuarios`) VALUES
(1, 3, 'Microsoft 365 E5', 'M365-XXXX-YYYY-ZZZZ', '2025-12-31', 50),
(2, 3, 'JetBrains PhpStorm', 'JET-AAAA-BBBB-CCCC', '2025-06-15', 10),
(3, 3, 'Adobe Photoshop CC', 'ADO-1111-2222-3333', '2025-01-01', 5),
(4, 3, 'Slack Pro (Workspace)', 'SLK-7777-8888-9999', '2025-10-30', 50),
(5, 3, 'Windows 11 Pro OEM', 'WIN-QWER-TYUI-OPAS', NULL, 1);

-- 7. Tabla: asignaciones
-- (Registra quién tiene qué activo)
INSERT INTO `asignaciones` (`id_asignacion`, `id_activo`, `id_empleado`, `fecha_asignacion`, `fecha_devolucion`, `notas`) VALUES
(1, 1, 3, '2024-01-20 09:00:00', NULL, 'Laptop asignada a Beatriz Franco.'),
(2, 3, 3, '2024-01-20 09:01:00', NULL, 'Monitor principal para Beatriz Franco.'),
(3, 2, 1, '2024-02-20 10:00:00', NULL, 'Laptop asignada a Admin Ana Torres.'),
(4, 5, 4, '2024-03-10 15:30:00', NULL, 'Teclado para David Salas.'),
(5, 4, 5, '2022-05-05 11:00:00', '2024-05-01 17:00:00', 'Móvil asignado a Elena Vera. Devuelto por baja de empleada.');

-- 8. Tabla: registros_mantenimiento
-- (Historial de servicio, realizado por el Técnico (Empleado ID 2))
INSERT INTO `registros_mantenimiento` (`id_mantenimiento`, `id_activo`, `fecha_servicio`, `descripcion`, `costo`, `realizado_por`) VALUES
(1, 6, '2025-10-30', 'Monitor (SN_DELL_006) no enciende. Se envía a diagnóstico.', 0.00, 2),
(2, 1, '2024-06-15', 'Limpieza interna de ventiladores y cambio de pasta térmica (SN_DELL_001).', 50.00, 2),
(3, 2, '2024-02-18', 'Instalación de imagen corporativa (formateo) (SN_LEN_002).', 0.00, 2),
(4, 4, '2024-04-20', 'Diagnóstico de batería hinchada (SN_APP_004). Se determina como BAJA.', 0.00, 2),
(5, 6, '2025-10-31', 'Reemplazo de panel LCD dañado (SN_DELL_006).', 150.00, 2);


-- Reactivar la verificación de claves foráneas
SET FOREIGN_KEY_CHECKS=1;

select * from categorias_activo;
select * from registros_mantenimiento;
-- Reactivar la verificación de claves foráneas
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;