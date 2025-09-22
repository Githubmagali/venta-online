<?php
require '../config/config.php';
require '../config/database.php';


if (isset($_POST['id'])) {

    $id = $_POST['id']; //viene desde formData
    $token = $_POST['token'];
    $cantidad = $_POST['cantidad'];
    $restar   = isset($_POST['restarUno']) ? (int)$_POST['restarUno'] : 0;
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp) {



        if (isset($_SESSION['carrito']['productos'][$id])) {
            $_SESSION['carrito']['productos'][$id] += $cantidad;
        } else {
            $_SESSION['carrito']['productos'][$id] = $cantidad;
        }
        $data['numero'] = array_sum($_SESSION['carrito']['productos']);
        $data['ok'] = true;
    } else {
        $data['ok'] = false;
    }
} else {
    $data['ok'] = false;
}

header('Content-Type: application/json');  //le digo al navegador que lo que devuelvo es un jsn
echo json_encode($data); #Convierte el array asociativo de PHP ($datos) en un string en formato JSON.
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