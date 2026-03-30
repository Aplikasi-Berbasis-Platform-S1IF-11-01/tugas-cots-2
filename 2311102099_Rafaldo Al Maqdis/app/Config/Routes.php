<?php

/**
 * Routes Configuration
 * File: app/Config/Routes.php
 */

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Default route
$routes->get('/', 'Barang::index');

// Barang Routes
$routes->get('barang',             'Barang::index');
$routes->get('barang/getData',     'Barang::getData');
$routes->post('barang/store',      'Barang::store');
$routes->get('barang/edit/(:num)', 'Barang::edit/$1');
$routes->post('barang/update',     'Barang::update');
$routes->post('barang/delete',     'Barang::delete');
