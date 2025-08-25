<?php

namespace App\Controllers\Api;

use App\Services\Product\Actions\ImportProductsAction;
use App\Services\Product\DTO\ProductDTO;
use Core\Controller\Controller;
use Core\Database\DB;
use Core\Support\Response;

class ProductController extends Controller
{
    public function index(): string
    {
        $pdo = DB::getInstance()->getConnection();
        $sort = $_GET['sort'] ?? 'title';
        $page = (int)($_GET['page'] ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $stmt = $pdo->query("SELECT * FROM products ORDER BY $sort LIMIT $limit OFFSET $offset");
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return Response::json($products, 200);
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
