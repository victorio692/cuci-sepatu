<?php
// Connect to database
$mysqli = new mysqli('localhost', 'root', '', 'cuci_sepatu');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Get users
$result = $mysqli->query("SELECT id, full_name, email, is_admin, password_hash FROM users");

echo "Users in database:\n";
echo "=================\n";
while ($row = $result->fetch_assoc()) {
    echo "ID: {$row['id']}\n";
    echo "Name: {$row['full_name']}\n";
    echo "Email: {$row['email']}\n";
    echo "Is Admin: {$row['is_admin']}\n";
    echo "Hash: " . substr($row['password_hash'], 0, 20) . "...\n";
    
    // Test password
    $test_password = 'password123';
    $verify = password_verify($test_password, $row['password_hash']);
    echo "Password verify result: " . ($verify ? "TRUE ✓" : "FALSE ✗") . "\n";
    echo "---\n";
}

$mysqli->close();
