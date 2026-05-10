<?php

use App\Controllers\ProductController;
use App\Controllers\UserController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/loginform', function () {
    return view('users/login_user');
}, ['filter' => 'AuthCheck']);

$routes->get('/signupform', function () {
    return view('users/signup_user');
}, ['filter' => 'AuthCheck']);
$routes->post('/signup', [UserController::class, 'signupuser']);
$routes->post('login', [UserController::class, 'loginuser']);
$routes->get('logout', [UserController::class, 'logout']);
 $routes->get('adminsignup', function () {
        return view('users/signup_admin');
    }, ['filter' => 'AuthCheck']);
      $routes->get('adminlogin', function () {
        return view('users/login_admin');
    }, ['filter' => 'AuthCheck']);

$routes->post('admin/createuser',[UserController::class,'createAdminUser']);
$routes->post('admin/login',[UserController::class,'adminlogin']);


//////  Product controller routes   ->solid principals ,paswoord hash and salting  , jwt ,admin page;

$routes->group('', function ($routes) {
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