<?php

namespace App\Services;

use App\Models\UserModel;
use App\Services\JwtService;
use App\Validation\SignupValidation;

class UserService extends BaseService
{
    protected $userModel, $validation;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel();
        $this->validation = new SignupValidation();
    }

    public function createUser($data)
    {
        $validation = $this->validation
            ->validateSignup();

        if (!$validation['status']) {

            return [

                'status' => false,

                'message' => $validation['message'],

                'errors' => $validation['errors']

            ];
        }
        $data = $validation['data'];
        $salt = bin2hex(random_bytes(16));

        $finalPassword = password_hash($data['password'] . $salt, PASSWORD_DEFAULT);
        $result= $this->userModel->insertUser([

            'name' => $data['name'],

            'email' => $data['email'],

            'role' => 'user',

            'password' => $finalPassword,
            'Salt' => $salt
        ]);
        if(!$result){
            return[
               'status'=>false,
               'message'=>"Login Failed"
            ];
        }
        return [

            'status' => true,

            'message' => 'User registered successfully <a href="' . base_url('loginform') . '">

            Login Here </a>',
            'token' => csrf_hash()

        ];
    }

    public function loginUser($data)
    {
        $validation = $this->validation
            ->validateLogin();

        if (!$validation['status']) {

            return [

                'status' => false,

                'message' => $validation['message'],

                'errors' => $validation['errors']

            ];
        }
        $data = $validation['data'];
        $jwtService = new JwtService();
        $user = $this->userModel
            ->loginUser($data['email']);;
        if ($user && isset($data['remember_me'])) {

            $this->userModel->updateRememberToken($user['id'], $data['remember_me']);
        }

        if (!$user) {

            return [

                'status' => false,

                'message' => 'User not found',

                'token' => csrf_hash()
            ];
        }

        $finalPassword = $data['password'] . $user['salt'];
        if (!password_verify($finalPassword, $user['password'])) {

            return [

                'status' => false,

                'message' => 'Invalid password',

                'token' => csrf_hash()
            ];
        }

        $pylod = $jwtService->encode($user, $data['remember_me'] ?? false);

        return [

            'status' => true,

            'message' => 'Login successful redirecting to dashboard..',

            'token' => csrf_hash(),

            'jwt' => $pylod['jwt'],
            'expire' => $pylod['expire']
        ];
    }



    //// Admin starts here 08/05
    public function createAdminUser($data)
    {
        $validation = $this->validation
            ->validateSignup();

        if (!$validation['status']) {

            return [

                'status' => false,

                'message' => $validation['message'],

                'errors' => $validation['errors']

            ];
        }
        $data = $validation['data'];
        $salt = bin2hex(random_bytes(16));
        $finalPassword = password_hash($data['password'] . $salt, PASSWORD_DEFAULT);

        $result = $this->userModel->insertAdmin([

            'name' => $data['name'],

            'email' => $data['email'],

            'role' => $data['role'],

            'password' => $finalPassword,

            'salt' => $salt,
        ]);
         if(!$result){
            return[
               'status'=>false,
               'message'=>"Login Failed"
            ];
        }
        return [

            'status' => true,

            'message' => 'Admin User registered successfully <a href="' . base_url('loginform') . '">

            Login Here </a>',
            'token' => csrf_hash()

        ];
    }

    public function loginadmin($data)
    {
        $validation = $this->validation
            ->validateLogin();

        if (!$validation['status']) {

            return [

                'status' => false,

                'message' => $validation['message'],

                'errors' => $validation['errors']

            ];
        }
        $data = $validation['data'];
        $jwtService = new JwtService();
        $user = $this->userModel
            ->loginUser($data['email']);
        if ($user && isset($data['remember'])) {

            $this->userModel->updateRememberToken($user['id'], $data['remember']);
        }
        if (!$user) {

            return [

                'status' => false,

                'message' => 'User not found',

                'token' => csrf_hash()
            ];
        }

        $finalPassword = $data['password'] . $user['salt'];
        if (!password_verify($finalPassword, $user['password'])) {

            return [

                'status' => false,

                'message' => 'Invalid password',

                'token' => csrf_hash()
            ];
        }

        $pylod = $jwtService->encode($user, $data['remember'] ?? false);

        return [

            'status' => true,

            'message' => 'Login successful redirecting to dashboard..',

            'token' => csrf_hash(),

            'jwt' => $pylod['jwt'],
            'expire' => $pylod['expire']
        ];
    }
}
