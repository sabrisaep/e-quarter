<?php

use App\Controllers\Admin;
use App\Controllers\Home;
use App\Controllers\Kerani;
use App\Controllers\Ketua;
use App\Controllers\Pengguna;
use App\Controllers\Pengurusan;
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

    $routes->get('program', [Admin::class, 'program']);
    $routes->post('program_simpan', [Admin::class, 'program_simpan']);
    $routes->post('program_padam/(:num)', [Admin::class, 'program_padam']);

    $routes->get('mata_pelajaran', [Admin::class, 'mata_pelajaran']);
    $routes->get('mata_pelajaran_semua', [Admin::class, 'mata_pelajaran_semua']);
    $routes->post('mata_pelajaran_simpan', [Admin::class, 'mata_pelajaran_simpan']);
    $routes->post('mata_pelajaran_padam/(:num)', [Admin::class, 'mata_pelajaran_padam']);
    $routes->get('get-program-by-jabatan/(:num)', [Admin::class, 'getProgramByJabatan']);
    $routes->get('get-mp-by-program/(:num)', [Admin::class, 'getMataPelajaranByProgram']);

    $routes->get('kata_laluan', [Admin::class, 'kata_laluan']);
    $routes->post('kata_laluan_simpan', [Admin::class, 'kata_laluan_simpan']);
});

$routes->group('kerani', ['filter' => 'keraniauth'], function ($routes) {
    $routes->get('/', [Kerani::class, 'index']);
    $routes->get('sukuan', [Kerani::class, 'sukuan']);
    $routes->get('subsidiari', [Kerani::class, 'subsidiari']);
    $routes->get('profil', [Kerani::class, 'profil']);
});

$routes->group('ketua', ['filter' => 'ketuaauth'], function ($routes) {
    $routes->get('/', [Ketua::class, 'index']);
    $routes->get('kategori', [Ketua::class, 'kategori']);
    $routes->get('sukuan', [Ketua::class, 'sukuan']);
    $routes->get('nota_minta', [Ketua::class, 'nota_minta']);
    $routes->get('profil', [Ketua::class, 'profil']);
});

$routes->group('pengurusan', ['filter' => 'pengurusanauth'], function ($routes) {
    $routes->get('/', [Pengurusan::class, 'index']);
    $routes->get('perbelanjaan', [Pengurusan::class, 'perbelanjaan']);
    $routes->get('subsidiari', [Pengurusan::class, 'subsidiari']);
    $routes->get('analisis', [Pengurusan::class, 'analisis']);
    $routes->get('profil', [Pengurusan::class, 'profil']);
});

$routes->group('', ['filter' => 'penggunaauth'], function ($routes) {
    $routes->post('/pengguna/kemaskini', [Pengguna::class, 'kemaskini']);
    $routes->post('/pengguna/tukar-password', [Pengguna::class, 'tukarPassword']);
});
