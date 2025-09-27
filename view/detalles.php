<?php

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
$token_tmp = "";


$data = new productosController();
$row = $data->getProductoControllerId($id);



?>
<!DOCTYPE html>
<html lang="en">

<body>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detalle del producto</title>

    </head>
    <div class="flex justify-between items-center bg-gray-50 py-5 px-20 ">
        <div>Logo</div>
        <div class="flex gap-x-5" id="menu">
            <a href="">Inicio</a>
            <a href="">Salir</a>
            <div>
                <a href="index.php?view=check">Carrito</a>
                <span id="num_cart">Cantidad carrito</span>
            </div>
        </div>
    </div>
    <div>

        <div class="max-w-6xl mx-auto py-10 px-5">
            <h1 class="text-2xl font-bold mb-6">Detalle</h1>

            <!-- Contenedor de productos -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Producto 1 -->

                <div class="bg-white shadow-md rounded-2xl p-4 flex flex-col items-center">
                    <div class="w-full h-40 bg-gray-300 rounded-lg flex items-center justify-center">
                        <span class="text-gray-600">Imagen</span>
                    </div>
                    <h2 class="mt-4 font-semibold text-lg"><?= $row['nombre'] ?></h2>
                    <p class="text-gray-500 text-sm"><?= $row['descripcion'] ?></p>
                    <p class="text-gray-500 text-sm"><?= MONEDA . number_format($row['precio'], 2, ',', '.'); ?></p>
                    <p><?= MONEDA . number_format($row['descuento'], 2, ',', '.'); ?></p>

                    <button onclick="addProducto(<?= $id; ?>)" type="button"
                        class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Agregar al carrito
                    </button>
                    <button onclick="deleteProducto(<?= $id; ?>)" type="button"
                        class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Borrar unidad
                    </button>
                </div>



            </div>
        </div>
</body>
<script>
    function addProducto(id, cantidad = 1) {

        let url = 'clases/actualizar_carrito.php'
        let formData = new FormData()
        formData.append('action', 'agregar')
        formData.append('id', id)
        formData.append('cantidad', cantidad)

        fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Error HTTP: " + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log("Respuesta del servidor:", data);

                if (data.ok) {
                    // actualizar subtotal, unidades de producto
                    let divSubtotal = document.getElementById('subtotal_' + id)
                    if (divSubtotal) {
                        divSubtotal.innerHTML = data.sub
                        console.log("Elemento", data.sub)
                    }

                    // actualizar total de productos del carrito
                    let divTotal = document.getElementById('total')
                    if (divTotal) {
                        divTotal.innerHTML = data.total
                        console.log("Elemento", data.total)
                    }

                    // Cantidad de unidades en el carrito
                    let elemento = document.getElementById('num_cart')
                    if (elemento) {
                        elemento.innerHTML = data.numero
                        console.log("Elemento", data.numero)
                    }
                }
            })
            .catch(error => {
                console.error("Error en el fetch:", error);
            })
    }


    function deleteProducto(id, restarUno = 1) {

        let url = 'clases/restar_uno.php'
        let formData = new FormData()
        formData.append('action', 'quitar')
        formData.append('id', id)
        formData.append('restarUno', restarUno)

        fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'

            })
            .then(response => {
                console.log('formdata', response)
                if (!response.ok) {
                    throw new Error("Error HTTP: " + response.status);
                }
                return response.json();
                console.log(response);
            })


            .then(data => {
                if (data.ok) {
                    // actualizar subtotal, unidades de producto
                    let divSubtotal = document.getElementById('subtotal_' + id)
                    if (divSubtotal) {
                        divSubtotal.innerHTML = data.sub
                        console.log("Elemento", data.sub)
                    }
                    // actualizar total de productos del carrito
                    let divTotal = document.getElementById('total')
                    if (divTotal) {
                        divTotal.innerHTML = data.total
                        console.log("Elemento", data.total)
                    }


                    let elemento = document.getElementById('num_cart')
                    elemento.innerHTML = data.numero; //data.numero para actualizar el DOM en tiempo real.
                    console.log("El elemento ", elemento)
                }
            })
            .catch(error => {
                console.error("Error en el fetch", error);
            })
    }
</script>

</html>