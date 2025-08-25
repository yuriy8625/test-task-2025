<?php

declare(strict_types=1);

namespace Core\Console;

abstract class Command
{
    const SUCCESS = 0;
    const FAILURE = 1;

    abstract public function handle(): int;

    protected function success(string $message): void
    {
        $this->writeColored($message, '0;32');
    }

    protected function info(string $message): void
    {
        $this->writeColored($message, '0;36');
    }

    protected function warning(string $message): void
    {
        $this->writeColored($message, '1;33');
    }

    protected function error(string $message): void
    {
        $this->writeColored($message, '0;31');
    }

    private function writeColored(string $message, string $color): void
    {
        echo "\033[" . $color . "m" . $message . "\033[0m\n";
    }
}
