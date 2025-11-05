<?php
spl_autoload_register(function($clase){
    // Primero, nos aseguramos de que la clase de conexión base (CBD) siempre esté disponible.
    include_once __DIR__."/../model/conexion.php";

    // Luego, intentamos cargar el archivo de la clase solicitada.
    $file = __DIR__."/../model/".$clase.".php";
    if (file_exists($file)) {
        include_once $file;
    }
});
?>