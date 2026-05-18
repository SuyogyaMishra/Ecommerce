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
        $result = $this->orderService->adminOrders();
        return $this->response->setJSON($result);
    }

    public function getUserOrder() {}

    public function addOrders()
    {
        $result = $this->orderService->addOrder();
        return $this->response->setJSON($result);
    }

    public function getOrderByUser()
    {
        $result = $this->orderService->getOrders();
        return $this->response->setJSON($result);
    }

    public function updateOrder()
    {
        $result = $this->orderService->updateOrder();
        return $this->response->setJSON($result);
    }

    public function deleteOrder($id)
    {
        $result = $this->orderService->deleteOrder($id);
        return $this->response->setJSON($result);
    }

    public function deleteUserOrder($id)
    {
        $result = $this->orderService->deleteUserOrder($id);
        return $this->response->setJSON($result);
    }
    public function orderDetailsPage($id)
    {

        return view('userproducts/order_detail');
    }

    public function details($id){
        return $this->orderService->orderDetails($id);
    }

    
}
