<?php

class dataBase
{

    private $hostName = 'localhost';
    private $database = 'tienda_online';
    private $userName = 'root';
    private $password = '';
    private $charset = 'utf8';

    function conectar()
    {
        try {
            $conexion = "mysql:host={$this->hostName};dbname={$this->database};charset={$this->charset}";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $pdo = new PDO($conexion, $this->userName, $this->password, $options);

            return $pdo;
        } catch (PDOException $e) {

            echo 'Error conexion:' . $e->getMessage();
            exit;
        }
    }
}
