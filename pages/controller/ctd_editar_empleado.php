<?php
    include "../template/loadclass.php";

    if(isset($_POST["btn_editar"])){
        $id_empleado = $_POST["id_empleado"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $email = $_POST["email"];
        
        $id_rol = $_POST["id_rol"];

        $crud = new CRUDEmpleado();
        $crud->EditarEmpleado($id_empleado, $nombre, $apellido, $email, $id_rol);

        // Redirigir de vuelta a la lista con un parámetro de éxito
        header("location: ../view/empleado/listar.php?edicion=exito");
    }
?>