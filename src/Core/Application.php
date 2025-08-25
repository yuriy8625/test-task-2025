<?php

declare(strict_types=1);

namespace Core;

use Core\Router\Router;
use Core\Support\Env;
use Core\Support\Request;
use Core\Support\Response;

class Application
{
    private static ?Application $instance = null;

    protected Router $router;
    protected Request $request;
    protected Response $response;
    public Env $env;

    private function __construct()
    {
        $this->env = Env::getInstance();

        $this->startSession();
        $this->router = new Router();
        $this->request = new Request();
        $this->response = new Response();
    }
    
    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function __clone()
    {
    }

    public static function getInstance(): Application
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function run(): void
    {
        $this->router->dispatch($this->request);
    }

    public function response(): Response
    {
        return $this->response;
    }
    public function request(): Request
    {
        return $this->request;
    }
    public function router(): Router
    {
        return $this->router;
    }
    public function env(): Env
    {
        return $this->env;
    }
}
