<?php
require_once "conexion.php";
class CRUDCategoria extends Conexion { 

    // --- R (Read) - Listar ---
    public function ListarCategoria() {
        $cn = $this->Conectar();
        $sql = "call sp_listar_categorias()"; // Tu SP
        $snt = $cn->prepare($sql);
        $snt->execute();
        $arr_cat = $snt->fetchAll(); 
        $cn = null;
        return $arr_cat;
    }

    // --- R (Read) - Buscar por ID ---
    public function BuscarCategoriaPorId($id_categoria) {
        $cn = $this->Conectar();
        $sql = "call sp_buscar_categoria_por_id(:id)"; // Tu SP
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id", $id_categoria);
        $snt->execute();
        $arr_cat = $snt->fetch(); 
        $cn = null;
        return $arr_cat;
    }
    
    // --- R (Read) - Consultar (para AJAX) ---
    public function ConsultarCategoriaPorId($id_categoria) {
        $data = $this->BuscarCategoriaPorId($id_categoria);
        // Devuelve el resultado directamente en formato JSON
        echo json_encode($data);
    }

    // --- C (Create) - Registrar ---
    public function RegistrarCategoria(Categoria $categoria) {
        $cn = $this->Conectar();
        $sql = "call sp_registrar_categoria(:nombre)"; // Tu SP
        $snt = $cn->prepare($sql);
        $snt->bindParam(":nombre", $categoria->nombre_categoria);
        $snt->execute();
        $cn = null;
    }
    
    // --- U (Update) - Editar ---
    public function EditarCategoria(Categoria $categoria) {
        $cn = $this->Conectar();
        $sql = "call sp_editar_categorias_activo(:id, :nombre)"; // Tu SP
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id", $categoria->id_categoria);
        $snt->bindParam(":nombre", $categoria->nombre_categoria);
        $snt->execute();
        $cn = null;
    }

    // --- D (Delete) - Borrar ---
    public function BorrarCategoria($id_categoria) {
        $cn = $this->Conectar();
        $sql = "call sp_borrar_categoria(:id)"; // Tu SP
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id", $id_categoria);
        $snt->execute();
        $cn = null;
    }

    // --- R (Read) - Filtrar (para AJAX) ---
    public function FiltrarCategoria($nombre_categoria) {
        $cn = $this->Conectar();
        $sql = "call sp_filtrar_categorias_por_nombre(:nombre)"; // Tu SP
        $snt = $cn->prepare($sql);
        $snt->bindParam(":nombre", $nombre_categoria, PDO::PARAM_STR, 100); 
        $snt->execute();
        $arr_cat = $snt->fetchAll();

        // Generar la tabla HTML para devolver en la respuesta AJAX
        $html = '';
        if (count($arr_cat) > 0) {
            $html .= '<table class="table table-hover table-sm table-success table-striped">';
            $html .= '<tr class="table-primary"><th>N°</th><th>ID Categoría</th><th>Nombre Categoría</th><th colspan="2">Acciones</th></tr>';
            $i = 0;
            foreach ($arr_cat as $cat) {
                $i++;
                $html .= '<tr>';
                $html .= '<td>' . $i . '</td>';
                $html .= '<td>' . $cat->id_categoria . '</td>';
                $html .= '<td>' . $cat->nombre_categoria . '</td>';
                // Usar las data attributes para los botones (para JS)
                $html .= '<td><a href="editar_categoria.php?idcat=' . $cat->id_categoria . '" class="btn_editar btn btn-outline-success"><i class="fas fa-pen-square"></i></a></td>';
                $html .= '<td><a href="#" data-bs-toggle="modal" data-bs-target="#md_borrar_cat" data-id="' . $cat->id_categoria . '" data-nombre="' . $cat->nombre_categoria . '" class="btn_borrar btn btn-outline-danger"><i class="fas fa-trash-alt"></i></a></td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
        } else {
            $html = '<div class="alert alert-danger alert-dismissible fade show" role="alert">No existen registros.</div>';
        }
        
        echo $html;
        $cn = null;
    }
}
?>