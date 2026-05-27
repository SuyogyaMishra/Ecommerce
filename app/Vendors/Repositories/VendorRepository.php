<?php

namespace App\Vendors\Repositories;

use App\Vendors\Models\VendorsModel;

class VendorRepository
{
    private static $instance = null;

    protected $vendorsModel, $user;



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
        if ($this->user == null) {
            $this->user = (array) $this->vendorsModel->getVendorById($id);
            return true;
            
        }
        return true;
    }

      public function getUser()
    {
       return $this->user;
    }

    public function unsetUser(){
        $this->user  = null;
        return true;
    }
}
