<?php

namespace App\Repositories;

use App\Models\UserModel;

class UserRepository {

    private $total_users = null;

    private $id;
    protected $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function getTotalUsers() {
        if ($this->total_users === null) {
            $this->total_users = $this->userModel->totalUsers();
        }

        return $this->total_users;
    }
    public function getUserById($id) {
        return $this->userModel->repoUserById($id);
    }

   
}