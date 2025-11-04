<?php
class Conexion {
    // Configuración de la nueva base de datos GATI
    private $user = "root"; 
    private $password = ""; 
    private $server = "localhost"; 
    private $bd = "bd_GATI_ds502"; 
    private $cn = null;

    public function Conectar() {
        try {
            // Cadena de conexión DSN
            $dsn = "mysql:host={$this->server};dbname={$this->bd};charset=utf8mb4";
            
            $this->cn = new PDO($dsn, $this->user, $this->password);
            
            // Configuración de atributos PDO
            $this->cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->cn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            
            return $this->cn;
        } catch (PDOException $e) {
            echo "Error de Conexión: " . $e->getMessage();
            return null;
        }
    }
}
?>