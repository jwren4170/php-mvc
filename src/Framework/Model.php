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

    abstract protected function validate(array $data): bool;

    public function __construct(
        private Database $conn,
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
        if (!$this->validate($data)) {
            return false;
        }

        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = 'INSERT INTO ' . $this->getTable() . ' (' . $columns . ') VALUES (' . $placeholders . ')';

        $conn = $this->conn->getConnection();
        $stmt = $conn->prepare($sql);

        $i = 1;
        foreach ($data as $value) {
            $type = match (gettype($value)) {
                'boolean' => PDO::PARAM_BOOL,
                'integer' => PDO::PARAM_INT,
                'null' => PDO::PARAM_NULL,
                default => PDO::PARAM_STR,
            };

            $stmt->bindValue($i++, $value, $type);
        }

        return $stmt->execute();
    }
}
