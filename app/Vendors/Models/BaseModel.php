<?php
namespace App\Vendors\Models;
use App\Repositories\UserRepository;

class BaseModel{

protected $db, $user;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->user = UserRepository::user();
    }

}