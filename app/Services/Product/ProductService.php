<?php

namespace App\Services\Product;

use App\Services\Product\DTO\ProductDTO;
use App\Services\Product\DTO\ProductPropertyDTO;
use App\Services\Product\Repository\ProductPropertyRepository;
use App\Services\Product\Repository\ProductRepository;
use Core\Database\DB;
use Core\Support\DataTransferObject\DB\UpdateOrCreateDTO;

class ProductService
{
    protected ProductRepository $productRepository;
    protected ProductPropertyRepository $productPropertyRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
        $this->productPropertyRepository = new ProductPropertyRepository();
    }

    /**
     * Update or Create Product.
     *
     * @param ProductDTO $productDTO
     * @return UpdateOrCreateDTO
     * @throws \Exception
     */
    public function updateOrCreateProduct(ProductDTO $productDTO): UpdateOrCreateDTO
    {
        $pdo = DB::getInstance()->getConnection();
        $pdo->beginTransaction();

        try {
            $productId = $this->productRepository->updateOrCreate($productDTO);
            $action = $productId ? UpdateOrCreateDTO::UPDATED : UpdateOrCreateDTO::NO_ACTION;
            if (!$productId) { // If the product already existed, we get its ID
                $productId = $this->productRepository->getIdByTitle($productDTO->title);
            }

            if ($productId && $productDTO->properties) {
                $this->updateOrCreateProperties($productId, $productDTO->properties);
            }

            $pdo->commit();
            return new UpdateOrCreateDTO($productId, $action);
        } catch (\Exception $e) {
            $pdo->rollBack();
            throw new \Exception('Error when updating or creating product: ' . $e->getMessage());
        }
    }


    /**
     * Update or Create Product Properties.
     *
     * @param int $productId
     * @param array<string, mixed> $properties
     * @return bool
     */
    protected function updateOrCreateProperties(int $productId, array $properties): bool
    {
        $updateOrCreate = false;
        foreach ($properties as $name => $value) {
            $property = new ProductPropertyDTO($productId, $name, $value);
            $id = $this->productPropertyRepository->updateOrCreate($property);
            $updateOrCreate = $id ? true : $updateOrCreate;
        }

        return $updateOrCreate;
    }
}