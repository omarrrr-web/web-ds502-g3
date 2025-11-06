<?php
// Define la ruta DE DOS NIVELES para las inclusiones estáticas
$route = "../../../"; 
include("../../template/loadclass.php");

// 1. Lógica PHP para precarga y manejo de listas
$crudactivos = new CRUDActivos(); 
$crudcategoria = new CRUDCategoria(); 
$rs_categorias = $crudcategoria->ListarCategoria(); // Obtiene todas las categorías para el dropdown

// 2. Capturar el ID y buscar el activo
if (!isset($_GET['idact'])) {
    header("location: listar_activos.php");
    exit();
}

$id_act = $_GET['idact'];
$activo_actual = $crudactivos->BuscarActivoPorId($id_act);

if (!$activo_actual) {
    die("<div class='alert alert-danger'>Activo no encontrado.</div>");
}

$title = "Editar Activo ID: " . $id_act;
include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header>
        <h3 class="text-success"><i class="fas fa-pen-square"></i> Editar Activo</h3>
        <hr/>
    </header>
    <nav class="mb-3">
        <a href="listar_activos.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-circle-left"></i> Regresar
        </a>
    </nav>
    
    <section>
        <article>
            <div class="row justify-content-center">
                <div class="card col-md-8">
                    <div class="card-body">
                        <form id="frm_editar_act" name="frm_editar_act" method="post" 
                              action="../../controller/ctr_grabar_activo.php" autocomplete="off">
                            
                            <input type="hidden" id="txt_tipo" name="txt_tipo" value="e">
                            
                            <input type="hidden" id="txt_id_act" name="txt_id_act" value="<?= $activo_actual->id_activo ?>">

                            <div class="row g-3">
                                
                                <div class="col-md-6">
                                    <label for="txt_serial" class="form-label">Número de Serie</label>
                                    <input type="text" class="form-control" id="txt_serial" name="txt_serial" 
                                           maxlength="255" readonly 
                                           value="<?= $activo_actual->serial_number ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="cbo_id_cat" class="form-label">Categoría</label>
                                    <select class="form-select" id="cbo_id_cat" name="cbo_id_cat" required>
                                        <option value="">Seleccione Categoría</option>
                                        <?php 
                                        foreach ($rs_categorias as $cat) {
                                            // LÓGICA DE SELECCIÓN: Marca 'selected' si coincide el ID actual
                                            $selected = ($cat->id_categoria == $activo_actual->id_categoria) ? 'selected' : '';
                                            echo "<option value=\"{$cat->id_categoria}\" {$selected}>{$cat->nombre_categoria}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="txt_marca" class="form-label">Marca</label>
                                    <input type="text" class="form-control" id="txt_marca" name="txt_marca" 
                                           maxlength="100" value="<?= $activo_actual->marca ?>">
                                </div>

                                <div class="col-md-4">
                                    <label for="txt_modelo" class="form-label">Modelo</label>
                                    <input type="text" class="form-control" id="txt_modelo" name="txt_modelo" 
                                           maxlength="100" value="<?= $activo_actual->modelo ?>">
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="cbo_estado" class="form-label">Estado Actual</label>
                                    <select class="form-select" id="cbo_estado" name="cbo_estado" required>
                                        <?php 
                                        $estados = ['En uso', 'Almacenado', 'Mantenimiento', 'Baja'];
                                        foreach ($estados as $estado) {
                                            // LÓGICA DE SELECCIÓN: Marca 'selected' si coincide el estado actual
                                            $selected = ($estado == $activo_actual->estado) ? 'selected' : '';
                                            echo "<option value=\"{$estado}\" {$selected}>{$estado}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="txt_fecha_compra" class="form-label">Fecha de Compra</label>
                                    <input type="date" class="form-control" id="txt_fecha_compra" name="txt_fecha_compra"
                                           value="<?= $activo_actual->fecha_compra ?>">
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="txt_precio" class="form-label">Precio (S/)</label>
                                    <input type="number" step="0.01" class="form-control" id="txt_precio" name="txt_precio" 
                                           min="0" value="<?= $activo_actual->precio ?>">
                                </div>

                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-outline-success" id="btn_actualizar" name="btn_actualizar">
                                    <i class="fas fa-sync-alt"></i> Actualizar Información
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </section>
</div>

<?php
include("../../template/footer.php");
?>