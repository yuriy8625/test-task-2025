<?php

namespace Core\Support;

use Core\Database\DB;
use PDO;

abstract class Repository
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::getInstance()->getConnection();
    }
}