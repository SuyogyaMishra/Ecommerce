<?php

namespace App\Services\AdminServices;

use App\Models\AnnouncementTargetModel;
use App\Models\CartModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\UserModel;
use App\Services\JwtService;
use PhpParser\Node\Stmt\Catch_;
use App\Repositories\UserRepository;
use App\Services\BaseService;

class UserDashboardService extends BaseService
{
    protected $productModel, $userModel, $jwtServices, $userRepository,$announcement,$orderModel,$cartModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
        $this->jwtServices = new JwtService;
        $this->userRepository = new UserRepository();
        $this->announcement=new AnnouncementTargetModel();
        $this->orderModel = new OrderModel();
        $this->cartModel = new CartModel();
    }
    public function usersdata($page, $limit)
    {
        $Users = $this->userModel->getAllUsers($page, $limit);
        $totalPages = ceil($Users['total'] / $Users['limit']);
        $totalUsers = $this->userRepository->getTotalUsers();
        $activeUsers = $this->userModel->activeUsers();
        $adminUsers = $this->userModel->adminUsers();
        if (!$Users) {
            return [

                'status' => false,

                'message' => 'User not found',

                'token' => csrf_hash()
            ];
        }
        if (!$totalUsers) {
            return [

                'status' => false,

                'message' => 'Total users not found',

                'token' => csrf_hash()
            ];
        }
        if (!$adminUsers) {
            return [

                'status' => false,

                'message' => 'total Admin users not found',

                'token' => csrf_hash()
            ];
        }
        if (!$activeUsers) {
            return [

                'status' => false,

                'message' => 'total Admin users not found',

                'token' => csrf_hash()
            ];
        }

        return [
            'status' => true,
            'totalUsers' => $totalUsers,
            'adminUsers' => $adminUsers,
            'activeUsers' => $activeUsers,
            'users' => $Users,
            'totalPages' => $totalPages

        ];
    }
    public function getUser($id)
    {
        try {

            $result = $this->userModel->getUserById($id);

            if (!$result) {

                return [
                    'status' => false,
                    'message' => 'User not found by id'
                ];
            }

            return [
                'status' => true,
                'user' => $result
            ];
        } catch (\Exception $e) {

            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getUserBuName($name)
    {
        try {
            $result = $this->userModel->getUserByName($name);

            if (!$result) {
                return [
                    'status' => false,
                    'message' => 'user not found'
                ];
            }
            return [
                'status' => true,
                'message' => 'user found',
                'users' => $result
            ];
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
        }
    }

    public function updateUsers($data) {
        try{
            return $data=$this->userModel->updateUser($data);
        }
        catch(\Exception $e){
            log_message('info',$e->getMessage());
        }
    }

    public function deleteUsers($id){
        try{
            return $this->userModel->deleteUser($id);
        }
        catch(\Exception $e){
            log_message('info',$e->getMessage());
        }
    }

    public function userstats(){
        try{

           $announcement=$this->announcement->getByUser();
    
           $totalOrders = $this->orderModel->countOrders();
          $totalCarts = $this->cartModel->cartCount();
          return $this->success('details found',['totalOrders'=>$totalOrders,'totatCarts'=>$totalCarts,'announcements'=>$announcement]);

        }
        catch(\Exception $e){
            customLog($e->getMessage().$e->getLine());
            return $this->error("Some thing wnt wrong");
        }
    }
}
