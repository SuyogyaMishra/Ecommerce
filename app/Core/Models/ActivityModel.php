<?php

namespace App\Core\Models;
use Core\Models\BaseModel;

class ActivityModel  extends BaseModel {

     public function logActivity($action , $metaData){
           $sql ='Insert into log_activity (user_id,user_role,action,meta_data) values(?,?,?,?)';
           return $this->db->query($sql,[$this->user['id'],$this->user['role'],$action,$metaData]);
     }
}
