<?php
  class CRUDCategoria extends Conexion { 
        public function ListarCategoria(){
            $arr_cat = null;          
            $cn = $this->Conectar();
            $cad_sql = "select * from tb_categoria";
            $snt = $cn->prepare($cad_sql);
            $snt -> execute();
            $arr_cat = $snt->fetchAll(PDO::FETCH_OBJ);
            $cn = null;

            return $arr_cat;
        }
    }