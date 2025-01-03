<?php

namespace App\Core\Router;
use App\Core\Errors\Errors;
use ReflectionClass;

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
        $callable = $this->match($this->method(), $this->path());

        if (!$callable) {
            Errors::E404();
        }

        $class = "App\\Controllers\\" . $callable['class'];
        $method = $callable['method'];
        if (!class_exists($class)) {
            var_dump("Class does not exist:", $class);
            die();
        }

        $classInstance = new $class();

        if (!method_exists($classInstance, $method)) {
            var_dump("Method does not exist:", $method);
            die();
        }

        if (!is_callable([$classInstance, $method])) {
            var_dump("Method is not callable:", $classInstance, $method);
            die();
        }


        // Call the method with parameters
        call_user_func_array([$classInstance, $method], $_REQUEST);
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
        foreach (self::$map[$method] as $uri => $call) {
            // Convert route placeholders (e.g., /edit-product/{id}) to regex
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $uri);
            $pattern = "@^" . $pattern . "$@";

            if (preg_match($pattern, $url, $matches)) {
                // Extract dynamic parameters
                $params = array_filter(
                    $matches,
                    fn($key) => !is_numeric($key),
                    ARRAY_FILTER_USE_KEY
                );

                // Store parameters for later use
                $_REQUEST = array_merge($_REQUEST, $params);

                return $call;
            }
        }

        return false;
    }

}
