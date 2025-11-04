# Explicación del Funcionamiento de la API y el `BaseController`

Este documento detalla la arquitectura y el funcionamiento del `BaseController.php`, que es el núcleo de la API REST del proyecto.

## 1. El Propósito: Una Clase Abstracta

`BaseController` es una clase `abstract` de PHP. Esto significa que no se puede usar directamente, sino que sirve como una **plantilla o esqueleto** para otros controladores más específicos (como `RolController` y `EmpleadoController`).

El objetivo principal es **evitar la repetición de código**. Las operaciones básicas de base de datos (Crear, Leer, Actualizar, Eliminar - CRUD) son muy similares para cualquier tabla. `BaseController` implementa esta lógica una sola vez de forma genérica.

## 2. El Constructor (`__construct`)

- **¿Qué hace?**: Es el primer método que se ejecuta cuando se crea una instancia de un controlador hijo (ej. `new RolController(...)`).
- **¿Cómo funciona?**: Recibe tres parámetros esenciales para poder funcionar de forma genérica:
    1.  `$pdo`: El objeto de conexión a la base de datos (PDO).
    2.  `$table`: El nombre de la tabla que el controlador va a gestionar (ej. `'roles'`).
    3.  `$primary_key`: El nombre de la columna que es la llave primaria de esa tabla (ej. `'id_rol'`).
- **Resultado**: Almacena estos tres datos en variables `protected` (`$this->pdo`, `$this->table`, `$this->primary_key`) para que los demás métodos de la clase puedan usarlos al construir las consultas SQL.

## 3. Los "Manejadores" (Handlers)

Estos son los métodos `public` que actúan como puntos de entrada. El enrutador de la API (`api/v1.php`) llama a uno de estos métodos dependiendo del verbo HTTP de la solicitud (GET, POST, PUT, DELETE).

- **`handleGet($id)`**:
    - Se usa para **consultar** datos (Leer).
    - Si la URL incluye un ID (ej. `/api/v1/empleado/5`), llama al método interno `getById(5)` para buscar un único registro.
    - Si no se proporciona un ID (ej. `/api/v1/empleado`), llama al método interno `getAll()` para obtener una lista de todos los registros.

- **`handlePost()`**:
    - Se usa para **crear** un nuevo registro.
    - Lee los datos en formato JSON que se envían en el cuerpo de la solicitud.
    - Llama al método interno `create()` pasándole esos datos.

- **`handlePut($id)`**:
    - Se usa para **actualizar** un registro existente.
    - Requiere que se especifique un ID en la URL.
    - Lee los nuevos datos del cuerpo de la solicitud.
    - Llama al método interno `update()` con el ID y los nuevos datos.

- **`handleDelete($id)`**:
    - Se usa para **eliminar** un registro.
    - Requiere un ID en la URL.
    - Llama al método interno `delete()` con ese ID.

## 4. Los Métodos de Lógica Interna (CRUD)

Estos métodos son `protected`, lo que significa que solo pueden ser accedidos desde el propio `BaseController` o desde las clases que lo heredan. Contienen la lógica SQL real.

- **`getAll()`**: Ejecuta una consulta `SELECT * FROM nombre_de_la_tabla`.

- **`getById($id)`**: Ejecuta `SELECT * FROM tabla WHERE id_de_la_tabla = ?`. Busca un registro específico por su llave primaria.

- **`create($data)`**:
    - Este método es la clave de la genericidad. Construye una consulta `INSERT` dinámicamente.
    - Toma las claves del array `$data` para generar la lista de columnas: `(columna1, columna2, ...)`.
    - Crea el número correcto de marcadores de posición (`?`) para los valores: `VALUES (?, ?, ...)`.
    - Ejecuta la consulta de forma segura usando sentencias preparadas, lo que previene inyecciones SQL.

- **`update($id, $data)`**:
    - Funciona de manera similar a `create`, pero para actualizaciones.
    - Recorre los datos para construir la cláusula `SET`: `SET columna1 = ?, columna2 = ?`.
    - Añade la condición `WHERE id_de_la_tabla = ?` al final.
    - Ejecuta la consulta `UPDATE` de forma segura.

- **`delete($id)`**: Ejecuta una consulta `DELETE FROM tabla WHERE id_de_la_tabla = ?`.

## 5. El Método de Respuesta (`sendResponse`)

- **¿Qué hace?**: Es una función de utilidad para estandarizar las respuestas de la API.
- **¿Cómo funciona?**:
    1.  Establece el **código de estado HTTP** (ej. `200` para "OK", `404` para "No encontrado", `500` para "Error del servidor").
    2.  Convierte el array de resultados de PHP a formato **JSON** usando `json_encode()`.
    3.  Imprime el resultado JSON, que es lo que el cliente final recibe.

## Conclusión: Ventajas de esta Arquitectura

- **Reutilización de Código**: Evita tener que escribir las mismas consultas CRUD una y otra vez para cada entidad (roles, empleados, productos, etc.).
- **Mantenimiento Sencillo**: Si se necesita cambiar la forma en que funciona una operación (por ejemplo, añadir logging), solo se cambia en `BaseController`.
- **Extensibilidad**: Si un controlador necesita un comportamiento especial (como el borrado lógico en `EmpleadoController`), puede **sobrescribir** el método correspondiente (`delete()`) sin afectar a los demás.
- **Rapidez de Desarrollo**: Para añadir una API para una nueva tabla, solo se necesita crear un nuevo controlador que herede de `BaseController` y pasarle el nombre de la tabla y su clave primaria. El resto de la funcionalidad se hereda automáticamente.
