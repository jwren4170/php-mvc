<?php

namespace App\Controllers;

use App\Models\Product;
use Framework\Viewer;

class Products
{
    public function __construct(
        private Viewer $viewer,
        private Product $model,
    ) {}

    public function index()
    {
        $title = 'Products';
        $products = $this->model->getProducts();

        echo $this->viewer->render('shared/header', compact('title'));
        echo $this->viewer->render('Products/index', compact('products'));
        echo $this->viewer->render('shared/footer');
    }

    public function show(string $id)
    {
        $title = 'Product Details';
        $product = $this->model->getProduct($id);

        echo $this->viewer->render('shared/header', compact('title'));
        echo $this->viewer->render('Products/show', compact('product'));
        echo $this->viewer->render('shared/footer');
    }
}