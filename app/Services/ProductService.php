<?php

namespace App\Services;

use App\Models\ProductModel;
use App\Repositories\UserRepository;
use App\Validation\ProductValidation;

class ProductService extends BaseService{

    protected $productModel,$userrepo,$productValidation;

    public function __construct(){
         parent::__construct();
        $this->productModel=new ProductModel();

        $this->userrepo=new UserRepository();

        $this->productValidation=new ProductValidation();
    }

    public function getUserById(){

        return $this->userrepo->user();
    }

    public function getProducts(){

             $page = (int)($this->request->getGet('page') ?? 1);
            $limit = (int)($this->request->getGet('limit') ?? 10);
            $search = trim($this->request->getGet('search') ?? '');
            $column = $this->request->getGet('sortColumn') ?? 'id';
            $direction = $this->request->getGet('sortDirection') ?? 'ASC';

        $result= $this->productModel->getProducts(
             $column,$direction,
            $page,
            $limit,
            $search,
        );
        if(!$result){
          return $this->error('Product Not Found');
        }
        return $this->success('',[

                'status' => true,

                'message' => 'Products fetched successfully',

                'products' => $result,

                'user' => $this->user,

                'totalProducts' => $this->totalProducts(),

                'activeProducts' => $this->activeProducts(),

                'outStockProducts' => $this->outStockProducts(),

                'totalPages' => ceil(($products['total'] ?? 0) / $limit),


            ]);
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

       try{

          $product= $this->productModel->getSingleProduct($id);
        if(!$product){
            return $this->error('can not find product');
        }
        return $this->success('',['product' => $product]);
       }
       catch(\Exception $e){
        customLog('some error occured while geting users');
       }
    }

    public function addProduct(){
        try{

        $validation=$this->productValidation
            ->validateProduct();

        if(!$validation['status'])
            return $this->validationError($validation);

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

       $id= $this->productModel->saveProduct($data);
        $metadata=changeToJson( ['id'=>$id],[]);
         $this->logger->logActivity('product added successfully ',$metadata);

        return $this->success('product added succesfuly');
        }
        catch(\Exception $e){
            customLog($e->getMessage());
        }
    }

    public function updateProduct($id){

        $validation=$this->productValidation
            ->validateProduct();

        if(!$validation['status'])
            return $this->validationError($validation);

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

       return $this->success('Product updated succesfully');
    }

    public function deleteProduct($id){

        $delted=  $this->productModel->deleteProduct($id);

        if(!$delted){
            return $this->error('can not delete product');
        }
          $metadata=changeToJson( ['id'=>$id],[]);
         $this->logger->logActivity('product added successfully ',$metadata);
        return $this->success('Product Deleted Successfully');
    }
    
}