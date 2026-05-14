<?php

namespace App\Services\AdminServices;

use App\Models\ProductModel;
use App\Validation\ProductValidation;
use App\Models\UserModel;
use App\Repositories\UserRepository;

class DashboardService
{
    protected $productModel, $userModel,$userRepository;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
        $this->userRepository = new UserRepository();
    }

    public function showTotalUsers()
    {
        $result = $this->userRepository->getTotalUsers();
        return $result;
    }

    public function showUsers($page)
    {
        $result = $this->userModel->getAllUsers($page);
        return $result;
    }
}
