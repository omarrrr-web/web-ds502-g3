<?php
include "../../template/loadclass.php"; // Asegúrate de incluir tu archivo de conexión a la base de datos

// Verifica si se ha recibido el parámetro 'idasig'
if (isset($_GET['idasig'])) {
    $id_asignacion = $_GET['idasig'];

    $crud_asig = new CRUDAsignaciones();

    // Llamar al método para borrar la asignación
    $crud_asig->BorrarAsignacion($id_asignacion);

    // Redirigir después de borrar
    header("Location: listar_asignaciones.php");
    exit();
} else {
    // Si no se recibe el parámetro 'idasig', redirigir a la lista de asignaciones
    header("Location: listar_asignaciones.php");
    exit();
}
?>
