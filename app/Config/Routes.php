<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ============ PUBLIK ============
$routes->get('/', '\App\Modules\Landing\Controllers\LandingController::index');

// ============ AUTH ============
$routes->post('/login/attempt', '\App\Modules\Auth\Controllers\AuthController::attemptLogin');
$routes->get('/logout', '\App\Modules\Auth\Controllers\AuthController::logout');

// ============ DASHBOARD ADMIN ============
$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard', '\App\Modules\Dashboard\Controllers\DashboardController::admin');
});

// ============ DASHBOARD USER OPD ============
$routes->group('opd', ['filter' => 'auth:opd'], function ($routes) {
    $routes->get('dashboard', '\App\Modules\Dashboard\Controllers\DashboardController::opd');
});