<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel
{
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
                    salt,
                    role,
                    remember_token,
                    created_at,
                    updated_at
                )
                VALUES
                (
                    ?,
                    ?,
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
            $data['Salt'],
            $data['role'],
            $data['remember'] ?? false

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


    public function getAllUsers($column,$direction,$page = 1, $limit = 4)
    {
        $offset = ($page - 1) * $limit;

        $sql = "
        SELECT 
            id,
            name,
            email,
            role,
            status,
            created_at
        FROM users
        ORDER BY {$column} {$direction}
        LIMIT ? OFFSET ?
    ";

        $users = $this->db
            ->query($sql, [
                (int)$limit,
                (int)$offset
            ])
            ->getResultArray();

        $totalSql = "SELECT COUNT(*) as total FROM users";

        $total = $this->db
            ->query($totalSql)
            ->getRow()
            ->total;

        return [

            'users' => $users,

            'total' => $total,

            'page' => $page,

            'limit' => $limit

        ];
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


    public function repoUserById($id)
    {
        $sql = "SELECT id,name,role,email
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



    // // admin methods with the hash and salting 


    public function insertAdmin($data)
    {
        return $this->db->query("INSERT INTO users(name,email,password,salt,role,created_at,updated_at) VALUES
    (" . $this->db->escape($data['name']) . "," . $this->db->escape($data['email']) . "," . $this->db->escape($data['password']) . "," . $this->db->escape($data['salt']) . "," . $this->db->escape($data['role']) . ",NOW(),NOW())");
    }

    public function totalUsers()
    {
        $sql = "SELECT COUNT(*) AS total FROM users";
        $result = $this->db->query($sql)->getRowArray();
        return $result['total'];
    }
    public function activeUsers()
    {
        $sql = "SELECT COUNT(*) AS active FROM users where status=1 ";
        $result = $this->db->query($sql)->getRowArray();
        return $result['active'];
    }
    public function adminUsers()
    {
        $sql = "SELECT COUNT(*) AS  admin  FROM users where role = 'admin'";
        $result = $this->db->query($sql)->getRowArray();
        return $result['admin'];
    }

    public function getUsers()
    {
        $sql = "SELECT id,name ,email FROM users where role = 'user' And status='1'";
        return $this->db->query($sql)->getResultArray();
    }

    public function getUserByName($name)
    {

        $sql = "SELECT *
                FROM users
                WHERE name Like ?
                ";

        return $this->db->query($sql, ["%" . $name . "%"])->getResultArray();
    }

    public function updateUser($data)
    {
        $sql = "UPDATE users
          SET
            name=?,
            email=?,
            role=?,
            status=?,
            updated_at=NOW()
          WHERE id=?";

        return $this->db->query($sql, [

            $data['name'],
            $data['email'],
            $data['role'],
            $data['status'],
            $data['id']

        ]);
    }

    public function getSearchedUser($keyword)
    {
        $sql = "SELECT id,name,email
                FROM users
                WHERE name Like ? or email Like ?
                ";

        return $this->db->query($sql, ["%" . $keyword . "%", "%" . $keyword . "%"])->getResultArray();
    }
}
