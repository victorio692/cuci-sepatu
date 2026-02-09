<?php
// Direct database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'cuciriobabang';

$mysqli = new mysqli($host, $user, $pass, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "=== STRUKTUR TABEL NOTIFICATIONS ===\n\n";

$result = $mysqli->query('DESCRIBE notifications');

if (!$result) {
    echo "Error: " . $mysqli->error . "\n";
    echo "\nTabel notifications belum ada. Jalankan SQL berikut:\n";
    echo file_get_contents('create_notifications_table.sql');
} else {
    while($field = $result->fetch_assoc()) {
        echo "Field: " . $field['Field'] . "\n";
        echo "Type: " . $field['Type'] . "\n";
        echo "Null: " . $field['Null'] . "\n";
        echo "Key: " . $field['Key'] . "\n";
        echo "Default: " . ($field['Default'] ?? 'NULL') . "\n";
        echo "Extra: " . ($field['Extra'] ?? '') . "\n";
        echo "---\n";
    }
}

$mysqli->close();
