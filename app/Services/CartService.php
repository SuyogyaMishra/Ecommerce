<?php

namespace App\Services;

use App\Models\CartModel;
use App\Models\ProductModel;
use App\Factories\TaxFactory;
use App\Models\TaxModel;
use App\Models\WalletModel;

class CartService extends BaseService
{

    protected $cartModel, $productModel, $tax, $walletModel;

    public function __construct()
    {
        parent::__construct();
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
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
        $this->db->transBegin();

        $status = $this->cartModel->addToCart($data);
        $this->db->transComplete();
        if (!$this->db->transStatus()) {
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
            $result = $this->cartModel->getCartByUser($this->user['id']);
            $walletBalance = $this->walletModel->getBalance($this->user['id']);
            if (!$result) {
                return $this->success('User cart is empty add items', [
                    'cart' => $result,
                    'user' => $this->user,
                    'walletBalance' => $walletBalance
                ]);
                
            }
          
            $subtotal = 0;
            foreach ($result as $key => $item) {
                $subtotal += $result[$key]['total'];
            }

            $services = TaxFactory::makeAll();

            $tax = [];
            $grandTotal = $subtotal;

            foreach ($services as $service) {

                $taxClass = $service->calculate($subtotal);

                $tax[$taxClass['taxname']] = $taxClass['taxamount'];

                $grandTotal += $taxClass['taxamount'];
            }
            $total = [
                'subtotal' => $subtotal,
                'total'  => ceil( $grandTotal)
            ];
            return $this->success( 'order details',[
                'cart' => $result ?? null,
                'user' => $this->user,
                'tax' => $tax,
                'total' => $total,
                'walletBalance' => $walletBalance


            ]);
        } catch (\Exception $e) {
            log_message('info', 'cart fetch error' . $e->getMessage());
        }
    }

    public function deleteCart($id)
    {
        try {
            $this->db->transBegin();
            $this->cartModel->removeCart($id);


            $this->db->transComplete();

            if (!$this->db->transStatus()) {
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
            $this->db->transRollback();
        }
    }

    public function changeQty($id, $qty)
    {
        try {
            $result = $this->cartModel->updateQuantity($id, $qty);
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
