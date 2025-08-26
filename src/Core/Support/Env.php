<?php

namespace Core\Support;

class Env
{
    private static ?Env $instance = null;

    private function __construct()
    {
        $this->loadEnv();
    }

    public static function getInstance(): Env
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function loadEnv(): void
    {
        $config = parse_ini_file(__DIR__ . '/../../../.env');

        if (!$config) {
            return;
        }

        foreach ($config as $name => $value) {
            putenv("$name=$value");
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }

    public static function get(string $key, $default = null): bool|array|string
    {
        return getenv($key) ?: $default;
    }

    public static function all(): array
    {
        return getenv();
    }
}