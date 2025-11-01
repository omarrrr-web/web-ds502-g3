<!DOCTYPE html>
<html lang="es">
    <?php
        $route = "../../../";
        $title = "Listado de proveedores";

        include("../../template/header.php");
    ?>
<body>
    <?php
    include("../../template/menubar.php");
    include("../../template/loadclass.php");

    $crud_pro = new CRUDProveedor();
    $rs = $crud_pro->ListarProveedor();
    ?>
    <div class="container mt-3">
        <header>
            <h1><i class="fas fa-truck text-danger me-2"></i><?=$title?></h1>
        </header>
        <section>
            <article>
                <div class="row">
                    <div class="col-md-6 mx-auto d-block">
                        <table class="table table-striped">
                            <tr class="table-danger">
                                <th>Núm.</th>
                                <th>Código</th>
                                <th>Razon Social</th>
                                <th>RUC</th>
                                <th>Direccion</th>
                            </tr>
                            <?php
                                $i = 0;

                                foreach($rs as $prov){                                    $i++;
                            ?>
                            <tr>
                                <td><?=$i?></td>   
                                <td><?=$prov->codigo_proveedor?></td>   
                                <td><?=$prov->razon_social?></td>  
                                <td><?=$prov->ruc?></td>      
                                <td><?=$prov->direccion?></td>  
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