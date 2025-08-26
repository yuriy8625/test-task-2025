<?php

namespace App\Services\Product\Repository;

use App\Services\Product\DTO\ProductFilterDTO;
use App\Services\Product\DTO\ProductDTO;
use Core\Support\Repository;

class ProductRepository extends Repository
{
    public function filter(ProductFilterDTO $filter): bool|array
    {
        $offset = ($filter->page - 1) * $filter->limit;
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM products
            ORDER BY {$filter->sort} {$filter->direction} 
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', (int)$filter->limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function count()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM products");
        return (int)$stmt->fetchColumn();
    }

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