<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Tws::index');
$routes->get('tws', 'Tws::index');

$routes->get('tws/create', 'Tws::create');
$routes->get('tws/edit/(:num)', 'Tws::edit/$1');
$routes->post('tws/save', 'Tws::save');

$routes->get('tws/delete/(:num)', 'Tws::delete/$1');

$routes->get('tws/json', 'Tws::json');