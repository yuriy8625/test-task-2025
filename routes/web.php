<?php

use App\Controllers\HomeController;

/** @var $router \Core\Router\Router */
$router->get('/', [HomeController::class, 'index']);
