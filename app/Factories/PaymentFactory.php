<?php
namespace App\Factories;
use App\Factories\BaseFactory;
use App\Services\Payments\RazorpayService;
use App\Constants\Literals;


class PaymentFactory extends BaseFactory{
      
      protected static array $items=[
        
         Literals::RAZORPAY=>RazorpayService::class,

    ];
     
}