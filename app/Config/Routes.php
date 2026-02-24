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
$routes->get('/forgot-password', 'Auth::forgotPassword');
$routes->post('/forgot-password', 'Auth::forgotPasswordSubmit');
$routes->get('/reset-password/(:segment)', 'Auth::resetPassword/$1');
$routes->post('/reset-password', 'Auth::resetPasswordSubmit');

// Dashboard (Protected)
$routes->group('', ['filter' => 'auth'], static function($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('/my-bookings', 'Dashboard::myBookings');
    $routes->get('/profile', 'Dashboard::profile');
    $routes->get('/profile/detail', 'Dashboard::profileDetail');
    $routes->get('/profile/change-password', 'Dashboard::changePasswordPage');
    $routes->get('/profile/change-email', 'Dashboard::changeEmailPage');
    $routes->get('/profile/change-phone', 'Dashboard::changePhonePage');
    $routes->post('/update-profile', 'Dashboard::updateProfile');
    $routes->post('/update-profile-photo', 'Dashboard::updateProfilePhoto');
    $routes->post('/change-password', 'Dashboard::changePassword');
    $routes->post('/change-email', 'Dashboard::changeEmail');
    $routes->post('/change-phone', 'Dashboard::changePhone');
});

// Booking (Protected)
$routes->group('', ['filter' => 'auth'], static function($routes) {
    $routes->get('/make-booking', 'Booking::makeBooking');
    $routes->post('/submit-booking', 'Booking::submitBooking');
    $routes->get('/quick-booking', 'Booking::quickBooking');
    $routes->post('/quick-booking/submit', 'Booking::submitQuickBooking');
    $routes->get('/checkout', 'Booking::checkout');
    $routes->post('/checkout/submit', 'Booking::submitCheckout');
    $routes->get('/booking-detail/(:num)', 'Booking::detail/$1');
    $routes->get('/booking/cancel/(:num)', 'Booking::cancelBooking/$1');
    $routes->post('/booking/cancel/(:num)', 'Booking::cancelBooking/$1');
});

// Cart Routes (Protected)
$routes->group('', ['filter' => 'auth'], static function($routes) {
    $routes->get('/cart', 'Cart::viewCart');
    $routes->post('/cart/add', 'Cart::addToCart');
    $routes->get('/cart/remove/(:num)', 'Cart::removeFromCart/$1');
    $routes->post('/cart/update-quantity', 'Cart::updateQuantity');
    $routes->post('/cart/checkout', 'Cart::checkout');
});

// Admin Routes (Protected)
$routes->group('admin', ['filter' => 'auth:admin'], static function($routes) {
    // Dashboard
    $routes->get('', 'Admin\Dashboard::index');
    
    // Bookings
    $routes->get('bookings', 'Admin\Bookings::index');
    $routes->get('bookings/(:num)', 'Admin\Bookings::detail/$1');
    $routes->put('bookings/(:num)/status', 'Admin\Bookings::updateStatus/$1');
    $routes->post('bookings/(:num)/status', 'Admin\Bookings::updateStatus/$1'); // For file upload
    $routes->delete('bookings/(:num)', 'Admin\Bookings::delete/$1');
    
    // Users
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/store', 'Admin\Users::store');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');
    $routes->get('users/(:num)', 'Admin\Users::detail/$1');
    $routes->post('users/(:num)/toggle', 'Admin\Users::toggleActive/$1');
    
    // Services
    $routes->get('services', 'Admin\Services::index');
    $routes->get('services/create', 'Admin\Services::create');
    $routes->post('services/store', 'Admin\Services::store');
    $routes->get('services/edit/(:num)', 'Admin\Services::edit/$1');
    $routes->post('services/update/(:num)', 'Admin\Services::update/$1');
    $routes->post('services/delete/(:num)', 'Admin\Services::delete/$1');
    $routes->post('services/(:num)/toggle', 'Admin\Services::toggleActive/$1');
    $routes->post('services/price', 'Admin\Services::updatePrice');
    
    // Reports
    $routes->get('reports', 'Admin\Reports::index');
    $routes->get('reports/print', 'Admin\Reports::print');
    
    // Profile
    $routes->get('profile', 'Admin\Profile::index');
    $routes->post('profile/update', 'Admin\Profile::update');
    $routes->post('profile/change-password', 'Admin\Profile::changePassword');
});

// Notification Routes
$routes->group('notifications', ['filter' => 'auth'], static function($routes) {
    $routes->get('', 'Notifications::index');
    $routes->get('getUnread', 'Notifications::getUnread');
    $routes->post('markAsRead/(:num)', 'Notifications::markAsRead/$1');
    $routes->post('markAllAsRead', 'Notifications::markAllAsRead');
    $routes->get('sendWhatsApp/(:num)', 'Notifications::sendWhatsApp/$1');
});

// API Routes
$routes->group('api', static function($routes) {
    // Auth API
    $routes->post('auth/register', 'Api\AuthApi::register');
    $routes->post('auth/login', 'Api\AuthApi::login');
    $routes->post('auth/logout', 'Api\AuthApi::logout');
    $routes->get('auth/profile', 'Api\AuthApi::profile');
    $routes->put('auth/profile', 'Api\AuthApi::updateProfile');
    $routes->post('auth/change-password', 'Api\AuthApi::changePassword');
    
    // Notifications API
    $routes->get('notifications', 'Api\NotificationsApi::index');
    $routes->get('notifications/unread', 'Api\NotificationsApi::unread');
    $routes->get('notifications/count', 'Api\NotificationsApi::count');
    $routes->get('notifications/(:num)', 'Api\NotificationsApi::show/$1');
    $routes->put('notifications/(:num)/read', 'Api\NotificationsApi::markAsRead/$1');
    $routes->put('notifications/read-all', 'Api\NotificationsApi::markAllAsRead');
    $routes->delete('notifications/(:num)', 'Api\NotificationsApi::delete/$1');
    $routes->delete('notifications/clear', 'Api\NotificationsApi::clear');
});
// apiservice
$routes->group('api', function($routes) {
    $routes->resource('services', [
        'controller' => 'Api\ServicesApi'
    ]);
});

// bookingapi
$routes->group('api/booking', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->post('create', 'BookingApi::create');
    $routes->get('my-bookings', 'BookingApi::myBookings');
    $routes->get('detail/(:num)', 'BookingApi::detail/$1');
    $routes->post('cancel/(:num)', 'BookingApi::cancel/$1');
});

// dashboardapi
$routes->group('api/dashboard', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->get('stats', 'DashboardApi::stats');
    $routes->get('recent-bookings', 'DashboardApi::recentBookings');
});

// Static Pages
$routes->get('/tentang', 'Pages::about');
$routes->get('/kontak', 'Pages::contact');
$routes->post('/kontak', 'Pages::submitContact');
$routes->get('/faq', 'Pages::faq');
$routes->get('/kebijakan', 'Pages::privacy');
$routes->get('/syarat', 'Pages::terms');
