<?php
$mysqli = new mysqli('localhost', 'root', '', 'cuci_sepatu');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

$email = 'admin@cucisepatu.com';
$password = password_hash('admin123', PASSWORD_BCRYPT);
$name = 'Admin';

// Delete jika sudah ada
$mysqli->query("DELETE FROM users WHERE email = '$email'");

// Insert admin baru
$mysqli->query("INSERT INTO users (full_name, email, phone, password_hash, is_active, is_admin, created_at, updated_at) 
VALUES ('$name', '$email', '08987654321', '$password', 1, 1, NOW(), NOW())");

echo "✓ Admin berhasil dibuat!\n";
echo "Email: $email\n";
echo "Password: admin123\n";
echo "\n";

// Verify
$result = $mysqli->query("SELECT id, full_name, email, is_admin FROM users WHERE email = '$email'");
if ($row = $result->fetch_assoc()) {
    echo "✓ Data admin di database:\n";
    echo "  ID: " . $row['id'] . "\n";
    echo "  Nama: " . $row['full_name'] . "\n";
    echo "  Email: " . $row['email'] . "\n";
    echo "  Status: " . ($row['is_admin'] ? 'Admin' : 'Customer') . "\n";
}

$mysqli->close();
