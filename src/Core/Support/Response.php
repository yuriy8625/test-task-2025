<?php

declare(strict_types=1);

namespace Core\Support;

class Response
{
    public static function json(array $data, int $status = 200): string
    {
        http_response_code($status);
        header("Content-Type: application/json; charset=utf-8");
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public static function text(string $content, int $status = 200): string
    {
        http_response_code($status);
        header("Content-Type: text/plain; charset=utf-8");
        return $content;
    }

    public static function html(string $content, int $status = 200): string
    {
        http_response_code($status);
        header("Content-Type: text/html; charset=utf-8");
        return $content;
    }

    public static function redirect(string $url, int $status = 302): void
    {
        http_response_code($status);
        header("Location: " . $url);
        exit;
    }
}
