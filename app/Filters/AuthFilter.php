<?php

namespace App\Filters;

use App\Services\JwtService;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request,$arguments=null)
    {
        try
        {
            $token = request()->getCookie('token');

            if(!$token)
                return redirect()->to(base_url('adminlogin'))->with('error','Unauthorized Access, Login as admin');

            $user = (new JwtService())->decode($token);

            if($user->role !== 'admin')
                return redirect()->to(base_url('adminlogin'))->with('error','Must be an admin to access this page');

        }
        catch(\Exception $e)
        {
            log_message('error','AuthFilter error: '.$e->getMessage());
            return redirect()->to(base_url('adminlogin'))->with('error','Invalid or expired token');
        }
    }

    public function after(RequestInterface $request,ResponseInterface $response,$arguments=null){}
}