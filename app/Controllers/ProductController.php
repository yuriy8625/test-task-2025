<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller\Controller;
use Core\View\View;

class ProductController extends Controller
{
    /**
     * @throws \Exception
     */
    public function catalog(): string
    {
         return View::render('products/catalog');
    }

    /**
     * @throws \Exception
     */
    public function sale(): string
    {
        return View::render('products/sale');
    }
}
