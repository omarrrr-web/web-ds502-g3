<?php
  class CRUDMarca extends Conexion { 

    public function ListarMarca(){
            $arr_mar = null;          
            $cn = $this->Conectar();
            $cad_sql = "select * from tb_marca";
            $snt = $cn->prepare($cad_sql);
            $snt -> execute();
            $arr_mar = $snt->fetchAll(PDO::FETCH_OBJ);
            $cn = null;

            return $arr_mar;
        }
    }