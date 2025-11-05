<?php
    $route = "../../../";
    include("../../template/loadclass.php");

    // Lógica para determinar el modo (Registro o Edición)
    $is_edit_mode = isset($_GET["id"]) && is_numeric($_GET["id"]);
    $empleado_data = null;
    $roles_empleado = [];

    $crud = new CRUDEmpleado();

    if ($is_edit_mode) {
        $title = "Editar Empleado";
        $id_empleado = $_GET["id"];
        $empleado_data = $crud->BuscarEmpleadoPorId($id_empleado);
        if (!$empleado_data) {
            die("Empleado no encontrado.");
        }
        $roles_empleado = $empleado_data->id_rol;
        $form_action = "../../controller/ctd_editar_empleado.php";
    } else {
        $title = "Registrar Empleado";
        $form_action = "../../controller/ctd_registrar_empleado.php";
    }

    // Cargar todos los roles para el dropdown
    $roles = $crud->ListarRoles();
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <?php include("../../template/header.php"); ?>
        <body>
        <?php include("../../template/menubar.php"); ?>
        
        <div class="container mt-3 mb-5">
            <header class="mb-4">
                <h1><i class="fas <?= $is_edit_mode ? 'fa-user-edit' : 'fa-user-plus' ?> me-2"></i> <?= $title ?></h1>
            </header>
        
            <div class="row justify-content-center">
                <div class="col-md-8 pb-5">
                    <form id="form-empleado" method="POST" action="<?= $form_action ?>">
                        <?php if ($is_edit_mode): ?>
                            <input type="hidden" name="id_empleado" value="<?= $empleado_data->id_empleado 
        ?>">
                        <?php endif; ?>
        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $is_edit_mode ? $empleado_data->nombre : '' ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido:</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $is_edit_mode ? $empleado_data->apellido : '' ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $is_edit_mode ? $empleado_data->email : '' ?>" required>
                        </div>
                        
                        <?php if (!$is_edit_mode): ?>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <?php endif; ?>
        
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol:</label>
                            <select class="form-select" id="rol" name="id_rol" required>
                                <option value="">Seleccione un rol...</option>
                                <?php foreach ($roles as $rol): ?>
                                    <option value="<?= $rol->id_rol ?>" <?= ($is_edit_mode && $rol->id_rol == $roles_empleado) ? 'selected' : '' ?>>
                                        <?= $rol->nombre_rol ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success" name="<?= $is_edit_mode ? 'btn_editar' : 'btn_registrar' ?>"><i class="fas fa-save me-2"></i> Guardar</button>
                    <a href="listar.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i> Regresar</a>
                </div>
            </form>
<?php include("../../template/footer.php"); ?>
</body>
</html>
