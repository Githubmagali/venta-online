<?php
require 'config/config.php';
require 'config/database.php';
$db = new dataBase();
$con = $db->conectar();


$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' ||  $token == '') {
    echo 'Error al procesar la peticion';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp) {

        #COUNT(id) te dice cuántos registros cumplen la condición
        $sql = $con->prepare("SELECT count(id) FROM productos WHERE id =? AND activo=1");
        $sql->execute([$id]);
        $resultado =  $sql->fetchColumn();

        if ($resultado > 0) {
            $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento FROM productos WHERE id =? AND activo=1
           LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);

            $descuento = $row['precio'] - (($row['precio'] * $row['descuento']) / 100);

            #print_r($row['descuento']);
        }
    } else {
        echo 'Error al procesar la peticion';
        exit;
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<body>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detalle del producto</title>
        <!--Tailwind-->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <div class="flex justify-between items-center bg-gray-50 py-5 px-20 ">
        <div>Logo</div>
        <div class="flex gap-x-5" id="menu">
            <a href="">Inicio</a>
            <a href="">Salir</a>
            <div>
                <span id="num_cart"><?= $num_cart ?></span>
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
                    <p><?= MONEDA . number_format($descuento, 2, ',', '.'); ?></p>
                    <button type="submit" class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Comprar
                    </button>
                    <button onclick="addProducto(<?= $id; ?>,'<?= $token_tmp; ?>', 1)" type="button"
                        class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Agregar al carrito
                    </button>
                    <button onclick="deleteProducto(<?= $id; ?>,'<?= $token_tmp; ?>')" type="button"
                        class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        Borrar unidad
                    </button>
                </div>



            </div>
        </div>
</body>
<script>
function addProducto(id, token, cantidad = 1) {

    let url = 'clases/carrito.php'
    let formData = new FormData() //creo un objeto vacio, quesimula un formulario html
    //que luego vas a mandar en la peticion fetch
    formData.append('id', id); // append lo agrega el final, con Append agregas la clave valor dentro de ese formData
    formData.append('token', token);
    formData.append('cantidad', cantidad);

    fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors' //cors permite hacer peticiones a otro dominio
        }).then(
            response => response.json())
        .then(data => {
            if (data.ok) {
                let elemento = document.getElementById('num_cart')
                elemento.innerHTML = data.numero;
            }
        })
}

function deleteProducto(id, token, restarUno = -1) {

    let url = 'clases/carrito.php'
    let formData = new FormData()

    formData.append('id', id)
    formData.append('token', token)
    formData.append('restarUno', restarUno)

    fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        })
        .then(response => response.json())
        .then(data => {
            if (data.ok) {
                let elemento = document.getElementById('num_cart')
                elemento.innerHTML = data.numero;
            }
        })
}
</script>

</html>