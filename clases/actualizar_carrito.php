<?php
require '../config/config.php';
require '../config/database.php';


if (isset($_POST['action'])) {


    $action = $_POST['action'];
    $id = isset($_POST['id']) ? $_POST['id'] : 0;

    if ($action == 'agregar') {

        $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;
        $respuesta = agregar($id, $cantidad);
        if ($respuesta > 0) {
            $datos['ok'] = true;
        } else {
            $datos['ok'] = false;
        }

        $datos['sub'] = MONEDA . number_format($respuesta, 2, '.', ',');
        $datos['total'] = MONEDA . number_format(calcularTotal(), 2, '.', ',');
    } else {
        $datos['ok'] = false;
    }
} else {
    $datos['ok'] = false;
}

header('Content-Type: application/json');
echo json_encode($datos);
exit;

function agregar($id, $cantidad)
{



    $res = 0;

    if ($id > 0 && $cantidad > 0 && is_numeric(($cantidad))) {
        if (isset($_SESSION['carrito']['productos'][$id])) {
            $_SESSION['carrito']['productos'][$id] = $cantidad;

            $db = new dataBase();
            $con = $db->conectar();
            $sql = $con->prepare("SELECT precio, descuento FROM
            productos WHERE id=? AND activo = 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
            $res = $cantidad * $precio_desc;

            return $res;
        } else {
            return $res;
        }
    }
}

function calcularTotal()
{

    $total = 0;

    if (isset($_SESSION['carrito']['productos'])) {

        $db = new dataBase();
        $con = $db->conectar();

        foreach ($_SESSION['carrito']['productos'] as $id =>  $cantidad) {
            $sql = $con->prepare("SELECT precio, descuento FROM productos WHERE id=? AND activo = 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $precio_desc = $row['precio'] - (($row['precio'] * $row['descuento']) / 100);
                $total += $cantidad * $precio_desc;
            }
        }
    }
    return $total;
}
