<?php

namespace App\Models;

use App\Repositories\UserRepository;

class CartModel
{
    protected $db,$user;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->user= UserRepository::user();
    }

    public function addToCart($data)
    {
        $sql = "INSERT INTO carts(user_id,product_id,quantity,price,status)
              VALUES(?,?,?,?,?)";

        return   $this->db->query($sql, [
            $data['user_id'],
            $data['product_id'],
            $data['quantity'],
            $data['price'],
            $data['status'] ?? 1
        ]);
    }

    public function getCartByUser($userId)
    {
        $sql = "SELECT c.*,p.name,p.image
              FROM carts c
              JOIN products p ON p.id=c.product_id
              WHERE c.user_id=? AND c.status=1 AND c.is_deleted=0
              ORDER BY c.id DESC";

        return $this->db->query($sql, [$userId])->getResultArray();
    }

    public function getCartBYId($id)
    {
        $sql = "SELECT *
              FROM carts
              WHERE id=? AND status=1 AND is_deleted=0";

        return $this->db->query($sql, [$id])->getRowArray();
    }


    public function getAlreadyCart($pid, $userId)
    {
        $sql = "SELECT *
              FROM carts
              WHERE product_id=? AND user_id=? AND status=1 AND is_deleted=0";

        return $this->db->query($sql, [$pid, $userId])->getRowArray();
    }

    public function removeCart($id)
    {
        return $this->db->query(
            "DELETE FROM carts WHERE id=?",
            [$id]
        );
    }

    public function updateQuantity($id, $qty)
    {
        return $this->db->query(
            "UPDATE carts SET quantity=? WHERE id=?",
            [$qty, $id]
        );
    }

    public function clearCart($userId)
    {
        return $this->db->query(
            "DELETE FROM carts WHERE user_id=?",
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

    public function cartCount()
    {
        return $this->db->query(
            "SELECT COUNT(*) as total FROM carts WHERE user_id=? AND status=1 AND is_deleted=0",
            [$this->user['id']]
        )->getRowArray()['total'];
    }

    public function getCartItems($userId)
    {
        $sql = "
        SELECT 
            c.*,
            COALESCE(
                JSON_ARRAYAGG(
                    CASE 
                        WHEN t.id IS NOT NULL THEN JSON_OBJECT(
                            'id',t.id,
                            'name',t.name,
                            'amount',t.amount,
                            'status',t.status
                        )
                    END
                ),
                JSON_ARRAY()
            ) as taxes
        FROM cart c
        LEFT JOIN taxes t ON t.cart_id=c.id
        WHERE c.user_id=?
        GROUP BY c.id
    ";

        $query = $this->db->query($sql, [$userId]);

        $result = $query->getResultArray();

        foreach ($result as &$row) {
            $row['taxes'] = json_decode($row['taxes'], true);
        }

        return $result;
    }
}
