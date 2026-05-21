<?php

namespace App\Interfaces;

interface PaymentInterface{

    public  function  createOrder($data);

    public function verifyPayment($data);

}