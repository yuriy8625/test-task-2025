<?php

declare(strict_types=1);

namespace Core\Console;

use Core\Support\Config;
use Core\Support\Env;

final class ConsoleHandler
{
    public function __construct(
        readonly array $argv)
    {
        Env::getInstance();
    }

    /**
     * @throws \Exception
     */
    public function run(): int
    {
        return $this->getCommand()->handle();
    }

    /**
     * @throws \Exception
     */
    protected function getCommand(): Command
    {
        $command = $this->argv[1] ?? null;
        $commands = Config::getInstance()->get('app.commands', []);

        /** @var ?Command $class */
        $class = $commands[$command] ?? null;
        if ($class) {
            return new $commands[$command]();
        }

        throw new \Exception('Command not found');
    }
}