<?php

namespace App\Services\AdminServices;

use App\Models\ProductModel;
use App\Validation\ProductValidation;
use App\Models\UserModel;
use App\Models\OrderModel;
use App\Repositories\UserRepository;
use App\Services\BaseService;

class DashboardService extends BaseService
{
    protected $productModel, $userModel,$userRepository,$orderModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
        $this->userRepository = new UserRepository();
        $this->orderModel = new OrderModel();
    }

    public function showTotalUsers()
    {
        $result = $this->userRepository->getTotalUsers();
        return $result;
    }

    public function showUsers($page)
    {
        $result = $this->userModel->getAllUsers($column='id',$direction='DESC',$page);
        return $result;
    }

    public function showDashboardData($page){
        try{
         $totalUsers = $this->userRepository->getTotalUsers();
         $totalProduct = $this->productModel->totalProducts();
         $totalorders = $this->orderModel->countAdminOrders();
         $users=  $this->userModel->getAllUsers($column='id',$direction='DESC',$page);

           return $this->success('data fetched',   [
            'totalUsers'=>$totalUsers,
            'totalOrders' =>$totalorders,
            'totalProducts'=>$totalProduct,
            'users'=>$users['users'],
            'page'=>$users['page'],
            'limit'=>$users['limit'],
            'totalPages'=>ceil($users['total']/$users['limit']),
        ]);
        }
        catch (\Exception $e){
            customLog($e->getMessage());
            return $this->error($e->getMessage());
        }

    }
}
