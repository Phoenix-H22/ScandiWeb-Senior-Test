<?php

namespace App\Core\Controller;

use App\Core\Errors\Errors;
/**
 * abstract class Controller is responsible for creating a contract for controllers
 */

abstract class Controller
{
    /**
     * Render method is responsible for rendering views
     *
     * @param string $view
     * @param array $data
     * @return void
     */
    public function render(string $view, array $data = null): void
    {
        if (file_exists(ROOT . '/views/' . $view . '.render.php')) {
            require ROOT . '/views/' . $view . '.render.php';
        } else {
            Errors::E500();
        }
    }
    /**
     * Redirect method is responsible for redirecting to a specific url
     *
     * @param string $url
     * @return void
     */
    public function redirect(string $url): void
    {
        if (!headers_sent()) {
            header('Location: ' . $url, true);
            exit();
        }
    }
    /**
     * Model method is responsible for returning a new instance of a model
     *
     * @param string $modelName
     * @return object
     */
    public function model(string $modelName): object
    {
        $model = 'App\\Models\\' . $modelName;
        return new $model();
    }
}
