<?php

namespace App\Services\Payments;

use Razorpay\Api\Api;
use App\Interfaces\paymentInterface;
use App\Models\PaymentModel;
use App\Models\OrderModel;
use App\Services\BaseService;

class RazorpayService extends BaseService implements paymentInterface
{

    protected $api, $orderModel, $paymentModel;

    public function __construct()
    {
        parent::__construct();
        $this->api = new Api(
            env('razorpay.key'),
            env('razorpay.secret')
        );
        $this->orderModel = new OrderModel();
        $this->paymentModel = new PaymentModel();
    }

    public function createOrder($data)
    {
        $response = $this->api
            ->paymentLink
            ->create([

                'amount' => $data['amount'] * 100,

                'currency' => 'INR',

                'description' => 'Order Payment',

                'customer' => [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    
                ],

                'callback_url' => base_url(
                    'payment/verify/razorpay'
                ),

                'callback_method' => 'get'
            ]);

        return [
            'gateway_order_id' => $response['id'],
            'redirect_url' => $response['short_url']
        ];
    }

    public function verifyPayment($data)
{
    try{

        $paymentLink=$this->api
        ->paymentLink
        ->fetch($data['razorpay_payment_link_id']);

        if($paymentLink->status!='paid'){

            return [
                'status'=>false,
                'message'=>'Payment not completed'
            ];

        }

        return [
            'status'=>true,
            'payment_id'=>$paymentLink->payments[0]['payment_id'] ?? null,
            'payment_link_id'=>$paymentLink->id,
            'reference_id'=>$paymentLink->reference_id,
            'payment_status'=>$paymentLink->status
        ];

    }catch(\Throwable $e){

        log_message('error','Payment Verification Failed : '.$e->getMessage()
        );

        return [
            'status'=>false,
            'message'=>$e->getMessage()
        ];

    }
}


}
