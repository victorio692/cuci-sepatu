<?php
$mysqli = new mysqli('localhost', 'root', '', 'cuci_sepatu');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Create payments table
$sql = "CREATE TABLE IF NOT EXISTS payments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    method VARCHAR(50) NOT NULL COMMENT 'bank_transfer, e_wallet, cash',
    status VARCHAR(50) NOT NULL DEFAULT 'pending',
    payment_code VARCHAR(100),
    payment_date TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

if ($mysqli->query($sql)) {
    echo "✓ Payments table created successfully!\n";
} else {
    echo "Error: " . $mysqli->error . "\n";
}

// Verify table exists
$result = $mysqli->query("SHOW TABLES LIKE 'payments'");
if ($result->num_rows > 0) {
    echo "✓ Payments table verified\n";
} else {
    echo "✗ Payments table not found\n";
}

$mysqli->close();
