<!DOCTYPE html>
<html lang="es">
<?php
$route = "../../../";
$title = "Listado de categorias";

include("../../template/header.php");
?>

<body>
    <?php
    include("../../template/menubar.php");
    include("../../template/loadclass.php");

    $crud_cat = new CRUDCategoria();
    $rs = $crud_cat->ListarCategoria();
    ?>
    <div class="container mt-3">
        <header>
            <h1><i class="fas fa-layer-group text-primary me-2"></i><?= $title ?></h1>
        </header>
        <section>
            <article>
                <div class="row">
                    <div class="col-md-6 mx-auto d-block">
                        <table class="table table-striped">
                            <tr class="table-danger">
                                <th>Núm.</th>
                                <th>Código</th>
                                <th>Categoría</th>
                            </tr>
                            <?php
                                $i = 0;

                                foreach($rs as $cat){                                    $i++;
                            ?>
                            <tr>
                                <td><?=$i?></td>   
                                <td><?=$cat->codigo_categoria?></td>   
                                <td><?=$cat->categoria?></td>      
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