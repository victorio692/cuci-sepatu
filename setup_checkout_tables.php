<?php
// Script to create booking_photos table and add delivery_method column
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'cuciriobabang';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Creating booking_photos table...\n";
$sql1 = "CREATE TABLE IF NOT EXISTS booking_photos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    booking_id INT UNSIGNED NOT NULL,
    photo_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    INDEX idx_booking_id (booking_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($sql1) === TRUE) {
    echo "✓ booking_photos table created successfully\n";
} else {
    echo "✗ Error creating booking_photos table: " . $conn->error . "\n";
}

echo "\nAdding delivery_method column to bookings table...\n";
$sql2 = "ALTER TABLE bookings 
ADD COLUMN delivery_method VARCHAR(20) DEFAULT 'antar' 
AFTER opsi_kirim";

if ($conn->query($sql2) === TRUE) {
    echo "✓ delivery_method column added successfully\n";
} else {
    echo "✗ Error adding delivery_method column: " . $conn->error . "\n";
}

$conn->close();
echo "\nDone!\n";
