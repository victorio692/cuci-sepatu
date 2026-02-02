<?php
// Test login flow
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'cuci_sepatu');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

echo "=== Testing Login Flow ===\n\n";

// Simulate login
$email = 'customer@gmail.com';
$password = 'password123';

echo "Step 1: Find user by email\n";
$user = $mysqli->query("SELECT * FROM users WHERE email = '$email'")->fetch_assoc();

if ($user) {
    echo "✓ User found\n";
    
    echo "\nStep 2: Verify password\n";
    $verify = password_verify($password, $user['password_hash']);
    if ($verify) {
        echo "✓ Password verified\n";
        
        echo "\nStep 3: Set session\n";
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['is_admin'] = $user['is_admin'];
        $_SESSION['full_name'] = $user['full_name'];
        echo "✓ Session variables set:\n";
        echo "  - user_id: " . $_SESSION['user_id'] . "\n";
        echo "  - is_admin: " . $_SESSION['is_admin'] . "\n";
        echo "  - full_name: " . $_SESSION['full_name'] . "\n";
        
        echo "\nStep 4: Determine redirect\n";
        $redirect = $user['is_admin'] ? '/admin/dashboard' : '/customer/dashboard';
        echo "✓ Redirect to: $redirect\n";
        
        echo "\nStep 5: Check if session persists\n";
        if (isset($_SESSION['user_id'])) {
            echo "✓ Session persisted in memory\n";
        } else {
            echo "✗ Session NOT persisted\n";
        }
    } else {
        echo "✗ Password verification failed\n";
    }
} else {
    echo "✗ User NOT found\n";
}

$mysqli->close();
