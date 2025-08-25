<?php

use App\Controllers\Api\ProductController;
use Core\Router\Router;

/** @var $router Router */
$router->get('/api/products', [ProductController::class, 'index']);
$router->post('/api/import', [ProductController::class, 'import']);
