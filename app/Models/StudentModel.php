<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'students';
    public function getAllStudents()
    {
        return $this->db->query("SELECT * FROM students")->getResult();
    }

    public function getStudentById($id)
    {
        return $this->db
            ->query("SELECT * FROM students WHERE id = ?", [$id])
            ->getRow();
    }

    public function insertStudent($data)
    {
        $sql = "INSERT INTO students 
                (first_name, last_name, fee, adr, DOA, created_at)
                VALUES (?, ?, ?, ?, ?, NOW())";

        return $this->db->query($sql, [
            $data['first_name'],
            $data['last_name'],
            $data['fee'],
            $data['adr'],
            $data['DOA']
        ]);
    }

    public function updateStudent($id, $data)
    {
        $sql = "UPDATE students 
                SET first_name = ?, last_name = ?, fee = ?, adr = ?, DOA = ?, updated_at = NOW()
                WHERE id = ?";

        return $this->db->query($sql, [
            $data['first_name'],
            $data['last_name'],
            $data['fee'],
            $data['adr'],
            $data['DOA'],
            $id
        ]);
    }

    public function deleteStudent($id)
    {
        return $this->db
            ->query("DELETE FROM students WHERE id = ?", [$id]);
    }
}