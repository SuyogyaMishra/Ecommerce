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
        try {

            $result = $this->cartService->getUserCart();

            if (!$result) {

                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Cart not found',
                    'cart' => [],
                ]);
            }

            return $this->response->setJSON([
                'status' => true,
                'cart' => $result['data'],
                'user' => $result['user'],
                'tax' => $result['tax'],
                'total'=>$result['total'],
                'walletBalance' => $result['walletBalance']
            ]);
        } catch (\Exception $e) {

            log_message('error', 'Cart Fetch Error : ' . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Something went wrong',
            ];
        }
    }


    public function updateCart($id)
    {
        $quantity = $this->request->getPost('quantity');

        $result = $this->cartService->changeQty($id, $quantity);
        return $this->response->setJSON($result);
    }

    public function deleteCart($id)
    {
        $result = $this->cartService->deleteCart($id);
        return $this->response->setJSON($result);
    }
}
