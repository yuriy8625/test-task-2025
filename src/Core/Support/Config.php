<?php
declare(strict_types=1);

namespace Core\Support;

class Config
{
    private static ?self $instance = null;
    private array $config = [];

    private string $configPath;

    private function __construct()
    {
        $this->configPath = realpath(__DIR__ . '/../../../config');

        if (is_dir($this->configPath)) {
            foreach (glob($this->configPath . '/*.php') as $file) {
                $key = pathinfo($file, PATHINFO_FILENAME);
                $this->config[$key] = require $file;
            }
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get(string $key, mixed $default = null): string|array|bool|null
    {
        $keys = explode('.', $key);
        $value = $this->config;

        foreach ($keys as $segment) {
            if (is_array($value) && array_key_exists($segment, $value)) {
                $value = $value[$segment];
            } else {
                return $default;
            }
        }

        return $value;
    }

    public function all(): array
    {
        return $this->config;
    }
}
