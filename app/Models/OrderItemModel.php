<?php

namespace App\Models;

class OrderItemModel
{
    protected $db;

    public function __construct()
    {
        $this->db=\Config\Database::connect();
    }

    public function createOrderItem($data)
    {
        $sql="INSERT INTO order_items(order_id,user_id,product_id,product_name,product_price,quantity,total)
              VALUES(?,?,?,?,?,?,?)";

        return $this->db->query($sql,[
            $data['order_id'],
            $data['user_id'],
            $data['product_id'],
            $data['product_name'],
            $data['product_price'],
            $data['quantity'],
            $data['total']
        ]);
    }

    public function getOrderItems($orderId)
    {
        return $this->db->query(
            "SELECT * FROM order_items WHERE order_id=?",
            [$orderId]
        )->getResultArray();
    }

    public function getUserOrderItems($userId)
    {
        return $this->db->query(
            "SELECT * FROM order_items WHERE user_id=? ORDER BY id DESC",
            [$userId]
        )->getResultArray();
    }
}