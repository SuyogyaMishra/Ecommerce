<?php

namespace App\Vendors\Repositories;

use App\Vendors\Models\VendorsModel;

class VendorRepository
{
    private static $instance = null;

    protected  $vendorsModel;

    protected static $user = null;



    private function __construct()
    {
        $this->vendorsModel = new VendorsModel();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setUser($id)
    {
        if (static::$user == null) {
            static::$user = (array)  $this->vendorsModel->getVendorById($id);
            return self::$instance;
            
        }
         return self::$instance;
    }

      public function getUser()
    {
       return static::$user;
    }

    public function unsetUser(){
        static::$user  = null;
        return true;
    }
}
