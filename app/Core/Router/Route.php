<?php

namespace App\Core\Router;
use App\Core\Errors\Errors;
/**
 * Route class is responsible for routing the application
 */

class Route
{
    
    use Router;
    use UrlEngine;

    /**
     * run method is responsible for running routes and calling the appropriate controller
     */
    public function run()
    {   
        //run the match function to get the class and method
        $callable = $this->match($this->method(), $this->path());
        if (!$callable) {
            Errors::E404();
        }
        //call the class, pass the method
        //add the default namespace to the controller
        $class = "App\\Controllers\\".$callable['class'];
        if (!class_exists($class)) {
            Errors::E500();
        }
        
        $method = $callable['method'];

        if (!is_callable($class, $method)) {
            Errors::E500();
        }
        $class = new $class();
        //run the method with the params if they exist
        if($this->params() == null){
          $class->$method();
            return;
        }else{
            $_REQUEST["id"] = $this->params();
            $class->$method($_REQUEST["id"]);
            return;
        }
        
       
    }
    /**
     * match method is responsible for matching the url with the routes
     *
     * @param string $method
     * @param string $url
     * @return bool | array
     */

    private function match($method, $url)
    {

        foreach (self::$map[$method] as $uri=>$call) {
            //does the $url have a trailing slash? if yes, remove it
            //make sure the only string present is not the slash
            if (substr($url, -1) === '/' && $uri != '/') {
                //remove the slash
                $url = substr($url, 0, -1);

                
            }
            //if our $uri does not contain a pre-slash, we add it
            if ($url == $uri) {
                return $call;

            }
        }
        return false;
    }
}
