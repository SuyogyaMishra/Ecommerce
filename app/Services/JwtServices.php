<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    private $key = '7xK#92!sL@pQ8mD$wR1zYvT5nB&cF3h';

    public function encode($data,$remember=false)
    {
        return JWT::encode([
            'iat'=>time(),
            'exp'=>time()+($remember ? 2592000 : 86400),
            'data'=>$data
        ],$this->key,'HS256');
    }

    public function decode($token)
    {
        return JWT::decode($token,new Key($this->key,'HS256'));
    }
}