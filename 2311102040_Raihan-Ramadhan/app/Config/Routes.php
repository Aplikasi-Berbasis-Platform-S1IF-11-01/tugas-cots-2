<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'MobilController::index');
// Mobil routes
$routes->get('mobil', 'MobilController::index');
$routes->get('mobil/create', 'MobilController::create');
$routes->post('mobil/store', 'MobilController::store');
$routes->get('mobil/edit/(:num)', 'MobilController::edit/$1');
$routes->post('mobil/update/(:num)', 'MobilController::update/$1');
$routes->get('mobil/delete/(:num)', 'MobilController::delete/$1');
$routes->get('mobil/json', 'MobilController::getJson'); 

// Penjual routes
$routes->get('penjual', 'PenjualController::index');
$routes->get('penjual/create', 'PenjualController::create');
$routes->post('penjual/store', 'PenjualController::store');
$routes->get('penjual/json', 'PenjualController::getJson');
$routes->get('penjual/delete/(:num)', 'PenjualController::delete/$1');
$routes->get('penjual/edit/(:num)', 'PenjualController::edit/$1');
$routes->post('penjual/update/(:num)', 'PenjualController::update/$1');