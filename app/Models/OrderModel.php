<?php

namespace App\Models;

class OrderModel
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function createOrder($data)
    {
        $sql = "INSERT INTO orders(user_id,order_id,name,email,phone,address,subtotal,total,payment_method,payment_status,order_status)
              VALUES(?,?,?,?,?,?,?,?,?,?,?)";

         $this->db->query($sql, [
            $data['user_id'],
            $data['order_id'],
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['address'],
            $data['subtotal'],
            $data['total'],
            $data['payment_method'],
            $data['payment_status'],
            $data['order_status']
        ]);

    return $this->db->insertID();
    }

    public function getLastOrderId()
    {
        return $this->db->query(
            "SELECT id FROM orders WHERE is_deleted=0 ORDER BY id DESC LIMIT 1"
        )->getRowArray();
    }




    public function getOrders($userId, $limit, $offset)
    {
        return $this->db->query(
            "SELECT * FROM orders 
         WHERE user_id=? AND is_deleted=0
         ORDER BY id DESC
         LIMIT ? OFFSET ?",
            [$userId, $limit, $offset]
        )->getResultArray();
    }
    public function countOrders($userId)
    {
        return $this->db->query(
            "SELECT COUNT(*) as total 
         FROM orders 
         WHERE user_id=? AND is_deleted=0",
            [$userId]
        )->getRowArray()['total'];
    }
    public function getSingleOrder($id, $userId)
    {
        return $this->db->query(
            "SELECT * FROM orders WHERE id=? AND user_id=? And is_deleted=0",
            [$id, $userId]
        )->getRowArray();
    }

    public function getOrderById($id)
    {
        return $this->db->query(
            "SELECT * FROM orders WHERE id=? AND is_deleted=0",
            [$id]
        )->getRowArray();
    }

    public function getAdminOrders($limit, $offset, $search = null)
    {
        $sql = "SELECT * FROM orders WHERE is_deleted=0";

        if ($search)
            $sql .= " AND (id LIKE '%$search%' 
                 OR name LIKE '%$search%'
                 OR email LIKE '%$search%')";

        $sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";

        return $this->db->query($sql, [
            (int)$limit,
            (int)$offset
        ])->getResultArray();
    }

    public function countAdminOrders($search = null)
    {
        $sql = "SELECT COUNT(*) as total FROM orders WHERE is_deleted=0";

        if ($search)
            $sql .= " AND (id LIKE '%$search%' 
                 OR name LIKE '%$search%'
                 OR email LIKE '%$search%')";

        return $this->db->query($sql)
            ->getRowArray()['total'];
    }

    public function countPendingOrders()
    {
        return $this->db->query(
            "SELECT COUNT(*) as total 
         FROM orders 
         WHERE order_status='pending' AND is_deleted=0"
        )->getRowArray()['total'];
    }

    public function countCompletedOrders()
    {
        return $this->db->query(
            "SELECT COUNT(*) as total 
         FROM orders 
         WHERE order_status='delivered' AND is_deleted=0"
        )->getRowArray()['total'];
    }

    public function updatePayment($id, $paymentId, $status)
    {
        return $this->db->query(
            "UPDATE orders SET transaction_id=?,payment_status=? WHERE id=? AND is_deleted=0",
            [$paymentId, $status, $id]
        );
    }

    public function updateOrderStatus($id, $status)
    {
        return $this->db->query(
            "UPDATE orders SET order_status=? WHERE id=? AND is_deleted=0",
            [$status, $id]
        );
    }
    public function deleteOrder($id)
    {
       
           $this->db->query(
        "UPDATE order_items SET is_deleted=1 WHERE id=?",
        [$id]
    );

         return $this->db->query(
        "UPDATE orders SET is_deleted=1 WHERE id=?",
        [$id]
    );
    }
    public function deleteUserOrder($id,$userId)
    {
       
           $this->db->query(
        "UPDATE order_items SET is_deleted=1 WHERE id=? And user_id=?",
        [$id,$userId]
    );

         return $this->db->query(
        "UPDATE orders SET is_deleted=1 WHERE id=? And user_id=?",
        [$id,$userId]
    );
    }

    public function markOrderPaid($id)
{
    $sql="UPDATE orders
          SET
            payment_status='paid',
            order_status='confirmed'
          WHERE id=?";

    return $this->db->query($sql,[$id]);
}

public function markOrderRefunded($id)
{
    $sql="UPDATE orders
          SET
            payment_status='refunded',
            order_status='cancelled'
          WHERE id=?";

    return $this->db->query($sql,[$id]);
}
}