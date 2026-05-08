<?php

namespace App\Services;

use App\Models\ProductModel;
use App\Validation\ProductValidation;

class ProductService
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

  

    public function saveProduct($request, $userId)
    {
        $validation = ProductValidation::validate(
            $request
        );

        if (!$validation['status']) {

            return $validation;
        }

        $data = [

            'user_id'      => $userId,

            'product_name' => $request->getPost('product_name'),

            'category'     => $request->getPost('category'),

            'price'        => $request->getPost('price'),

            'quantity'     => $request->getPost('quantity')

        ];

        $this->productModel->insertProduct($data);

        return [

            'status' => true

        ];
    }
    public function getUserProducts($userId){
        return   $this->productModel->getUserProducts($userId);
    }

    public function getProduct($id, $userId)
{
    return $this->productModel->getSingleProduct(

        $id,

        $userId

    );
}
public function updateProduct($id, $request, $userId)
{
    $data = [

        'product_name' => $request->getPost('product_name'),

        'category' => $request->getPost('category'),

        'price' => $request->getPost('price'),

        'quantity' => $request->getPost('quantity')

    ];

    $this->productModel->updateProduct(

        $id,

        $userId,

        $data

    );

    return [

        'status' => true,

        'message' => 'Product Updated Successfully'

    ];
}
public function deleteProduct($id, $userId)
{
    $this->productModel->deleteProduct(

        $id,

        $userId

    );

    return [

        'status' => true,

        'message' => 'Product Deleted Successfully'

    ];
}
}