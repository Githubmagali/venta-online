<?php
include 'conexion.php';

class ProductosModel
{


    public static function traerProductosModel($tabla)
    {

        $db = Conexion::conectar();


        $sql = $db->prepare("SELECT id, nombre, descripcion, precio FROM $tabla WHERE activo = 1");

        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }


    #Traerme el precio y el descueto por ID

    public static function traerProductoPorId($tabla, $id)
    {

        $db = Conexion::conectar();

        $sql = $db->prepare("SELECT precio, descuento FROM $tabla WHERE id = $id AND activo = 1");

        if ($sql->execute()) {
            return $sql->fetch(PDO::FETCH_ASSOC);
        }
    }

    #Traerme el producto 

    public static function getProductoModelId($tabla, $id)
    {

        $db = Conexion::conectar();
        #COUNT(id) te dice cuántos registros cumplen la condición
        $stmt = $db->prepare("SELECT COUNT(id) FROM $tabla WHERE id =? AND activo = 1");
        $stmt->execute([$id]);
        $resultado = $stmt->fetchColumn();

        if ($resultado > 0) {

            $stmt = $db->prepare("SELECT nombre, descripcion, precio, descuento FROM $tabla WHERE id = ? AND activo = 1 LIMIT 1");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row;
        }
        return false;
    }
}
