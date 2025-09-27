<?php

$datos = new productosController();
$resul = $datos->productosController();




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

        <div class="flex justify-between items-center bg-gray-50 py-5 px-20 ">
            <div>Logo</div>
            <div class="flex gap-x-5" id="menu">
                <a href="">Inicio</a>
                <a href="">Salir</a>
                <a href="index.php?view=check">Carrito <span id="num_cart"></span></a>
            </div>
        </div>
        <div>

            <div class="max-w-6xl mx-auto py-10 px-5">
                <h1 class="text-2xl font-bold mb-6">Nuestros productos</h1>

                <!-- Contenedor de productos -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- Producto 1 -->
                    <?php foreach ($resul as $item) {
                    ?>
                        <div class="bg-white shadow-md rounded-2xl p-4 flex flex-col items-center">
                            <div class="w-full h-40 bg-gray-300 rounded-lg flex items-center justify-center">
                                <span class="text-gray-600">Imagen</span>
                            </div>
                            <h2 class="mt-4 font-semibold text-lg"><?= $item['nombre'] ?></h2>
                            <p class="text-gray-500 text-sm"><?= $item['descripcion'] ?></p>
                            <p class="text-gray-500 text-sm">$<?= number_format($item['precio'], 2, ',', '.'); ?></p>
                            <a class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
                                href="index.php?view=detalles&id=<?= $item['id'] ?>&token=<?= hash_hmac('sha1', $item['id'], KEY_TOKEN) ?>">
                                Detalles</a>

                        </div>
                    <?php } ?>


                </div>

            </div>




    </body>

</html>