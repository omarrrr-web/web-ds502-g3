<?php

class CRUDRol extends Conexion {
    public function ListarRoles() {
        $data = null;
        $cn = $this->Conectar();
        $sql = "CALL sp_listar_roles()";
        $snt = $cn->prepare($sql);
        $snt->execute();
        $data = $snt->fetchAll(PDO::FETCH_OBJ);
        $cn = null;
        return $data;
    }

    public function BuscarRolPorId($id) {
        $data = null;
        $cn = $this->Conectar();
        $sql = "CALL sp_buscar_rol_por_id(:id)";
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id", $id, PDO::PARAM_INT);
        $snt->execute();
        if ($snt->rowCount() > 0) {
            $data = $snt->fetch(PDO::FETCH_OBJ);
        }
        $cn = null;
        return $data;
    }

    public function RegistrarRol(Rol $rol) {
        $cn = $this->Conectar();
        $sql = "CALL sp_registrar_rol(:nombre)";
        $snt = $cn->prepare($sql);
        $snt->bindParam(":nombre", $rol->getNombre_rol(), PDO::PARAM_STR);
        $res = $snt->execute();
        $cn = null;
        return $res;
    }

    public function EditarRol(Rol $rol) {
        $cn = $this->Conectar();
        $sql = "CALL sp_editar_rol(:id, :nombre)";
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id", $rol->getId_rol(), PDO::PARAM_INT);
        $snt->bindParam(":nombre", $rol->getNombre_rol(), PDO::PARAM_STR);
        $res = $snt->execute();
        $cn = null;
        return $res;
    }

    public function EliminarRol($id) {
        $cn = $this->Conectar();
        $sql = "CALL sp_eliminar_rol(:id)";
        $snt = $cn->prepare($sql);
        $snt->bindParam(":id", $id, PDO::PARAM_INT);
        $res = $snt->execute();
        $cn = null;
        return $res;
    }

    public function FiltrarRoles($termino) {
        $data = null;
        $cn = $this->Conectar();
        $sql = "CALL sp_filtrar_roles(:termino)";
        $snt = $cn->prepare($sql);
        $snt->bindParam(":termino", $termino, PDO::PARAM_STR);
        $snt->execute();
        $data = $snt->fetchAll(PDO::FETCH_OBJ);
        $cn = null;
        return $data;
    }
}
?>