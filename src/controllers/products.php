<?php

class Products
{
    public function index()
    {
        require 'src/models/product.php';
        $products = new Product()->getProducts();
        require './views/products_index.php';
    }
}
