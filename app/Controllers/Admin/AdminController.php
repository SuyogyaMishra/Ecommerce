<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\ProductService;
use App\Services\AdminServices\DashboardService;
use App\Services\JwtService;

class AdminController extends BaseController
{
    protected  $jwtService, $AdminService;

    public function __construct()
    {
        helper('cookie');
        $this->jwtService = new JwtService();
        $this->AdminService = new DashboardService();
    }

    public function dashboard()
    {
        $page = $this->request->getGet('page') ?? 1;

        $token = $this->request->getCookie('token');

        $decodedToken = $this->jwtService->decode($token);
       
        $users = $this->AdminService->showUsers($page);
        return $this->response->setJSON([
            'status' => true,
            'totalUsers' => $users['total'],
            'users' => $users['users'],
            'page' => $users['page'],
            'limit' => $users['limit'],
            'totalPages' => ceil($users['total'] / $users['limit']),
            'decodedToken' => $decodedToken
        ]);
    }
}
