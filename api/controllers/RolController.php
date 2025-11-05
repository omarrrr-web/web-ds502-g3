<?php

require_once 'BaseController.php';

class RolController extends BaseController {
    public function __construct($pdo) {
        parent::__construct($pdo, 'roles', 'id_rol');
    }

    // No se necesita anadir nada mas, ya que Rol usa el CRUD generico.
}
