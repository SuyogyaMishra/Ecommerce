<?php

function customLog($message){
    $path=WRITEPATH.'logs/'.'custom'.'-'.date('Y-m-d').'.log';
    $log='['.date('Y-m-d H:i:s').'] '.$message.PHP_EOL;
    file_put_contents($path,$log,FILE_APPEND);
}