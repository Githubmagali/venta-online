<?php
require 'config/database.php';
require 'config/config.php';

$db = new dataBase();
$con = $db->conectar();
$producto = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;



$lista_carrito = array();
if ($producto != null) {

    foreach ($producto as $clave => $cantidad) {
        #echo "Producto $clave: $cantidad unidades\n";

        $sql = $con->prepare("SELECT id, nombre, descripcion, precio, descuento, $cantidad AS cantidad FROM productos 
        WHERE id=? AND activo = 1");
        $sql->execute([$clave]);

        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
}
#hash_hmac() sifra una informacion mediante una contraseña
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
                <a href="">Inicio</a>
                <a href="">Salir</a>
                <a href="check.php">Carrito <span id="num_cart"></span></a>
            </div>
        </div>
        <div>


            <main class="flex justify-center mt-10">
                <div class="w-full max-w-4xl">
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-center">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b">Producto</th>
                                    <th class="py-2 px-4 border-b">Precio</th>
                                    <th class="py-2 px-4 border-b">Cantidad</th>
                                    <th class="py-2 px-4 border-b">Subtotal</th>
                                    <th class="py-2 px-4 border-b"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($lista_carrito == null) { ?>
                                    <tr>
                                        <td colspan="4" class="py-4">No hay productos en el carrito</td>
                                    </tr>
                                    <?php } else {
                                    $total = 0;
                                    foreach ($lista_carrito as $item) {
                                        if (empty($item)) continue;
                                        #print_r($item);


                                        $_id = $item['id'];
                                        $nombre = $item['nombre'];
                                        $precio = $item['precio'];
                                        $descuento = $item['descuento'];
                                        $cantidad = $item['cantidad'];
                                        $precio_desc = $precio - (($precio * $descuento) / 100);
                                        $subtotal = $cantidad * $precio_desc;
                                        $total += $cantidad * $precio_desc;
                                    ?>
                                        <tr>
                                            <td><?= $nombre ?></td>
                                            <td><?= MONEDA . number_format($precio_desc, 2, '.', ',') ?></td>
                                            <td>
                                                <input type="number" min="0" value="<?= $cantidad ?>" id="cantidad_<?= $_id ?>"
                                                    onchange="actualizaCantidad(this.value,<?= $_id ?>)" />
                                            </td>
                                            <td>
                                                <div id="subtotal_<?= $_id; ?>" name="subtotal[]">
                                                    <p><?= MONEDA . number_format($subtotal, 2, '.', ',') ?></p>
                                                </div>
                                            </td>
                                            <td><a href="#" id="eliminar" data-bs-id="<?= $_id ?>" data-bs-toogle="modal"
                                                    data-bs-target="eliminaModal">Eliminar</a></td>

                                        </tr>
                                    <?php } ?>
                                    <td>
                                        <p id="total"><?= MONEDA . number_format($total, 2, '.', ',') ?></p>


                                    </td>
                                <?php } ?>
                                <div>
                                    <button>Realizar pago</button>
                                </div>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>






            <script>
                function actualizaCantidad(cantidad, id) {

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
                        .then(response => response.json())

                        .then(data => {
                            console.log("Respuesta cruda:", data);

                            if (data.ok) {
                                let divSubtotal = document.getElementById('subtotal_' + id);
                                if (divSubtotal) {
                                    divSubtotal.innerHTML = data.sub;
                                }

                                let divTotal = document.getElementById('total');
                                if (divTotal) {
                                    divTotal.innerHTML = data.total;
                                    console.log("El total es:", divTotal);
                                }

                            }
                        })


                }
            </script>


    </body>

</html>