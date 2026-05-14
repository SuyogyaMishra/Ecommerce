<?php
if(!function_exists('generateOrderId')){

    function generateOrderId($prefix='ORD'){
        return $prefix.'-'.date('YmdHis').'-'.strtoupper(bin2hex(random_bytes(3)));
    }
}