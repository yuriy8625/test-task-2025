<?php

namespace Core\Database\Connector;

use PDO;
use PDOException;

class MysqlConnector implements ConnectionInterface
{

    public function connect(array $config): PDO
    {
        try {
            $dsn = sprintf(
                '%s:host=%s;port=%s;dbname=%s;charset=%s',
                $config['driver'],
                $config['host'],
                $config['port'],
                $config['database'],
                $config['charset']
            );

            return new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                $config['options'] ?? []
            );
        } catch (PDOException $e) {
            throw new \RuntimeException("Database connection failed: " . $e->getMessage());
        }
    }
}