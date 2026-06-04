<?php

use App\Controllers\Admin;
use App\Controllers\Home;
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', [Home::class, 'index']);
$routes->post('/login', [Home::class, 'login']);

$routes->group('admin', ['filter' => 'adminauth'], function ($routes) {
    $routes->get('/', [Admin::class, 'index']);

});
