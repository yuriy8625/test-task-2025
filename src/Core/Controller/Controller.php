<?php

declare(strict_types=1);

namespace Core\Controller;

use Core\Application;

class Controller
{
    protected Application $app;

    public function __construct()
    {
        $this->app = Application::getInstance();
    }
}
