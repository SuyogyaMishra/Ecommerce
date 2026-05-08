<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\ProductService;

class ProductController extends BaseController
{
    protected $productService;



    public function __construct()
    {
        $this->productService = new ProductService();
    }



    public function index()
    {
        // Check Login
        if (!session()->get('isLoggedIn')) {

            return $this->response->setJSON([

                'status' => false,

                'message' => 'Unauthorized Access',

                'redirect' => base_url('loginform')

            ]);
        }

        // Get Products
        $products = $this->productService->getUserProducts(

            session()->get('user_id')

        );

        // JSON Response
        return $this->response->setJSON([

            'status' => true,

            'user' => [

                'user_id'    => session()->get('user_id'),

                'user_name'  => session()->get('user_name'),

                'user_email' => session()->get('user_email'),

                'user_role'  => session()->get('user_role')

            ],

            'products' => $products

        ]);
    }



    public function saveProduct()
    {
        $result = $this->productService->saveProduct(

            $this->request,

            session()->get('user_id')

        );

        if (!$result['status']) {

            return $this->response->setJSON([

                'status' => false,

                'csrf_hash' => csrf_hash(),

                'errors' => $result['errors']

            ]);
        }

        return $this->response->setJSON([

            'status' => true,

            'csrf_hash' => csrf_hash(),

            'message' => 'Product Inserted Successfully redirecting to dashboard',

            'redirect' => base_url('dashboard')

        ]);
    }

    public function getProduct($id)
    {
        // Check Login
        if (!session()->get('isLoggedIn')) {

            return $this->response->setJSON([

                'status' => false,

                'message' => 'Unauthorized Access',

                'redirect' => base_url('loginform')

            ]);
        }

        // Get Product
        $product = $this->productService->getProduct(

            $id,

            session()->get('user_id')

        );

        // Product Not Found
        if (!$product) {

            return $this->response->setJSON([

                'status' => false,

                'message' => 'Product Not Found'

            ]);
        }

        // Success Response
        return $this->response->setJSON([

            'status' => true,

            'product' => $product

        ]);
    }

    public function updateProduct($id)
    {
        $result = $this->productService->updateProduct(

            $id,

            $this->request,

            session()->get('user_id')

        );

        return $this->response->setJSON($result);
    }
}
