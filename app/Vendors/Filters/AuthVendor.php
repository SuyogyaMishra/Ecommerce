<?php

namespace App\Vendors\Filters;

use App\Core\Services\JwtService;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Vendors\Repositories\VendorRepository;

class AuthVendor implements FilterInterface
{
    public function before(RequestInterface $request,$arguments=null)
    {
        try
        {
            $token = request()->getCookie('vendor_token');

            if(!$token)
                return redirect()->to(base_url('vendor/loginform'))->with('error','Unauthorized Access, Login as admin');

            $user = (new JwtService())->decode($token);            
             $venRepo = VendorRepository::getInstance();

             $venRepo->setUser($user->id);           
        
            if($user->role !== 'vendor'){

                return redirect()->to(base_url('vendor/loginform'))->with('error','Must be an Vendor to access this page');
            }

            $request->user = $user;
        }
        catch(\Exception $e)
        {
            log_message('error','AuthFilter error: '.$e->getMessage());
            return redirect()->to(base_url('vendor/loginform'))->with('error','Token expired or logged out');
        }
    }

    public function after(RequestInterface $request,ResponseInterface $response,$arguments=null){}
}