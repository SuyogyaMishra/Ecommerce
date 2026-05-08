<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel{
    protected $db;

    public function __construct()
    {

        $this->db = \Config\Database::connect();
    }

    public function insertUser($data)
    {
        $sql = "INSERT INTO users
                (
                    name,
                    email,
                    password,
                    role,
                    created_at,
                    updated_at
                )
                VALUES
                (
                    ?,
                    ?,
                    ?,
                    ?,
                    NOW(),
                    NOW()
                )";

        return $this->db->query($sql, [

            $data['name'],
            $data['email'],
            $data['password'],
            $data['role']

        ]);
    }

  

    public function loginUser($email)
    {
        $sql = "SELECT *
                FROM users
                WHERE email = ?
                AND status = 1
                LIMIT 1";

        return $this->db
                    ->query($sql, [$email])
                    ->getRowArray();
    }



    public function updateRememberToken($id, $token)
    {
        $sql = "UPDATE users
                SET remember_token = ?,
                    updated_at = NOW()
                WHERE id = ?";

        return $this->db->query($sql, [

            $token,
            $id

        ]);
    }



    public function getUserByToken($token)
    {
        $sql = "SELECT *
                FROM users
                WHERE remember_token = ?
                LIMIT 1";

        return $this->db
                    ->query($sql, [$token])
                    ->getRowArray();
    }


    public function removeRememberToken($id)
    {
        $sql = "UPDATE users
                SET remember_token = NULL
                WHERE id = ?";

        return $this->db->query($sql, [$id]);
    }


    public function getAllUsers()
    {
        $sql = "SELECT
                    id,
                    name,
                    email,
                    role,
                    status,
                    created_at
                FROM users
                ORDER BY id DESC";

        return $this->db
                    ->query($sql)
                    ->getResultArray();
    }

 
    public function getUserById($id)
    {
        $sql = "SELECT *
                FROM users
                WHERE id = ?
                LIMIT 1";

        return $this->db
                    ->query($sql, [$id])
                    ->getRowArray();
    }



    public function deleteUser($id)
    {
        $sql = "DELETE FROM users
                WHERE id = ?";

        return $this->db->query($sql, [$id]);
    }



    public function updateStatus($id, $status)
    {
        $sql = "UPDATE users
                SET status = ?,
                    updated_at = NOW()
                WHERE id = ?";

        return $this->db->query($sql, [

            $status,
            $id

        ]);
    }
      
    
}