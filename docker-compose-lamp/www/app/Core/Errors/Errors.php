<?php

namespace App\Core\Errors;

class Errors
{
    /**
     * E404 method is responsible for rendering 404 page
     *
     * @return void
     */
    public static function E404():void
    {
        http_response_code(404);
        require ROOT . '/views/errors/404.render.php';
        die();
    }
    /**
     * E500 method is responsible for rendering 500 page
     *
     * @return void
     */
    public static function E500(): void
    {
        http_response_code(500);
        require ROOT . '/views/errors/500.render.php';
        die();
    }
}
