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

    // CRUD Akun OPD
    $routes->get('akun-opd', '\App\Modules\OPD\Controllers\AkunOpdController::index');
    $routes->get('akun-opd/create', '\App\Modules\OPD\Controllers\AkunOpdController::create');
    $routes->post('akun-opd/store', '\App\Modules\OPD\Controllers\AkunOpdController::store');
    $routes->get('akun-opd/detail/(:num)', '\App\Modules\OPD\Controllers\AkunOpdController::detail/$1');
    $routes->get('akun-opd/edit/(:num)', '\App\Modules\OPD\Controllers\AkunOpdController::edit/$1');
    $routes->post('akun-opd/update/(:num)', '\App\Modules\OPD\Controllers\AkunOpdController::update/$1');
    $routes->get('akun-opd/reset/(:num)', '\App\Modules\OPD\Controllers\AkunOpdController::resetPassword/$1');
    $routes->get('akun-opd/toggle/(:num)', '\App\Modules\OPD\Controllers\AkunOpdController::toggleStatus/$1');
});

// ============ DASHBOARD USER OPD ============
$routes->group('opd', ['filter' => 'auth:opd'], function ($routes) {
    $routes->get('dashboard', '\App\Modules\Dashboard\Controllers\DashboardController::opd');
});

// ============ UBAH PASSWORD (Admin & User OPD) ============
$routes->get('/ubah-password', '\App\Modules\Auth\Controllers\AuthController::ubahPassword', ['filter' => 'auth']);
$routes->post('/ubah-password/simpan', '\App\Modules\Auth\Controllers\AuthController::simpanPassword', ['filter' => 'auth']);