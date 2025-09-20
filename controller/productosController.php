<?php


class productosController
{


    public function productosController()
    {

        return ProductosModel::traerProductosModel('productos');
    }
}