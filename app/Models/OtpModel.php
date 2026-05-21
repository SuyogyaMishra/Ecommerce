<?php

namespace App\Models;

use CodeIgniter\Model;

class OtpModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db=\Config\Database::connect();
    }

    public function createOtp($userId,$otp,$type='wallet')
    {
        return $this->db->query(
            "INSERT INTO otps(user_id,otp,type,expires_at) VALUES(?,?,?,DATE_ADD(NOW(),INTERVAL 5 MINUTE))",
            [$userId,$otp,$type]
        );
    }

    public function getOtp($userId,$otp,$type='wallet')
    {
        return $this->db->query(
            "SELECT * FROM otps WHERE user_id=? AND otp=? AND type=? ORDER BY id DESC LIMIT 1",
            [$userId,$otp,$type]
        )->getRowArray();
    }

    public function verifyOtp($id)
    {
        return $this->db->query(
            "UPDATE otps SET verified=1 WHERE id=?",
            [$id]
        );
    }

    public function invalidateOtp($userId,$type='wallet')
    {
        return $this->db->query(
            "UPDATE otps SET verified=1 WHERE user_id=? AND type=?",
            [$userId,$type]
        );
    }
}