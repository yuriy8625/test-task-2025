<?php

namespace App\Services\Product\Repository;

use App\Services\Product\DTO\ProductDTO;
use Core\Support\Repository;

class ProductRepository extends Repository
{
    public function updateOrCreate(ProductDTO $productDTO): int
    {
        $stmt = $this->pdo->prepare("
                INSERT INTO products (title, price)
                VALUES (:title, :price)
                ON DUPLICATE KEY UPDATE price = :price
            ");
        $stmt->execute([
            'title' => $productDTO->title,
            'price' => $productDTO->price
        ]);

        return $this->pdo->lastInsertId();
    }

    public function getIdByTitle(string $title): ?int
    {
        $stmt = $this->pdo->prepare("SELECT id FROM products WHERE title = :title");
        $stmt->execute(['title' => $title]);

        return $stmt->fetchColumn();
    }
}