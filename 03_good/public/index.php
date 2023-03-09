<?php

require_once '../vendor/autoload.php';

use app\controllers\ProductController;
use app\Router;

$router = new Router;

$router->get('/', [ProductController::class, 'index']);
$router->get('/products', [ProductController::class, 'index']);

$router->get('/products/create', [ProductController::class, 'create']);
$router->post('/products/create', [ProductController::class, 'create']);

$router->get('/products/update', [ProductController::class, 'update']);
$router->post('/products/update', [ProductController::class, 'update']);

$router->post('/products/delete', [ProductController::class, 'delete']);


$router->resolve();