<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\UserController;
use App\Controllers\Admin\AdminController;
use App\Controllers\ProductController;

use Config\View;


/**
 * @var RouteCollection $routes
 */

$routes->group('admin', ['filter' => 'auth'], function ($routes) {

    $routes->get('dashboard', function () {
        return View('Admin/AdminDashboard');
    });
    $routes->get('users', function () {
        return View('Admin/AdminUsers');
    });
    $routes->get('dashboarddata', [AdminController::class, 'dashboard']);
    $routes->get('userdata', [AdminController::class, 'userdata']);
    $routes->get('getuser/(:num)', [AdminController::class, 'getUsers/$1']);
    $routes->get('searchuser/(:any)', [AdminController::class, 'searchUsers/$1']);
    $routes->put('updateuser', [AdminController::class, 'updateUser']);
    $routes->delete('deleteuser/(:num)', [AdminController::class, 'deleteUser']);

    $routes->get('products', [AdminController::class, 'products']);

    $routes->get('productdata', [ProductController::class, 'productData']);

    $routes->get('getproduct/(:num)', [ProductController::class, 'getProduct']);

    $routes->post('addproduct', [ProductController::class, 'addProduct']);

    $routes->put('updateproduct/(:num)', [ProductController::class, 'updateProduct']);

    $routes->delete('deleteproduct/(:num)', [ProductController::class, 'deleteProduct']);


    $routes->get('orders','Admin\AdminController::orders');

    $routes->get('getorders','OrderController::getOrders');

    $routes->put('updateorder', 'OrderController::updateOrder');
    
    $routes->delete('deleteorder/(:num)', 'OrderController::deleteOrder/$1');

    $routes->get('logout', [UserController::class, 'adminLogout']);
});
