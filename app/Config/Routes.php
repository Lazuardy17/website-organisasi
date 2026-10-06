<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ============ PUBLIK ============
$routes->get('/', '\App\Modules\Landing\Controllers\LandingController::index');

// ============ AUTH ============
$routes->post('/login/attempt', '\App\Modules\Auth\Controllers\AuthController::attemptLogin');
$routes->get('/logout', '\App\Modules\Auth\Controllers\AuthController::logout');

// ============ UBAH PASSWORD (Admin & User OPD) ============
// ⭐ Tambah filter 'identitas' — biar OPD yang belum lengkap tidak bisa akses
$routes->get('/ubah-password', '\App\Modules\Auth\Controllers\AuthController::ubahPassword', ['filter' => ['auth', 'identitas']]);
$routes->post('/ubah-password/simpan', '\App\Modules\Auth\Controllers\AuthController::simpanPassword', ['filter' => ['auth', 'identitas']]);

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

    // Verifikasi Penilaian
    $routes->get('verifikasi', '\App\Modules\Verifikasi\Controllers\VerifikasiController::index');
    $routes->get('verifikasi/detail/(:num)', '\App\Modules\Verifikasi\Controllers\VerifikasiController::detail/$1');
    $routes->post('verifikasi/verifikasi/(:num)', '\App\Modules\Verifikasi\Controllers\VerifikasiController::verifikasi/$1');
    $routes->post('verifikasi/revisi/(:num)', '\App\Modules\Verifikasi\Controllers\VerifikasiController::revisi/$1');

    // Rekapitulasi
    $routes->get('rekapitulasi', '\App\Modules\Rekapitulasi\Controllers\RekapitulasiController::index');

    // Ekspor Laporan
    $routes->get('laporan', '\App\Modules\Laporan\Controllers\LaporanController::index');
    $routes->post('laporan/generate', '\App\Modules\Laporan\Controllers\LaporanController::generate');
});

// ============ DASHBOARD USER OPD ============
$routes->group('opd', ['filter' => 'auth:opd'], function ($routes) {

    // Identitas — TANPA filter 'identitas' (agar bisa diakses meski belum lengkap)
    $routes->get('identitas', '\App\Modules\OPD\Controllers\IdentitasController::index');
    $routes->post('identitas/simpan', '\App\Modules\OPD\Controllers\IdentitasController::simpan');

    // ⭐ Grup dengan filter 'identitas' — TERKUNCI sampai identitas lengkap
    $routes->group('', ['filter' => 'identitas'], function ($routes) {
        $routes->get('dashboard', '\App\Modules\Dashboard\Controllers\DashboardController::opd');

        // Akun OPD
        $routes->get('akun', '\App\Modules\OPD\Controllers\AkunController::index');
        $routes->post('akun/update', '\App\Modules\OPD\Controllers\AkunController::update');

        // Pengisian Variabel
        $routes->get('penilaian', '\App\Modules\Penilaian\Controllers\PenilaianController::index');
        $routes->post('penilaian/simpan/(:num)', '\App\Modules\Penilaian\Controllers\PenilaianController::simpan/$1');

        // Kesimpulan & Submit
        $routes->get('kesimpulan', '\App\Modules\Penilaian\Controllers\KesimpulanController::index');
        $routes->post('kesimpulan/submit', '\App\Modules\Penilaian\Controllers\KesimpulanController::submit');
    });
});

// ⚠️ HAPUS ROUTE DEBUG SEBELUM PRODUCTION
// $routes->get('/tes-pdf', function () { ... });