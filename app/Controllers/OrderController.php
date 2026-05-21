<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\ProductService;

class OrderController extends BaseController
{
    protected $productService, $cartService, $orderService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->cartService = new CartService();
        $this->orderService = new OrderService();
    }

    public function getOrders()
    {
        return $this->orderService->adminOrders();
    }

    public function getUserOrder() {}

    public function addOrders()
    {
        return $this->orderService->addOrder();
    }

    public function getOrderByUser()
    {
       return $this->orderService->getOrders();
    }

    public function updateOrder()
    {
        return $this->orderService->updateOrder();
    }

    public function deleteOrder($id)
    {
        return $this->orderService->deleteOrder($id);
    }

    public function deleteUserOrder($id)
    {
        return $this->orderService->deleteUserOrder($id);
    }
    public function orderDetailsPage($id)
    {

        return view('userproducts/order_detail');
    }

    public function details($id)
    {
        return $this->orderService->orderDetails($id);
    }
    public function invoice($id){
        return $this->orderService->invoice($id);
    }
}
