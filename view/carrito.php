<?php

$datos = new productosController();
$dato = $datos->productosController();


if (isset($_POST['eliminar'])) {
    $id = $_POST['eliminar'];

    foreach ($_SESSION['carrito'] as $producto => $detalles) {
        if ($detalles['id'] == $id) {
            unset($_SESSION['carrito'][$producto]);
            break;
        }
    }

    header("Location: index.php?view=carrito");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<body class="d-flex flex-column  min-vh-100">
    <main class="flex-fill">
        <nav class="navbar fixed-top bg-body-tertiary justify-content-between">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Logo</a>
                <div class="d-flex gap-5 px-5 text-decoration-none ">
                    <a class="text-decoration-none text-dark " href="index.php?view=inicio">Inicio</a>
                    <a class="text-decoration-none text-dark " href="">Salir</a>
                    <a class="text-decoration-none text-dark " href="index.php?view=check">volver</a>

                </div>

            </div>
        </nav>

        <div class="d-flex justify-content-center w-100" style="padding-top: 200px;">
            <div class="container my-4">
                <div class="container my-4">
                    <div class="table-responsive shadow rounded">
                        <table class="table table-striped table-hover align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0;
                                if (isset($_SESSION['carrito'])) {
                                    foreach ($_SESSION['carrito'] as $indice => $arreglo) {
                                        $subtotal = $arreglo['cantidad'] * $arreglo['precio'];
                                        $total += $subtotal; ?>
                                        <tr>
                                            <td><?= htmlspecialchars($indice) ?></td>
                                            <td><?= htmlspecialchars($arreglo['cantidad']) ?></td>
                                            <td><?= MONEDA . "" . number_format($arreglo['precio'], 2) ?></td>
                                            <td><?= MONEDA . "" . number_format($subtotal, 2) ?></td>
                                            <td>
                                                <form method="post" style="display: inline;">
                                                    <input type="hidden" name="eliminar" value="<?= $arreglo['id'] ?>" />
                                                    <button type="submit" class="btn btn-sm"> Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
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