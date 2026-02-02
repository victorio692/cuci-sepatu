<?php
$mysqli = new mysqli('localhost', 'root', '', 'cuci_sepatu');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Check bookings table structure
echo "=== BOOKINGS TABLE STRUCTURE ===\n";
$result = $mysqli->query("DESCRIBE bookings");
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}

echo "\n=== PAYMENTS TABLE STRUCTURE ===\n";
$result = $mysqli->query("DESCRIBE payments");
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}

echo "\n=== SAMPLE BOOKING ===\n";
$result = $mysqli->query("SELECT * FROM bookings LIMIT 1");
if ($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id'] . "\n";
    echo "Service: " . $row['service'] . "\n";
    echo "Total: " . $row['total'] . "\n";
    echo "Status: " . $row['status'] . "\n";
} else {
    echo "Tidak ada booking\n";
}

echo "\n=== ADMIN ACCOUNT ===\n";
$result = $mysqli->query("SELECT id, full_name, email, is_admin FROM users WHERE is_admin = 1");
while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id'] . " | Name: " . $row['full_name'] . " | Email: " . $row['email'] . "\n";
}

$mysqli->close();
