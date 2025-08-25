<?php

declare(strict_types=1);

namespace Core\Router;

use Core\Support\Config;
use Core\Support\Request;
use Core\Support\Response;

class Router
{
    protected array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    public function __construct()
    {
        $this->loadRoutes();
    }

    public function loadRoutes(): void
    {
        $filePath = Config::getInstance()->get('app.route_path') . '/routes.php';
        if (!file_exists($filePath)) {
            throw new \RuntimeException("Routes file not found: {$filePath}");
        }

        $router = $this;
        require $filePath;
    }

    public function get(string $path, array|callable $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, array|callable $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    public function put(string $path, array|callable $handler): void
    {
        $this->addRoute('PUT', $path, $handler);
    }

    public function delete(string $path, array|callable $handler): void
    {
        $this->addRoute('DELETE', $path, $handler);
    }

    private function addRoute(string $method, string $path, array|callable $handler): void
    {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', preg_quote($path, '/'));
        $pattern = '/^' . $pattern . '$/';
        $this->routes[$method][] = ['pattern' => $pattern, 'handler' => $handler];
    }

    public function dispatch(Request $req): void
    {
        if (!isset($this->routes[$req->method()])) {
            echo Response::text('404 Not Found', 404);
            return;
        }

        foreach ($this->routes[$req->method()] as $route) {
            if (preg_match($route['pattern'], $req->uri(), $matches)) {
                $params = array_values(array_filter($matches, fn($key) => !is_int($key), ARRAY_FILTER_USE_KEY));
                $handler = $route['handler'];

                if (is_array($handler)) {
                    [$class, $methodName] = $handler;
                    $controller = new $class();
                    $response = call_user_func_array([$controller, $methodName], $params);
                } else {
                    $response = call_user_func_array($handler, $params);
                }

                echo $response;
                return;
            }
        }



        echo Response::text('404 Not Found', 404);
    }
}
