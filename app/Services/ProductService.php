<?php

namespace App\Services;

use App\Models\ProductModel;
use App\Repositories\UserRepository;
use App\Validation\ProductValidation;

class ProductService{

    protected $productModel,$userrepo,$productValidation;

    public function __construct(){

        $this->productModel=new ProductModel();

        $this->userrepo=new UserRepository();

        $this->productValidation=new ProductValidation();
    }

    public function getUserById($id){

        return $this->userrepo->getUserById($id);
    }

    public function getProducts($page=1,$limit=10,$search=''){

        return $this->productModel->getProducts(
            $page,
            $limit,
            $search
        );
    }

    public function totalProducts(){

        return $this->productModel->totalProducts();
    }

    public function activeProducts(){

        return $this->productModel->activeProducts();
    }

    public function outStockProducts(){

        return $this->productModel->outStockProducts();
    }

    public function getProduct($id){

        return $this->productModel->getSingleProduct($id);
    }

    public function addProduct(){

        $validation=$this->productValidation
            ->validateProduct();

        if(!$validation['status'])
            return $validation;

        $data=$validation['data'];

        $image=$validation['files']['image']??null;

        if($image && $image->isValid()){

            $imageName=$image->getRandomName();

            $image->move(
                FCPATH.'uploads/products',
                $imageName
            );

            $data['image']='uploads/products/'.$imageName;
        }

        $this->productModel->saveProduct($data);

        return [

            'status'=>true,

            'message'=>'Product Added Successfully'
        ];
    }

    public function updateProduct($id){

        $validation=$this->productValidation
            ->validateProduct();

        if(!$validation['status'])
            return $validation;

        $data=$validation['data'];

        $image=$validation['files']['image']??null;

        if($image && $image->isValid()){

            $imageName=$image->getRandomName();

            $image->move(
                FCPATH.'uploads/products',
                $imageName
            );

            $data['image']='uploads/products/'.$imageName;
        }else{
            unset($data['image']);
        }

        $this->productModel->saveProduct($data,$id);

        return [

            'status'=>true,

            'message'=>'Product Updated Successfully'
        ];
    }

    public function deleteProduct($id){

        $this->productModel->deleteProduct($id);

        return [

            'status'=>true,

            'message'=>'Product Deleted Successfully'
        ];
    }
    
}