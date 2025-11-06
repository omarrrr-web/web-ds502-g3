<?php
// Define la ruta relativa a la raíz para las inclusiones estáticas
$route = "../../..";
include("../../template/loadclass.php");

// 1. INCLUSIÓN DE CLASES NECESARIAS
// Necesitamos CRUDActivos para el registro y CRUDCategoria para la lista desplegable
$crudactivos = new CRUDActivos();
$crudcategoria = new CRUDCategoria(); 
$rs_categorias = $crudcategoria->ListarCategoria(); // Obtiene todas las categorías

include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header>
        <h3 class="text-warning"><i class="fas fa-plus-circle"></i> Registrar Nuevo Activo</h3>
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
                        <form id="frm_registrar_act" name="frm_registrar_act" method="post" 
                              action="../../controller/ctr_grabar_activo.php" autocomplete="off">
                            
                            <input type="hidden" id="txt_tipo" name="txt_tipo" value="r">

                            <div class="row g-3">
                                
                                <div class="col-md-6">
                                    <label for="txt_serial" class="form-label">Número de Serie</label>
                                    <input type="text" class="form-control" id="txt_serial" name="txt_serial" 
                                           placeholder="Serial Number" maxlength="255" required autofocus>
                                </div>

                                <div class="col-md-6">
                                    <label for="cbo_id_cat" class="form-label">Categoría</label>
                                    <select class="form-select" id="cbo_id_cat" name="cbo_id_cat" required>
                                        <option value="" selected>Seleccione Categoría</option>
                                        <?php 
                                        // Recorre el array de categorías obtenido del modelo
                                        foreach ($rs_categorias as $cat) {
                                            // El VALUE es el ID, lo que se muestra es el nombre
                                            echo "<option value=\"{$cat->id_categoria}\">{$cat->nombre_categoria}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="txt_marca" class="form-label">Marca</label>
                                    <input type="text" class="form-control" id="txt_marca" name="txt_marca" 
                                           placeholder="Ej: Dell / HP" maxlength="100">
                                </div>

                                <div class="col-md-4">
                                    <label for="txt_modelo" class="form-label">Modelo</label>
                                    <input type="text" class="form-control" id="txt_modelo" name="txt_modelo" 
                                           placeholder="Ej: Latitude 5400" maxlength="100">
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="cbo_estado" class="form-label">Estado Inicial</label>
                                    <select class="form-select" id="cbo_estado" name="cbo_estado" required>
                                        <option value="Almacenado" selected>Almacenado</option>
                                        <option value="En uso">En uso</option>
                                        <option value="Mantenimiento">Mantenimiento</option>
                                        <option value="Baja">Baja</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="txt_fecha_compra" class="form-label">Fecha de Compra</label>
                                    <input type="date" class="form-control" id="txt_fecha_compra" name="txt_fecha_compra">
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="txt_precio" class="form-label">Precio (S/)</label>
                                    <input type="number" step="0.01" class="form-control" id="txt_precio" name="txt_precio" 
                                           placeholder="0.00" min="0">
                                </div>

                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-outline-success" id="btn_registrar" name="btn_registrar">
                                    <i class="fas fa-save"></i> Grabar Activo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </section>
    <?php include("../../template/footer.php"); ?>
</div>

