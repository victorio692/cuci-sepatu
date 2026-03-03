<?php
/**
 * Script untuk menambahkan kolom icon_path ke tabel services
 * Jalankan: php add_icon_path_column.php
 */

// Database config
$host = 'localhost';
$dbname = 'cuciriobabang';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "🔧 Menambahkan kolom icon_path ke tabel services...\n";
    
    // Check if column already exists
    $stmt = $pdo->query("SHOW COLUMNS FROM services LIKE 'icon_path'");
    $exists = $stmt->fetch();
    
    if ($exists) {
        echo "✅ Kolom icon_path sudah ada!\n";
    } else {
        // Add icon_path column
        $sql = "ALTER TABLE services ADD COLUMN icon_path VARCHAR(255) NULL AFTER durasi_hari";
        $pdo->exec($sql);
        
        echo "✅ Kolom icon_path berhasil ditambahkan!\n";
    }
    
    echo "\n✨ Selesai! Sekarang upload icon layanan sudah bisa digunakan.\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

