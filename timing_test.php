<?php
// Timing test untuk halaman login
use Config\Services;
use CodeIgniter\HTTP\Request;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$app = require_once FCPATH . 'vendor/autoload.php';

// Start timing
$start = microtime(true);

$app = require_once FCPATH . 'vendor/codeigniter4/framework/system/bootstrap.php';

echo "=== TIMING ANALYSIS ===\n";
echo "Bootstrap time: " . round((microtime(true) - $start) * 1000, 2) . "ms\n\n";

// Simulate Auth::login() call
$start = microtime(true);
$db = new \mysqli('localhost', 'root', '', 'cuci_sepatu');
$db->close();
echo "Database connect time: " . round((microtime(true) - $start) * 1000, 2) . "ms\n";

// Check current_url() performance
$start = microtime(true);
for ($i = 0; $i < 100; $i++) {
    $url = 'http://localhost:8080/login';
}
echo "100x URL processing: " . round((microtime(true) - $start) * 1000, 2) . "ms\n";

// Test strpos performance
$start = microtime(true);
$url = 'http://localhost:8080/login';
for ($i = 0; $i < 100; $i++) {
    $check = strpos($url, '/dashboard') !== false;
}
echo "100x strpos check: " . round((microtime(true) - $start) * 1000, 2) . "ms\n";
?>
