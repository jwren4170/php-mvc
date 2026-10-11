<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    public function getConnection(): PDO
    {
        $credentials = $this->getDatabaseCredentials();

        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ];

            return new PDO("pgsql:host={$credentials['DB_HOST']};port={$credentials['DB_PORT']};dbname={$credentials['DB_NAME']}", $credentials['DB_USER'], $credentials['DB_PASSWORD'], $options);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
    }

    private function getDatabaseCredentials(): array
    {
        $values = parse_ini_file(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . '.env', false, INI_SCANNER_RAW);

        if ($values === false) {
            throw new \RuntimeException('Unable to read .env file.');
        }

        $values = array_merge($values, $_ENV);

        return $values;
    }
}