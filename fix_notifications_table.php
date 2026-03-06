<?php

// This script will fix the notifications table

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';

// Bootstrap CodeIgniter
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

require(FCPATH . 'vendor/autoload.php');

$dotenv = new \Dotenv\Dotenv(FCPATH);

$configClass = new \Config\App();
$configClass->indexPage = '';
$basePath = $configClass->baseURL;

$config = \Config\Database::connect();

echo "=== FIXING NOTIFICATIONS TABLE ===\n\n";

try {
    // Drop table if exists
    $dropSQL = "DROP TABLE IF EXISTS notifications";
    $config->query($dropSQL);
    echo "✓ Dropped existing notifications table (if any)\n\n";
    
    // Create notifications table with correct columns
    $createSQL = "CREATE TABLE notifications (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        id_user INT(11) UNSIGNED NOT NULL,
        booking_id INT(11) UNSIGNED NULL,
        judul VARCHAR(200) NOT NULL,
        pesan TEXT NOT NULL,
        tipe VARCHAR(50) DEFAULT 'info' COMMENT 'new_booking, status_update, info',
        dibaca INT(1) DEFAULT 0,
        created_at DATETIME NULL,
        KEY id_user (id_user),
        KEY booking_id (booking_id),
        KEY created_at (created_at),
        CONSTRAINT notifications_ibfk_1 FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    $config->query($createSQL);
    echo "✓ Created notifications table with correct columns\n\n";
    
    // Verify table structure
    $result = $config->query("DESCRIBE notifications");
    echo "Table structure:\n";
    foreach ($result->getResultArray() as $field) {
        echo "- " . $field['Field'] . " | " . $field['Type'] . "\n";
    }
    
    echo "\n✅ Notifications table fixed successfully!\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
