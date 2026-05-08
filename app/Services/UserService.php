<?php

namespace App\Services;

use App\Models\UserModel;

class UserService
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function createUser($data)
    {
        return $this->userModel->insertUser([

            'name' => $data['name'],

            'email' => $data['email'],

            'role' => 'user',

            'password' => password_hash(
                $data['password'],
                PASSWORD_DEFAULT
            )
        ]);
    }

    public function loginUser($data)
    {
        $user = $this->userModel
            ->loginUser($data['email']);

        if (!$user) {

            return [

                'status' => false,

                'message' => 'Email not found',

                'token' => csrf_hash()
            ];
        }

        if (
            !password_verify(
                $data['password'],
                $user['password']
            )
        ) {

            return [

                'status' => false,

                'message' => 'Invalid password',

                'token' => csrf_hash()
            ];
        }

        session()->set([

            'user_id' => $user['id'],

            'user_name' => $user['name'],

            'user_email' => $user['email'],

            'user_role' => $user['role'],

            'isLoggedIn' => true
        ]);
    
        return [

            'status' => true,

            'message' => 'Login successful redirecting to dashboard..',

            'token' => csrf_hash()
        ];
    }
}
