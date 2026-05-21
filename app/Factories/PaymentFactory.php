<?php
namespace App\Factories;
use App\Factories\BaseFactory;
use App\Services\Payments\RazorpayService;
use App\Services\Payments\StripeService;


class PaymentFactory extends BaseFactory{
      
      protected static array $items=[
        
         'razorpay'=>RazorpayService::class,

          'stripe'=>StripeService::class,
      
    ];
     
}