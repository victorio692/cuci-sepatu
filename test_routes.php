<?php
// Test route trace
require_once 'vendor/autoload.php';

$routes = new CodeIgniter\Router\RouteCollection();
$routes->setDefaultController('Home::index');
$routes->setDefaultMethod('index');

// Replicate routes
$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::loginSubmit');

$routes->group('customer', static function($routes) {
    $routes->get('/dashboard', 'Customer\Dashboard::index');
    $routes->get('/my-bookings', 'Customer\Dashboard::myBookings');
});

$routes->group('admin', static function($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('/dashboard', 'Admin\Dashboard::index');
});

// Test URLs
$testUrls = [
    '/customer/dashboard',
    '/customer/my-bookings',
    '/admin/dashboard',
    '/admin/',
];

echo "Testing Routes:\n";
echo "===============\n\n";

foreach ($testUrls as $url) {
    echo "URL: $url\n";
    try {
        $match = $routes->reverseRoute('Customer\Dashboard::index');
        echo "  Matched\n";
    } catch (\Exception $e) {
        echo "  Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
}
