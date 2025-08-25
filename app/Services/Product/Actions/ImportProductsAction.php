<?php

namespace App\Services\Product\Actions;

use App\Services\Product\DTO\ImportedProductDTO;
use App\Services\Product\DTO\ProductDTO;
use App\Services\Product\ProductService;
use Core\Database\DB;
use Core\Support\DataTransferObject\DB\UpdateOrCreateDTO;
use PDO;

class ImportProductsAction
{
    protected ProductService $productService;

    protected PDO $pdo;

    protected int $imported = 0;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->pdo = DB::getInstance()->getConnection();
    }

    /**
     * @param array<ProductDTO> $products
     * @return int
     */
    public function handle(array $products): ImportedProductDTO
    {
        foreach ($products as $product) {
            try {
                $result = $this->productService->updateOrCreateProduct($product);
                $this->imported = in_array($result->action,  UpdateOrCreateDTO::ACTIVE_ACTIONS)
                    ? ++$this->imported
                    : $this->imported;

            } catch (\Exception $e) {
            }
        }

        return new ImportedProductDTO($this->imported);
    }
}