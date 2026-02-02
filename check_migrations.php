<?php
try {
    $mysqli = new mysqli('localhost', 'root', '', 'cuci_sepatu');
    
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }
    
    // Reset migrations table
    $mysqli->query("DROP TABLE IF EXISTS migrations");
    echo "✅ Tabel migrations direset\n";
    
    // Check what migrations files exist
    $migrationPath = 'app/Database/Migrations/';
    $files = scandir($migrationPath);
    echo "\nFile migrations yang ditemukan:\n";
    foreach ($files as $file) {
        if (preg_match('/\.php$/', $file)) {
            echo "  - " . $file . "\n";
        }
    }
    
    $mysqli->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
