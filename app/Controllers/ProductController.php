<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\ProductService;
use App\Services\JwtService;

class ProductController extends BaseController
{
    protected $productService;
    protected $JwtService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->JwtService     = new JwtService();
    }

    /**
     * Get Authenticated User From JWT
     */
    private function getAuthUser()
    {
        $token = request()->getCookie('token');

        if (!$token) {
            return false;
        }

        return $this->JwtService->decode($token);
    }

    /**
     * Get All Products Of Logged In User
     */
    public function index()
    {
        $user = $this->getAuthUser();

        if (!$user) {

            return $this->response->setJSON([
                'status'   => false,
                'message'  => 'Unauthorized Access',
                'redirect' => base_url('loginform')
            ]);
        }

        $products = $this->productService->getUserProducts(
            $user->id
        );

        return $this->response->setJSON([

            'status' => true,

            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role
            ],

            'products' => $products
        ]);
    }

    /**
     * Save Product
     */
    public function saveProduct()
    {
        $user = $this->getAuthUser();

        if (!$user) {

            return $this->response->setJSON([
                'status'   => false,
                'message'  => 'Unauthorized Access',
                'redirect' => base_url('loginform')
            ]);
        }

        $result = $this->productService->saveProduct(
            $this->request,
            $user->id
        );

        if (!$result['status']) {

            return $this->response->setJSON([
                'status'    => false,
                'csrf_hash' => csrf_hash(),
                'errors'    => $result['errors']
            ]);
        }

        return $this->response->setJSON([
            'status'    => true,
            'csrf_hash' => csrf_hash(),
            'message'   => 'Product Inserted Successfully',
            'redirect'  => base_url('dashboard')
        ]);
    }

    /**
     * Get Single Product
     */
    public function getProduct($id)
    {
        $user = $this->getAuthUser();

        if (!$user) {

            return $this->response->setJSON([
                'status'   => false,
                'message'  => 'Unauthorized Access',
                'redirect' => base_url('loginform')
            ]);
        }

        $product = $this->productService->getProduct(
            $id,
            $user->id
        );

        if (!$product) {

            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Product Not Found'
            ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'product' => $product
        ]);
    }

    /**
     * Update Product
     */
    public function updateProduct($id)
    {
        $user = $this->getAuthUser();

        if (!$user) {

            return $this->response->setJSON([
                'status'   => false,
                'message'  => 'Unauthorized Access',
                'redirect' => base_url('loginform')
            ]);
        }

        $result = $this->productService->updateProduct(
            $id,
            $this->request,
            $user->id
        );

        return $this->response->setJSON($result);
    }
}