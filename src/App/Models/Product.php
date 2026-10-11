<?php

namespace App\Models;

use App\Database;
use PDO;
use PDOException;

class Product
{
    public function __construct(
        private Database $conn
    ) {}

    public function getProducts()
    {
        $conn = $this->conn->getConnection();

        $sql = 'SELECT * FROM product';
        $stmt = $conn->query($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProduct(string $id)
    {
        $host = 'localhost';
        $user = 'jword';
        $password = 'intune67';
        $database = 'php_mvc';
        $port = 5432;

        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ];

            $conn = new PDO("pgsql:host=$host;port=$port;dbname=$database", $user, $password, $options);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }

        $sql = 'SELECT * FROM product WHERE id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}