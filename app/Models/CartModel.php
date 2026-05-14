<?php

namespace App\Models;

class CartModel
{
    protected $db;

    public function __construct()
    {
        $this->db=\Config\Database::connect();
    }

    public function addToCart($data)
    {
        $sql="INSERT INTO carts(user_id,product_id,quantity,price,status)
              VALUES(?,?,?,?,?)";

        return $this->db->query($sql,[
            $data['user_id'],
            $data['product_id'],
            $data['quantity'],
            $data['price'],
            $data['status'] ?? 1
        ]);
    }

    public function getCartByUser($userId)
    {
        $sql="SELECT c.*,p.name,p.image
              FROM carts c
              JOIN products p ON p.id=c.product_id
              WHERE c.user_id=? AND c.status=1 AND c.is_deleted=0
              ORDER BY c.id DESC";

        return $this->db->query($sql,[$userId])->getResultArray();
    }

    public function getAlreadyCart($pid,$userId)
    {
        $sql="SELECT *
              FROM carts
              WHERE product_id=? AND user_id=? AND status=1 AND is_deleted=0";

        return $this->db->query($sql,[$pid,$userId])->getRowArray();
    }

    public function removeCart($id)
    {
        return $this->db->query(
            "UPDATE carts SET is_deleted=1 WHERE id=?",
            [$id]
        );
    }

    public function updateQuantity($id,$qty)
    {
        return $this->db->query(
            "UPDATE carts SET quantity=? WHERE id=?",
            [$qty,$id]
        );
    }

    public function clearCart($userId)
    {
        return $this->db->query(
            "UPDATE carts SET is_deleted=1 WHERE user_id=?",
            [$userId]
        );
    }

    public function cartTotal($userId)
    {
        return $this->db->query(
            "SELECT SUM(price*quantity) as total FROM carts WHERE user_id=? AND status=1 AND is_deleted=0",
            [$userId]
        )->getRowArray();
    }

    public function cartCount($userId)
    {
        return $this->db->query(
            "SELECT COUNT(*) as total FROM carts WHERE user_id=? AND status=1 AND is_deleted=0",
            [$userId]
        )->getRowArray();
    }
}