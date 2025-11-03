<?php
    include("../template/loadclass.php");

    $crudempleado = new CRUDEmpleado();
    $empleados = [];
    $accion = $_POST['accion'] ?? 'listar_activos';

    switch ($accion) {
        case 'listar_inactivos':
            $empleados = $crudempleado->ListarEmpleadosInactivos();
            break;
        case 'filtrar':
            if (isset($_POST["termino_busqueda"]) && !empty($_POST["termino_busqueda"])) {
                $termino = $_POST["termino_busqueda"];
                $empleados = $crudempleado->FiltrarEmpleados($termino);
            }
            break;
        case 'listar_activos':
        default:
            $empleados = $crudempleado->ListarEmpleados();
            break;
    }

    // Incluimos la vista parcial que generará la tabla.
    // La vista espera que la variable $empleados esté definida.
    include("../view/empleado/_tabla_empleados.php");
?>