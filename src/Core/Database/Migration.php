<?php

declare(strict_types=1);

namespace Core\Database;

abstract class Migration
{
    abstract public function run();
}