<?php
require_once "conexion.php"; 
require_once "licencia.php"; 

class CRUDLicencia extends Conexion { 

    // --- R (Read) - Listar ---
    public function ListarLicencias() {
        $cn = $this->Conectar();
        $sql = "call sp_listar_licencias()"; 
        $snt = $cn->prepare($sql);
        $snt->execute();
        $arr_licencias = $snt->fetchAll();
        $cn = null;
        return $arr_licencias;
    }

    // --- R (Read) - Buscar por ID / Consultar ---
    public function BuscarLicenciaPorId($id_licencia) {
        $cn = $this->Conectar();
        $sql = "call sp_buscar_licencia_por_id(:id)"; 
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id", $id_licencia);
        $snt->execute();
        $licencia = $snt->fetch(); 
        $cn = null;
        return $licencia;
    }
    
    public function ConsultarLicenciaPorId($id_licencia) {
        $data = $this->BuscarLicenciaPorId($id_licencia);
        echo json_encode($data);
    }

    // --- C (Create) - Registrar ---
    public function RegistrarLicencia(Licencia $licencia) { 
        $cn = $this->Conectar();
        $sql = "call sp_registrar_licencia(:id_cat, :nombre, :clave, :expira, :cantidad)"; 
        $snt = $cn->prepare($sql);
        
        $snt->bindParam(":id_cat", $licencia->id_categoria);
        $snt->bindParam(":nombre", $licencia->nombre_software);
        $snt->bindParam(":clave", $licencia->clave_licencia);
        $snt->bindParam(":expira", $licencia->fecha_expiracion);
        $snt->bindParam(":cantidad", $licencia->cantidad_usuarios);
        
        $snt->execute();
        $cn = null;
    }
    
    // --- U (Update) - Editar ---
    public function EditarLicencia(Licencia $licencia) { 
        $cn = $this->Conectar();
        $sql = "call sp_editar_licencia(:id_lic, :id_cat, :nombre, :clave, :expira, :cantidad)"; 
        $snt = $cn->prepare($sql);
        
        $snt->bindParam(":id_lic", $licencia->id_licencia);
        $snt->bindParam(":id_cat", $licencia->id_categoria);
        $snt->bindParam(":nombre", $licencia->nombre_software);
        $snt->bindParam(":clave", $licencia->clave_licencia);
        $snt->bindParam(":expira", $licencia->fecha_expiracion);
        $snt->bindParam(":cantidad", $licencia->cantidad_usuarios);
        
        $snt->execute();
        $cn = null;
    }

    // --- D (Delete) - Borrar ---
    public function BorrarLicencia($id_licencia) {
        $cn = $this->Conectar();
        $sql = "call sp_borrar_licencia(:id)"; 
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id", $id_licencia);
        $snt->execute();
        $cn = null;
    }

    // --- R (Read) - Filtrar (para AJAX) ---
    public function FiltrarLicencias($valor) {
        $cn = $this->Conectar();
        $sql = "call sp_filtrar_licencias(:valor)"; 
        $snt = $cn->prepare($sql);
        $snt->bindParam(":valor", $valor, PDO::PARAM_STR, 150); 
        $snt->execute();
        $arr_licencias = $snt->fetchAll();
        $cn = null;

        // Generación de la tabla HTML para devolver en la respuesta AJAX
        $html = '';
        if (count($arr_licencias) > 0) {
            $html .= '<table class="table table-hover table-sm table-info table-striped">';
            $html .= '<tr class="table-dark"><th>N°</th><th>Software</th><th>Clave</th><th>Usuarios</th><th>Expira</th><th>Categoría</th><th colspan="2">Acciones</th></tr>';
            $i = 0;
            foreach ($arr_licencias as $lic) {
                $i++;
                $html .= '<tr class="reg_licencia">';
                $html .= '<td class="codlic">' . $lic->id_licencia . '</td>';
                $html .= '<td>' . $lic->nombre_software . '</td>'; 
                $html .= '<td>' . $lic->clave_licencia . '</td>';
                $html .= '<td>' . $lic->cantidad_usuarios . '</td>';
                $html .= '<td>' . ($lic->fecha_expiracion ?? 'Permanente') . '</td>'; // Muestra "Permanente" si es NULL
                $html .= '<td>' . $lic->nombre_categoria . '</td>';
                
                // Botones de acción (deberás crear las vistas correspondientes)
                $html .= '<td><a href="editar_licencia.php?idlic=' . $lic->id_licencia . '" class="btn_editar btn btn-outline-success btn-sm"><i class="fas fa-pen-square"></i></a></td>';
                $html .= '<td><a href="#" data-bs-toggle="modal" data-bs-target="#md_borrar_lic" data-id="' . $lic->id_licencia . '" data-nombre="' . $lic->nombre_software . '" class="btn_borrar btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i></a></td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
        } else {
            $html = '<div class="alert alert-danger alert-dismissible fade show" role="alert">No existen licencias que coincidan con el filtro.</div>';
        }
        
        echo $html;
    }
}
?>