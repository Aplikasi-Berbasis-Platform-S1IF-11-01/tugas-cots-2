<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Produk::form');
$routes->get('/table', 'Produk::table');
$routes->get('/edit/(:num)', 'Produk::edit/$1');

$routes->post('/save', 'Produk::save');
$routes->post('/update/(:num)', 'Produk::update/$1');
$routes->get('/delete/(:num)', 'Produk::delete/$1');

$routes->get('/data', 'Produk::getData');
