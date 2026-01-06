<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==========================================
// PUBLIC ROUTES
// ==========================================
$routes->get('/', 'Home::index');

// ==========================================
// AUTH ROUTES (Login, Register, Logout)
// ==========================================
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::attemptRegister');
$routes->get('/logout', 'Auth::logout');

// ==========================================
// ADMIN ROUTES (Protected dengan RoleAdmin Filter)
// ==========================================
$routes->group('admin', ['filter' => 'roleAdmin'], static function($routes) {
    // Dashboard
    $routes->get('dashboard', 'Admin\Dashboard::index');
    
    // Kelola Layanan
    $routes->get('services', 'Admin\Services::index');
    $routes->get('services/create', 'Admin\Services::create');
    $routes->post('services/store', 'Admin\Services::store');
    $routes->get('services/edit/(:num)', 'Admin\Services::edit/$1');
    $routes->post('services/update/(:num)', 'Admin\Services::update/$1');
    $routes->get('services/delete/(:num)', 'Admin\Services::delete/$1');
    
    // Kelola Booking
    $routes->get('bookings', 'Admin\Bookings::index');
    $routes->get('bookings/detail/(:num)', 'Admin\Bookings::detail/$1');
    $routes->post('bookings/update-status/(:num)', 'Admin\Bookings::updateStatus/$1');
    $routes->get('bookings/delete/(:num)', 'Admin\Bookings::delete/$1');
    $routes->get('bookings/filter/(:alpha)', 'Admin\Bookings::filterByStatus/$1');
    
    // Kelola Pelanggan
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/detail/(:num)', 'Admin\Users::detail/$1');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');
});

// ==========================================
// PELANGGAN ROUTES (Protected dengan RolePelanggan Filter)
// ==========================================
$routes->group('pelanggan', ['filter' => 'rolePelanggan'], static function($routes) {
    // Dashboard
    $routes->get('dashboard', 'Pelanggan\Dashboard::index');
    
    // Booking
    $routes->get('booking', 'Pelanggan\Booking::index');
    $routes->get('booking/create', 'Pelanggan\Booking::create');
    $routes->post('booking/store', 'Pelanggan\Booking::store');
    $routes->get('booking/detail/(:num)', 'Pelanggan\Booking::detail/$1');
    $routes->post('booking/cancel/(:num)', 'Pelanggan\Booking::cancel/$1');
    
    // Profil
    $routes->get('profile', 'Pelanggan\Profile::index');
    $routes->post('profile/update', 'Pelanggan\Profile::update');
});
