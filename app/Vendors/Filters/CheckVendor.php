<?php

namespace App\Vendors\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CheckVendor implements FilterInterface
{
    public function before(RequestInterface $request,$arguments=null)
    {
        try
        {
            $token = request()->getCookie('vendor_token');

            if($token){
                return redirect()->to(base_url('vendor/dashboard'));
            }
            return;

        }
        catch(\Exception $e)
        {
            log_message('error','AuthFilter error: '.$e->getMessage());
            return redirect()->to(base_url('vendor/loginform'))->with('error','Token expired or logged out');
        }
    }

    public function after(RequestInterface $request,ResponseInterface $response,$arguments=null){}
}