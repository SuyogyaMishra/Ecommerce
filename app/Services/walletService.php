<?php

namespace App\Services;

use App\Models\CartModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Validation\OrderValidation;
use App\Models\PaymentModel;
use App\Models\WalletModel;
use App\Services\Payments\PaymentService;
use App\Services\BaseService;

class walletService extends BaseService
{

    protected $cartModel, $productModel, $paymentService, $user, $orderModel, $orderItemModel, $paymentModel, $orderValidation, $tax, $walletModel;

    public function __construct()
    {
        parent::__construct();
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->paymentModel = new PaymentModel();
        $this->paymentService = new PaymentService();
        $this->orderValidation = new OrderValidation();
        $this->walletModel = new WalletModel();
    }

    public function getCartByUserId()
    {
        try {

            $userId = $this->user['id'];
         
            $data = [
                'balance' => $this->walletModel->getBalance($userId),
                'totalcredit' => $this->walletModel->totalCredits($userId),
                'totaldebit' => $this->walletModel->totalDebits($userId),
                'transactions' => $this->walletModel->getTransaction($userId)
            ];

            if ($data === false || empty($data)) {
                return $this->error('unable to fetch wallet details');
            }

            return $this->success('wallet details fetched', $data, 200);
        } catch (\Throwable $e) {

            customLog('error' . $e->getMessage().$e->getFile().$e->getLine());
            return $this->error($e->getMessage());
        }
    }
}
