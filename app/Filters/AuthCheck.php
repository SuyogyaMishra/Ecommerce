<?php

namespace App\Filters;

use App\Services\JwtService;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthCheck implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        try {

            $token = request()->getCookie('token');
            $segment = request()->getUri()->getSegment(1);
            log_message('info', 'AuthCheck: Retrieved token from cookies:');
            if (!$token) {
                log_message('info', 'No token found in cookies.');
                return;
            }

            $user = (new JwtService())->decode($token);

            if ($user) {

                if ($user->role === 'admin'  && $segment === 'adminlogin') {
                    return redirect()->to(base_url('admin/dashboard'));
                }
                else{
                    return;
                }

                
            }
            return redirect()->to(base_url('dashboard'));

        } catch (\Exception $e) {

            log_message('error', 'AuthCheck Error: ' . $e->getMessage());

            setcookie('token', '', time() - 3600, '/');

            return;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}