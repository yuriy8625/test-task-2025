<?php

namespace App\Services\Product\Repository;

use App\Services\Product\DTO\ProductPropertyDTO;
use Core\Support\Repository;

class ProductPropertyRepository extends Repository
{
    public function updateOrCreate(ProductPropertyDTO $propertyDTO): int
    {
        $stmt = $this->pdo->prepare("
                INSERT INTO product_properties (product_id, name, value)
                VALUES (:product_id, :name, :value)
                ON DUPLICATE KEY UPDATE value = :value
            ");

        $stmt->execute([
            'product_id' => $propertyDTO->product_id,
            'name' => $propertyDTO->name,
            'value' => $propertyDTO->value
        ]);

        return $this->pdo->lastInsertId();
    }
}