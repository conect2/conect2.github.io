<?php
include './library/configServer.php';
include './library/consulSQL.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Productos</title>
    <?php include './inc/link.php'; ?>
</head>

<body id="container-page-product">
    <?php include './inc/navbar.php'; ?>
    <section id="infoproduct">
        <div class="container">
            <div class="row">
                <div class="page-header">
                    <h1>DETALLE DE PRODUCTO <small class="tittles-pages-logo">CONECT2</small></h1>
                </div>
                <?php 
                    $CodigoProducto=consultasSQL::clean_string($_GET['codigo']);
                    $productoinfo=  ejecutarSQL::consultar("SELECT articulo.codigo,articulo.nombre,articulo.idcategoria,categoria.nombre,articulo.Precio,articulo.Descuento,articulo.stock,articulo.imagen FROM categoria INNER JOIN articulo ON articulo.idcategoria=categoria.idcategoria  WHERE codigo='".$CodigoProducto."'");
                    while($fila=mysqli_fetch_array($productoinfo, MYSQLI_ASSOC)){
                        echo '
                            <div class="col-xs-12 col-sm-6">
                                <h3 class="text-center">Información de articulo</h3>
                                <br><br>
                                <h4><strong>nombre: </strong>'.$fila['nombre'].'</h4><br>
                                <h4><strong>Precio: </strong>$'.number_format(($fila['Precio']-($fila['Precio']*($fila['Descuento']/100))), 2, '.', '').'</h4><br>
                                <h4><strong>Cantidad: </strong>'.$fila['stock'].'</h4><br>
                                <h4><strong>Categoria: </strong>'.$fila['nombre'].'</h4>';
                                if($fila['stock']>=1){
                                    if($_SESSION['nombreAdmin']!="" || $_SESSION['nombreUser']!=""){
                                        echo '<form action="process/carrito.php" method="POST" class="FormCatElec" data-form="">
                                            <input type="hidden" value="'.$fila['codigo'].'" name="codigo">
                                            <label class="text-center"><small>Agrega la cantidad de productos que añadiras al carrito de compras (Maximo '.$fila['stock'].' productos)</small></label>
                                            <div class="form-group">
                                                <input type="number" class="form-control" value="1" min="1" max="'.$fila['stock'].'" name="cantidad">
                                            </div>
                                            <button class="btn btn-lg btn-raised btn-success btn-block"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp; Añadir al carrito</button>
                                        </form>
                                        <div class="ResForm"></div>';
                                    }else{
                                        echo '<p class="text-center"><small>Para agregar productos al carrito de compras debes iniciar sesion</small></p><br>';
                                        echo '<button class="btn btn-lg btn-raised btn-info btn-block" data-toggle="modal" data-target=".modal-login"><i class="fa fa-user"></i>&nbsp;&nbsp; Iniciar sesion</button>';
                                    }
                                }else{
                                    echo '<p class="text-center text-danger lead">No hay existencias de este articulo</p><br>';
                                }
                                if($fila['imagen']!="" && is_file("./assets/img-products/".$fila['imagen'])){ 
                                    $imagenFile="./assets/img-products/".$fila['imagen']; 
                                }else{ 
                                    $imagenFile="./assets/img-products/default.png"; 
                                }
                                echo '<br>
                                <a href="product.php" class="btn btn-lg btn-primary btn-raised btn-block"><i class="fa fa-mail-reply"></i>&nbsp;&nbsp;Regresar a la tienda</a>
                            </div>


                            <div class="col-xs-12 col-sm-6">
                                <br><br><br>
                                <img class="img-responsive" src="'.$imagenFile.'">
                            </div>';
                    }
                ?>
            </div>
        </div>
    </section>

    <?php include './inc/footer.php'; ?>

</body>

</html>