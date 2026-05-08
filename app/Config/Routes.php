<?php

use App\Controllers\ProductController;
use App\Controllers\UserController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/loginform', function () {
    return view('users/login_user');
});

$routes->get('/signupform', function () {
    return view('users/signup_user');
});
$routes->post('signup', [UserController::class, 'signupuser']);
$routes->post('login', [UserController::class, 'loginuser']);
$routes->get('logout', [UserController::class, 'logout']);


//////  Product controller routes   ->solid principals ,paswoord hash and salting  , jwt ,admin page;

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/dashboard', function () {
        return view('userproducts/dashboard');
    });
    $routes->get('getproducts', [ProductController::class, 'index']);

    $routes->get('/addproduct', function () {
        return view('userproducts/add_product');
    });
    $routes->post('saveproduct', [ProductController::class, 'saveProduct']);
    $routes->get(
        '/get-product/(:num)',
        'ProductController::getProduct/$1'
    );
    $routes->post(
        '/update-product/(:num)',
        'ProductController::updateProduct/$1'
    );

    $routes->post(
        '/delete-product/(:num)',
        'ProductController::deleteProduct/$1'
    );
});













require APPPATH . 'Config/Routes/AdminRoutes.php';