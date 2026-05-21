<?php

namespace App\Repositories;

use App\Models\UserModel;

class UserRepository
{
    private $total_users=null;

    protected static $user=null;

    protected $userModel;

    public function __construct()
    {
        $this->userModel=new UserModel();
    }

    public function getTotalUsers()
    {
        if($this->total_users===null){
            $this->total_users=$this->userModel->totalUsers();
        }

        return $this->total_users;
    }

    public function setUser($id)
    {
        if(static::$user===null){
            static::$user=$this->userModel->repoUserById($id);
        }

        return $this;
    }

    public static function user()
    {
        return static::$user;
    }
}