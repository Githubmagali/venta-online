<?php

if (isset($_POST['eliminar'])) {
    $id = $_POST['eliminar'];

    foreach ($_SESSION['carrito'] as $producto => $detalles) {
        if ($detalles['id'] == $id) {
            unset($_SESSION['carrito'][$producto]);
            break;
        }
    }

    header("Location: index.php?view=carrito");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<body class="">
    <div class="d-flex justify-content-between px-5 ">
        <div>Logo</div>
        <div class="d-flex justify-content-between px-5 gap-5" id="menu">
            <a href="index.php?view=inicio">Inicio</a>
            <a href="">Salir</a>
            <a href="index.php?view=check">volver</a>
        </div>
    </div>


    <main class="d-flex justify-content-center w-100">
        <div class="w-full max-w-4xl">
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 text-center">
                    <?php
                    $total = 0;

                    if (isset($_SESSION['carrito'])) {
                        foreach ($_SESSION['carrito'] as $indice => $arreglo) {
                            echo "<div class='border-b py-2'>";
                            echo "<strong>$indice</strong><br>";

                            $total += $arreglo['cantidad'] * $arreglo['precio'];

                            foreach ($arreglo as $key => $value) {
                                echo $key . ": " . $value . "<br>";
                            }

                            // Botón eliminar
                            echo " <form method='post' style='display:inline;'>
                               <input type='hidden' name='eliminar' value='{$arreglo['id']}'>
                                <button type='submit' class='btn btn-danger btn-sm'>Eliminar</button>
                                 </form> ";
                            echo "</div>";
                        }

                        echo "<h3>El total de la compra es de " . MONEDA . " $ $total</h3>";
                    }
                    ?>

                </table>
            </div>
        </div>
    </main>


</body>


</html>