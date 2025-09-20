<!DOCTYPE html>
<html lang="en">

<body>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Tailwind-->
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Tienda online</title>

    <body class="bg-gray-100">

        <div class="flex justify-between items-center bg-gray-50 py-5 px-20 ">
            <div>Logo</div>
            <div class="flex gap-x-5" id="menu">
                <a href="">Inicio</a>
                <a href="">Salir</a>
            </div>
        </div>
        <div>

            <div class="max-w-6xl mx-auto py-10 px-5">
                <h1 class="text-2xl font-bold mb-6">Nuestros productos</h1>

                <!-- Contenedor de productos -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- Producto 1 -->
                    <?php foreach ($resul as $item) { ?>
                    <div class="bg-white shadow-md rounded-2xl p-4 flex flex-col items-center">
                        <div class="w-full h-40 bg-gray-300 rounded-lg flex items-center justify-center">
                            <span class="text-gray-600">Imagen</span>
                        </div>
                        <h2 class="mt-4 font-semibold text-lg"><?= $item['nombre'] ?></h2>
                        <p class="text-gray-500 text-sm"><?= $item['descripcion'] ?></p>
                        <p class="text-gray-500 text-sm">$<?= number_format($item['precio'], 2, ',', '.'); ?></p>
                        <button class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            Comprar
                        </button>
                    </div>
                    <?php } ?>


                </div>
                </head>



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
                </script>


    </body>

</html>