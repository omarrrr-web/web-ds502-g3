<!DOCTYPE html>
<html lang="es">
    <?php
        $route = "../../../";
        $title = "Listado de marcas";

        include("../../template/header.php");
    ?>
<body>
    <?php
    include("../../template/menubar.php");
    include_once("../../model/conexion.php");
    include_once("../../model/crudmarca.php");
    include("../../template/loadclass.php");

    $crud_cat = new CRUDMarca();
    $rs = $crud_cat->ListarMarca();
    ?>
    <div class="container mt-3">
        <header>
            <h1><i class="fas fa-tags text-success me-2"></i><?=$title?></h1>
        </header>
        <section>
            <article>
                <div class="row">
                    <div class="col-md-6 mx-auto d-block">
                        <table class="table table-striped">
                            <tr class="table-danger">
                                <th>Núm.</th>
                                <th>Código</th>
                                <th>Marca</th>
                            </tr>
                            <?php
                                $i = 0;

                                foreach($rs as $mar){                                    $i++;
                            ?>
                            <tr>
                                <td><?=$i?></td>   
                                <td><?=$mar->codigo_marca?></td>   
                                <td><?=$mar->marca?></td>      
                            </tr>
                            <?php
                                }
                            ?>
                                
                        </table>
                    </div>
                </div>
            </article>
        </section>
    <?php
        include("../../template/footer.php");
    ?>
    </div>
</body>
</html>