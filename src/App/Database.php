<?php
// enforce strict types
declare(strict_types=1);

namespace App;

use PDO;
use PDOException;

class Database
{
    public function __construct(
        private array $credentials
    ) {}

    public function getConnection(): PDO
    {
        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ];

            return new PDO("pgsql:host={$this->credentials['DB_HOST']};port={$this->credentials['DB_PORT']};dbname={$this->credentials['DB_NAME']}", $this->credentials['DB_USER'], $this->credentials['DB_PASSWORD'], $options);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
    }
}
