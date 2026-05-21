<?php

namespace App\Models;

use App\Repositories\UserRepository;

class AnnouncementTargetModel
{

    protected $db, $user;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->user = UserRepository::user();
    }

    public function insert($data)
    {
        $sql = 'INSERT INTO announcement_targets (announcement_id,target_type,target_id) values (?,?,?)';
        return $this->db->query($sql, [
            $data['id'],
            $data['type'],
            $data['target_id']
        ]);
    }

    public function update($id, $data)
    {

        $sql = 'UPDATE announcement_targets 
    SET target_type=?,target_id=?,updated_at=NOW()
    WHERE announcement_id=?';

        return $this->db->query($sql, [
            $data['type'],
            $data['target_id'],
            $id
        ]);
    }

    public function deleteByAnnouncementId($id)
{
    return $this->db->query(
        "DELETE FROM announcement_targets WHERE announcement_id=?",
        [$id]
    );
}

public function getByUser()
{
    return $this->db->query(
        "SELECT DISTINCT a.title,a.message
        FROM announcements a
        JOIN announcement_targets t ON t.announcement_id=a.id
        WHERE a.status=1
        AND (
            (a.start_at<=NOW())
            AND ( a.end_at>=NOW())
        )
        AND (
            t.target_type='ALL_USERS'
            OR (t.target_type='SPECIFIC_USER' AND t.target_id=?)
        )Order By a.created_at DESC ",
        [$this->user['id']]
    )->getResultArray();
}
}
