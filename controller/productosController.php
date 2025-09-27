<?php


class productosController
{


    public function productosController()
    {

        return ProductosModel::traerProductosModel('productos');
    }

    public function productosControllerId($id)
    {

        return ProductosModel::traerProductoPorId("productos", $id);
    }


    #Para traerme el producto

    public static function getProductoControllerId($id)
    {


        return ProductosModel::getProductoModelId("productos", $id);
    }
}
