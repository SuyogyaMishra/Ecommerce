<?php

use App\Core\Models\ActivityModel;

function test(){
   $test= changeToJson(['name' => 'Suyogya', 'age' => '11'],['name'=>'sonia','age'=>'21']);
    var_dump($test);die;
}

function logActivity($action, $metaData = null) {
    try{
     $activityModel= new ActivityModel();
     customLog('checking');
     $status= $activityModel->logActivity($action,$metaData);
     if(!$status){
        customLog('some error occured during activty log');
     }
     return true;
    } 
    catch(\Exception $e){
        customLog($e->getMessage());
    }
}

 function changeToJson($changes,$existing){
    $old=[];
    $new=[];
    foreach($changes as $key => $value){
         $new[$key]=$value;
    }
    foreach($existing as $key => $value){
         $old[$key]=$value;
    }
     return json_encode([
    "before" => $old,
    "changes" => $new
       ], JSON_PRETTY_PRINT);



 }

