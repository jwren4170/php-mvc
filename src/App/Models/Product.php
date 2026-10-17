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

    public function getProducts(): array|bool
    {
        $conn = $this->conn->getConnection();

        $sql = 'SELECT * FROM product';
        $stmt = $conn->query($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProduct(string $id)
    {
        $conn = $this->conn->getConnection();

        $sql = 'SELECT * FROM product WHERE id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}
