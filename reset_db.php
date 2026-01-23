<?php
// Script untuk reset database dengan struktur dari partner

require 'vendor/autoload.php';

// Bootstrap CodeIgniter
$_SERVER['CI_ENVIRONMENT'] = 'development';
define('APPPATH', __DIR__ . '/app/');
define('BASEPATH', __DIR__ . '/vendor/codeigniter4/framework/system/');
define('FCPATH', __DIR__ . '/public/');
define('ROOTPATH', __DIR__ . '/');

// Get database config
$config = new \Config\Database();
$db = $config->default;

// Drop existing tables
$db->query("SET FOREIGN_KEY_CHECKS=0");
$tables = ['migrations', 'bookings', 'layanans', 'users'];
foreach ($tables as $table) {
    try {
        $db->query("DROP TABLE IF EXISTS $table");
    } catch (\Exception $e) {
        echo "Failed to drop table $table: " . $e->getMessage() . "\n";
    }
}
$db->query("SET FOREIGN_KEY_CHECKS=1");

echo "✅ Database reset berhasil!\n";

// Run migrations
$migrate = \Config\Services::migrations();
try {
    $migrate->latest();
    echo "✅ Migration berhasil dijalankan!\n";
} catch (\Exception $e) {
    echo "❌ Migration error: " . $e->getMessage() . "\n";
}

// Run seeder
try {
    $seeder = \Config\Database::seeder();
    $seeder->call('AdminSeeder');
    echo "✅ AdminSeeder berhasil dijalankan!\n";
} catch (\Exception $e) {
    echo "❌ Seeder error: " . $e->getMessage() . "\n";
}
