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

    $routes->get('kerani', [Admin::class, 'kerani']);
    $routes->post('kerani_simpan', [Admin::class, 'kerani_simpan']);
    $routes->post('kerani_padam/(:num)', [Admin::class, 'kerani_padam']);
    $routes->post('kerani_reset/(:num)', [Admin::class, 'kerani_reset']);
    $routes->post('kerani_sekat/(:num)', [Admin::class, 'kerani_sekat']);
    $routes->post('kerani_aktifkan/(:num)', [Admin::class, 'kerani_aktifkan']);


});
