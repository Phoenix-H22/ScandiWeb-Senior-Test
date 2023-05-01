<?php

use App\Core\Router\Route;

$app = new Route();

$app::get('/', 'ProductController', 'show');
$app::post('/', 'ProductController', 'delete');
$app::get('/add-product', 'ProductController', 'add');
$app::post('/add-product', 'ProductController', 'create');
$app::get('/edit-product', 'ProductController', 'edit');
// $app::post('/edit-product', 'ProductController', 'update');
$app->run();
