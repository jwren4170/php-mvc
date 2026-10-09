<?php

namespace App\Controllers;

use App\Models\Product;
use Framework\Viewer;

class Products
{
    public function index()
    {
        $products = (new Product())->getProducts();

        $viewer = new Viewer();

        echo $viewer->render('Products/index', compact('products'));
    }

    public function show(string $id)
    {
        $product = (new Product())->getProduct($id);

        $viewer = new Viewer();

        echo $viewer->render('Products/show', compact('product'));
    }
}
