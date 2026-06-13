<?php

use App\Controllers\Admin;
use App\Controllers\Home;
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', [Home::class, 'index']);
$routes->post('/login', [Home::class, 'login']);
$routes->get('/logout', [Home::class, 'logout']);

$routes->group('admin', ['filter' => 'adminauth'], function ($routes) {
    $routes->get('/', [Admin::class, 'index']);

    // Generic user management routes
    $routes->get('manage/(:segment)', [Admin::class, 'manageUsers']);
    $routes->post('user_simpan/(:segment)', [Admin::class, 'user_simpan']);
    $routes->post('user_padam/(:segment)/(:num)', [Admin::class, 'user_padam']);
    $routes->post('user_reset/(:segment)/(:num)', [Admin::class, 'user_reset']);
    $routes->post('user_sekat/(:segment)/(:num)', [Admin::class, 'user_sekat']);
    $routes->post('user_aktifkan/(:segment)/(:num)', [Admin::class, 'user_aktifkan']);

    $routes->get('jabatan', [Admin::class, 'jabatan']);
    $routes->post('jabatan_simpan', [Admin::class, 'jabatan_simpan']);
    $routes->post('jabatan_padam/(:num)', [Admin::class, 'jabatan_padam']);

    $routes->get('ketua', [Admin::class, 'ketua']);
    $routes->post('ketua_simpan', [Admin::class, 'ketua_simpan']);
    $routes->post('ketua_padam/(:num)', [Admin::class, 'ketua_padam']);
    $routes->post('ketua_reset/(:num)', [Admin::class, 'ketua_reset']);
    $routes->post('ketua_sekat/(:num)', [Admin::class, 'ketua_sekat']);
    $routes->post('ketua_aktifkan/(:num)', [Admin::class, 'ketua_aktifkan']);


    /*
     * Jabatan
     * - Ketua Program / Jabatan
     * - Program
     *   - Mata Pelajaran
     */
    // perlu tambah pengurusan senarai jabatan & ketua
    // tambah
    // selepas keluarkan role=ketua dari pengguna
});