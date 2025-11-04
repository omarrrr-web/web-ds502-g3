<?php
// Incluye explícitamente la clase padre (soluciona el error de "Class not found")
require_once "conexion.php"; 
// El autoloader debe encargarse de incluir activo.php, 
// pero se incluye la clase para referencia
require_once "activos.php"; 

class CRUDActivos extends Conexion { 

    // --- R (Read) - Listar ---
    public function ListarActivos() {
        $cn = $this->Conectar();
        $sql = "call sp_listar_activos()"; // SP de Listar Activos
        $snt = $cn->prepare($sql);
        $snt->execute();
        $arr_activos = $snt->fetchAll(); // Cambiamos $arr_cat a $arr_activos
        $cn = null;
        return $arr_activos;
    }

    // --- R (Read) - Buscar por ID / Consultar ---
    public function BuscarActivoPorId($id_activo) {
        $cn = $this->Conectar();
        $sql = "call sp_buscar_activo_por_id(:id)"; // SP de Buscar Activo por ID
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id", $id_activo);
        $snt->execute();
        $activo = $snt->fetch(); // Cambiamos $arr_cat a $activo (singular)
        $cn = null;
        return $activo;
    }
    
    public function ConsultarActivoPorId($id_activo) {
        $data = $this->BuscarActivoPorId($id_activo);
        // Devuelve el resultado directamente en formato JSON
        echo json_encode($data);
    }

    // --- C (Create) - Registrar ---
    // Usamos la clase Activo como parámetro
    public function RegistrarActivo(Activo $activo) { 
        $cn = $this->Conectar();
        // Usamos el SP de Registrar Activo, que tiene 7 parámetros
        $sql = "call sp_registrar_activo(:id_cat, :serial, :marca, :modelo, :fecha, :precio, :estado)"; 
        $snt = $cn->prepare($sql);
        
        // Bind de parámetros con los atributos de la clase Activo
        $snt->bindParam(":id_cat", $activo->id_categoria);
        $snt->bindParam(":serial", $activo->serial_number);
        $snt->bindParam(":marca", $activo->marca);
        $snt->bindParam(":modelo", $activo->modelo);
        $snt->bindParam(":fecha", $activo->fecha_compra);
        $snt->bindParam(":precio", $activo->precio);
        $snt->bindParam(":estado", $activo->estado);
        
        $snt->execute();
        $cn = null;
    }
    
    // --- U (Update) - Editar ---
    // Usamos la clase Activo como parámetro
    public function EditarActivo(Activo $activo) { 
        $cn = $this->Conectar();
        // Usamos el SP de Editar Activo, que tiene 8 parámetros (incluyendo el ID)
        $sql = "call sp_editar_activo(:id_act, :id_cat, :serial, :marca, :modelo, :fecha, :precio, :estado)"; 
        $snt = $cn->prepare($sql);
        
        // Bind de parámetros con los atributos de la clase Activo
        $snt->bindParam(":id_act", $activo->id_activo);
        $snt->bindParam(":id_cat", $activo->id_categoria);
        $snt->bindParam(":serial", $activo->serial_number);
        $snt->bindParam(":marca", $activo->marca);
        $snt->bindParam(":modelo", $activo->modelo);
        $snt->bindParam(":fecha", $activo->fecha_compra);
        $snt->bindParam(":precio", $activo->precio);
        $snt->bindParam(":estado", $activo->estado);
        
        $snt->execute();
        $cn = null;
    }

    // --- D (Delete) - Borrar ---
    public function BorrarActivo($id_activo) {
        $cn = $this->Conectar();
    
        // Primero, eliminar las asignaciones asociadas al activo
        $sql_delete_asignaciones = "DELETE FROM asignaciones WHERE id_activo = :id";
        $snt_delete_asignaciones = $cn->prepare($sql_delete_asignaciones);
        $snt_delete_asignaciones->bindParam(":id", $id_activo);
        $snt_delete_asignaciones->execute();

        // Segundo, eliminar los registros de mantenimiento asociados al activo
        $sql_delete_mantenimiento = "DELETE FROM registros_mantenimiento WHERE id_activo = :id";
        $snt_delete_mantenimiento = $cn->prepare($sql_delete_mantenimiento);
        $snt_delete_mantenimiento->bindParam(":id", $id_activo);
        $snt_delete_mantenimiento->execute();
    
        // Luego, proceder a borrar el activo
        $sql_borrar_activo = "call sp_borrar_activo(:id)"; // SP de Borrar Activo
        $snt_borrar_activo = $cn->prepare($sql_borrar_activo);
        $snt_borrar_activo->bindParam(":id", $id_activo);
        $snt_borrar_activo->execute();
    
        $cn = null;
    }

    // --- R (Read) - Filtrar (para AJAX) ---
    public function FiltrarActivos($valor) {
        $cn = $this->Conectar();
        $sql = "call sp_filtrar_activos(:valor)"; // SP de Filtrar Activos
        $snt = $cn->prepare($sql);
        $snt->bindParam(":valor", $valor, PDO::PARAM_STR, 100); 
        $snt->execute();
        $arr_activos = $snt->fetchAll();
        $cn = null;

        // Generación de la tabla HTML para devolver en la respuesta AJAX
        $html = '';
        if (count($arr_activos) > 0) {
            $html .= '<table class="table table-hover table-sm table-warning table-striped">';
            $html .= '<tr class="table-dark"><th>N°</th><th>ID</th><th>Categoría</th><th>Serial</th><th>Marca</th><th>Modelo</th><th>Estado</th><th colspan="2">Acciones</th></tr>';
            $i = 0;
            foreach ($arr_activos as $act) {
                $i++;
                $html .= '<tr class="reg_activo">';
                $html .= '<td>' . $i . '</td>';
                $html .= '<td class="codact">' . $act->id_activo . '</td>';
                $html .= '<td>' . $act->nombre_categoria . '</td>'; // Muestra el nombre de la categoría
                $html .= '<td class="serialact">' . $act->serial_number . '</td>';
                $html .= '<td>' . $act->marca . '</td>';
                $html .= '<td>' . $act->modelo . '</td>';
                $html .= '<td>' . $act->estado . '</td>';
                
                // Botones de acción (deberás crear las vistas correspondientes)
                $html .= '<td><a href="editar_activo.php?idact=' . $act->id_activo . '" class="btn_editar btn btn-outline-success btn-sm"><i class="fas fa-pen-square"></i></a></td>';
                $html .= '<td><a href="#" data-bs-toggle="modal" data-bs-target="#md_borrar_act" data-id="' . $act->id_activo . '" data-serial="' . $act->serial_number . '" class="btn_borrar btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
        } else {
            $html = '<div class="alert alert-danger alert-dismissible fade show" role="alert">No existen activos que coincidan con el filtro.</div>';
        }
        
        echo $html;
    }
}
?>