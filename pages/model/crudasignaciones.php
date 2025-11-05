<?php
require_once "conexion.php";

class CRUDAsignaciones extends Conexion {

    // --- R (Read) - Listar ---
    public function ListarAsignaciones() {
        $cn = $this->Conectar();
        $sql = "CALL sp_listar_asignaciones()"; // Tu procedimiento almacenado
        $snt = $cn->prepare($sql);
        $snt->execute();
        $arr_asig = $snt->fetchAll(PDO::FETCH_OBJ);
        $cn = null;
        return $arr_asig;
    }

    // --- R (Read) - Buscar por ID ---
    public function BuscarAsignacionesPorId($id_asignacion) {
        $cn = $this->Conectar();
        $sql = "CALL sp_buscar_asignacion_por_id(:id)"; // Tu SP para buscar
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id", $id_asignacion, PDO::PARAM_INT);
        $snt->execute();
        $asignacion = $snt->fetch(PDO::FETCH_OBJ);
        $cn = null;
        return $asignacion;
    }

    // --- C (Create) - Registrar ---
    public function RegistrarAsignacion(Asignacion $asignacion) {
        $cn = $this->Conectar();
        $sql = "CALL sp_registrar_asignacion(:id_empleado, :id_activo, :fecha_devolucion, :notas)";
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id_empleado", $asignacion->id_empleado, PDO::PARAM_INT);
        $snt->bindParam(":id_activo", $asignacion->id_activo, PDO::PARAM_INT);
        $snt->bindParam(":fecha_devolucion", $asignacion->fecha_devolucion);
        $snt->bindParam(":notas", $asignacion->notas, PDO::PARAM_STR);
        $snt->execute();
        $cn = null;
    }

    // --- U (Update) - Editar ---
    public function EditarAsignacion(Asignacion $asignacion) {
        $cn = $this->Conectar();
        $sql = "CALL sp_editar_asignacion(:id_asignacion, :id_empleado, :id_activo, :fecha_asignacion, :fecha_devolucion, :notas)";
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id_asignacion", $asignacion->id_asignacion, PDO::PARAM_INT);
        $snt->bindParam(":id_empleado", $asignacion->id_empleado, PDO::PARAM_INT);
        $snt->bindParam(":id_activo", $asignacion->id_activo, PDO::PARAM_INT);
        $snt->bindParam(":fecha_asignacion", $asignacion->fecha_asignacion);
        $snt->bindParam(":fecha_devolucion", $asignacion->fecha_devolucion);
        $snt->bindParam(":notas", $asignacion->notas, PDO::PARAM_STR);
        $snt->execute();
        $cn = null;
    }
    // --- D (Delete) - Borrar ---
    public function BorrarAsignacion($id_asignacion) {
        $cn = $this->Conectar();
        $sql = "CALL sp_borrar_asignacion(:id)";
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id", $id_asignacion, PDO::PARAM_INT);
        $snt->execute();
        $cn = null;
    }

     public function FiltrarAsignaciones($valor) {
        $cn = $this->Conectar();
        $sql = "CALL sp_filtrar_asignaciones(:valor)";
        $snt = $cn->prepare($sql);
        $snt->bindValue(":valor", $valor);
        $snt->execute();
        $resultados = $snt->fetchAll(PDO::FETCH_OBJ);
        $cn = null;

        if (count($resultados) > 0) {
            echo '<table class="table table-hover table-sm table-striped">';
            echo '<thead class="table-dark"><tr><th>#</th><th>Empleado</th><th>Activo (Serial)</th><th>Fecha Devolución</th><th>Notas</th><th>Acciones</th></tr></thead><tbody>';

            $i = 1;
            foreach ($resultados as $asignacion) {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $asignacion->empleado_nombre . "</td>";
                echo "<td>" . $asignacion->activo_nombre . "</td>";
                echo "<td>" . ($asignacion->fecha_devolucion ? $asignacion->fecha_devolucion : "-") . "</td>";
                echo "<td>" . $asignacion->notas . "</td>";
                echo "<td><a href='editar_asignacion.php?idasig=" . $asignacion->id_asignacion . "' class='btn btn-outline-success btn-sm'>Editar</a></td>";
                echo "</tr>";
                $i++;
            }

            echo '</tbody></table>';
        } else {
            echo '<p class="alert alert-info">No se encontraron asignaciones que coincidan con los criterios.</p>';
        }
    }
}
?>