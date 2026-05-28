<?php
namespace App\Vendors\Models;
use App\Repositories\UserRepository;
use App\Vendors\Repositories\VendorRepository;

class BaseModel{

protected $db, $user;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

}