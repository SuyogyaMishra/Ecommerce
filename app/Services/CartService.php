<?php

namespace App\Services;

use App\Models\CartModel;
use App\Models\ProductModel;

class CartService
{

    protected $cartModel, $productModel,$user;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        $this->user = service('jwt')->decode(service('request')->getCookie('token'));
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
            
            $updateQty = $isAlready['quantity'] + 1;
            $this->cartModel->updateQuantity($isAlready['id'], $updateQty);
            return [
                'status' => true,
                'message' => 'Cart quantity updated as was alredy aded'
            ];
        }
        $data = ["product_id" => $product['id'], 'user_id' => $userId, 'quantity' => 1, 'price' => $product['price']];
        $status= $this->cartModel->addToCart($data);
        return [
            'status'=>$status ? true : false,
            'message'=>$status ? 'Product added to cart' : 'Failed to add product',
        ];
    }

    public function getUserCart()
    {
        try{
          $result = $this->cartModel->getCartByUser($this->user->id);
            if(!$result){
                return [
                    'status' => false,
                    'Message' => "Can Not find user cart",
                    'data' =>$result
                ];
            }
            return [
                'status' => true,
                'data' => $result,
                'user' => $this->user
                
            ];
        }
        catch(\Exception $e){
            log_message('info', 'cart fetch error'.$e->getMessage());
        }
    }

    public function deleteCart($id)
    {
        try{
        $result =$this->cartModel->removeCart($id);
           if(!$result){
             return [
                       'status' =>false,
                       'message' =>"Cart item can not be deleted"
              ];
           }
           return [
                       'status' =>true,
                       'message' =>"Cart item deleted"
              ];
        }
        catch(\Exception $e){
            log_message('info',$e->getMessage().$e->getLine());
        }
    }

    public function changeQty($id, $qty)
    {
      try{  
       $result = $this->cartModel->updateQuantity($id, $qty);
       if(!$result){
           return [
            'status' => 'false',
            'message' => 'can not update cart'
           ];
       }
            return [
            'status' => 'true',
            'message' => 'cart updated successfuly'

           ];
      }
      catch(\Exception $e){
        log_message('info cart increse', 'cant be updated cart');
      }
    }
}
