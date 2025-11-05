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
        $sql = "CALL sp_editar_asignacion(:id_asignacion, :id_empleado, :id_activo, :fecha_devolucion, :notas)";
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id_asignacion", $asignacion->id_asignacion, PDO::PARAM_INT);
        $snt->bindParam(":id_empleado", $asignacion->id_empleado, PDO::PARAM_INT);
        $snt->bindParam(":id_activo", $asignacion->id_activo, PDO::PARAM_INT);
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
        // Establece la conexión con la base de datos
        $conexion = Conexion::Conectar();

        // Consulta para buscar asignaciones por el nombre del empleado o ID del activo
        $sql = "SELECT a.id_asignacion, a.id_activo, a.id_empleado, a.fecha_asignacion, a.fecha_devolucion, a.notas, 
                       e.nombre AS nombre_empleado, e.apellido AS apellido_empleado 
                FROM asignaciones a
                JOIN empleados e ON a.id_empleado = e.id_empleado
                WHERE e.nombre LIKE :valor OR e.apellido LIKE :valor OR a.id_activo LIKE :valor";

        // Prepara la consulta
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(":valor", "%" . $valor . "%");

        // Ejecuta la consulta
        $stmt->execute();

        // Verifica si hay resultados
        if ($stmt->rowCount() > 0) {
            // Muestra los resultados
            echo '<table class="table table-hover table-sm table-striped">';
            echo '<thead class="table-dark"><tr><th>#</th><th>Empleado</th><th>Fecha Asignación</th><th>Fecha Devolución</th><th>Notas</th><th>Acciones</th></tr></thead><tbody>';

            // Itera sobre los resultados y muestra en la tabla
            $i = 1;
            while ($asignacion = $stmt->fetch(PDO::FETCH_OBJ)) {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $asignacion->nombre_empleado . " " . $asignacion->apellido_empleado . "</td>";
                echo "<td>" . $asignacion->fecha_asignacion . "</td>";
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
