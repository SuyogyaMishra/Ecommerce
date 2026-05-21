<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Services\CartService;
use App\Services\ProductService;

class CartController extends BaseController
{
    protected $productService, $cartService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->cartService = new CartService();
    }


    public function index()
    {
        return view('userproducts/cart_product');
    }

    public function checkoutCart()
    {
        return view('userproducts/checkout_cart');
    }
    public function getCart()
    {

           return $this->cartService->getUserCart();
    }


    public function updateCart($id)
    {
        return  $this->cartService->changeQty($id);
        // return $this->response->setJSON($result);
    }

    public function deleteCart($id)
    {
        return $this->cartService->deleteCart($id);
        // return $this->response->setJSON($result);
    }
}
