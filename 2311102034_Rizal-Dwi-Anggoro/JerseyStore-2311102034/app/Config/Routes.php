<?php

use CodeIgniter\Router\RouteCollection;

/**
 * Routes - Jersey Store CI4
 */

/** @var RouteCollection $routes */

// ─── Default (redirect ke dashboard) ───
$routes->get('/', 'Dashboard::index');

// ─── Dashboard ───
$routes->get('dashboard', 'Dashboard::index');

// ─── Jersey CRUD ───
$routes->get('jersey',                'Jersey::index');

$routes->get('jersey/json',           'Jersey::json');  
$routes->post('jersey/json',          'Jersey::json');

$routes->get('jersey/tambah',         'Jersey::tambah');
$routes->post('jersey/simpan',        'Jersey::simpan');
$routes->get('jersey/edit/(:num)',    'Jersey::edit/$1');
$routes->post('jersey/update/(:num)', 'Jersey::update/$1');
$routes->post('jersey/hapus/(:num)',  'Jersey::hapus/$1');
$routes->get('jersey/detail/(:num)',  'Jersey::detail/$1');
