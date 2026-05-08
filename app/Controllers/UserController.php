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
        $this->validation->setRules(
            SignupValidation::rules()
        );

        if (!$this->validation->run($data)) {

            return $this->response->setJSON([

                'status' => false,

                'message' => 'Validation failed',

                'errors' => $this->validation->getErrors(),
                'token' => csrf_hash()

            ]);
        }
        $this->signupService->createUser([

            'name' => $data['name'],

            'email' =>  $data['email'],

            'password' =>  $data['password']

        ]);

        return $this->response->setJSON([

            'status' => true,

            'message' => 'User registered successfully <a href="' . base_url('loginform') . '">

            Login Here </a>',
            'token' => csrf_hash()

        ]);
    }

    public function loginuser()
    {
        $this->validation->setRules(

            SignupValidation::loginRules()
        );

        if (
            !$this->validation->run(
                $this->request->getPost()
            )
        ) {

            return $this->response->setJSON([

                'status' => false,

                'errors' => $this->validation->getErrors(),

                'token' => csrf_hash()
            ]);
        }

        $result = $this->signupService->loginUser(

            $this->request->getPost()
        );

        return $this->response->setJSON($result);
    }



    public function logout()
    {
        $userId = session()->get('user_id');

        $userModel = new \App\Models\UserModel();

        $userModel->removeRememberToken($userId);

        delete_cookie('remember_token');

        session()->destroy();

        return redirect()->to('/loginform');
    }





    //admin functions 08/05
    public function createAdminUser()
    {
        $data = $this->request->getPost();
        $this->signupService->createAdminUser([

            'name' => $data['name'],

            'email' =>  $data['email'],

            'role' => $data['role'],

            'password' =>  $data['password']

        ]);

        return $this->response->setJSON([

            'status' => true,

            'message' => 'Admin User registered successfully <a href="' . base_url('loginform') . '">

            Login Here </a>',
            'token' => csrf_hash()

        ]);
    }
    public function adminlogin()
    {
        $data = $this->request->getPost();
        $result = $this->signupService->loginadmin($data);
        if (!$result['status']) {

            return $this->response->setJSON($result);
        }
        return redirect()->to(base_url('/admin/dashboard'))->setCookie([
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
}
