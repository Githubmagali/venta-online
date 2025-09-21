<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define("KEY_TOKEN", "TOKEN");
define("MONEDA", "ARS ");


session_start();


$num_cart = 0;


if (isset($_SESSION['carrito']['productos'])) {
    $num_cart = count($_SESSION['carrito']['productos']);
}

#print_r($_SESSION);






//$_SESSION = [
//  "carrito" => [
//    "productos" => [
//        15 => 2,   // id=15, cantidad=2
//       20 => 1    // id=20, cantidad=1
//    ]
//]
//];