<?php
spl_autoload_register("LoadClasses");

function LoadClasses($className) {
    
    // Calcula la ruta absoluta al MODELO, saliendo de 'template/'
    // __DIR__ es la ruta del directorio actual (pages/template)
    // /../ sale de 'template' y lo lleva a 'pages/'
    // /model/ lo lleva a 'pages/model/'
    $path = __DIR__ . '/../model/'; // <--- CAMBIO CRUCIAL

    $extension = ".php"; 
    $fullPath = $path . $className . $extension;
    
    // Incluir
    if (file_exists($fullPath)) {
        include_once $fullPath;
    } 
}
?>