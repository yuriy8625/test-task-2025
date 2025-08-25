<?php

namespace Database\Seeder;

use App\Services\Product\Actions\ImportProductsAction;
use App\Services\Product\DTO\ProductDTO;
use Core\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function handle(): void
    {
        try {
            $data = require __DIR__ . '/data/products.php';
            $products = ProductDTO::collection($data);

            $action = new ImportProductsAction();
            $action->handle($products);
        } catch (\Exception $e) {
            throw new \Exception('Error when seeding products: ' . $e->getMessage());
        }
    }
}