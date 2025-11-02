<?php
    include "../template/loadclass.php";

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

    // --- INICIO DE LA LÓGICA UNIFICADA PARA GENERAR LA TABLA ---
    $tabla_html = "<table class='table table-striped table-bordered table-hover'>";
    $tabla_html .= "<thead class='table-dark'>";
    $tabla_html .= "<tr>";
    $tabla_html .= "<th>ID</th>";
    $tabla_html .= "<th>Nombre</th>";
    $tabla_html .= "<th>Apellido</th>";
    $tabla_html .= "<th>Email</th>";
    $tabla_html .= "<th>Rol</th>";
    $tabla_html .= "<th class='text-center'>Acciones</th>";
    $tabla_html .= "</tr>";
    $tabla_html .= "</thead>";
    $tabla_html .= "<tbody>";

    if (!empty($empleados)) {
        foreach ($empleados as $emp) {
            $tabla_html .= "<tr>";
            $tabla_html .= "<td>{$emp->id_empleado}</td>";
            $tabla_html .= "<td>{$emp->nombre}</td>";
            $tabla_html .= "<td>{$emp->apellido}</td>";
            $tabla_html .= "<td>{$emp->email}</td>";
            $tabla_html .= "<td>{$emp->roles}</td>";
            $tabla_html .= "<td class='text-center'><div class='btn-group'>";
            $tabla_html .= "<button type='button' class='btn btn-info btn-sm btn-mostrar' data-id='{$emp->id_empleado}'><i class='fas fa-eye'></i> Mostrar</button>";
            $tabla_html .= "<a href='form_empleado.php?id={$emp->id_empleado}' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i> Editar</a>";
            
            if ($emp->activo) {
                $tabla_html .= "<button type='button' class='btn btn-danger btn-sm btn-desactivar' data-id='{$emp->id_empleado}'><i class='fas fa-trash'></i> Desactivar</button>";
            } else {
                $tabla_html .= "<button type='button' class='btn btn-success btn-sm btn-activar' data-id='{$emp->id_empleado}'><i class='fas fa-check-circle'></i> Activar</button>";
            }
            $tabla_html .= "</div></td>";
            $tabla_html .= "</tr>";
        }
    } else {
        $mensaje = ($accion === 'filtrar') ? "No se encontraron empleados con ese filtro." : "No hay empleados en esta lista.";
        $tabla_html .= "<tr><td colspan='6' class='text-center'>{$mensaje}</td></tr>";
    }

    $tabla_html .= "</tbody>";
    $tabla_html .= "</table>";

    echo $tabla_html;
    
?>