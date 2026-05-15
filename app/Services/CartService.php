<?php

namespace App\Services;

use App\Models\CartModel;
use App\Models\ProductModel;
use App\Factories\TaxFactory;
use App\Models\TaxModel;
use App\Models\WalletModel;

class CartService
{

    protected $cartModel, $productModel, $user, $tax,$walletModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        $this->user = service('jwt')->decode(service('request')->getCookie('token'));
        $this->tax = new TaxModel();
        $this->walletModel = new WalletModel();
    }

    public function addCart($id)
    {  
        $token = service('request')->getCookie('token');
        $userId = service('jwt')->decode($token)->id;
        $product = $this->productModel->getSingleProduct($id);
        if (!$product) {
            return [
                'status' => false,
                'message' => 'Product not found'
            ];
        }

        if (($product['stock'] ?? 0) <= 0) {
            return [
                'status' => false,
                'message' => 'Product out of stock'
            ];
        }


        $isAlready = $this->cartModel->getAlreadyCart($id, $userId);
        if ($isAlready) {
            return [
                'status' => true,
                'message' => 'Already in your cart'
            ];
        }
        $data = ["product_id" => $product['id'], 'user_id' => $userId, 'quantity' => 1, 'price' => $product['price']];
        $status = $this->cartModel->addToCart($data);
        if (!$status) {
            return [
                'status' => false,
                'message' => 'Failed to add product'
            ];
        }

        return [
            'status' => $status ? true : false,
            'message' => $status ? 'Product added to cart' : 'Failed to add product',
        ];
    }

    public function getUserCart()
    {
        try {
            $result = $this->cartModel->getCartByUser($this->user->id);
            if (!$result) {
                return [
                    'status' => false,
                    'Message' => "Can Not find user cart",
                    'data' => $result
                ];
            }
            $subtotal = 0;
            foreach ($result as $key => $item) {
                $subtotal += $result[$key]['total'];
            }

            $shipingService = TaxFactory::make('shiping');
            $shipingCharges = $shipingService->calculate($subtotal);
            $grandTotal = $subtotal + $shipingCharges['taxamount'];

            
            $tax = [
                $shipingCharges['taxname'] => $shipingCharges['taxamount'],
            ];
            $total = [
                'subtotal' => $subtotal,
                'total'  => $grandTotal
            ];
            $walletBalance = $this->walletModel->getBalance($this->user->id);

            return [
                'status' => true,
                'data' => $result,
                'user' => $this->user,
                'tax' => $tax,
                'total' => $total,
                 'walletBalance' =>$walletBalance


            ];
        } catch (\Exception $e) {
            log_message('info', 'cart fetch error' . $e->getMessage());
        }
    }

    public function deleteCart($id)
    {
        try {
            $result = $this->cartModel->removeCart($id);
            $taxDeleted = $this->tax->deleteByCartId($id);
            if (!$result) {
                return [
                    'status' => false,
                    'message' => "Cart item can not be deleted"
                ];
            }
            return [
                'status' => true,
                'message' => "Cart item deleted"
            ];
        } catch (\Exception $e) {
            log_message('info', $e->getMessage() . $e->getLine());
        }
    }

    public function changeQty($id, $qty)
    {
        try {
            $result = $this->cartModel->updateQuantity($id, $qty);
            $result = $this->cartModel->getCartBYId($id);

            $shipingTax = TaxFactory::make('shiping');
            $shipingdata = $shipingTax->calculate($result['total']);

            $taxes = [
                [
                    'user_id' => $result['user_id'],
                    'cart_id' => $id,
                    'name' => $shipingdata['taxname'],
                    'amount' => $shipingdata['taxamount'],
                    'status' => 'cart'
                ]
            ];
            $status = $this->tax->insertTax($taxes);

            if (!$result) {
                return [
                    'status' => 'false',
                    'message' => 'can not update cart'
                ];
            }
            return [
                'status' => 'true',
                'message' => 'cart updated successfuly'

            ];
        } catch (\Exception $e) {
            log_message('info cart increse', 'cant be updated cart');
        }
    }
}
