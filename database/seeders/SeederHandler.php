<?php

namespace Database\Seeder;

final class SeederHandler
{
    protected static array $seeders = [
        ProductSeeder::class,
    ];

    public static function handle(): void
    {
        /** @var <class-string> $seeder Seeder */
        array_map(fn($seeder) => (new $seeder)->handle(), self::$seeders);
    }
}