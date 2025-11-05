<?php

require_once 'BaseController.php';

class ActivoController extends BaseController {
    public function __construct($pdo) {
        parent::__construct($pdo, 'activos', 'id_activo');
    }

}
