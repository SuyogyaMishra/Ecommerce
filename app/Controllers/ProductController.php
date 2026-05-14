<?php

namespace App\Controllers;

use App\Services\ProductService;
use App\Services\JwtService;
use App\Services\CartService;

class ProductController extends BaseController
{
    protected $productService,$jwtService,$cartService;

    public function __construct()
    {
        $this->productService=new ProductService();
        $this->jwtService=new JwtService();
        $this->cartService=new CartService();
    }

    public function productData()
    {
        try{

            $decodedToken=$this->jwtService->decode($this->request->getCookie('token'));

            $page=(int)($this->request->getGet('page') ?? 1);
            $limit=(int)($this->request->getGet('limit') ?? 10);
            $search=trim($this->request->getGet('search') ?? '');

            $products=$this->productService->getProducts($page,$limit,$search);

            return $this->response->setJSON([

                'status'=>true,

                'message'=>'Products fetched successfully',

                'products'=>$products,

                'totalProducts'=>$this->productService->totalProducts(),

                'activeProducts'=>$this->productService->activeProducts(),

                'outStockProducts'=>$this->productService->outStockProducts(),

                'totalPages'=>ceil(($products['total'] ?? 0)/$limit),

                'user'=>$decodedToken,

                'token'=>csrf_hash()

            ]);

        }catch(\Throwable $e){

            return $this->response
            ->setStatusCode(500)
            ->setJSON([

                'status'=>false,

                'message'=>$e->getMessage(),

                'token'=>csrf_hash()

            ]);
        }
    }

    public function getProduct($id)
    {
        try{

            $product=$this->productService->getProduct($id);

            if(!$product){

                return $this->response
                ->setStatusCode(404)
                ->setJSON([

                    'status'=>false,

                    'message'=>'Product not found',

                    'token'=>csrf_hash()

                ]);
            }

            return $this->response->setJSON([

                'status'=>true,

                'message'=>'Product fetched successfully',

                'product'=>$product,

                'token'=>csrf_hash()

            ]);

        }catch(\Throwable $e){

            return $this->response
            ->setStatusCode(500)
            ->setJSON([

                'status'=>false,

                'message'=>$e->getMessage(),

                'token'=>csrf_hash()

            ]);
        }
    }

    public function addProduct()
    {
        try{

            $result=$this->productService->addProduct($this->request);

            if(!$result['status']){

                return $this->response
                ->setStatusCode(400)
                ->setJSON([

                    'status'=>false,

                    'errors'=>$result['errors'] ?? [],

                    'message'=>$result['message'] ?? 'Validation failed',

                    'token'=>csrf_hash()

                ]);
            }

            return $this->response
            ->setStatusCode(201)
            ->setJSON([

                'status'=>true,

                'message'=>$result['message'] ?? 'Product added successfully',

                'token'=>csrf_hash()

            ]);

        }catch(\Throwable $e){

            return $this->response
            ->setStatusCode(500)
            ->setJSON([

                'status'=>false,

                'message'=>$e->getMessage(),

                'token'=>csrf_hash()

            ]);
        }
    }

    public function updateProduct($id)
    {
        try{

            $result=$this->productService->updateProduct($id);

            if(!$result['status']){

                return $this->response
                ->setStatusCode(400)
                ->setJSON([

                    'status'=>false,

                    'errors'=>$result['errors'] ?? [],

                    'message'=>$result['message'] ?? 'Update failed',

                    'token'=>csrf_hash()

                ]);
            }

            return $this->response->setJSON([

                'status'=>true,

                'message'=>$result['message'] ?? 'Product updated successfully',

                'token'=>csrf_hash()

            ]);

        }catch(\Throwable $e){

            return $this->response
            ->setStatusCode(500)
            ->setJSON([

                'status'=>false,

                'message'=>$e->getMessage(),

                'token'=>csrf_hash()

            ]);
        }
    }

    public function deleteProduct($id)
    {
        try{

            $result=$this->productService->deleteProduct($id);

            if(!$result['status']){

                return $this->response
                ->setStatusCode(400)
                ->setJSON([

                    'status'=>false,

                    'message'=>$result['message'] ?? 'Delete failed',

                    'token'=>csrf_hash()

                ]);
            }

            return $this->response->setJSON([

                'status'=>true,

                'message'=>$result['message'] ?? 'Product deleted successfully',

                'token'=>csrf_hash()

            ]);

        }catch(\Throwable $e){

            return $this->response
            ->setStatusCode(500)
            ->setJSON([

                'status'=>false,

                'message'=>$e->getMessage(),

                'token'=>csrf_hash()

            ]);
        }
    }

    public function addToCart($id)
    {
        try{

            $result=$this->cartService->addCart($id);

            if(!$result['status']){

                return $this->response
                ->setStatusCode(400)
                ->setJSON([

                    'status'=>false,

                    'message'=>$result['message'] ?? 'Failed to add product to cart',

                    'token'=>csrf_hash()

                ]);
            }

            return $this->response->setJSON([

                'status'=>true,

                'message'=>$result['message'] ?? 'Product added to cart successfully',

                'cart'=>$result['cart'] ?? null,

                'token'=>csrf_hash()

            ]);

        }catch(\Throwable $e){

            return $this->response
            ->setStatusCode(500)
            ->setJSON([

                'status'=>false,

                'message'=>$e->getMessage(),

                'token'=>csrf_hash()

            ]);
        }
    }
}