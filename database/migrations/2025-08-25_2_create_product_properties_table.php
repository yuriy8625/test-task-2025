<?php

use Core\Database\DB;

return new class extends \Core\Database\Migration
{

    public function run(): void
    {
        DB::getInstance()->getConnection()->exec("
            CREATE TABLE IF NOT EXISTS product_properties (
                id INT AUTO_INCREMENT PRIMARY KEY,
                product_id INT NOT NULL,
                name VARCHAR(50) NOT NULL,
                value VARCHAR(100),
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
                UNIQUE KEY uq_product_property (product_id, name)
            )
        ");
    }
};
