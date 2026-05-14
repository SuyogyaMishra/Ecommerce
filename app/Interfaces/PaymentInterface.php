<?php

namespace App\Interfaces;

interface PaymentInterface{

    public function createOrder($data);

    public function verifyPayment($data);

    public function refund($paymentId,$amount=null);
}