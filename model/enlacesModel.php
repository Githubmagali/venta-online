<?php

class enlacesModel
{


    public static function enlacesModel($enlace)
    {
        switch ($enlace) {
            case 'inicio':
                $ruta = "view/inicio.php";
                break;
            case 'check':
                $ruta = "view/check.php";
                break;
            case 'checkout':
                $ruta = "view/checkout.php";
                break;
            case 'compras':
                $ruta = "view/compras.php";
                break;
            case 'detalles':
                $ruta = "view/detalles.php";
                break;
            case 'carritoNuevo':
                $ruta = "view/carritoNuevo.php";
                break;
            case 'ajax':
                $ruta = "view//ajax.php";
                break;
            case 'salir':
                $ruta = "view/salir.php";
                break;
            default:
                $ruta = "view/error404.php";
                break;
        }
        return $ruta;
    }
}