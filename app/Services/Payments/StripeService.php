<?php

namespace App\Services\Payments;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Interfaces\PaymentInterface;

class StripeService implements PaymentInterface{

    public function __construct(){

        Stripe::setApiKey(env('stripe.secret'));
    }

    public function createOrder($data){

        return Session::create([

            'payment_method_types'=>['card'],

            'line_items'=>[[

                'price_data'=>[
                    'currency'=>'inr',
                    'product_data'=>[
                        'name'=>$data['name']
                    ],
                    'unit_amount'=>$data['amount']*100
                ],

                'quantity'=>1

            ]],

            'mode'=>'payment',

            'success_url'=>base_url('payment/success'),

            'cancel_url'=>base_url('payment/cancel')
        ]);
    }

    public function verifyPayment($data){

        return true;
    }

    public function refund($paymentId,$amount=null){

        return \Stripe\Refund::create([
            'payment_intent'=>$paymentId
        ]);
    }
}