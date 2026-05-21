<?php

namespace App\Models;

use App\Repositories\UserRepository;

class AnnouncementModel
{
    protected $db, $user;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->user = UserRepository::user();
    }

    public function insert($data)
    {
        $sql = "INSERT INTO announcements(title,	message,status,start_at	,end_at	,created_by)  Values (?,?,?,?,?,?)";

        $this->db->query(
            $sql,
            [
                $data['title'],
                $data['message'],
                $data['status'],
                $data['start_at'],
                $data['end_at'],
                $this->user['id'],
            ]



        );
        return $this->db->insertID();
    }

    public function allAnnouncement( $limit, $offset, $search, $column, $dir) {
        $sql = "SELECT 
                t1.*,
                MIN(t2.target_type) as target_type,
                GROUP_CONCAT(t2.target_id) AS target_ids

            FROM announcements t1

            INNER JOIN announcement_targets t2
            ON t1.id=t2.announcement_id";

        if ($search) {

            $sql .= "
            WHERE
            t1.message LIKE '%{$search}%'
            OR t1.title LIKE '%{$search}%'
        ";
        }

        $sql .= "
        GROUP BY t1.id
        ORDER BY {$column} {$dir}
        LIMIT {$limit}
        OFFSET {$offset}
    ";

        $data = $this->db
            ->query($sql)
            ->getResultArray();

        $totalSql = "
        SELECT COUNT(DISTINCT t1.id) as total

        FROM announcements t1

        INNER JOIN announcement_targets t2
        ON t1.id=t2.announcement_id
    ";

        if ($search) {

            $totalSql .= "
            WHERE
            t1.message LIKE '%{$search}%'
            OR t1.title LIKE '%{$search}%'
        ";
        }

        $total = $this->db
            ->query($totalSql)
            ->getRow()
            ->total;

        return [

            'data' => $data,

            'total' => $total

        ];
    }

    public function update($id, $data)
    {
        $sql = "UPDATE announcements 
    SET title=?,message=?,status=?,start_at=?,end_at=?,updated_at=NOW()
    WHERE id=?";

        return $this->db->query(
            $sql,
            [
                $data['title'],
                $data['message'],
                $data['status'],
                $data['start_at'],
                $data['end_at'],
                $id
            ]
        );
    }

    public function deleteById($id)
    {
        $sql = 'Delete From announcements where id=?';
        return $this->db->query($sql, [$id]);
    }
}
