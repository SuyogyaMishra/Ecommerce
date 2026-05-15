<?php

namespace App\Models;

use CodeIgniter\Model;

class WalletPaymentModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db=\Config\Database::connect();
    }

    public function insertPayment($data)
    {
        $sql="INSERT INTO wallet_payments(user_id,order_id,wallet_id,transaction_id,amount,type,status,note) VALUES(?,?,?,?,?,?,?,?)";

        return $this->db->query($sql,[
            $data['user_id'],
            $data['order_id'],
            $data['wallet_id'] ?? null,
            $data['transaction_id'],
            $data['amount'],
            $data['type'],
            $data['status'],
            $data['note'] ?? null
        ]);
    }

    

    public function getByOrderId($orderId)
    {
        $sql="SELECT * FROM wallet_payments WHERE order_id=? LIMIT 1";

        return $this->db->query($sql,[$orderId])->getRowArray();
    }



    public function getByTransactionId($transactionId)
    {
        $sql="SELECT * FROM wallet_payments WHERE transaction_id=? LIMIT 1";

        return $this->db->query($sql,[$transactionId])->getRowArray();
    }



    public function getUserPayments($userId)
    {
        $sql="SELECT * FROM wallet_payments WHERE user_id=? ORDER BY id DESC";

        return $this->db->query($sql,[$userId])->getResultArray();
    }



    public function updateStatus($id,$status)
    {
        $sql="UPDATE wallet_payments SET status=? WHERE id=?";

        return $this->db->query($sql,[$status,$id]);
    }



    public function refundPayment($id)
    {
        $sql="UPDATE wallet_payments SET status='refunded' WHERE id=?";

        return $this->db->query($sql,[$id]);
    }
}