<?php
// Simple script to reset database

try {
    // Connect to database
    $mysqli = new mysqli('localhost', 'root', '', 'cuci_sepatu');
    
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }
    
    // Drop tables
    $mysqli->query("SET FOREIGN_KEY_CHECKS=0");
    $tables = ['migrations', 'bookings', 'layanans', 'users'];
    
    foreach ($tables as $table) {
        if ($mysqli->query("DROP TABLE IF EXISTS `$table`")) {
            echo "✅ Tabel $table dihapus\n";
        }
    }
    
    $mysqli->query("SET FOREIGN_KEY_CHECKS=1");
    echo "\n✅ Database reset berhasil!\n";
    echo "Sekarang jalankan: php spark migrate\n";
    echo "Kemudian: php spark db:seed AdminSeeder\n";
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
