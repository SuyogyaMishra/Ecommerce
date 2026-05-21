<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model{

    protected $table='payments';

    public function createPayment($data)
    {
        $sql="INSERT INTO payments(
                user_id,
                gateway,
                gateway_order_id,
                amount,
                status
            )
            VALUES(?,?,?,?,?)";

        return $this->db->query($sql,[
            $data['order_id'],
            $data['gateway'],
            $data['gateway_order_id'],
            $data['amount'],
            $data['status']
        ]);
    }

    public function getByGatewayOrderId($gatewayOrderId)
    {
        $sql="SELECT * FROM payments
              WHERE gateway_order_id=?
              LIMIT 1";

        return $this->db
        ->query($sql,[$gatewayOrderId])
        ->getRowArray();
    }

    public function getPaymentByOrderId($orderId)
    {
        $sql="SELECT * FROM payments
              WHERE order_id=?
              LIMIT 1";

        return $this->db
        ->query($sql,[$orderId])
        ->getRowArray();
    }

    public function markPaid($id,$paymentId,$payload=null)
    {
        $sql="UPDATE payments
              SET
                gateway_payment_id=?,
                status='paid',
                payload=?
              WHERE id=?";

        return $this->db->query($sql,[
            $paymentId,
            $payload,
            $id
        ]);
    }

    public function markFailed($id,$payload=null)
    {
        $sql="UPDATE payments
              SET
                status='failed',
                payload=?
              WHERE id=?";

        return $this->db->query($sql,[
            $payload,
            $id
        ]);
    }

    public function markRefunded($id,$payload=null)
    {
        $sql="UPDATE payments
              SET
                status='refunded',
                payload=?
              WHERE id=?";

        return $this->db->query($sql,[
            $payload,
            $id
        ]);
    }
      public function updatePaymentStatus( $paymentId, $status)
    {
        return $this->db->query(
            "UPDATE payments SET gateway_payment_id=?, status=? ",
            [$paymentId, $status]
        );
    }
}