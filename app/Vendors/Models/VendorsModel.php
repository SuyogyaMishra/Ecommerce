<?php

namespace App\Vendors\Models;

use App\Vendors\Models\BaseModel;

class VendorsModel  extends BaseModel
{
         
    public function addVendor($data)
    {
        $sql = 'Insert into vendors (name,email,salt,password) values(?,?,?,?)';
        return  $this->db->query($sql, [$data['name'], $data['email'], $data['salt'], $data['password']]);
    }

    public function getVendorByEmail($email)
    {
        $sql = ' Select * from vendors where email = ?';
        return $this->db->query($sql, $email)->getRow();
    }
    public function getVendorById($Id)
    {
        $sql = ' Select id,name,email from vendors where id = ?';
        return $this->db->query($sql, $Id)->getRow();
    }

    public function getTotalVendor()
    {
        $sql = "SELECT COUNT(id) as total FROM vendors";

        $result = $this->db
            ->query($sql)
            ->getRow();

        return $result->total;
    }
    public function totalKycPending()
    {
        $sql = "SELECT COUNT(id) as total FROM vendors  Where kyc_status=0";

        $result = $this->db
            ->query($sql)
            ->getRow();

        return $result->total;
    }
    public function totalRequestedKyc()
    {
        $sql = "SELECT COUNT(id) as total FROM vendors  Where kyc_status=1";

        $result = $this->db
            ->query($sql)
            ->getRow();

        return $result->total;
    }

    public function getVendors()
    {
        $sql = ' Select * from vendors';
        return $this->db->query($sql)->getResultArray();
    }

    public function requestedKyc()
    {
        $sql = "SELECT * FROM vendors  Where kyc_status=1";

        return  $this->db
            ->query($sql)
            ->getResultArray();
    }

    public function getDashboardVendors($offset, $limit, $dir, $cl, $search = null,)
    {

        $sql = "SELECT id,name,email,status,kyc_status From  vendors ";
        $params = [];
        if (!empty($search)) {

            $sql .= " where name LIKE ? OR email LIKE ?";

            array_push( $params,"%{$search}%");

            array_push($params,"%{$search}%");
        }
        $sql = $sql . " Order BY {$cl} {$dir} Limit {$limit} OFFSET {$offset}  ";

        return $this->db->query($sql, $params)->getResultArray();
    }

    public function getRequestedVendors($offset, $limit, $dir, $cl, $search = null,)
    {

        $sql = "SELECT id,name,email,status,kyc_status From  vendors  where kyc_status = 1";
        $params = [];
        if (!empty($search)) {

            $sql .= "
        AND (
            name LIKE ?
            OR email LIKE ?
        )
    ";

            array_push(
                $params,
                "%{$search}%"
            );

            array_push(
                $params,
                "%{$search}%"
            );
        }
        $sql = $sql . " Order BY {$cl} {$dir} Limit {$limit} OFFSET {$offset}  ";

        return $this->db->query($sql, $params)->getResultArray();
    }



    public function updateVendor($data){
        $sql = 'Update vendors Set name=? , email=?,status=? where id = ?';
        return $this->db->query($sql,[$data['name'],$data['email'],$data['status'],$data['id']]);
    }

    public function deleteVendor($id){
        $sql = "Delete from Vendors where id = ?";
        return $this->db->query($sql,[$id]);
    }



    public function changeKycStatus($id,$status){
        $sql = 'Update vendors Set kyc_status=? where id = ?';

        return $this->db->query($sql,[$status,$id]);
    }

    public function getKycStatus($id){
        $sql = 'Select kyc_status as status from vendors where id = ?';
        return $this->db->query($sql,[$id])->getRowArray();
    }


    public function chnageStatusByAdmin($id,$adminId,$status){
        $sql = 'Update vendors Set kyc_status = ? , admin_id =? where id = ?';

        return $this->db->query($sql,[$status,$adminId,$id]);
    }
}
