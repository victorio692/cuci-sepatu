<?php
// Test customer dashboard without auth filter

namespace App\Controllers\Customer;

use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

// Simulate routing
$_SERVER['REQUEST_URI'] = '/customer/dashboard';
$_SERVER['REQUEST_METHOD'] = 'GET';

// Load CodeIgniter
require_once 'vendor/autoload.php';

// Create a test session
session_start();
$_SESSION['user_id'] = 4; // John Doe customer ID

// Try to instantiate the controller
try {
    $controller = new Dashboard();
    echo "Controller instantiated successfully\n";
    echo "Calling index() method...\n";
    
    // This won't work perfectly but shows if class loads
    if (method_exists($controller, 'index')) {
        echo "✓ Method 'index' exists\n";
    } else {
        echo "✗ Method 'index' not found\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
