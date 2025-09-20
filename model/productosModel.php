<?php
require 'config/database.php';

class ProductosModel
{


    public static function traerProductosModel($tabla)
    {

        $db = new dataBase();

        $stmt = $db->conectar();

        $sql = $stmt->prepare("SELECT * from $tabla where activos = 1 ");

        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}