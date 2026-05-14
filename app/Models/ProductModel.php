<?php

namespace App\Models;

class ProductModel{

    protected $db;

    public function __construct(){
        $this->db=\Config\Database::connect();
    }

    public function getProducts($page=1,$limit=10,$search=''){

        $offset=($page-1)*$limit;

        $sql="SELECT * FROM products";

        $params=[];

        if($search){

            $sql.=" WHERE name LIKE ?";

            $params[]='%'.$search.'%';
        }

        $countQuery=$this->db->query($sql,$params);

        $total=count($countQuery->getResultArray());

        $sql.=" ORDER BY id DESC LIMIT ? OFFSET ?";

        $params[]=(int)$limit;
        $params[]=(int)$offset;

        $products=$this->db
            ->query($sql,$params)
            ->getResultArray();

        return [

            'users'=>$products,

            'page'=>$page,

            'total'=>$total
        ];
    }

    public function totalProducts(){

        return $this->db->query(
            "SELECT COUNT(*) as total FROM products"
        )->getRowArray()['total'];
    }

    public function activeProducts(){

        return $this->db->query(
            "SELECT COUNT(*) as total FROM products WHERE status=1"
        )->getRowArray()['total'];
    }

    public function outStockProducts(){

        return $this->db->query(
            "SELECT COUNT(*) as total FROM products WHERE stock=0"
        )->getRowArray()['total'];
    }

    public function getSingleProduct($id){

        return $this->db->query(
            "SELECT * FROM products WHERE id=?",
            [$id]
        )->getRowArray();
    }

    public function saveProduct($data,$id=null){

        if($id){

            $sql="UPDATE products SET
                name=?,
                price=?,
                stock=?,
                status=?";

            $params=[
                $data['name'],
                $data['price'],
                $data['stock'],
                $data['status']
            ];

            if(isset($data['image'])){

                $sql.=", image=?";

                $params[]=$data['image'];
            }

            $sql.=" WHERE id=?";

            $params[]=$id;

            return $this->db->query(
                $sql,
                $params
            );
        }

        return $this->db->query(

            "INSERT INTO products(
                name,
                price,
                stock,
                image,
                status
            ) VALUES(?,?,?,?,?)",

            [
                $data['name'],
                $data['price'],
                $data['stock'],
                $data['image']??null,
                $data['status']
            ]

        );
    }

    public function deleteProduct($id){

        return $this->db->query(
            "DELETE FROM products WHERE id=?",
            [$id]
        );
    }
}