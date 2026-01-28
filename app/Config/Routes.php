<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// home/login route
$routes->get('/', 'Home::index');
$routes->post('/', 'Home::authenticate');

// register route
$routes->get('/register', 'Register::index');
$routes->post('/register', 'Register::store');

// dashboard route
$routes->get('/dashboard', 'Dashboard::dashboard');
$routes->post('/dashboard', 'Dashboard::dashboard');

// search_records route
$routes->get('/search_records', 'SearchRecords::search_records');
// $routes->post('/search', 'Search::search');

// create route
$routes->get('/create', 'Create::create');
// $routes->post('/create', 'Create::store');

// logout route
$routes->get('/logout', 'Logout::index');


// RECORDS TABLE

// create records route
$routes->get('/create', 'CreateRecords::index');
$routes->post('/create', 'CreateRecords::create_records');


// update records route
$routes->post('/update_record', 'UpdateRecords::update_records');

// delete records route
$routes->post('delete_records/(:num)', 'DeleteRecords::delete_records/$1');

// search_records route (GET and POST)
$routes->get('search_records', 'SearchRecords::search_records');
$routes->post('search_records', 'SearchRecords::search_records');

// change_password route
$routes->get('change_password', 'ChangePassword::index');
$routes->post('change_password', 'ChangePassword::update');


