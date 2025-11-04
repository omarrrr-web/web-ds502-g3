<?php
  class CRUDProveedor extends Conexion { 
        public function ListarProveedor(){
            $arr_prov = null;          
            $cn = $this->Conectar();
            $cad_sql = "select * from tb_proveedor";
            $snt = $cn->prepare($cad_sql);
            $snt -> execute();
            $arr_prov = $snt->fetchAll(PDO::FETCH_OBJ);
            $cn = null;

            return $arr_prov;
        }
    }