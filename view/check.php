<?php
$producto = new productosController();
$productos = $producto->productosController();
#print_r($productos);
?>

<!DOCTYPE html>
<html lang="en">

<body>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Tailwind-->
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Tienda online</title>
    </head>

    <body class="bg-gray-100">

        <div class="flex justify-between items-center bg-gray-50 py-5 px-20 ">
            <div>Logo</div>
            <div class="flex gap-x-5" id="menu">
                <a href="index.php?view=inicio">Inicio</a>
                <a href="">Salir</a>
                <a href="">Carrito</a>
            </div>
        </div>

        <main class="flex justify-center mt-10">
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
                                            <input type="number" min="1" name="cantidadPost" value="1"
                                                class="text-center w-20 border rounded" />
                                        </td>
                                        <td class="py-2 px-4 border-b">
                                            <button type="submit" name="btnPost"
                                                class="px-3 py-1 bg-green-500 text-white rounded">Agregar</button>
                                            <a href="clases/eliminar_carrito.php?id=<?= $item['id'] ?>"
                                                class="px-3 py-1 bg-red-500 text-white rounded">Eliminar</a>
                                        </td>
                                    </form>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <?php
        if (isset($_POST['btnPost'])) {
            $producto = $_POST['productoPost'];
            $precio   = $_POST['precioPost'];
            $cantidad = $_POST['cantidadPost'];

            $_SESSION['carrito']['producto'] = $producto;
            $_SESSION['carrito']['cantidad'] = $precio;
            $_SESSION['carrito']['precio'] = $cantidad;

            echo "<script>alert('Producto $producto')</script>";
        }
        ?>

    </body>

</html>