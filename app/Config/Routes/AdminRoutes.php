<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\UserController;
/**
 * @var RouteCollection $routes
 */
    
    $routes->get('adminsignup', function () {
        return view('users/signup_admin');
    });
      $routes->get('adminlogin', function () {
        return view('users/login_admin');
    });
    $routes->post('admin/createuser', [UserController::class, 'createAdminUser']);