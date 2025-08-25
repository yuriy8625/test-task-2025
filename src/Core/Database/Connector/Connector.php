<?php

namespace Core\Database\Connector;

use Core\Support\Config;
use RuntimeException;

class Connector
{
    public static function connectionFactory(): \PDO
    {
        $config = self::getConfig();

        $driver = $config['driver'] ?? '';
        $connector = match ($config['driver']) {
            'mysql' => new MysqlConnector(),
            default => throw new RuntimeException("Unsupported driver: $driver"),
        };

        if (!$connector instanceof ConnectionInterface) {
            throw new RuntimeException("Connector must implement ConnectionInterface");
        }

        return $connector->connect($config);
    }

    protected static function getConfig(): bool|array|string
    {
        $config = Config::getInstance()->get('database.connections.' . getenv('DB_CONNECTION'));

        if (!$config) {
            throw new RuntimeException("Database connection not found");
        }

        return $config;
    }
}