<?php

namespace App\Controllers;

use App\Services\ProductService;
use App\Services\JwtService;
use App\Services\CartService;

class ProductController extends BaseController
{
    protected $productService, $jwtService, $cartService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->jwtService = new JwtService();
        $this->cartService = new CartService();
    }

    public function productData()
    {

           
           return  $this->productService->getProducts();

           
    }

    public function getProduct($id)
    {

            return $this->productService->getProduct($id);

          
    }

    public function addProduct()
    {

        return $this->productService->addProduct();
    }

    public function updateProduct($id)
    {

            return $this->productService->updateProduct($id);

           
    }

    public function deleteProduct($id)
    {

        return $this->productService->deleteProduct($id);
    }

    public function addToCart($id)
    {

        return $this->cartService->addCart($id);
    }
}
