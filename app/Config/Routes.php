<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Routes for employee CRUD operations
$routes->get('/', 'Employee::index'); // Display employee list
$routes->get('employee/create', 'Employee::create'); // Show employee creation form
$routes->post('employee/store', 'Employee::store'); // Store new employee data
$routes->get('employee/edit/(:num)', 'Employee::edit/$1'); // Show employee edit form
$routes->post('employee/update/(:num)', 'Employee::update/$1'); // Update employee data
$routes->post('employee/delete/(:num)', 'Employee::delete/$1'); // Delete employee

// Routes for dependent dropdowns
$routes->post('employee/get_states', 'Employee::get_states'); // Get states based on selected country
$routes->post('employee/get_cities', 'Employee::get_cities'); // Get cities based on selected state

