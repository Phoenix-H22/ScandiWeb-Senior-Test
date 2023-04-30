<?php

namespace App\Core\Errors;

class Errors
{
    public static function E404()
    {
        http_response_code(404);
        require ROOT . '/views/errors/404.render.php';
        die();
    }
    public static function E500()
    {
        http_response_code(500);
        require ROOT . '/views/errors/500.render.php';
        die();
    }
}
