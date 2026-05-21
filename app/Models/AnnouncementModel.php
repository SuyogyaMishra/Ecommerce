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

    public function allAnnouncement()
    {

        $sql = "SELECT t1.*,MIN(t2.target_type) as target_type,GROUP_CONCAT(t2.target_id) AS target_ids
    FROM announcements t1
    INNER JOIN announcement_targets t2
    ON t1.id=t2.announcement_id
    GROUP BY t1.id";

        return $this->db->query($sql)->getResultArray();
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

    public function deleteById($id){
        $sql ='Delete From announcements where id=?';
        return $this->db->query($sql,[$id]);
    }
}
