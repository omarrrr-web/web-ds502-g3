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
        $sql = "call sp_listar_activos_activos()"; // MODIFICADO: SP de Listar solo Activos Activos
        $snt = $cn->prepare($sql);
        $snt->execute();
        $arr_activos = $snt->fetchAll(PDO::FETCH_OBJ); // Cambiamos $arr_cat a $arr_activos
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


    public function DesactivarActivo($id_activo){
            try{
                $cn = $this->Conectar();
                $sql = "call sp_baja_activo(:id)";
                $snt = $cn->prepare($sql);
                $snt->bindParam(":id", $id_activo, PDO::PARAM_INT);
                $snt->execute();
                $cn = null;
            } catch(PDOException $ex){
                die($ex->getMessage());
            }
        }

    public function ActivarActivo($id_activo){
        try{
            $cn = $this->Conectar();
            $sql = "call sp_alta_activo(:id)";
            $snt = $cn->prepare($sql);
            $snt->bindParam(":id", $id_activo, PDO::PARAM_INT);
            $snt->execute();
            $cn = null;
        } catch(PDOException $ex){
            die($ex->getMessage());
        }
    }

    // --- D (Delete) - Borrar ---
    

    // --- R (Read) - Filtrar (para AJAX) ---
    public function FiltrarActivos($valor) {
        $cn = $this->Conectar();
        $sql = "call sp_filtrar_activos_activos(:valor)"; // MODIFICADO: Ahora solo filtra activos
        $snt = $cn->prepare($sql);
        $snt->bindParam(":valor", $valor, PDO::PARAM_STR, 100); 
        $snt->execute();
        $arr_activos = $snt->fetchAll();
        $cn = null;

        // Generación de la tabla HTML para devolver en la respuesta AJAX
        $html = '';
        if (count($arr_activos) > 0) {
            $html .= '<div class="table-responsive">';
            $html .= '<table class="table table-hover table-striped table-bordered">';
            $html .= '<thead class="table-dark"><tr><th class="text-center">N°</th><th class="text-center">ID</th><th>Categoría</th><th>Serial</th><th>Marca</th><th>Modelo</th><th>Estado</th><th class="text-center">Acciones</th></tr></thead>';
            $html .= '<tbody>';
            $i = 0;
            foreach ($arr_activos as $act) {
                $i++;
                $html .= '<tr class="reg_activo align-middle">';
                $html .= '<td class="text-center">' . $i . '</td>';
                $html .= '<td class="text-center codact">' . $act->id_activo . '</td>';
                $html .= '<td>' . ($act->nombre_categoria ?? 'Sin Categoría') . '</td>';
                $html .= '<td class="serialact">' . $act->serial_number . '</td>';
                $html .= '<td>' . $act->marca . '</td>';
                $html .= '<td>' . $act->modelo . '</td>';
                $html .= '<td><span class="badge bg-success">' . $act->estado . '</span></td>';
                
                // Botones de acción
                $html .= '<td class="text-center">';
                $html .= '<button class="btn btn-info btn-sm btn_mostrar" data-id="' . $act->id_activo . '" title="Mostrar"><i class="fas fa-eye"></i></button>';
                $html .= '<a href="#" class="btn btn-success btn-sm" title="Editar" data-bs-toggle="modal" data-bs-target="#md_editar_activo" data-idact="' . $act->id_activo . '"><i class="fas fa-pen-square"></i></a>';
                $html .= '<button type="button" data-id="' . $act->id_activo . '" class="btn btn-danger btn-sm btn-desactivar-activo" title="Desactivar"><i class="fas fa-trash-alt"></i></button>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            $html .= '</tbody></table></div>';
        } else {
            $html = '<div class="alert alert-info">No existen activos que coincidan con el filtro.</div>';
        }
        
        echo $html;
    }

    public function FiltrarActivosDesactivados($valor) {
        $cn = $this->Conectar();
        $sql = "call sp_filtrar_activos_desactivados(:valor)"; // SP para listar activos en baja
        $snt = $cn->prepare($sql);
        $snt->bindParam(":valor", $valor, PDO::PARAM_STR, 100); 
        $snt->execute();
        $arr_activos = $snt->fetchAll();
        $cn = null;

        // Generación de la tabla HTML
        $html = '';
        if (count($arr_activos) > 0) {
            $html .= '<div class="table-responsive">';
            $html .= '<table class="table table-hover table-striped table-bordered">';
            $html .= '<thead class="table-dark"><tr><th class="text-center">N°</th><th class="text-center">ID</th><th>Categoría</th><th>Serial</th><th>Marca</th><th>Modelo</th><th>Estado</th><th class="text-center">Acción</th></tr></thead>';
            $html .= '<tbody>';
            $i = 0;
            foreach ($arr_activos as $act) {
                $i++;
                $html .= '<tr class="reg_activo align-middle">';
                $html .= '<td class="text-center">' . $i . '</td>';
                $html .= '<td class="text-center codact">' . $act->id_activo . '</td>';
                $html .= '<td>' . ($act->nombre_categoria ?? 'Sin Categoría') . '</td>';
                $html .= '<td class="serialact">' . $act->serial_number . '</td>';
                $html .= '<td>' . $act->marca . '</td>';
                $html .= '<td>' . $act->modelo . '</td>';
                $html .= '<td><span class="badge bg-danger">' . $act->estado . '</span></td>';
                
                // Boton de reactivar
                $html .= '<td class="text-center"><button type="button" data-id="' . $act->id_activo . '" class="btn btn-success btn-sm btn-activar-activo"><i class="fas fa-check-circle me-1"></i> Reactivar</button></td>';
                $html .= '</tr>';
            }
            $html .= '</tbody></table></div>';
        } else {
            $html = '<div class="alert alert-info">No existen activos en baja que coincidan con el filtro.</div>';
        }
        
        echo $html;
    }
}
?>