<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require 'controller/plantillaController.php';
require 'controller/productosController.php';
require 'controller/enlacesController.php';
require 'model/productosModel.php';
require 'model/enlacesModel.php';
require 'clases/actualizar_carrito.php';


define("KEY_TOKEN", "TOKEN");
define("MONEDA", "ARS ");

define('DB_HOST', 'mysql:host=localhost;dbname=tienda_online;charset=utf8');
define('DB_USER', 'root');
define('DB_PASS', '');


$_SESSION['carrito']['producto'] = "";
$_SESSION['carrito']['cantidad'] = "";
$_SESSION['carrito']['precio'] = "";



$plantilla = new plantillaController();
$plantilla->ctrTraerPlantilla();
