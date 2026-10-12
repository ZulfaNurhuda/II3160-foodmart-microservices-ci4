<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/stores', 'Stores::index');
$routes->get('/stores/(:num)', 'Stores::show/$1');
