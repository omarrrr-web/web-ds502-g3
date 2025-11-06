<?php
// Define la ruta DE DOS NIVELES
$route = "../../.."; 
include("../../template/loadclass.php");
$title = "Consultar Asignación";
include("../../template/header.php");
include("../../template/menubar.php");
?>

<div class="container mt-3">
    <header>
        <h3 class="text-info"><i class="fa fa-search"></i> Consultar Asignación por ID</h3>
        <hr/>
    </header>
    
    <nav class="mb-3">
        <a href="listar_asignaciones.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-circle-left"></i> Regresar
        </a>
    </nav>
    
    <section>
        <article>
            <div class="row justify-content-center mt-3">
                <div class="card col-md-6">
                    <div class="card-body">
                        <form id="frm_consultar_asig" name="frm_consultar_asig" method="post" autocomplete="off">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="txt_id_asig" class="form-label">ID Asignación</label>
                                    <input type="number" class="form-control" id="txt_id_asig" name="txt_id_asig" 
                                           placeholder="ID a buscar" autofocus min="1">
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-outline-primary" name="btn_consultar_asig">
                                    <i class="fa fa-search"></i> Consultar
                                </button>
                            </div>
                        </form>
                        
                        <div class="mt-4 p-3 border rounded">
                            <h5>Detalles:</h5>
                            <div id="resultado_consulta_asig">
                                <?php 
                                if (isset($_POST['txt_id_asig'])) {
                                    $id_asig = $_POST['txt_id_asig'];
                                    $crud_asig = new CRUDAsignaciones();
                                    $asignacion = $crud_asig->BuscarAsignacionesPorId($id_asig);
                                    
                                    if ($asignacion) {
                                        // Mostrar los detalles de la asignación
                                        echo "<p><strong>ID Asignación:</strong> " . $asignacion->id_asignacion . "</p>";
                                        echo "<p><strong>Empleado:</strong> " . $asignacion->nombre_empleado . "</p>";
                                        echo "<p><strong>Fecha Asignación:</strong> " . date('Y-m-d', strtotime($asignacion->fecha_asignacion)) . "</p>";
                                        echo "<p><strong>Fecha Devolución:</strong> " . ($asignacion->fecha_devolucion ? date('Y-m-d', strtotime($asignacion->fecha_devolucion)) : '-') . "</p>";
                                        echo "<p><strong>Notas:</strong> " . $asignacion->notas . "</p>";
                                    } else {
                                        echo '<div class="alert alert-danger">Asignación no encontrada.</div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-info">Ingrese un ID para ver los detalles de la asignación.</div>';
                                }
                                ?>
                            </div>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="consultar_asignacion.php" class="btn btn-outline-primary"><i class="fa fa-file"></i> Nueva Consulta</a>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </section>
    <?php include("../../template/footer.php"); ?>
</div>

