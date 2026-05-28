<?php

namespace App\Vendors\Services;

use App\Core\Services\JwtService;
use App\Vendors\Models\VendorsModel;
use App\Vendors\Services\BaseService;
use Error;
use PHPUnit\Framework\TestStatus\Success;

class ProfileService extends BaseService
{

    protected $vendorModel,$jwtService;

    public function __construct()
    {
        parent::__construct();
        $this->vendorModel = new VendorsModel();
        $this->jwtService = new JwtService();
    }
    public function register()
    {

        try {
            $data = $this->request->getPost();
            $salt = bin2hex(random_bytes(8));
            $data['salt'] = $salt;
            $password = password_hash($data['password'] . $salt, PASSWORD_DEFAULT);
            $data['password'] = $password;

            $status = $this->vendorModel->addVendor($data);
            if (!$status) {
                return $this->error('Some error occourd');
            }

            return $this->success('Registration Successfull', ['url' => base_url('vendor/login')]);
        } catch (\Exception $e) {
            customLog($e->getLine() . $e->getMessage());
        }
    }

    public function login(){
        $data= $this->request->getPost();
        $rember = $data['remember_me'] ?? false;

         $user =(array) $this->vendorModel->getVendorByEmail($data['email']);
         $user['role']='vendor';
          if(empty($user)){
               return $this->error('No user Find for '.$data['email']);
          }
          $password = $data['password'].$user['salt'];
        
          if(!password_verify($password,$user['password'])){
                    return $this->error('Invalid Password');
          }

         $token = $this->jwtService->encode($user,$rember);

         return $this->success('Login Successfull , Redirecting to dashboard',['url' => base_url('vendor/dashboard')])->setcookie(
             [
                    'name' => 'vendor_token',
                    'value' => $token['jwt'],
                    'expire' =>  $token['expire'],
                    'httponly' => true
                ]
         );
    }

    public function logout(){
         $this->vendorRepo->unsetUser();   
         return redirect()->to(base_url('vendor/loginform'))->deleteCookie('vendor_token');
    }

    public function profile(){

        return $this->Success('fetched',['name'=>$this->user['name'],'email'=>$this->user['email']]);
        // $profile= $this->vendorModel->getVendorById($this->user-);
    }

    public function vendorKycStatus(){

        $status= $this->vendorModel->getKycStatus($this->user['id']);
        if(!$status){
            return $this->error('Some error occured');
        }
        return $this->success('',$status);

    }
}
