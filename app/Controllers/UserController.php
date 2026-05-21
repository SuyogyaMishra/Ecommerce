<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\AdminServices\UserDashboardService;
use App\Services\UserService;

use App\Validation\SignupValidation;
use App\Services\JwtService;

class UserController extends BaseController
{
    protected $signupService, $validation,$userDashboadService;

    public function __construct()
    {
        helper('cookie');
        $this->signupService = new UserService();
        $this->validation = \Config\Services::validation();
        $this->userDashboadService = new UserDashboardService();

    }
    public function signupuser()
    {
        $data = $this->request->getPost();
        $result=$this->signupService->createUser([

            'name' => $data['name'],

            'email' =>  $data['email'],

            'password' =>  $data['password']

        ]);

        return $this->response->setJSON($result);
    }

    public function loginuser()
    {
        return  $this->signupService->loginUser();
     
    }
   
    public function getUser(){
        return $this->signupService->getUser();
    }


    public function logout()
    {
        $userId = session()->get('user_id');

        $userModel = new \App\Models\UserModel();

        $userModel->removeRememberToken($userId);

        delete_cookie('remember_token');

        session()->destroy();

        return redirect()->to('/loginform')->deleteCookie('token')->with('success', 'Logout successful');
    }





    //admin functions 08/05
    public function createAdminUser()
    {
        $data = $this->request->getPost();
        $result =$this->signupService->createAdminUser([

            'name' => $data['name'],

            'email' =>  $data['email'],

            'role' => 'admin',

            'password' =>  $data['password']

        ]);

        return $this->response->setJSON($result);
    }
    public function adminlogin()
    {
        $data = $this->request->getPost();
        $result = $this->signupService->loginadmin($data);
        if (!$result['status']) {

            return $this->response->setJSON($result);
        }
        return $this->response->setJSON([
            'status'=>true,
            'message'=>'Login Succes,Redirecting admin dashboard',
            'redirect'=>'admin\dashboard'
        ])->setCookie([
            'name' => 'token',
            'value' => $result['jwt'],
            'expire' => 86400,
            'httponly' => true
        ]);
    }
    public function adminLogout()
    {
        session()->destroy();

        return redirect()->to(base_url('adminlogin'))
            ->deleteCookie('token')
            ->with('success', 'Logout successful');
    }
    public function orders(){
        return view('userproducts/order_product');
    }

    public function getUsers(){
        return $this->signupService->getUsers();
    }
    public function dashboard(){
        return view('userproducts/user_dashboard');
    }
    public function userstats(){
      return $this->userDashboadService->userstats();
    }
}
