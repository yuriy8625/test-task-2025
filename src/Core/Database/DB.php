<?php

declare(strict_types=1);

namespace Core\Database;

use Core\Database\Connector\Connector;
use PDO;
use PDOException;

class DB
{
    private static ?self $instance = null;
    private ?PDO $connection = null;

    private function __construct()
    {
        $this->connect();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect(): void
    {
        if ($this->connection !== null) {
            return;
        }

        try {
            $this->connection = Connector::connectionFactory();
        } catch (PDOException $e) {
            throw new \RuntimeException("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            $this->connect();
        }
        return $this->connection;
    }

    // Prevent cloning of the instance
    private function __clone() {}

    public function __wakeup(): void
    {
        throw new \RuntimeException("Cannot unserialize singleton");
    }
}
