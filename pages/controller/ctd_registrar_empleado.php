<?php
    include "../template/loadclass.php";

    if(isset($_POST["btn_registrar"])){
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $email = $_POST["email"];
        $password = $_POST["password"]; // La contraseña se guarda en texto plano, se recomienda hashear.
        $id_rol = $_POST["id_rol"];

        $crud = new CRUDEmpleado();
        $crud->RegistrarEmpleado($nombre, $apellido, $email, $password, $id_rol);

        // Redirigir de vuelta a la lista con un parámetro de éxito
        header("location: ../view/empleado/listar.php?registro=exito");
    }
?>