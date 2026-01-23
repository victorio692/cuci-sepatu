<?php
// Create test accounts with correct passwords
$mysqli = new mysqli('localhost', 'root', '', 'cuci_sepatu');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Delete old test accounts
$mysqli->query("DELETE FROM users WHERE email IN ('customer@gmail.com', 'admin@gmail.com', 'customer@email.com', 'admin@syh.com')");

// Create password hashes
$customer_password = password_hash('password123', PASSWORD_BCRYPT);
$admin_password = password_hash('password123', PASSWORD_BCRYPT);

// Insert new accounts
$customer_sql = "INSERT INTO users (full_name, email, phone, password_hash, address, city, province, zip_code, is_active, is_admin, created_at, updated_at) 
VALUES ('John Doe', 'customer@gmail.com', '08123456789', '$customer_password', '', '', '', '', 1, 0, NOW(), NOW())";

$admin_sql = "INSERT INTO users (full_name, email, phone, password_hash, address, city, province, zip_code, is_active, is_admin, created_at, updated_at) 
VALUES ('Admin User', 'admin@gmail.com', '08987654321', '$admin_password', '', '', '', '', 1, 1, NOW(), NOW())";

if ($mysqli->query($customer_sql)) {
    echo "✓ Customer account created: customer@gmail.com\n";
} else {
    echo "✗ Error creating customer: " . $mysqli->error . "\n";
}

if ($mysqli->query($admin_sql)) {
    echo "✓ Admin account created: admin@gmail.com\n";
} else {
    echo "✗ Error creating admin: " . $mysqli->error . "\n";
}

// Verify
echo "\n--- Verifying Accounts ---\n";
$result = $mysqli->query("SELECT id, full_name, email, is_admin FROM users WHERE email IN ('customer@gmail.com', 'admin@gmail.com')");
while ($row = $result->fetch_assoc()) {
    echo "✓ " . ($row['is_admin'] ? "[ADMIN]" : "[CUSTOMER]") . " {$row['full_name']} - {$row['email']}\n";
}

$mysqli->close();

$customerStmt->execute();

echo "✅ Test accounts created successfully!\n\n";
echo "Admin Account:\n";
echo "  Email: admin@syh.com\n";
echo "  Password: password123\n";
echo "  URL: http://localhost:8080/admin\n\n";
echo "Customer Account:\n";
echo "  Email: customer@email.com\n";
echo "  Password: password123\n";
echo "  URL: http://localhost:8080/dashboard\n";

$db->close();
?>
