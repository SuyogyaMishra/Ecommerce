<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\walletService;
use CodeIgniter\HTTP\ResponseInterface;


class WalletController extends BaseController
{
    protected $walletService;

    public function __construct()
    {
        $this->walletService = new walletService();
       
    }
    public function index(){
        return view('userproducts/user_wallet');
    }
     public function getUserByUserId(){
        return$this->walletService->getCartByUserId();
      
    }
    
}
