<?php

namespace App\Models;

use CodeIgniter\Model;

class WalletModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function addWallet($data)
    {
        $this->db->query(
            "INSERT INTO wallet(user_id,type,amount,source,reference_id,note,created_at) VALUES(?,?,?,?,?,?,CURRENT_TIMESTAMP)",
            [
                $data['user_id'],
                $data['type'],
                $data['amount'],
                $data['source'],
                $data['reference_id'],
                $data['note']
            ]
        );

        return $this->db->insertID();
    }

    public function rechargeWallet($user_id, $amount, $source = 'cash', $reference_id = null, $note = 'wallet recharge')
    {
        return $this->db->query(
            "INSERT INTO wallet(user_id,type,amount,source,reference_id,note,created_at) VALUES(?,?,?,?,?,?,CURRENT_TIMESTAMP)",
            [
                $user_id,
                'credit',
                $amount,
                $source,
                $reference_id,
                $note
            ]
        );
    }

    public function debitWallet($user_id, $amount, $source = 'wallet', $reference_id = null, $note = 'wallet debit')
    {
        $balance = $this->getBalance($user_id);

        if ($balance < $amount) return false;

        return $this->db->query(
            "INSERT INTO wallet(user_id,type,amount,source,reference_id,note,created_at) VALUES(?,?,?,?,?,?,CURRENT_TIMESTAMP)",
            [
                $user_id,
                'debit',
                $amount,
                $source,
                $reference_id,
                $note
            ]
        );
    }

    // public function getWallet($user_id, $limit = 50)
    // {
    //     return $this->db->query(
    //         "SELECT * FROM wallet WHERE user_id=? ORDER BY id DESC LIMIT ?",
    //         [$user_id, $limit]
    //     )->getResultArray();
    // }

    public function getBalance($user_id)
    {
        $row = $this->db->query(
            "SELECT 
            IFNULL(SUM(CASE WHEN type='credit' THEN amount ELSE 0 END),0)-
            IFNULL(SUM(CASE WHEN type='debit' THEN amount ELSE 0 END),0) balance
            FROM wallet 
            WHERE user_id=?",
            [$user_id]
        )->getRowArray();

        return (float)$row['balance'];
    }




    public function getTransaction($user_id)
    {
        $sql = "SELECT w1.*,
                 (
                         SELECT SUM(
                                CASE             
                                 WHEN w2.type='credit' THEN w2.amount
                                  ELSE -w2.amount
                                  END
                    )
        FROM wallet w2
        WHERE w2.user_id=w1.user_id
        AND w2.id<=w1.id
    ) balance
    FROM wallet w1
    WHERE w1.user_id=?
    ORDER BY w1.id DESC";

        return $this->db->query($sql, [$user_id])->getResultArray();
    }




    public function deleteTransaction($id)
    {
        return $this->db->query(
            "DELETE FROM wallet WHERE id=?",
            [$id]
        );
    }

    public function totalCredits($user_id)
    {
        $row = $this->db->query(
            "SELECT IFNULL(SUM(amount),0) total FROM wallet WHERE user_id=? AND type='credit'",
            [$user_id]
        )->getRowArray();

        return (float)$row['total'];
    }

    public function totalDebits($user_id)
    {
        $row = $this->db->query(
            "SELECT IFNULL(SUM(amount),0) total FROM wallet WHERE user_id=? AND type='debit'",
            [$user_id]
        )->getRowArray();

        return (float)$row['total'];
    }

    public function getCredits($user_id)
    {
        return $this->db->query(
            "SELECT * FROM wallet WHERE user_id=? AND type='credit' ORDER BY id DESC",
            [$user_id]
        )->getResultArray();
    }

    public function getDebits($user_id)
    {
        return $this->db->query(
            "SELECT * FROM wallet WHERE user_id=? AND type='debit' ORDER BY id DESC",
            [$user_id]
        )->getResultArray();
    }

    public function transferWallet($from, $to, $amount, $reference_id = null)
    {
        $this->db->transStart();

        $this->debitWallet($from, $amount, 'transfer', $reference_id, 'wallet transfer debit');

        $this->rechargeWallet($to, $amount, 'transfer', $reference_id, 'wallet transfer credit');

        $this->db->transComplete();

        return $this->db->transStatus();
    }
}
