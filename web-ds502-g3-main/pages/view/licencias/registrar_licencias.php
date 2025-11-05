<?php
// Define la ruta DE DOS NIVELES
$route = "../../.."; 
include("../../template/loadclass.php");

// 1. INCLUSIÓN DE CLASES NECESARIAS
// Necesitamos CRUDLicencia (para el registro) y CRUDCategoria (para el dropdown)
$crudlicencia = new CRUDLicencia(); 
$crudcategoria = new CRUDCategoria(); 

// Obtener las categorías, filtrando idealmente por aquellas de tipo 'Software' 
// (aunque aquí listamos todas para que el usuario elija la correcta)
$rs_categorias = $crudcategoria->ListarCategoria(); 

$title = "Registrar Licencia";
include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header>
        <h3 class="text-primary"><i class="fas fa-plus-circle"></i> Registrar Nueva Licencia</h3>
        <hr/>
    </header>
    
    <nav class="mb-3">
        <a href="listar_licencia.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-circle-left"></i> Regresar
        </a>
    </nav>
    
    <section>
        <article>
            <div class="row justify-content-center">
                <div class="card col-md-8">
                    <div class="card-body">
                        <form id="frm_registrar_lic" name="frm_registrar_lic" method="post" 
                              action="../../controller/ctr_grabar_licencia.php" autocomplete="off">
                            
                            <input type="hidden" id="txt_tipo" name="txt_tipo" value="r">

                            <div class="row g-3">
                                
                                <div class="col-md-6">
                                    <label for="cbo_id_cat" class="form-label">Categoría de Software</label>
                                    <select class="form-select" id="cbo_id_cat" name="cbo_id_cat" required>
                                        <option value="" selected>Seleccione Categoría</option>
                                        <?php 
                                        foreach ($rs_categorias as $cat) {
                                            // Se muestra el nombre, se guarda el ID
                                            echo "<option value=\"{$cat->id_categoria}\">{$cat->nombre_categoria}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="txt_nombre" class="form-label">Nombre del Software</label>
                                    <input type="text" class="form-control" id="txt_nombre" name="txt_nombre" 
                                           placeholder="Ej: MS Office, AutoCAD" maxlength="150" required autofocus>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="txt_clave" class="form-label">Clave de Licencia</label>
                                    <input type="text" class="form-control" id="txt_clave" name="txt_clave" 
                                           placeholder="Ej: A365-XXXX-YYYY-ZZZZ" maxlength="255" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="txt_cantidad" class="form-label">Cantidad de Usuarios/Asientos</label>
                                    <input type="number" class="form-control" id="txt_cantidad" name="txt_cantidad" 
                                           placeholder="Ej: 10, 50" min="1" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="txt_expiracion" class="form-label">Fecha de Expiración</label>
                                    <input type="date" class="form-control" id="txt_expiracion" name="txt_expiracion" 
                                           title="Dejar vacío si la licencia es perpetua/permanente.">
                                </div>
                                
                                <div class="col-md-6"></div>

                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-outline-success" id="btn_registrar" name="btn_registrar">
                                    <i class="fas fa-save"></i> Grabar Licencia
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