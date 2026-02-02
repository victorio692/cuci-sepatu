<?php
// Debug migration

require 'vendor/autoload.php';

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Simulate CI4 environment
$_SERVER['CI_ENVIRONMENT'] = 'development';

// Load CI4
chdir(__DIR__);
require 'vendor/codeigniter4/framework/system/bootstrap.php';

try {
    echo "Starting migration...\n";
    
    // Get migrations service
    $migrations = \Config\Services::migrations();
    
    // Run migrate
    $result = $migrations->latest();
    echo "Migration result: " . var_export($result, true) . "\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n";
    echo $e->getTraceAsString();
}
?>
