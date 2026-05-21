<?php

namespace App\Models;

class TaxModel
{

    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function insertTax($data)
    {
        $sql = "INSERT INTO order_payment(user_id,order_id,name,amount,status) VALUES ";

        $values = [];
        $params = [];
        foreach ($data as $tax) {
            $values[] = "(?,?,?,?,?)";
            $params[] = $tax['user_id'];
            $params[] = $tax['order_id'];
            $params[] = $tax['name'];
            $params[] = $tax['amount'];
            $params[] = $tax['status'];
        }

         $sql .= implode(',', $values) . "
            ON DUPLICATE KEY UPDATE
                amount=VALUES(amount),
                status=VALUES(status)";

        $this->db->query($sql, $params);

        return $this->db->affectedRows() > 0;
    }

    public function deleteByCartId($id)
    {

        $sql = "UPDATE order_payment SET is_deleted=1 WHERE cart_id=?";

        return $this->db->query($sql, [$id]);
    }

    public function getTaxById($id)
    {

        $sql = "SELECT * FROM order_payment  WHERE user_id=? AND status = ? AND is_deleted =?";

        return $this->db->query($sql, [$id,'cart',0])->getResultArray();
    }


}
