<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    private $key = '4f8d0a3c91d0f1b7a6d28f4e8c9a7b1d3f6e2c5a9b7d4f1e8c2a6d9b0f3e7a1';

    public function encode($data,$remember=false)
    {
        return JWT::encode([
            'iat'=>time(),   //when
            'exp'=>time()+($remember ? 2592000 : 86400), // exp cal in sec
            'id'=>$data['id'],
            'email'=>$data['email'],    
            'role'=>$data['role'],
            'name'=>$data['name']
        ],$this->key,'HS256');
    }

    public function decode($token)
    {
        return JWT::decode($token,new Key($this->key,'HS256'));
    }
}