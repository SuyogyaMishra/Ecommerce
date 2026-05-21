<?php

namespace App\Factories;

class BaseFactory
{

    protected static array $items = [];

     public static function makeAll():array{

        $services=[];

        foreach(static::$items as $key=>$class){
            $services[$key]=new $class;
        }

        return $services;
    }

    public static function make($type)
    {

        if (!isset(static::$items[$type])) {
            throw new \Exception('Service Not Availble');
        }

        $class = static::$items[$type];

        return new $class;
    }
}
