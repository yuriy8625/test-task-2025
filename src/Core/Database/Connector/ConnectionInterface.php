<?php

namespace Core\Database\Connector;

use PDO;

interface ConnectionInterface
{
    public function connect(array $config): PDO;
}