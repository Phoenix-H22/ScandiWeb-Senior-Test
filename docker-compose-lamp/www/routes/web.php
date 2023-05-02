<?php

use App\Core\Router\Route;

$app = new Route();
// List of routes
$app::get('/', 'ProductController', 'show');
$app::delete('/', 'ProductController', 'delete');
$app::get('/add-product', 'ProductController', 'add');
$app::post('/add-product', 'ProductController', 'create');
$app::get('/edit-product', 'ProductController', 'edit');
$app::put('/edit-product', 'ProductController', 'update');
$app->run();
