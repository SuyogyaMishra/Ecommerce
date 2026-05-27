<?php
namespace App\Vendors\Controllers;
use App\Controllers\BaseController;
use App\Vendors\Services\ProfileService;
class ProfileController extends BaseController
{
    protected $profileService;

    public function __construct()
    {
        $this->profileService = new ProfileService();
    }


    public function signup()
    {
        return view('App\Vendors\Views\signup');
    }
    public function loginform(){
        return view('App\Vendors\Views\login');
    }
    public function register(){
        return $this->profileService->register();
    }
    public function login(){
      return $this->profileService->login();
    }
    public function logout(){
        return $this->profileService->logout();
    }
    
}