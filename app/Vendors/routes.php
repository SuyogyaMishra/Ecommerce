<?php
use Config\View;

/**
 * @var RouteCollection $routes
 */



$routes->group('vendor', ['namespace' => 'App\Vendors\Controllers','filter'=>'VendorCheck'], function ($routes) {

   $routes->get('signup', 'ProfileController::signup');
    $routes->get('loginform', 'ProfileController::loginform');
    $routes->post('register', 'ProfileController::register');
    $routes->post('login', 'ProfileController::login');

});



//// these filtter are inside authVendor filter
$routes->group('vendor', ['namespace' => 'App\Vendors\Controllers','filter' => 'AuthVendor'], function ($routes) {
         
       $routes->get('dashboard', function(){
        return 'test';
       });
        $routes->get('logout', 'ProfileController::logout');


   

});