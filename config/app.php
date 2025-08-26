<?php

declare(strict_types=1);

return [
    'app_name' => getenv('APP_NAME'),

    'base_path' => dirname(__DIR__),
    'view_path' => dirname(__DIR__) . '/views',
    'route_path' => dirname(__DIR__) . '/routes',
    'migration_path' => dirname(__DIR__) . '/database/migrations',
    'seeder_path' => dirname(__DIR__) . '/database/seeds',
    'commands' => [
        'migrate' => \App\Commands\MigrateCommand::class,
        'seed' => \App\Commands\SeedCommand::class,
    ],
];
