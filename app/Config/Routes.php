<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/sales', 'Sales::index');
$routes->get('/sales/top-products', 'Sales::topProducts');
$routes->get('/sales/top-customers', 'Sales::topCustomers');
$routes->get('/sales/trend', 'Sales::trend');
$routes->get('/sales/customer/(:num)', 'Sales::customer/$1');
$routes->get('/sales/(:num)-(:num)-(:num)', 'Sales::show/$1/$2/$3');
