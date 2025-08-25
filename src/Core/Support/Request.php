<?php

declare(strict_types=1);

namespace Core\Support;

class Request
{
    public function method(): string
    {
        return strtoupper(trim($_SERVER['REQUEST_METHOD'] ?? 'GET'));
    }

    public function uri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        return parse_url($uri, PHP_URL_PATH) ?: '/';
    }

    public function input(?string $key = null, mixed $default = null): mixed
    {
        $data = $this->parseBody();

        return $key === null ? $data : ($data[$key] ?? $default);
    }

    private function parseBody(): array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (str_contains($contentType, 'application/json')) {
            $raw = file_get_contents("php://input");
            $decoded = json_decode($raw, true);
            return is_array($decoded) ? $decoded : [];
        }

        $method = $this->method();
        if ($method === 'GET') {
            return $_GET;
        } elseif ($method === 'POST') {
            return $_POST;
        } elseif (in_array($method, ['PUT', 'PATCH', 'DELETE'])) {
            $input = file_get_contents('php://input');
            parse_str($input, $parsed);
            return is_array($parsed) ? $parsed : [];
        }
        return [];
    }

}
