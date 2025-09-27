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

<body>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Tienda online</title>
    </head>

    <body class="bg-gray-100">

        <div class="d-flex justify-content-between px-5 ">
            <div>Logo</div>
            <div class="d-flex justify-content-between px-5 gap-5" id="menu">
                <a href="index.php?view=inicio">Inicio</a>
                <a href="">Salir</a>
                <a href="index.php?view=carrito">Carrito</a>
            </div>
        </div>

        <main class="d-flex justify-content-center">
            <div class="w-full max-w-4xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-center">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 border-b">Producto</th>
                                <th class="py-2 px-4 border-b">Precio</th>
                                <th class="py-2 px-4 border-b">Cantidad</th>
                                <th class="py-2 px-4 border-b">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $item) { ?>
                                <tr>
                                    <form method="post">
                                        <td class="py-2 px-4 border-b">
                                            <input type="text" name="productoPost" value="<?= $item['nombre'] ?>" readonly
                                                class="bg-transparent text-center w-full" />
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            <input type="text" name="precioPost" value="<?= $item['precio'] ?>" readonly
                                                class="bg-transparent text-center w-full" />
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            <input type="number" min="1" name="cantidadPost"
                                                value="<?= isset($_SESSION['carrito'][$item['nombre']]['cantidad']) ? $_SESSION['carrito'][$item['nombre']]['cantidad'] : 1 ?>"
                                                class="text-center w-20 border rounded" />
                                        </td>
                                        <input type="hidden" name="id" value="<?= $item['id'] ?>" />
                                        <td class="py-2 px-4 border-b">
                                            <button type="submit" name="btnPost"
                                                class="px-3 py-1 bg-green-500 text-white rounded">Agregar</button>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalEliminar" data-id="<?= $item['id'] ?>">
                                                Eliminar
                                            </button>

                                        </td>
                                    </form>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
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