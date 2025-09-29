<?php


class productosController
{


    public function productosController()
    {

        return ProductosModel::traerProductosModel('productos');
    }




    #Para traerme el producto

    public static function getProductoControllerId($id)
    {


        return ProductosModel::getProductoModelId("productos", $id);
    }
}
