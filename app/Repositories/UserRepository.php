<?php

namespace App\Repositories;

use App\Models\UserModel;

class UserRepository
{

    private $total_users = null;

    protected $user;
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function getTotalUsers()
    {
        if ($this->total_users === null) {
            $this->total_users = $this->userModel->totalUsers();
        }

        return $this->total_users;
    }
    public function setUser($id)
    {

        if ($this->user === null)
            $this->user = $this->userModel->repoUserById($id);

        return $this;
    }

    public function user()
    {

        return $this->user;
    }
}
