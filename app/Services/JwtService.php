<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
     private $key;

    public function __construct()
    {
        $this->key=env('jwt_key');
    }

    public function encode($data,$remember=false)
    {   $expire = $remember ? 2592000 : 0;
        $jwt= JWT::encode([
            'iat'=>time(),   //when
            'exp'=>time()+$expire, // exp cal in sec
            'id'=>$data['id'],
            'email'=>$data['email'],    
            'role'=>$data['role'],
            'name'=>$data['name']
        ],$this->key,'HS256');
        return [
            'jwt'=>$jwt,
            'expire'=>$expire

        ];
    }

    public function decode($token)
    {
        return JWT::decode($token,new Key($this->key,'HS256'));
    }
}