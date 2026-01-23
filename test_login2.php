<?php
// Test login script
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'cuci_sepatu');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

echo "=== Testing Login ===\n\n";

// Test email
$email = 'customer@gmail.com';
$password = 'password123';

echo "Attempting to login with: $email\n";

// Find user
$user = $mysqli->query("SELECT * FROM users WHERE email = '$email'")->fetch_assoc();

if ($user) {
    echo "✓ User found: " . $user['full_name'] . "\n";
    echo "  Email: " . $user['email'] . "\n";
    echo "  Is Admin: " . $user['is_admin'] . "\n";
    
    // Verify password
    $verify = password_verify($password, $user['password_hash']);
    if ($verify) {
        echo "✓ Password verification: SUCCESS\n";
        echo "\nLogin would proceed to redirect.\n";
        if ($user['is_admin']) {
            echo "Redirect to: /admin/dashboard\n";
        } else {
            echo "Redirect to: /customer/dashboard\n";
        }
    } else {
        echo "✗ Password verification: FAILED\n";
        echo "Expected: $password\n";
        echo "Hash: " . substr($user['password_hash'], 0, 20) . "...\n";
    }
} else {
    echo "✗ User NOT found with email: $email\n";
    echo "\nAvailable users:\n";
    $all = $mysqli->query("SELECT email, full_name, is_admin FROM users");
    while ($u = $all->fetch_assoc()) {
        echo "  - " . $u['email'] . " (" . ($u['is_admin'] ? "Admin" : "Customer") . ")\n";
    }
}

$mysqli->close();
