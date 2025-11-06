<?php
require_once "conexion.php";
require_once "registros_mantenimiento.php";

class CRUDRegistrosMantenimiento extends Conexion {

    // --- R (Read) - Listar ---
    public function ListarMantenimientos() {
        $cn = $this->Conectar();
        $sql = "CALL sp_listar_mantenimientos()";
        $snt = $cn->prepare($sql);
        $snt->execute();
        $arr_mantenimientos = $snt->fetchAll(PDO::FETCH_OBJ);
        $cn = null;
        return $arr_mantenimientos;
    }

    // --- R (Read) - Buscar por ID ---
    public function BuscarMantenimientoPorId($id_mantenimiento) {
        $cn = $this->Conectar();
        $sql = "CALL sp_buscar_mantenimiento_por_id(:id)";
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id", $id_mantenimiento, PDO::PARAM_INT);
        $snt->execute();
        $mantenimiento = $snt->fetch(PDO::FETCH_OBJ);
        $cn = null;
        return $mantenimiento;
    }

    // --- C (Create) - Registrar ---
    public function RegistrarMantenimiento(RegistroMantenimiento $mantenimiento) {
        $cn = $this->Conectar();
        $sql = "CALL sp_registrar_mantenimiento(:id_activo, :fecha_servicio, :descripcion, :costo, :realizado_por)";
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id_activo", $mantenimiento->id_activo, PDO::PARAM_INT);
        $snt->bindParam(":fecha_servicio", $mantenimiento->fecha_servicio);
        $snt->bindParam(":descripcion", $mantenimiento->descripcion, PDO::PARAM_STR);
        $snt->bindParam(":costo", $mantenimiento->costo);
        $snt->bindParam(":realizado_por", $mantenimiento->realizado_por, PDO::PARAM_INT);
        $snt->execute();
        $cn = null;
    }

    // --- U (Update) - Editar ---
    public function EditarMantenimiento(RegistroMantenimiento $mantenimiento) {
        $cn = $this->Conectar();
        $sql = "CALL sp_editar_mantenimiento(:id_mantenimiento, :id_activo, :fecha_servicio, :descripcion, :costo, :realizado_por)";
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id_mantenimiento", $mantenimiento->id_mantenimiento, PDO::PARAM_INT);
        $snt->bindParam(":id_activo", $mantenimiento->id_activo, PDO::PARAM_INT);
        $snt->bindParam(":fecha_servicio", $mantenimiento->fecha_servicio);
        $snt->bindParam(":descripcion", $mantenimiento->descripcion, PDO::PARAM_STR);
        $snt->bindParam(":costo", $mantenimiento->costo);
        $snt->bindParam(":realizado_por", $mantenimiento->realizado_por, PDO::PARAM_INT);
        $snt->execute();
        $cn = null;
    }

    // --- D (Delete) - Borrar ---
    public function BorrarMantenimiento($id_mantenimiento) {
        $cn = $this->Conectar();
        $sql = "CALL sp_borrar_mantenimiento(:id)";
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id", $id_mantenimiento, PDO::PARAM_INT);
        $snt->execute();
        $cn = null;
    }

    // --- R (Read) - Filtrar (para AJAX) ---
    public function FiltrarMantenimientos($valor) {
        $cn = $this->Conectar();
        $sql = "CALL sp_filtrar_mantenimientos(:valor)";
        $snt = $cn->prepare($sql);
        $snt->bindValue(":valor", $valor);
        $snt->execute();
        $resultados = $snt->fetchAll(PDO::FETCH_OBJ);
        $cn = null;

        $html = '';
        if (count($resultados) > 0) {
            $html .= '<table class="table table-hover table-sm table-striped">';
            $html .= '<thead class="table-dark"><tr><th>#</th><th>Activo</th><th>Serial</th><th>Fecha Servicio</th><th>Descripción</th><th>Costo</th><th>Realizado Por</th><th colspan="3">Acciones</th></tr></thead><tbody>';

            $i = 1;
            foreach ($resultados as $mant) {
                $html .= "<tr>";
                $html .= "<td>" . $i . "</td>";
                $html .= "<td>" . $mant->activo_nombre . "</td>";
                $html .= "<td>" . $mant->serial_number . "</td>";
                $html .= "<td>" . $mant->fecha_servicio . "</td>";
                $html .= "<td>" . substr($mant->descripcion, 0, 50) . (strlen($mant->descripcion) > 50 ? '...' : '') . "</td>";
                $html .= "<td>S/ " . number_format($mant->costo, 2) . "</td>";
                $html .= "<td>" . $mant->empleado_nombre . "</td>";
                
                // Botones de acción
                $html .= '<td><a href="mostrar_mantenimiento.php?idmant=' . $mant->id_mantenimiento . '" class="btn btn-outline-info btn-sm" title="Ver"><i class="fas fa-eye"></i></a></td>';
                $html .= '<td><a href="editar_mantenimiento.php?idmant=' . $mant->id_mantenimiento . '" class="btn btn-outline-success btn-sm" title="Editar"><i class="fas fa-pen-square"></i></a></td>';
                $html .= '<td><a href="#" data-bs-toggle="modal" data-bs-target="#md_borrar_mant" data-id="' . $mant->id_mantenimiento . '" class="btn_borrar btn btn-outline-danger btn-sm" title="Borrar"><i class="fas fa-trash-alt"></i></a></td>';
                
                $html .= "</tr>";
                $i++;
            }

            $html .= '</tbody></table>';
        } else {
            $html = '<p class="alert alert-info">No se encontraron registros de mantenimiento que coincidan con los criterios.</p>';
        }
        
        echo $html;
    }
}
?>
