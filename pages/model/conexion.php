<?php
class Conexion {
    private $server = "localhost";
    private $db = "bd_GATI_ds502";
    private $user = "root";
    private $psw = "";

    public function Conectar() {
        try {
            $conexion = new PDO("mysql:host=$this->server;dbname=$this->db", $this->user, $this->psw);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conexion;

            //echo "BD conectada";
        } catch (PDOException $ex) {
            echo "Existen errores: " . $ex->getMessage();
            return null;
        }
    }
}
// Instancia a la conexión
// $cnx = new Conexion();
// $cnx->Conectar();
?>
