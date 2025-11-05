<?php
  class CRUDEmpleado extends Conexion {
        public function ListarEmpleados(){        
            $cn = $this->Conectar();
            $cad_sql = "call sp_listar_empleados()";
            $snt = $cn->prepare($cad_sql);
            $snt -> execute();
            $arr_empleados = $snt->fetchAll(PDO::FETCH_OBJ);
            $cn = null;

            return $arr_empleados;
        }

        public function BuscarEmpleadoPorId($id_empleado){
            $arr_emp = null;
            $cn = $this->Conectar();
            $sql = "call sp_buscar_empleado_por_id(:id_empleado)";
            $snt = $cn->prepare($sql);
            $snt->bindParam(":id_empleado", $id_empleado, PDO::PARAM_INT);
            $snt->execute();
            $nr = $snt->rowCount();

            if ($nr > 0){
                $arr_emp = $snt->fetch(PDO::FETCH_OBJ);
            }
            $cn = null;
            return $arr_emp;
        }

        public function ListarRoles(){
            $cn = $this->Conectar();
            $cad_sql = "call sp_listar_roles()";
            $snt = $cn->prepare($cad_sql);
            $snt->execute();
            $arr_roles = $snt->fetchAll(PDO::FETCH_OBJ);
            $cn = null;
            return $arr_roles;
        }

        public function RegistrarEmpleado($nombre, $apellido, $email, $password, $id_rol){
            try{
                $cn = $this->Conectar();
                $sql = "call sp_registrar_empleado(:nombre, :apellido, :email, :password, :id_rol)";
                $snt = $cn->prepare($sql);
                $snt->bindParam(":nombre", $nombre);
                $snt->bindParam(":apellido", $apellido);
                $snt->bindParam(":email", $email);
                $snt->bindParam(":password", $password);
                $snt->bindParam(":id_rol", $id_rol, PDO::PARAM_INT);
                $snt->execute();
                $cn = null;
            } catch(PDOException $ex){
                die($ex->getMessage());
            }
        }

        public function EditarEmpleado($id_empleado, $nombre, $apellido, $email, $id_rol){
            try{
                $cn = $this->Conectar();
                // El SP de editar no modifica el estado `activo`, por lo que se pasa como 1 (o se podría añadir al SP)
                $sql = "call sp_editar_empleado(:id_empleado, :nombre, :apellido, :email, 1, :id_rol)";
                $snt = $cn->prepare($sql);
                $snt->bindParam(":id_empleado", $id_empleado, PDO::PARAM_INT);
                $snt->bindParam(":nombre", $nombre);
                $snt->bindParam(":apellido", $apellido);
                $snt->bindParam(":email", $email);
                $snt->bindParam(":id_rol", $id_rol, PDO::PARAM_INT);
                $snt->execute();
                $cn = null;
            } catch(PDOException $ex){
                die($ex->getMessage());
            }
        }

        public function DesactivarEmpleado($id_empleado){
            try{
                $cn = $this->Conectar();
                $sql = "call sp_desactivar_empleado(:id_empleado)";
                $snt = $cn->prepare($sql);
                $snt->bindParam(":id_empleado", $id_empleado, PDO::PARAM_INT);
                $snt->execute();
                $cn = null;
            } catch(PDOException $ex){
                die($ex->getMessage());
            }
        }

        public function ListarEmpleadosInactivos(){
            $cn = $this->Conectar();
            $cad_sql = "call sp_listar_empleados_inactivos()";
            $snt = $cn->prepare($cad_sql);
            $snt->execute();
            $arr_empleados = $snt->fetchAll(PDO::FETCH_OBJ);
            $cn = null;
            return $arr_empleados;
        }

        public function ActivarEmpleado($id_empleado){
            try{
                $cn = $this->Conectar();
                $sql = "call sp_activar_empleado(:id_empleado)";
                $snt = $cn->prepare($sql);
                $snt->bindParam(":id_empleado", $id_empleado, PDO::PARAM_INT);
                $snt->execute();
                $cn = null;
            } catch(PDOException $ex){
                die($ex->getMessage());
            }
        }

        public function FiltrarEmpleados($termino){
            $cn = $this->Conectar();
            $cad_sql = "call sp_filtrar_empleados(:termino)";
            $snt = $cn->prepare($cad_sql);
            $snt->bindParam(":termino", $termino, PDO::PARAM_STR);
            $snt->execute();
            $arr_empleados = $snt->fetchAll(PDO::FETCH_OBJ);
            $cn = null;
            return $arr_empleados;
        }
        
    }
?>