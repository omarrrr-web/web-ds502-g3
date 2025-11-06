# CRUD de Registros de Mantenimiento - Instrucciones de Instalación

## Resumen
Se ha creado un CRUD completo para la tabla `registros_mantenimiento` siguiendo la misma estructura y patrones de las demás tablas del proyecto.

## Archivos Creados

### 1. Base de Datos
- **`db/sp_registros_mantenimiento.sql`** - Procedimientos almacenados independientes
- **`db/bd_GATI_ds502.sql`** - Actualizado con los procedimientos almacenados integrados

### 2. Modelo (pages/model/)
- **`registros_mantenimiento.php`** - Clase modelo con propiedades de la tabla
- **`crudregistrosmantenimiento.php`** - Clase CRUD que extiende Conexion

### 3. Controladores (pages/controller/)
- **`ctr_grabar_mantenimiento.php`** - Registrar y editar
- **`ctr_filtrar_mantenimiento.php`** - Filtrar registros
- **`ctr_mostrar_mantenimiento.php`** - Mostrar detalles (AJAX)
- **`ctr_consultar_mantenimiento.php`** - Consultar por ID (JSON)
- **`ctr_get_form_mantenimiento.php`** - Cargar formulario de edición (AJAX)

### 4. Vistas (pages/view/mantenimiento/)
- **`listar_mantenimientos.php`** - Lista completa con tabla
- **`registrar_mantenimiento.php`** - Formulario de registro
- **`editar_mantenimiento.php`** - Formulario de edición
- **`mostrar_mantenimiento.php`** - Vista de detalles
- **`consultar_mantenimiento.php`** - Búsqueda por ID con AJAX
- **`filtrar_mantenimiento.php`** - Filtrado dinámico con AJAX
- **`borrar_mantenimiento.php`** - Eliminación de registros

### 5. Carpeta de Acceso Directo
- **`mantenimiento/index.php`** - Redirección a listar_mantenimientos.php

## Instalación

### Paso 1: Ejecutar Procedimientos Almacenados
Ejecuta uno de estos archivos SQL en tu base de datos MySQL:

**Opción A - Archivo independiente:**
```sql
SOURCE /ruta/a/db/sp_registros_mantenimiento.sql;
```

**Opción B - Archivo completo (si vas a recrear toda la BD):**
```sql
SOURCE /ruta/a/db/bd_GATI_ds502.sql;
```

### Paso 2: Verificar Archivos
Todos los archivos PHP ya están en su lugar. El autoloader (`pages/template/loadclass.php`) cargará automáticamente las nuevas clases.

### Paso 3: Acceder al Módulo
Accede a través de cualquiera de estas URLs:
- `http://tu-servidor/mantenimiento/`
- `http://tu-servidor/pages/view/mantenimiento/listar_mantenimientos.php`

## Funcionalidades Implementadas

### ✅ CRUD Completo
- **Create (Crear)**: Registrar nuevos mantenimientos
- **Read (Leer)**: Listar, consultar y mostrar detalles
- **Update (Actualizar)**: Editar registros existentes
- **Delete (Eliminar)**: Borrado físico de registros

### ✅ Características Adicionales
- **Filtrado dinámico**: Búsqueda por serial, activo, empleado o descripción
- **Consulta por ID**: Búsqueda específica con respuesta AJAX/JSON
- **Validación de formularios**: Campos requeridos y tipos de datos
- **Interfaz Bootstrap**: Diseño consistente con el resto del proyecto
- **Relaciones**: Integración con tablas `activos` y `empleados`

## Estructura de la Tabla

```sql
registros_mantenimiento (
    id_mantenimiento INT PRIMARY KEY AUTO_INCREMENT,
    id_activo INT NOT NULL,
    fecha_servicio DATE NOT NULL,
    descripcion TEXT NOT NULL,
    costo DECIMAL(10, 2) DEFAULT 0.00,
    realizado_por INT NOT NULL,
    FOREIGN KEY (id_activo) REFERENCES activos(id_activo),
    FOREIGN KEY (realizado_por) REFERENCES empleados(id_empleado)
)
```

## Procedimientos Almacenados Creados

1. `sp_listar_mantenimientos()` - Lista todos los registros con JOINs
2. `sp_buscar_mantenimiento_por_id(p_id_mantenimiento)` - Busca por ID
3. `sp_registrar_mantenimiento(...)` - Inserta nuevo registro
4. `sp_editar_mantenimiento(...)` - Actualiza registro existente
5. `sp_borrar_mantenimiento(p_id_mantenimiento)` - Elimina registro
6. `sp_filtrar_mantenimientos(p_termino)` - Filtra por término de búsqueda

## Notas Importantes

- **No se modificaron** archivos de otras tablas (activos, empleados, asignaciones, etc.)
- **Se reutilizó** la estructura y patrones existentes del proyecto
- **Compatible** con el sistema de autoload existente
- **Integrado** con las clases CRUDActivos y CRUDEmpleado para los selectores
- **Sigue** las convenciones de nombres del proyecto (ctr_, sp_, etc.)

## Próximos Pasos Opcionales

Si deseas agregar más funcionalidades:
- Agregar paginación a la lista de mantenimientos
- Implementar exportación a PDF/Excel
- Agregar gráficos de costos de mantenimiento
- Crear reportes por período o por activo
- Implementar notificaciones de mantenimientos programados

---
**Fecha de creación**: Noviembre 2024
**Desarrollado siguiendo**: Estructura existente del proyecto GATI DS502
