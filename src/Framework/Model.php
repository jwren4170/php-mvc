<?php

// enable strict types
declare(strict_types=1);

namespace Framework;

use App\Database;
use PDO;

abstract class Model
{
    /** @disregard */
    protected $table;

    public function __construct(
        private Database $conn
    ) {}

    private function getTable(): string
    {
        if ($this->table !== null)
            return $this->table;
        else
            $parts = explode('\\', $this::class);

        return strtolower(array_pop($parts));
    }

    public function findAll(): array|bool
    {
        $conn = $this->conn->getConnection();

        $sql = 'SELECT * FROM ' . $this->getTable();
        $stmt = $conn->query($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findOne(string $id)
    {
        $conn = $this->conn->getConnection();

        $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function insert(array $data)
    {
        $sql = 'INSERT INTO product(name, description) VALUES(?,?)';

        $conn = $this->conn->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(2, $data['description'], PDO::PARAM_STR);
        return $stmt->execute();
    }
}
