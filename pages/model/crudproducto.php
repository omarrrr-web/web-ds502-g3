<?php
  class CRUDProducto extends Conexion { 
        public function ListarProducto(){        
            $cn = $this->Conectar();
            $cad_sql = "call sp_listar_producto()";
            $snt = $cn->prepare($cad_sql);
            $snt -> execute();
            $arr_prod = $snt->fetchAll(PDO::FETCH_OBJ);
            $cn = null;

            return $arr_prod;
        }
        public function BuscarProductoPorCodigo($cod_prod){
            $arr_prod = null;
            $cn = $this->Conectar();
            $sql = "call sp_buscar_producto_por_codigo(:cod_prod)";
            $snt = $cn->prepare($sql);
            $snt->bindParam(":cod_prod",$cod_prod,PDO::PARAM_STR, 5);
            $snt->execute();
            $nr = $snt->rowCount();

            if ($nr>0){
                $arr_prod = $snt->fetch(PDO::FETCH_OBJ);
            }
            $cn = null;
            return $arr_prod;
        }
        public function RegistrarProducto(Producto $producto){
            try{
                $cn = $this->Conectar();
                $sql = "call sp_registrar_producto(:cod_prod,:prod,:stk,:cst,:gnc,:cod_mar,:cod_cat)";
                $snt = $cn->prepare($sql);

                $snt->bindParam(":cod_prod",$producto->codigo_producto);
                $snt->bindParam(":prod",$producto->producto);
                $snt->bindParam(":stk",$producto->stock);
                $snt->bindParam(":cst",$producto->costo);
                $snt->bindParam(":gnc",$producto->ganancia);
                $snt->bindParam(":cod_mar",$producto->producto_codigo_marca);
                $snt->bindParam(":cod_cat",$producto->producto_codigo_categoria);

                $snt->execute();

                $cn = null;
            }catch(PDOException $ex){
                die($ex->getMessage());
            }
        }
        public function EditarProducto(Producto $producto){
            try{
                $cn = $this->Conectar();
                $sql = "call sp_editar_producto(:cod_prod,:prod,:stk,:cst,:gnc,:cod_mar,:cod_cat)";
                $snt = $cn->prepare($sql);

                $snt->bindParam(":cod_prod",$producto->codigo_producto);
                $snt->bindParam(":prod",$producto->producto);
                $snt->bindParam(":stk",$producto->stock);
                $snt->bindParam(":cst",$producto->costo);
                $snt->bindParam(":gnc",$producto->ganancia);
                $snt->bindParam(":cod_mar",$producto->producto_codigo_marca);
                $snt->bindParam(":cod_cat",$producto->producto_codigo_categoria);

                $snt->execute();

                $cn = null;
            }catch(PDOException $ex){
                die($ex->getMessage());
            }
        }
        public function BorrarProducto($cod_prod){
            try{
                $cn = $this->Conectar();
                $sql = "call sp_borrar_producto(:cod_prod)";
                $snt = $cn->prepare($sql);
                $snt ->bindParam(":cod_prod",$cod_prod);
                $snt->execute();
                $cn=null;
            }catch(PDOException $ex){
                die($ex->getMessage());
            }
        }
    }