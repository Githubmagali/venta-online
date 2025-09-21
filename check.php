<?php
require 'config/database.php';
require 'config/config.php';

$db = new dataBase();
$con = $db->conectar();

$producto = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();
if ($producto != null) {

    foreach ($producto as $clave => $cantidad) {
        echo "Producto $clave: $cantidad unidades\n";

        $sql = $con->prepare("SELECT id, nombre, descripcion, precio, descuento, $cantidad AS cantidad FROM productos 
        WHERE id=? AND activo = 1");
        $sql->execute([$clave]);

        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);

        #print_r($lista_carrito);
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
                <a href="check.php">Carrito <span id="num_cart"><?= $num_cart ?></span></a>
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
                                    <th class="py-2 px-4 border-b">Subotal</th>
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


                                        $_id = $item['id'];
                                        $nombre = $item['nombre'];
                                        $precio = $item['precio'];
                                        $descuento = $item['descuento'];
                                        $precio_desc = $precio - (($precio * $descuento) / 100);
                                        $subtotal = $cantidad * $precio_desc;
                                        $total += $subtotal; ?>
                                <tr>
                                    <td><?= $nombre ?></td>
                                    <td><?= MONEDA . number_format($precio_desc, 2, '.', ',') ?></td>
                                    <td>
                                        <input type="number" min="" value="<?= $cantidad ?>" id="cantidad_<?= $_id ?>"
                                            onchange="actualizaCantidad(this.value,<?= $_id ?>)" />
                                    </td>
                                    <td>
                                        <div id="subtotal_<?= $_id; ?>" name="subtotal[]">
                                            <?= MONEDA . number_format($subtotal, 2, '.', ',');  ?>
                                        </div>
                                    </td>
                                    <td><a href="#" id="eliminar" data-bs-id="<?= $_id ?>" data-bs-toogle="modal"
                                            data-bs-target="eliminaModal">Eliminar</a></td>

                                </tr>
                                <?php } ?>
                                <td>
                                    <p><?= MONEDA . number_format($total, 2, '.', ',') ?></p>
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
            // Seleccionamos el contenedor del menú
            const menu = document.getElementById("menu");

            // Creamos el botón principal dinámicamente
            const toggleButton = document.createElement("button");
            toggleButton.textContent = "Abrir";
            toggleButton.className = "bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600";

            // Creamos el contenedor oculto de botones
            const extraButtons = document.createElement("div");
            extraButtons.className = "hidden flex gap-x-3"; // Oculto al inicio

            // Creamos los botones adicionales
            const btn1 = document.createElement("button");
            btn1.textContent = "Inicio";
            btn1.className = "bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600";

            const btn2 = document.createElement("button");
            btn2.textContent = "Configuración";
            btn2.className = "bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600";

            const btn3 = document.createElement("button");
            btn3.textContent = "Ayuda";
            btn3.className = "bg-purple-500 text-white px-3 py-1 rounded hover:bg-purple-600";

            // Metemos los botones al contenedor extra
            extraButtons.appendChild(btn1);
            extraButtons.appendChild(btn2);
            extraButtons.appendChild(btn3);

            // Insertamos el botón principal y el contenedor extra en el menú
            menu.appendChild(toggleButton);
            menu.appendChild(extraButtons);

            // Evento para mostrar u ocultar los botones extra
            toggleButton.addEventListener("click", () => {
                extraButtons.classList.toggle("hidden");
            });


            function actualizaCantidad(cantidad, id) {

                let url = 'clases/actualizar_carrito.php'
                let formData = new FormData()
                formData.append('action', 'agregar')
                formData.append('id', id)
                formData.append('cantidad', cantidad)

                fetch(url, {
                        method: 'POST',
                        body: formData,
                        code: 'cors'
                    }).then(response => response.json())
                    .then(data => {
                        console.log("Respuesta del servidor:", data);
                        if (data.ok) {
                            console.log("Respuesta del servidor:", data);

                            let divSubtotal = document.getElementById('subtotal_' + id)
                            console.log("Div total:", divSubtotal);
                            divSubtotal.innerHTML = data.divSubtotal

                        }
                    })
            }
            </script>


    </body>

</html>