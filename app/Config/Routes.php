<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/analytics/top-products', 'Analytics::topProducts');
$routes->get('/analytics/top-customers', 'Analytics::topCustomers');
$routes->get('/analytics/sales-trend', 'Analytics::salesTrend');
$routes->get('/dashboard/sales-summary', 'Analytics::dashboard');
