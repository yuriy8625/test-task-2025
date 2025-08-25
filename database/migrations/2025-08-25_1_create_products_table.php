<?php

use Core\Database\DB;

return new class extends \Core\Database\Migration {

    public function run(): void
    {
        DB::getInstance()->getConnection()->exec("
            CREATE TABLE IF NOT EXISTS products (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(150) NOT NULL UNIQUE,
                price DECIMAL(8,2) NOT NULL,
                INDEX idx_title (title)
            )
        ");
    }
};
