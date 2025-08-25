<?php

declare(strict_types=1);

namespace Core\Database;

use Core\Support\Config;
use PDO;

abstract class Seeder
{
    protected string $seederPath;

    protected PDO $pdo;

    public function __construct()
    {
        $this->seederPath = Config::getInstance()->get('app.seeder_path');
        $this->pdo = DB::getInstance()->getConnection();
    }

    abstract public function handle();
}