<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home
$routes->get('/', 'Home::index');

// Auth
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::loginSubmit');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::registerSubmit');
$routes->get('/logout', 'Auth::logout');

// Dashboard (Protected)
$routes->group('', ['filter' => 'auth'], static function($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('/my-bookings', 'Dashboard::myBookings');
    $routes->get('/profile', 'Dashboard::profile');
    $routes->post('/update-profile', 'Dashboard::updateProfile');
    $routes->post('/change-password', 'Dashboard::changePassword');
});

// Booking (Protected)
$routes->group('', ['filter' => 'auth'], static function($routes) {
    $routes->get('/make-booking', 'Booking::makeBooking');
    $routes->post('/submit-booking', 'Booking::submitBooking');
    $routes->get('/booking-detail/(:num)', 'Booking::detail/$1');
    $routes->post('/cancel-booking/(:num)', 'Booking::cancelBooking/$1');
});

// Admin Routes (Protected)
$routes->group('admin', ['filter' => 'auth:admin'], static function($routes) {
    // Dashboard
    $routes->get('/', 'Admin\Dashboard::index');
    
    // Bookings
    $routes->get('/bookings', 'Admin\Bookings::index');
    $routes->get('/bookings/(:num)', 'Admin\Bookings::detail/$1');
    $routes->put('/bookings/(:num)/status', 'Admin\Bookings::updateStatus/$1');
    
    // Users
    $routes->get('/users', 'Admin\Users::index');
    $routes->get('/users/(:num)', 'Admin\Users::detail/$1');
    $routes->post('/users/(:num)/toggle', 'Admin\Users::toggleActive/$1');
    
    // Services
    $routes->get('/services', 'Admin\Services::index');
    $routes->post('/services/price', 'Admin\Services::updatePrice');
});

// Static Pages
$routes->get('/tentang', 'Pages::about');
$routes->get('/kontak', 'Pages::contact');
$routes->post('/kontak', 'Pages::submitContact');
$routes->get('/kebijakan', 'Pages::privacy');
$routes->get('/syarat', 'Pages::terms');
