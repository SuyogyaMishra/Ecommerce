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

$routes->post('admin/createuser', [UserController::class, 'createAdminUser']);
$routes->post('admin/login', [UserController::class, 'adminlogin']);


//////  Product controller routes   for the users   ->solid principals ,paswoord hash and salting  , jwt ,admin page;

$routes->group('', ['filter' => 'AuthUserFilter'], function ($routes) {
    $routes->get('/dashboard', function () {
        return view('userproducts/dashboard');
    });
    $routes->get('getproducts', [ProductController::class, 'productData']);


    $routes->post('addtocart/(:num)', [ProductController::class, 'addToCart/$1']);

    $routes->get('user/cart', 'CartController::index');

    $routes->get('getcart', 'CartController::getCart');
    $routes->get('checkout', 'CartController::checkoutCart');

    $routes->post('updatecart/(:num)', 'CartController::updateCart/$1');

    $routes->post('deletecart/(:num)', 'CartController::deleteCart/$1');

    $routes->get('user/orders', 'UserController::orders');

    ///user place ordr

    $routes->post('placeorder', 'OrderController::AddOrders');
    $routes->get('getorders', 'OrderController::getOrderByUser');
    $routes->delete('cancelorder/(:num)', 'OrderController::deleteUserOrder/$1');



    //  routes for payment  for the razor pay
    $routes->get('/payment', 'PaymentController::index');
    $routes->get('getpayment/(:num)', 'PaymentController::getPaymentByOrderId/$1');
    $routes->post('createpayment', 'PaymentController::createPayment');
    $routes->get('payment/verify/razorpay', 'PaymentController::verifyPayment');


    $routes->get(
        'payment/cancel',
        'PaymentController::cancel'
    );








    // walet routes
    $routes->get('wallet', 'WalletController::index');
    $routes->get('getwallet','WalletController::getUserByUserId');
    
});









require APPPATH . 'Config/Routes/AdminRoutes.php';
