<?php

namespace App\Services\AdminServices;

use App\Models\ProductModel;
use App\Validation\ProductValidation;
USE App\Models\UserModel;
class DashboardService
{
    protected $productModel,$userModel;

   public function __construct()
   {
       $this->productModel = new ProductModel();
       $this->userModel = new UserModel();
   }
    
   public function showTotalUsers(){
    $result=$this->userModel->totalUsers();
    return $result;
   }

   public Function showUsers($page){
    $result=$this->userModel->getAllUsers($page);
    return $result;
   }
}