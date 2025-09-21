<?php

require '../config/config.php';


if (isset($_POST['id'])) {

    $id = $_POST['id']; //viene desde formData
    $token = $_POST['token'];
    $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 0;
    $restar   = isset($_POST['restarUno']) ? (int)$_POST['restarUno'] : 0;
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp) {

        if (isset($_SESSION['carrito']['productos'][$id])) {
            $_SESSION['carrito']['productos'][$id] += 1;
        } else {
            $_SESSION['carrito']['productos'][$id] = 1;
        }


        $datos['numero'] = count($_SESSION['carrito']['productos']);
        $datos['ok'] = true;
    } else {
        $datos['ok'] = false;
    }
} else {
    $datos['ok'] = false;
}

header('Content-Type: application/json');  //le digo al navegador que lo que devuelvo es un jsn
echo json_encode($datos); #Convierte el array asociativo de PHP ($datos) en un string en formato JSON.
#transforma en {"numero": 3, "ok" : true}

#echo envia ese string el JSON como respuesta al navegador
#osea lo manda de vuelta a JavaScript como si fuera el “resultado” del fetch

//$_SESSION = [
//  "carrito" => [
//    "productos" => [
//        15 => 2,   // id=15, cantidad=2
//       20 => 1    // id=20, cantidad=1
//    ]
//]
//];