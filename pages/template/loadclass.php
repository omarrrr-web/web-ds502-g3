<?php
    spl_autoload_register("Cargar");
    function Cargar($class) {
        $route = "../../model/";

        $file = $route.$class.".php";

        include_once($file);
    }
?>