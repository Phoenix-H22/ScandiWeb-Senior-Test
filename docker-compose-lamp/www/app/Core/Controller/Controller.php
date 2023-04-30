<?php

namespace App\Core\Controller;

use App\Core\Errors\Errors;

abstract class Controller
{
    public function render(string $view, array $data = null): void
    {
        if (file_exists(ROOT . '/views/' . $view . '.render.php')) {
            require ROOT . '/views/' . $view . '.render.php';
        } else {
            Errors::E500();
        }
    }

    public function redirect(string $url): void
    {
        if (!headers_sent()) {
            header('Location: ' . $url, true);
            exit();
        }
    }

    public function model(string $modelName): object
    {
        $model = 'App\\Models\\' . $modelName;
        return new $model();
    }
}
