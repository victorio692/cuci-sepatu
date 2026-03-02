<?php
// Direct database migration to add icon_path column
// This bypasses the CodeIgniter migration system

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'cuciriobabang';

try {
    $conn = new mysqli($host, $user, $pass, $db);
    
    if ($conn->connect_error) {
        die("❌ Connection failed: " . $conn->connect_error);
    }
    
    // Check if icon_path column exists
    $result = $conn->query("SHOW COLUMNS FROM services LIKE 'icon_path'");
    
    if ($result === false) {
        echo "❌ Error checking column: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        echo "✅ icon_path column already exists\n";
    } else {
        // Add the column
        $sql = "ALTER TABLE services ADD COLUMN icon_path VARCHAR(255) NULL DEFAULT NULL COMMENT 'Path to service icon image'";
        
        if ($conn->query($sql) === TRUE) {
            echo "✅ icon_path column added successfully!\n";
        } else {
            echo "❌ Error adding column: " . $conn->error;
        }
    }
    
    // Show services list
    echo "\n📋 Current Services:\n";
    $result = $conn->query("SELECT id, kode_layanan, nama_layanan, icon_path FROM services");
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $icon_status = empty($row['icon_path']) ? '❌ No image' : "✅ {$row['icon_path']}";
            echo "ID: {$row['id']}, Code: {$row['kode_layanan']}, Name: {$row['nama_layanan']}, Status: $icon_status\n";
        }
    }
    
    $conn->close();
    echo "\n✅ Database update completed!";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>