<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Product
$routes->get('/', 'Products::index');

// create
$routes->get('/create', 'Products::create');
$routes->post('/store', 'Products::store');

// update
$routes->get('/edit/(:any)', 'Products::edit/$1');
$routes->post('/update/(:any)', 'Products::update/$1');

// delete
$routes->delete('/delete/(:any)', 'Products::destroy/$1');

// read
$routes->get('/products/get_json', 'Products::getProducts');
