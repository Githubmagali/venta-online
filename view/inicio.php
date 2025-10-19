<?php

$datos = new productosController();
$resul = $datos->productosController();

#print_r($_SESSION);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda online</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
</head>
<style>
    .contenedor-img {
        width: 600px;
        height: 200px;
        background-image: url("img/borcegos-negros.png");
        background-size: cover;
        /* Recorta y llena todo */
        background-position: center;
        /* Centra la parte visible */
        background-repeat: no-repeat;
    }

    .contenedor-row-css {
        width: auto;
        height: 200px;
        overflow: hidden;
    }

    .contenedor-row-css-img {
        width: 100%;
        height: auto;
        object-fit: cover;
        /* para cortar el excedente */
        object-position: center;
        /*  para centrar la parte visible */
        display: block;
    }
</style>


<body class="d-flex flex-column  min-vh-100">

    <main class="flex-fill">
        <div
            class="col-12 d-flex flex-column flex-lg-row justify-content-lg-between py-3 bg-body-tertiary align-items-lg-center">
            <div class="mb-3 mb-lg-0">Logo</div>

            <div class="d-flex flex-column align-items-lg-center flex-lg-row gap-2 gap-lg-4" id="menu">
                <a href="index.php?view=inicio">Inicio</a>
                <a href="index.php?view=check">Comprar</a>
                <a href="index.php?view=carrito">Carrito</a>


                <div class="position-relative">
                    <input type="text" id="buscar" class="border rounded-5 border-dark" placeholder="Buscar...">
                    <div id="resultados" class="list-group position-absolute end-0 mt-1 shadow w-100">

                    </div>
                </div>
            </div>
        </div>



        <div class="max-w-6xl mx-auto py-10 px-5" style="padding-top: 80px;">

            <!-- Contenedor de productos -->
            <div class="container">
                <div class="row">
                    <?php foreach ($resul as $item) {
                    ?>
                        <div class="col-12 col-md-6 col-lg-3 mb-4">
                            <div class="card h-100">
                                <div class="contenedor-row-css">
                                    <img src="img/<?= $item['img'] ?>" class="contenedor-row-css-img" />
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h4 class="mt-4 font-semibold text-lg"><?= $item['nombre'] ?></h4>
                                    <p class="text-gray-500 text-sm"><?= $item['descripcion'] ?></p>
                                    <p class="text-gray-500 text-sm">
                                        $<?= number_format($item['precio'], 2, ',', '.'); ?>
                                    </p>
                                    <a class="mt-3 bg-blue-500  px-4 py-2 rounded-lg hover:bg-blue-600"
                                        href="index.php?view=detalles&id=<?= $item['id'] ?>&token=<?= hash_hmac('sha1', $item['id'], KEY_TOKEN) ?>">
                                        Detalles</a>

                                </div>


                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="d-flex align-content-center">
                    <div class="col-12 contenedor-img"></div>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#buscar").keyup(function() {
                let consulta = $(this).val();

                if (consulta != "") {
                    $.ajax({
                        url: "clases/buscar.php",
                        method: "POST",
                        data: {
                            query: consulta
                        },
                        success: function(data) {
                            $("#resultados").html(data);
                        }
                    });
                } else {
                    $("#resultados").html("");
                }
            });
        });
    </script>


</body>

</html>