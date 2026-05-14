<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Services\Payments\PaymentService;

class PaymentController extends BaseController
{

    protected $PaymentService;

    public function __construct()
    {
        $this->PaymentService = new PaymentService();
    }

    public function index()
    {
        return view('userproducts/order_payments');
    }

    public function getPaymentByOrderId($id)
    {
        return $this->PaymentService->getPayment($id);
    }

    public function createPayment()
    {

        return $this->PaymentService->createPayment( $this->request->getPost() );
        
    }
    public function verifyPayment()
{
    try{
       return $this->PaymentService->verifyPayment( );

    }catch(\Throwable $e){

        return $this->response->setJSON([
            'status'=>false,
            'message'=>$e->getMessage()
        ]);

    }
}
}
