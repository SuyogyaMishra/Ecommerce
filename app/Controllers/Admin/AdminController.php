<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\AdminServices\DashboardService;
use App\Services\JwtService;
use App\Services\AdminServices\UserDashboardService;

class AdminController extends BaseController
{
    protected $jwtService,$AdminService,$userDashboardService;

    public function __construct()
    {
        helper('cookie');

        $this->jwtService=new JwtService();
        $this->AdminService=new DashboardService();
        $this->userDashboardService=new UserDashboardService();
    }

    public function dashboard()
    {

    
        $page=$this->request->getGet('page')??1;

        $token=$this->request->getCookie('token');

        $decodedToken=$this->jwtService->decode($token);

       return $this->AdminService->showDashboardData($page);
       
    }

    public function userData()
    {
        $page=$this->request->getGet('page')??1;
        $limit=$this->request->getGet('limit')??10;
        $search=$this->request->getGet('search')??"";
        $column = $this->request->getGet('column')??'id';
        $direction = $this->request->getGet('direction');
        $token=$this->jwtService->decode(
            $this->request->getCookie('token')
        );

        $result=$this->userDashboardService->usersdata(
            $column,
            $direction,
            $page,
            $limit,
            $search
        );

        if(!$result['status']){

            return $this->response->setJSON([
                'status'=>false,
                'message'=>$result['message']
            ]);

        }

        return $this->response->setJSON([

            'status'=>true,
            'message'=>'Users fetched successfully',

            'data'=>[
                'user'=>$token,
                'users'=>$result['users'],
                'totalUsers'=>$result['totalUsers'],
                'adminUsers'=>$result['adminUsers'],
                'activeUsers'=>$result['activeUsers'],
                'totalPages'=>$result['totalPages']
            ]

        ]);
    }

    public function getUsers($id)
    {
        $result=$this->userDashboardService->getUser($id);

        if(!$result['status']){

            return $this->response->setJSON([
                'status'=>false,
                'message'=>$result['message']
            ]);

        }

        return $this->response->setJSON([
            'status'=>true,
            'data'=>$result['user']
        ]);
    }

    public function searchUsers($keyword)
    {
        $result=$this->userDashboardService->getUserBuName($keyword);

        if(!$result['status']){

            return $this->response->setJSON([
                'status'=>false,
                'message'=>$result['message']
            ]);

        }

        return $this->response->setJSON([
            'status'=>true,
            'data'=>$result['users']
        ]);
    }

    public function updateUser()
    {
        try{

            $data=$this->request->getJSON(true);

            $update=$this->userDashboardService->updateUsers($data);

            if(!$update){

                return $this->response->setJSON([
                    'status'=>false,
                    'message'=>'User cannot be updated'
                ]);

            }

            return $this->response->setJSON([
                'status'=>true,
                'message'=>'User updated successfully'
            ]);

        }catch(\Exception $e){

            log_message('error',$e->getMessage());

            return $this->response->setJSON([
                'status'=>false,
                'message'=>'Internal server error'
            ]);

        }
    }

    public function deleteUser($id)
    {
        try{

            $delete=$this->userDashboardService->deleteUsers($id);

            if(!$delete){

                return $this->response->setJSON([
                    'status'=>false,
                    'message'=>'User cannot be deleted'
                ]);

            }

            return $this->response->setJSON([
                'status'=>true,
                'message'=>'User deleted successfully'
            ]);

        }catch(\Exception $e){

            log_message('error',$e->getMessage());

            return $this->response->setJSON([
                'status'=>false,
                'message'=>'Internal server error'
            ]);

        }
    }

    public function products()
    {
        return view('Admin/AdminProduct');
    }

    public function orders()
    {
        return view('Admin/AdminOrder');
    }
}