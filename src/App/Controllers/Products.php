<?php
// enforce strict types
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Product;
use Framework\Exceptions\PageNotFoundException;
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
        $products = $this->model->findAll();

        echo $this->viewer->render('shared/header', compact('title'));
        echo $this->viewer->render('Products/index', compact('products'));
        echo $this->viewer->render('shared/footer');
    }

    public function show(string $id)
    {
        $title = 'Product Details';
        $product = $this->model->findOne($id);

        if (!$product)
            throw new PageNotFoundException('Product not found');

        echo $this->viewer->render('shared/header', compact('title'));
        echo $this->viewer->render('Products/show', compact('product'));
        echo $this->viewer->render('shared/footer');
    }

    public function showPage(string $title, string $id, string $page)
    {
        echo $title . ' ' . $id . ' ' . $page;
    }

    public function new()
    {
        $title = 'New Product';

        echo $this->viewer->render('shared/header', compact('title'));
        echo $this->viewer->render('Products/new');
        echo $this->viewer->render('shared/footer');
    }

    public function create()
    {
        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
        ];

        var_dump($this->model->insert($data));
    }
}
