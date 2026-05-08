<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel
{



    public function getUserProducts($userId)
    {
        $db = \Config\Database::connect();

        $query = $db->query(

            "SELECT * FROM products
             WHERE user_id = ?
             ORDER BY id DESC",

            [$userId]

        );

        return $query->getResultArray();
    }


    public function insertProduct($data)
    {
        $db = \Config\Database::connect();

        return $db->query(

            "INSERT INTO products
            (user_id, product_name, category, price, quantity)

            VALUES (?, ?, ?, ?, ?)",

            [

                $data['user_id'],

                $data['product_name'],

                $data['category'],

                $data['price'],

                $data['quantity']

            ]

        );
    }

    public function getSingleProduct($id, $userId)
    {
        $db = \Config\Database::connect();

        $query = $db->query(

            "SELECT * FROM products
             WHERE id = ?
             AND user_id = ?",

            [$id, $userId]

        );

        return $query->getRowArray();
    }


    public function updateProduct($id, $userId, $data)
    {
        $db = \Config\Database::connect();

        return $db->query(

            "UPDATE products

             SET

             product_name = ?,
             category = ?,
             price = ?,
             quantity = ?

             WHERE id = ?
             AND user_id = ?",

            [

                $data['product_name'],

                $data['category'],

                $data['price'],

                $data['quantity'],

                $id,

                $userId

            ]

        );
    }


    public function deleteProduct($id, $userId)
    {
        $db = \Config\Database::connect();

        return $db->query(

            "DELETE FROM products
             WHERE id = ?
             AND user_id = ?",

            [$id, $userId]

        );
    }
}