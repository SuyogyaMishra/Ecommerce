<?php

namespace App\Services\Payments;

class PaymentMangerService {

    public static function gateway($gateway){

        return match($gateway){

            'razorpay'=>new RazorpayService(),

            'stripe'=>new StripeService(),

            default=>throw new \Exception('Invalid gateway')
        };
    }
}