<?php

use App\Core\Router\Route;

$app = new Route();

// Existing routes
$app::get('/', 'ProductController', 'show');
$app::delete('/', 'ProductController', 'delete');
$app::get('/add-product', 'ProductController', 'add');
$app::post('/add-product', 'ProductController', 'create');
$app::get('/edit-product/{id}', 'ProductController', 'edit');
$app::put('/edit-product', 'ProductController', 'update');
// Add GraphQL route
$app::post('/graphql', 'GraphQLController', 'handle');
$app->run();
