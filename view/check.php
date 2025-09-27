<?php
$producto = new productosController();
$productos = $producto->productosController();
print_r($productos);

if (isset($_POST['btnPost'])) {
    $id = $_POST['id'];
    $producto = $_POST['productoPost'];
    $precio   = $_POST['precioPost'];
    $cantidad = $_POST['cantidadPost'];

    $_SESSION['carrito'][$producto]['cantidad'] = $cantidad;
    $_SESSION['carrito'][$producto]['precio'] = $precio;
    $_SESSION['carrito'][$producto]['id'] = $id;

    header("location:index.php?view=check");
    exit;
}

if (isset($_POST['eliminar'])) {
    $id = $_POST['eliminar'];

    foreach ($_SESSION['carrito'] as $producto => $detalles) {
        if ($detalles['id'] == $id) {
            unset($_SESSION['carrito'][$producto]);
            break;
        }
    }

    header("location:index.php?view=carrito");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<body class="">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Tienda online</title>
    </head>

    <div class="bg-gray-100 container p-20 ">
        <nav class="navbar fixed-top bg-body-tertiary justify-content-between">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Logo</a>
                <div class="d-flex gap-5 px-5 text-decoration-none ">
                    <a class="text-decoration-none text-dark " href="index.php?view=inicio">Inicio</a>
                    <a class="text-decoration-none text-dark " href="">Salir</a>
                    <a class="text-decoration-none text-dark " href="index.php?view=carrito">Carrito</a>
                </div>

            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-3  text-center p-3">Columna 1</div>
                <div class="col-3   text-center p-3">Columna 2</div>

            </div>
        </div>

        <main class="container py-5">
            <div class="row g-4">
                <!-- g-4 agrega espacio entre columnas y filas -->
                <?php foreach ($productos as $item) { ?>
                    <div class="col-12 col-md-6 col-lg-3">
                        <!-- 1 columna en mov, 2 en md, 4 en lg -->
                        <form method="post">
                            <div class="card h-100 text-center shadow-sm">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title"><?= htmlspecialchars($item['nombre']) ?></h5>
                                    <p class="card-text mb-2">Precio:
                                        <?= MONEDA . " " . number_format($item['precio'], 2) ?></p>

                                    <div class="mb-3">
                                        <label for="cantidad_<?= $item['id'] ?>" class="form-label">Cantidad:</label>
                                        <input type="number" min="1" name="cantidadPost" id="cantidad_<?= $item['id'] ?>"
                                            value="<?= isset($_SESSION['carrito'][$item['nombre']]['cantidad']) ? $_SESSION['carrito'][$item['nombre']]['cantidad'] : 1 ?>"
                                            class="form-control text-center">
                                    </div>

                                    <input type="hidden" name="productoPost" value="<?= $item['nombre'] ?>">
                                    <input type="hidden" name="precioPost" value="<?= $item['precio'] ?>">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">

                                    <button type="submit" name="btnPost" class="btn btn-success mt-auto">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </main>



        <!--Overlay -->
        <!-- Modal Eliminar -->
        <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEliminarLabel">Confirmar eliminación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        ¿Seguro que desea eliminar este producto del carrito?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form method="post">
                            <input type="hidden" name="eliminar" id="inputEliminar">
                            <button type="submit" class="btn btn-danger">Confirmar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modalEliminar = document.getElementById('modalEliminar');
        const inputEliminar = document.getElementById('inputEliminar');

        if (modalEliminar) {
            modalEliminar.addEventListener('show.bs.modal', (event) => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                inputEliminar.value = id;
            });
        }
    });
</script>


</html>