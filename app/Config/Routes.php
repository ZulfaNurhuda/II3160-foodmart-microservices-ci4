<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/promotions', 'Promotions::index');
$routes->get('/promotions/(:num)', 'Promotions::show/$1');
