<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/customers', 'Customers::index');
$routes->get('/customers/(:num)', 'Customers::show/$1');
$routes->get('/customers/(:num)/summary', 'Customers::summary/$1');
