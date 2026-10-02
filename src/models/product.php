<?php

class Product
{

    public function getProducts()
    {
        $host = 'localhost';
        $user = 'jword';
        $password = 'intune67';
        $database = 'php_mvc';
        $port = 5432;

        try {

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ];

            $conn = new PDO("pgsql:host=$host;port=$port;dbname=$database", $user, $password, $options);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }


        $sql = "SELECT * FROM product";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
