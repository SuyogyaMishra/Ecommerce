<?php

namespace App\Vendors\Models;

use App\Vendors\Models\BaseModel;

class VendorDocs  extends BaseModel
{
     public function addDocs($docs){
        $sql = "INSERT INTO vendor_docs (doc_name,doc_number,vendor_id,path) values(?,?,?,?)";
        return $this->db->query($sql,[$docs['name'],$docs['number'],$docs['v_id'],$docs['url']]);
     }

     public function getKycDetails($id){
      $sql= "Select v.name , vd.doc_name,vd.doc_number,vd.path,vd.vendor_id from vendor_docs vd inner join vendors v 

            on vd.vendor_id = v.id order by vd.created_at desc limit 1
      ";

      return $this->db->query($sql,[$id])->getRowArray();
     }

     public function VerifyKyc($adminId,$vendorId){
         $sql= 'update vendor_docs Set is_verified = 1, admin_id = ? where vendor_id = ? ';
         return  $this->db->query($sql,[$adminId,$vendorId]);

       
     }

     

      public function RejectKyc($adminId,$vendorId){
         $sql= 'update vendor_docs Set is_verified = 0, admin_id = ? where vendor_id = ?  ';
         $this->db->query($sql,[$adminId,$vendorId]);

       
     }

}