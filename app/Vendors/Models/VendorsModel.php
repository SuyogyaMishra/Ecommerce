<?php

namespace App\Vendors\Models;
use App\Vendors\Models\BaseModel;
class VendorsModel  extends BaseModel {

     public function addVendor($data){
           $sql ='Insert into vendors (name,email,salt,password) values(?,?,?,?)';
         return  $this->db->query($sql,[$data['name'],$data['email'],$data['salt'],$data['password']]);
     }

     public function getVendorByEmail($email){
         $sql = ' Select * from vendors where email = ?';
         return $this->db->query($sql,$email)->getRow();
     }
     public function getVendorById($Id){
         $sql = ' Select * from vendors where email = ?';
         return $this->db->query($sql,$Id)->getRow();
     }

}
