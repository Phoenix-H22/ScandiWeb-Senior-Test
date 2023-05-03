<?php

namespace App\Core\Router;
/**
 * trait UrlEngine is responsible for getting the request method, path and params
 */

trait UrlEngine
{
    /**
     * method method is responsible for getting the request method
     *
     * @return string
     */
    public function method()
    {
        if($_SERVER['REQUEST_METHOD'] == 'PUT'){
            return 'post';
        }else if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
            return 'post';
        }else{
            return strtolower($_SERVER['REQUEST_METHOD']);
        }
    }
    /**
     * path method is responsible for getting the request path
     *
     * @return string
     */

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
    /**
     * params method is responsible for getting the request params
     *
     * @return array
     */
    public function params()
    {
        $params = $_SERVER['REQUEST_URI'];
        $params = explode('/', $params);
        $params = array_filter($params);
        $params = array_slice($params, 1);
        if($params){
            $params["id"] = $params[0]??null;
            if($params["id"]!=null){
                unset($params[0]);
            }
        }else{
            $params = null;
        }
        return $params;
    }
    
}
