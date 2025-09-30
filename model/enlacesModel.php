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
            case 'detalles':
                $ruta = "view/detalles.php";
                break;
            case 'carrito':
                $ruta = "view/carrito.php";
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
