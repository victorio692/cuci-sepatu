<?php
$mysqli = new mysqli('localhost', 'root', '', 'cuci_sepatu');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Create password hash
$hash = password_hash('password123', PASSWORD_BCRYPT);

// Delete old accounts
$mysqli->query("DELETE FROM users WHERE email IN ('customer@gmail.com', 'admin@gmail.com')");

// Insert customer account
$mysqli->query("INSERT INTO users (full_name, email, phone, password_hash, is_active, is_admin, created_at, updated_at) VALUES ('John Doe', 'customer@gmail.com', '08123456789', '$hash', 1, 0, NOW(), NOW())");

// Insert admin account
$mysqli->query("INSERT INTO users (full_name, email, phone, password_hash, is_active, is_admin, created_at, updated_at) VALUES ('Admin User', 'admin@gmail.com', '08987654321', '$hash', 1, 1, NOW(), NOW())");

echo "✓ Accounts created successfully!\n\n";

// Verify
$result = $mysqli->query('SELECT email, is_admin, full_name FROM users WHERE email LIKE "%gmail.com%"');
while($row = $result->fetch_assoc()) {
    echo '✓ ' . $row['full_name'] . ' - ' . $row['email'] . ' (' . ($row['is_admin'] ? 'Admin' : 'Customer') . ")\n";
}

$mysqli->close();
