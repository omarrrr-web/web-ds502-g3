<?php
// Define la ruta DE DOS NIVELES
$route = "../../.."; 
include("../../template/loadclass.php");

// 1. Lógica PHP para precarga y manejo de listas
$crudlicencia = new CRUDLicencia(); 
$crudcategoria = new CRUDCategoria(); 
$rs_categorias = $crudcategoria->ListarCategoria(); // Obtiene todas las categorías para el dropdown

// 2. Capturar el ID y buscar la licencia actual
if (!isset($_GET['idlic'])) {
    header("location: listar_licencias.php");
    exit();
}

$id_lic = $_GET['idlic'];
$licencia_actual = $crudlicencia->BuscarLicenciaPorId($id_lic);

if (!$licencia_actual) {
    die("<div class='alert alert-danger'>Licencia no encontrada.</div>");
}

$title = "Editar Licencia ID: " . $id_lic;
include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header>
        <h3 class="text-success"><i class="fas fa-pen-square"></i> Editar Licencia</h3>
        <hr/>
    </header>
    
    <nav class="mb-3">
        <a href="listar_licencias.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-circle-left"></i> Regresar
        </a>
    </nav>
    
    <section>
        <article>
            <div class="row justify-content-center">
                <div class="card col-md-8">
                    <div class="card-body">
                        <form id="frm_editar_lic" name="frm_editar_lic" method="post" 
                              action="../../controller/ctr_grabar_licencia.php" autocomplete="off">
                            
                            <input type="hidden" id="txt_tipo" name="txt_tipo" value="e">
                            
                            <input type="hidden" id="txt_id_lic" name="txt_id_lic" value="<?= $licencia_actual->id_licencia ?>">

                            <div class="row g-3">
                                
                                <div class="col-md-6">
                                    <label for="txt_id_lic_display" class="form-label">ID Licencia</label>
                                    <input type="text" class="form-control" id="txt_id_lic_display" 
                                           value="<?= $licencia_actual->id_licencia ?>" readonly>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="cbo_id_cat" class="form-label">Categoría de Software</label>
                                    <select class="form-select" id="cbo_id_cat" name="cbo_id_cat" required>
                                        <option value="">Seleccione Categoría</option>
                                        <?php 
                                        foreach ($rs_categorias as $cat) {
                                            // LÓGICA DE SELECCIÓN: Marca 'selected' si coincide el ID actual
                                            $selected = ($cat->id_categoria == $licencia_actual->id_categoria) ? 'selected' : '';
                                            echo "<option value=\"{$cat->id_categoria}\" {$selected}>{$cat->nombre_categoria}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="txt_nombre" class="form-label">Nombre del Software</label>
                                    <input type="text" class="form-control" id="txt_nombre" name="txt_nombre" 
                                           maxlength="150" required autofocus 
                                           value="<?= $licencia_actual->nombre_software ?>">
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="txt_clave" class="form-label">Clave de Licencia</label>
                                    <input type="text" class="form-control" id="txt_clave" name="txt_clave" 
                                           maxlength="255" required 
                                           value="<?= $licencia_actual->clave_licencia ?>">
                                </div>

                                <div class="col-md-6">
                                    <label for="txt_cantidad" class="form-label">Cantidad de Usuarios/Asientos</label>
                                    <input type="number" class="form-control" id="txt_cantidad" name="txt_cantidad" 
                                           min="1" required 
                                           value="<?= $licencia_actual->cantidad_usuarios ?>">
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="txt_expiracion" class="form-label">Fecha de Expiración</label>
                                    <input type="date" class="form-control" id="txt_expiracion" name="txt_expiracion" 
                                           title="Dejar vacío si la licencia es perpetua/permanente."
                                           value="<?= $licencia_actual->fecha_expiracion ?>">
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