<?php
try {
    $mysqli = new mysqli('localhost', 'root', '', 'cuci_sepatu');
    
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }
    
    // Drop database dan buat ulang
    echo "🔄 Menghapus dan membuat ulang database...\n";
    $mysqli->query("DROP DATABASE IF EXISTS cuci_sepatu");
    $mysqli->query("CREATE DATABASE cuci_sepatu CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    
    echo "✅ Database telah direset!\n";
    echo "\nSekarang jalankan: php spark migrate\n";
    
    $mysqli->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
