<?php

declare(strict_types=1);

namespace App\Commands;

use Core\Console\Command;
use Database\Seeder\SeederHandler;

class SeedCommand extends Command
{
    public function handle(): int
    {
        try {
            (new SeederHandler())->handle();
            $this->success('Seeding completed successfully');

            return Command::SUCCESS;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());

            return Command::FAILURE;
        }
    }
}