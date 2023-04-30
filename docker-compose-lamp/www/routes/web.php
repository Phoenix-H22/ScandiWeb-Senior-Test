<?php

use App\Core\Router\Route;

$app = new Route();

$app::get('/', 'ProductController', 'show');
$app::post('/', 'ProductController', 'delete');
$app::get('/add-product', 'ProductController', 'add');
$app::post('/add-product', 'ProductController', 'create');
$app->run();
