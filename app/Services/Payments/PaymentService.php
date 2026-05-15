<?php

namespace App\Services\Payments;

use App\Models\CartModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Services\BaseService;
use App\Models\PaymentModel;
use App\Models\WalletModel;

class PaymentService extends BaseService
{
    protected $orderModel, $paymentModel, $walletModel;
    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new OrderModel();
        $this->paymentModel = new paymentModel();
        $this->walletModel = new WalletModel();
    }

    public function getPayment($id)
    {
        $result = $this->orderModel->getOrderById($id);

        if (!$result) {
            return  $this->error();
        }
        return $this->success("fetched", $result);
    }




    public function createPayment($data)
    {
        try {

            $gateway = $data['gateway'];
            $user = (array)$this->user;
            $payment = PaymentMangerService
                ::gateway($gateway);
            $response = $payment->createOrder([
                'amount' => $data['amount'],
                'name' => $user['name'],
                'email' => $user['email'],
                'receipt' => $user['id']
            ]);

            $this->paymentModel->createPayment([
                'order_id' => $user['id'],
                'gateway' => $gateway,
                'gateway_order_id' => $response['gateway_order_id'],
                'amount' => $data['amount'],
                'status' => 'pending'
            ]);

            return $this->success(
                'Payment initiated',
                [
                    'redirect_url' => $response['redirect_url']
                ]
            );
        } catch (\Exception $e) {

            customLog(

                'Payment Failed : ' . $e->getMessage() . $e->getFile() . $e->getLine()
            );

            return $this->error($e->getMessage());
        }
    }



    public function verifyPayment()
    {
        try {

            $data = [

                'razorpay_payment_link_id' => $this
                    ->request
                    ->getGet('razorpay_payment_link_id'),

                'razorpay_payment_link_reference_id' => $this
                    ->request
                    ->getGet('razorpay_payment_link_reference_id'),

                'razorpay_payment_link_status' => $this
                    ->request
                    ->getGet('razorpay_payment_link_status'),

                'razorpay_payment_id' => $this
                    ->request
                    ->getGet('razorpay_payment_id')
            ];
             
            $paymentGateway = PaymentMangerService::gateway('razorpay');
             
            $verified = $paymentGateway->verifyPayment($data);
             
            if (!$verified['status'])
                throw new \Exception('Payment verification failed');

             
            $payment = $this->paymentModel->getByGatewayOrderId(
                $verified['payment_link_id']
            );
           
            if (!$payment)
                throw new \Exception('Payment not found');
             
            
            if ($payment['status'] === 'paid'){
                return redirect()->to(base_url('user/orders'));
            }
            

            $this->paymentModel->markPaid($payment['id'], $verified['payment_id']);
            $walletData = [
                'user_id' => $payment['user_id'],
                'type'  => 'credit',
                'amount' => $payment['amount'],
                'source' => 'online payment',
                'reference_id' => $verified['payment_id'],
                'note' =>  'online added'

            ];
               
            $this->walletModel->addWallet($walletData);

            return redirect()->to(base_url('wallet'));
        } catch (\Throwable $e) {

            customLog( $e->getMessage());

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function refundPayment($paymentId, $gateway, $amount = null, $orderId = null)
    {
        try {

            $paymentGateway = PaymentMangerService::gateway($gateway);

            $refund = $paymentGateway->refund(
                $paymentId,
                $amount
            );

            if ($orderId) {
                VAR_DUMP($orderId);
                die;
                $this->orderModel->markOrderRefunded($orderId);

                $this->paymentModel->updatePaymentStatus(
                    $paymentId,
                    'refunded'
                );
            }

            return $this->success(
                'Refund initiated',
                $refund
            );
        } catch (\Throwable $e) {

            log_message(
                'error',
                'Refund Failed : ' . $e->getMessage()
            );

            return $this->error(
                $e->getMessage()
            );
        }
    }
}
