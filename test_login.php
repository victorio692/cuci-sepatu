<?php
// Test database connection dan verify password

require_once 'vendor/autoload.php';

use Config\Database;

$db = Database::connect();

// Get customer account
$user = $db->table('users')
    ->where('email', 'customer@gmail.com')
    ->get()
    ->getRow();

if ($user) {
    echo "User found: " . $user->full_name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Password hash: " . $user->password_hash . "\n";
    echo "Is admin: " . $user->is_admin . "\n";
    
    // Test password
    $test_password = 'password123';
    $verify = password_verify($test_password, $user->password_hash);
    echo "\nPassword verification result: " . ($verify ? "TRUE" : "FALSE") . "\n";
    
    // Also test admin
    echo "\n--- Admin Account ---\n";
    $admin = $db->table('users')
        ->where('email', 'admin@gmail.com')
        ->get()
        ->getRow();
    
    if ($admin) {
        echo "Admin found: " . $admin->full_name . "\n";
        echo "Email: " . $admin->email . "\n";
        echo "Password hash: " . $admin->password_hash . "\n";
        echo "Is admin: " . $admin->is_admin . "\n";
        $admin_verify = password_verify($test_password, $admin->password_hash);
        echo "Password verification result: " . ($admin_verify ? "TRUE" : "FALSE") . "\n";
    } else {
        echo "Admin account not found\n";
    }
} else {
    echo "Customer account not found\n";
}

// List all users
echo "\n--- All Users in Database ---\n";
$all_users = $db->table('users')->get()->getResult();
foreach ($all_users as $u) {
    echo "ID: {$u->id}, Name: {$u->full_name}, Email: {$u->email}, Admin: {$u->is_admin}\n";
}
