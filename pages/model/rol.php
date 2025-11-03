<?php
class Rol {
    private $id_rol;
    private $nombre_rol;

    public function getId_rol() {
        return $this->id_rol;
    }

    public function setId_rol($id) {
        $this->id_rol = $id;
    }

    public function getNombre_rol() {
        return $this->nombre_rol;
    }

    public function setNombre_rol($nombre) {
        $this->nombre_rol = $nombre;
    }
}
?>