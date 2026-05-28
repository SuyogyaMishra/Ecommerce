<?php
namespace App\Vendors\Controllers;
use App\Controllers\BaseController;
use App\Vendors\Services\KycService;
class KycController extends BaseController
{
    protected $KycService;

    public function __construct()
    {
        $this->KycService = new KycService();
    }

    public function kyc(){
        return $this->KycService->adddocs();
    }
    public function submitKyc(){
        return $this->KycService->submitKyc();
    }



}