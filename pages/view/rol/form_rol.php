<?php
    $route = "../../../";
    include("../../template/loadclass.php");

    $is_edit_mode = isset($_GET["id"]) && is_numeric($_GET["id"]);
    $rol_data = null;

    $crud = new CRUDRol();

    if ($is_edit_mode) {
        $title = "Editar Rol";
        $id_rol = $_GET["id"];
        $rol_data = $crud->BuscarRolPorId($id_rol);
        if (!$rol_data) {
            die("Rol no encontrado.");
        }
        $form_action = "../../controller/ctd_editar_rol.php";
    } else {
        $title = "Registrar Rol";
        $form_action = "../../controller/ctd_registrar_rol.php";
    }
?>
<!DOCTYPE html>
<html lang="es">

<?php include("../../template/header.php"); ?>

<body>
    <?php include("../../template/menubar.php"); ?>

    <div class="container mt-3 mb-5">
        <header class="mb-4">
            <h1><i class="fas <?= $is_edit_mode ? 'fa-user-tag' : 'fa-plus-circle' ?> me-2"></i> <?= $title ?></h1>
        </header>

        <div class="row justify-content-center">
            <div class="col-md-8 pb-5">
                <form id="form-rol" method="POST" action="<?= $form_action ?>">
                    <?php if ($is_edit_mode): ?>
                        <input type="hidden" name="id_rol" value="<?= $rol_data->id_rol ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="nombre_rol" class="form-label">Nombre del Rol:</label>
                        <input type="text" class="form-control" id="nombre_rol" name="nombre_rol" value="<?= $is_edit_mode ? $rol_data->nombre_rol : '' ?>" required>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success" name="<?= $is_edit_mode ? 'btn_editar' : 'btn_registrar' ?>">
                            <i class="fas fa-save me-2"></i> Guardar
                        </button>
                        <a href="listar.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Regresar
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <?php include("../../template/footer.php"); ?>
    </div>

</body>

</html>