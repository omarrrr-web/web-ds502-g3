<?php
class Activo {
    public $id_activo;
    public $id_categoria;
    public $serial_number;
    public $marca;
    public $modelo;
    public $fecha_compra;
    public $precio;
    public $estado; // ENUM('En uso', 'Almacenado', 'Mantenimiento', 'Baja')
}
?>