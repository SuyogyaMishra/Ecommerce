<?php

use Config\View;

/**
 * @var RouteCollection $routes
 */



$routes->group('vendor', ['namespace' => 'App\Vendors\Controllers', 'filter' => 'VendorCheck'], function ($routes) {

    $routes->get('signup', 'ProfileController::signup');
    $routes->get('loginform', 'ProfileController::loginform');
    $routes->post('register', 'ProfileController::register');
    $routes->post('login', 'ProfileController::login');
});



//// these filtter are inside authVendor filter
$routes->group('vendor', ['namespace' => 'App\Vendors\Controllers', 'filter' => 'AuthVendor'], function ($routes) {

    $routes->get('dashboard', function () {
        return view('App\Vendors\Views\Vendordashboard');
        
    });

    $routes->get('logout', 'ProfileController::logout');


    $routes->get('profile', 'ProfileController::profile');


     $routes->get('kyc', 'KycController::kyc');
     
     $routes->get('kyc/status', 'ProfileController::kycStatus');

     $routes->post('submit/kyc', 'KycController::submitKyc');

   

      
});
