<?php

use App\Controllers\ProductController;

/** @var $router \Core\Router\Router */
$router->get('/', [ProductController::class, 'catalog']);
$router->get('/sale', [ProductController::class, 'sale']);
