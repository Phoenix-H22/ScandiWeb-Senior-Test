<?php

namespace App\Core\Router;

trait UrlEngine
{
    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function path()
    {
        if($_SERVER['REQUEST_URI']!= '/'){
        $path = $_SERVER['REQUEST_URI'];
        $path = explode("/", $path);
        $path = array_filter($path);
        $path = array_slice($path, 0);
        $path = "/".$path[0];
        }else{
            $path = '/';
        }
        return $path;
    }
    // params like /edit-product/1
    public function params()
    {
        $params = $_SERVER['REQUEST_URI'];
        $params = explode('/', $params);
        $params = array_filter($params);
        $params = array_slice($params, 1);
        return $params??null;
    }
    
}
