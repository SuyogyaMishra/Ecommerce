<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\UserController;
use App\Controllers\Admin\AdminController;
use Config\View;

/**
 * @var RouteCollection $routes
 */

$routes->group('admin',['filter'=>'auth'],function($routes){

    $routes->get('dashboard', function () {
        return View('Admin/AdminDashboard');
    });
     $routes->get('users', function () {
        return View('Admin/AdminUsers');
    });
    $routes->get('dashboarddata',[AdminController::class,'dashboard']);

    $routes->get('logout',[UserController::class,'adminLogout']);

});