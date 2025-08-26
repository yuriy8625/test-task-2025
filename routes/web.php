<?php

use App\Controllers\ProductController;

/** @var $router \Core\Router\Router */
$router->get('/', [ProductController::class, 'index']);
$router->get('/sale', [ProductController::class, 'catalog']);
