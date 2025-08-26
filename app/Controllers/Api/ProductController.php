<?php

namespace App\Controllers\Api;

use App\Services\Product\Actions\ImportProductsAction;
use App\Services\Product\DTO\ProductDTO;
use App\Services\Product\DTO\ProductFilterDTO;
use App\Services\Product\Repository\ProductRepository;
use Core\Controller\Controller;
use Core\Support\DataTransferObject\DB\PaginationDTO;
use Core\Support\Env;
use Core\Support\Response;

class ProductController extends Controller
{
    public function index(): string
    {
        try {
            $productRepo = new ProductRepository();
            $data = $this->app->request()->input(default: []);
            $filter = ProductFilterDTO::fromArray($data);

            $products = $productRepo->filter($filter);
            $count = $productRepo->count();

            $result = new PaginationDTO($products, $count, $filter->page, $filter->limit);

            return Response::json($result->toArray(), 200);
        } catch (\Throwable $th) {
            return Response::json(['error' => 'Bad Request'], 400);
        }
    }

    /**
     * @throws \Exception
     */
    public function import(): string
    {
        try {
            $data = $this->app->request()->input(default: []);
            $products = ProductDTO::collection($data);

            $imported = (new ImportProductsAction())->handle($products);

            return Response::json($imported->toArray());
        } catch (\Throwable $th) {
            return Response::json(['error' => 'Bad Request'], 400);
        }
    }
}
