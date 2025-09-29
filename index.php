<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


define("KEY_TOKEN", "TOKEN");
define("MONEDA", "ARS ");
define('DB_HOST', 'mysql:host=localhost;dbname=tienda_online;charset=utf8');
define('DB_USER', 'root');
define('DB_PASS', '');

require 'controller/plantillaController.php';
require 'controller/productosController.php';
require 'controller/enlacesController.php';
require 'model/productosModel.php';
require 'model/enlacesModel.php';
require 'clases/actualizar_carrito.php';




if (!isset($_SESSION['carrito'])) { //comprobamos que exista para no pisar lo que ya tengo en el carritp
    $_SESSION['carrito'] = [];
}
#session_unset();    // limpia todas las variables de $_SESSION
#session_destroy();  // destruye la sesión actual





$plantilla = new plantillaController();
$plantilla->ctrTraerPlantilla();
