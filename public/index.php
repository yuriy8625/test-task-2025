<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

// Initialize the application and run
$app = Core\Application::getInstance();

$app->run();
