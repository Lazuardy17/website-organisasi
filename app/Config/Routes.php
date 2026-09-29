<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');

$routes->get('/login', '\App\Modules\Auth\Controllers\AuthController::login');
$routes->post('/login/attempt', '\App\Modules\Auth\Controllers\AuthController::attemptLogin');
$routes->get('/logout', '\App\Modules\Auth\Controllers\AuthController::logout');

