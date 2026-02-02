<?php
require 'vendor/autoload.php';

$db = new mysqli('localhost', 'root', '', 'cuci_sepatu');

if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}

// Create customer account
$email = 'customer@example.com';
$password = 'customer123';
$phone = '089987654321';
$full_name = 'Budi Santoso';
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Check if customer exists
$check = $db->query("SELECT id FROM users WHERE email = '{$db->real_escape_string($email)}'");
if ($check->num_rows > 0) {
    echo "Customer sudah ada!\n";
    $row = $check->fetch_assoc();
    echo "ID: " . $row['id'] . "\n";
    echo "Email: " . $email . "\n";
    echo "Password: " . $password . "\n";
    $db->close();
    exit;
}

// Insert customer
$sql = "INSERT INTO users (full_name, email, phone, password_hash, is_admin, is_active, created_at, updated_at) 
        VALUES ('{$db->real_escape_string($full_name)}', '{$db->real_escape_string($email)}', '{$db->real_escape_string($phone)}', '{$password_hash}', 0, 1, NOW(), NOW())";

if ($db->query($sql)) {
    $customer_id = $db->insert_id;
    echo "✅ Customer berhasil dibuat!\n";
    echo "ID: " . $customer_id . "\n";
    echo "Nama: " . $full_name . "\n";
    echo "Email: " . $email . "\n";
    echo "Password: " . $password . "\n";
    echo "\nSilakan login ke: http://localhost:8080/login\n";
} else {
    echo "❌ Error: " . $db->error . "\n";
}

$db->close();
?>
