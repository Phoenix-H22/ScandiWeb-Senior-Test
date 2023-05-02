<?php

namespace App\Core\Router;

trait Router
{
    private static $map;
    public static function get($url, $class, $method)
    {

        self::$map['get'][$url] = [
            'class'=>$class,
            'method'=>$method
        ];
    }

    public static function post($url, $class, $method)
    {

        self::$map['post'][$url] = [
            'class'=>$class,
            'method'=>$method
        ];
    }
    public static function put($url, $class, $method)
    {
        self::$map['post'][$url] = [
            'class'=>$class,
            'method'=>$method
        ];
    }
    public static function delete($url, $class, $method)
    {
        self::$map['post'][$url] = [
            'class'=>$class,
            'method'=>$method
        ];
    }


    public static function getMap()
    {
        return self::$map;
    }
}
