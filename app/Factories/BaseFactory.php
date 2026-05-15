<?php

namespace App\Factories;

class BaseFactory{

    protected static array $items=[];

    public static function make($type){

        if(!isset(static::$items[$type])){
            throw new \Exception('Invalid type');
        }

        $class=static::$items[$type];

        return new $class;
    }
}