<?php
    spl_autoload_register("Cargar");
    function Cargar($class) {
        $route = __DIR__ . "/../model/";

        $file = $route.$class.".php";

        include_once($file);
    }
?>