<?php
// 1. Cabeceras y manejo de OPTIONS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// 2. Incluir dependencias
require_once '../pages/model/conexion.php';
require_once 'controllers/RolController.php';
require_once 'controllers/EmpleadoController.php';

// 3. Mapeo de rutas a controladores
$controller_map = [
    'roles' => 'RolController',
    'empleados' => 'EmpleadoController'
];

// 4. Obtener y validar la tabla/recurso
$table = isset($_GET['table']) ? $_GET['table'] : null;

if (!$table || !isset($controller_map[$table])) {
    http_response_code(400);
    echo json_encode(["error" => "Recurso no especificado o no permitido."]);
    exit();
}

// 5. Conexión a la BD e instanciación del controlador
try {
    $conexion_wrapper = new Conexion();
    $pdo = $conexion_wrapper->Conectar();

    if (!$pdo) {
        throw new PDOException("No se pudo establecer la conexión a la base de datos.");
    }

    $controller_name = $controller_map[$table];
    $controller = new $controller_name($pdo);

    // 6. Enrutamiento según el método HTTP
    $method = $_SERVER['REQUEST_METHOD'];
    $id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : null;

    switch ($method) {
        case 'GET':
            $controller->handleGet($id);
            break;
        case 'POST':
            $controller->handlePost();
            break;
        case 'PUT':
            $controller->handlePut($id);
            break;
        case 'DELETE':
            $controller->handleDelete($id);
            break;
        default:
            http_response_code(405); // Method Not Allowed
            echo json_encode(["error" => "Método no permitido."]);
            break;
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error en el servidor: " . $e->getMessage()]);
}