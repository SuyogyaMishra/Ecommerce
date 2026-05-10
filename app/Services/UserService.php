<?php

namespace App\Services;

use App\Models\UserModel;
use App\Services\JwtService;

class UserService
{
    protected $userModel, $jwtService;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->jwtService = new JwtService();
    }

    public function createUser($data)
    {
+        $salt = bin2hex(random_bytes(16));

        $finalPassword = password_hash(
            $data['password'] . $salt,
            PASSWORD_DEFAULT
        );
        return $this->userModel->insertUser([

            'name' => $data['name'],

            'email' => $data['email'],

            'role' => $data['role'] ?? 'user',
            'remember' => $data['remember'] ?? false,

            'password' => $finalPassword,

            'salt' => $salt
        ]);
    }


   public function loginUser($data)
{
    $user = $this->userModel
        ->loginUser($data['email']);

    if (!$user) {

        return [

            'status' => false,

            'message' => 'User not found',

            'token' => csrf_hash()
        ];
    }

    $finalPassword = $data['password'] . $user['salt'];

    if (
        !password_verify(
            $finalPassword,
            $user['password']
        )
    ) {

        return [

            'status' => false,

            'message' => 'Invalid password',

            'token' => csrf_hash()
        ];
    }

    // remember me checkbox
    $remember = !empty($data['remember_me']);

    $payload = [

        'id' => $user['id'],

        'name' => $user['name'],

        'email' => $user['email'],

        'role' => $user['role'],

        'remember' => $remember
    ];

    $jwt = $this->jwtService->encode($payload);

    $expire = $remember ? 2592000 : 86400;

    $this->userModel
        ->updateRememberToken(
            $user['id'],
            $remember
        );

    return [

        'status' => true,

        'message' => 'Login successful',

        'jwt' => $jwt,

        'expire' => $expire,

        'token' => csrf_hash()
    ];
}



    //// Admin starts here 08/05
    public function createAdminUser($data)
    {
        $salt = bin2hex(random_bytes(16));
        $finalPassword = password_hash($data['password'] . $salt, PASSWORD_DEFAULT);

        return $this->userModel->insertAdmin([

            'name' => $data['name'],

            'email' => $data['email'],

            'role' => $data['role'],

            'password' => $finalPassword,

            'salt' => $salt,
        ]);
    }

    public function loginadmin($data)
    {
        $jwtService = new JwtService();
        $user = $this->userModel
            ->loginUser($data['email']);

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

        $pylod = $jwtService->encode($user);

        return [

            'status' => true,

            'message' => 'Login successful redirecting to dashboard..',

            'token' => csrf_hash(),

            'jwt' => $pylod
        ];
    }
}
