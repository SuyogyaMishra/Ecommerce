<?php

namespace App\Filters;

use App\Services\JwtService;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthUserFilter implements FilterInterface
{
    public function before(RequestInterface $request,$arguments=null)
    {
        try
        {
            $token = request()->getCookie('token');

            if(!$token)
                return redirect()->to(base_url('loginform'))->with('error','Unauthorized Access, Please login');

            $user = (new JwtService())->decode($token);

            if($user->role !== 'user')
                return redirect()->to(base_url('loginform'))->with('error','Only users can access this page');

            $request->user = $user;
        }
        catch(\Exception $e)
        {
            log_message('error','AuthUserFilter error: '.$e->getMessage());
            return redirect()->to(base_url('loginform'))->with('error','Invalid or expired token');
        }
    }

    public function after(RequestInterface $request,ResponseInterface $response,$arguments=null){}
}