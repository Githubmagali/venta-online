<?php

define("KEY_TOKEN", "TOKEN");
define("MONEDA", "ARS ");


session_start();


$num_cart = 0;

if (isset($_SESSION['carrito']['productos'])) {
    $num_cart = array_sum($_SESSION['carrito']['productos']);
}

//$_SESSION = [
//  "carrito" => [
//    "productos" => [
//        15 => 2,   // id=15, cantidad=2
//       20 => 1    // id=20, cantidad=1
//    ]
//]
//];