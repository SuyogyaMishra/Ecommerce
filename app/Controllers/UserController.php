<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Services\UserService;

use App\Validation\SignupValidation;
use App\Services\JwtService;

class UserController extends BaseController
{
    protected $signupService, $validation;

    public function __construct()
    {
        helper('cookie');
        $this->signupService = new UserService();
        $this->validation = \Config\Services::validation();
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
        

        $result = $this->signupService->loginUser(

            $this->request->getPost()
        );

        if (!$result['status']) {

            return $this->response->setJSON($result);
        }
     
        return $this->response

            ->setJSON([

                'status' => true,

                'message' => $result['message'],

                'redirect' => base_url('/dashboard'),

                'token' => csrf_hash()
            ])

            ->setCookie([

                'name'     => 'token',

                'value'    => $result['jwt'],

                'expire'   => $result['expire'],

                'httponly' => true,

                'secure'   => false, // true on HTTPS

                'path'     => '/'
            ]);
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

            'role' => $data['role'],

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
}
