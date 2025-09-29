<?php

//print_r($_SESSION);

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
$token_tmp = "";
$data = new productosController();
$row = $data->getProductoControllerId($id);
#print_r($row);
#print_r($_SESSION);
if (isset($_POST['btnPost'])) {
    $producto = $_POST['productoPost'];
    $precio   = $_POST['precioPost'];
    $cantidad = $_POST['cantidadPost'];

    //Si no esta en el carrito
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    //Si existe acumula
    if (isset($_SESSION['carrito'][$producto])) {
        $_SESSION['carrito'][$producto]['cantidad'] += $cantidad;
    } else {
        $_SESSION['carrito'][$producto] = [
            'cantidad' => $cantidad,
            'precio' => $precio,
            'id' => $id
        ];
    }
}
if (isset($_POST['btnBorrarPost'])) {
    $producto = $_POST['productoPost'];
    $precio   = $_POST['precioPost'];
    $cantidad = $_POST['cantidadPost'];


    if (isset($_SESSION['carrito'][$producto])) {
        $_SESSION['carrito'][$producto]['cantidad'] -= $cantidad;
    }

    //cuando llega a cero lo saco del carrito
    if ($_SESSION['carrito'][$producto]['cantidad'] <= 0) {
        unset($_SESSION['carrito'][$producto]);
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del producto</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
</head>

<body class="d-flex flex-column  min-vh-100">

    <main class="flex-fill">
        <div class="d-flex justify-content-between py-3 bg-gradient">
            <div class="px-4">Logo</div>
            <div class="d-flex gap-5 px-4" id="menu">
                <a href="index.php?view=inicio">Inicio</a>
                <a href="">Salir</a>
                <div>
                    <a href="index.php?view=carrito">Carrito</a>
                </div>
            </div>
        </div>

        <div>
            <h1 class="text-2xl font-bold mb-6 p-5">Detalle</h1>
        </div>

        <div class="px-lg-4">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 d-flex justify-content-center mb-4 mb-lg-0">
                    <div class="bg-light rounded-lg d-flex align-items-center justify-content-center w-100"
                        style="max-width:900px;">
                        <img src="img/<?= $row['img'] ?>" class="img-fluid" alt="<?= $row['nombre'] ?>">
                    </div>
                </div>


                <div class="col-12 col-lg-6">
                    <form method="post" class="d-flex flex-column gap-3">
                        <h2 class="h3"><?= $row['nombre'] ?></h2>
                        <p class="text-muted"><?= $row['descripcion'] ?></p>
                        <p class="fw-bold"><?= MONEDA . number_format($row['precio'], 2, ',', '.'); ?></p>
                        <p class="text-danger"><?= MONEDA . number_format($row['descuento'], 2, ',', '.'); ?></p>

                        <input type="hidden" name="cantidadPost" value="1" />
                        <input type="hidden" name="productoPost" value="<?= $row['nombre'] ?>" />
                        <input type="hidden" name="precioPost" value="<?= $row['precio'] ?>" />

                        <div class="mt-3">
                            <button type="submit" name="btnPost" class="btn btn-outline-dark me-2">
                                Agregar al carrito
                            </button>
                            <button type="submit" name="btnBorrarPost" class="btn btn-danger">
                                Borrar unidad
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!--Footer -->
    <footer class="bg-secondary-subtle text-white bg-opacity-100 text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; <?= date('Y') ?> Fernandez Magali Victoria</p>
            <p class="mb-0">
                <a href="#" class="text-white text-decoration-none me-3">Política de privacidad</a>
                <a href="#" class="text-white text-decoration-none">Contacto</a>
            </p>
        </div>
    </footer>
</body>


</html>