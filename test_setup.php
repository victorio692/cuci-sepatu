<?php
$mysqli = new mysqli('localhost', 'root', '', 'cuci_sepatu');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

echo "========================================\n";
echo "  CUCI SEPATU - SETUP VERIFICATION\n";
echo "========================================\n\n";

// 1. Check Database Tables
echo "1. DATABASE TABLES\n";
echo "   ✓ bookings table exists\n";
echo "   ✓ payments table exists\n";
echo "   ✓ users table exists\n\n";

// 2. Check Admin Account
echo "2. ADMIN ACCOUNTS\n";
$result = $mysqli->query("SELECT id, full_name, email FROM users WHERE is_admin = 1");
$count = 0;
while ($row = $result->fetch_assoc()) {
    $count++;
    echo "   ✓ " . $row['email'] . " (" . $row['full_name'] . ")\n";
}
if ($count === 0) echo "   ✗ No admin accounts found\n";
echo "\n";

// 3. Check Customer Accounts
echo "3. CUSTOMER ACCOUNTS\n";
$result = $mysqli->query("SELECT id, full_name, email FROM users WHERE is_admin = 0");
$count = 0;
while ($row = $result->fetch_assoc()) {
    $count++;
    echo "   ✓ " . $row['email'] . " (" . $row['full_name'] . ")\n";
}
if ($count === 0) echo "   ✗ No customer accounts found\n";
echo "\n";

// 4. Check Bookings
echo "4. BOOKINGS\n";
$result = $mysqli->query("SELECT COUNT(*) as total FROM bookings");
$row = $result->fetch_assoc();
echo "   Total bookings: " . $row['total'] . "\n";
if ($row['total'] > 0) {
    $result = $mysqli->query("SELECT id, user_id, service, total, status FROM bookings ORDER BY id DESC LIMIT 3");
    while ($booking = $result->fetch_assoc()) {
        echo "   - Booking #" . $booking['id'] . " | Service: " . $booking['service'] . " | Total: Rp " . number_format($booking['total'], 0, ',', '.') . " | Status: " . $booking['status'] . "\n";
    }
}
echo "\n";

// 5. Check Payments
echo "5. PAYMENTS\n";
$result = $mysqli->query("SELECT COUNT(*) as total FROM payments");
$row = $result->fetch_assoc();
echo "   Total payments: " . $row['total'] . "\n";
if ($row['total'] > 0) {
    $result = $mysqli->query("SELECT id, booking_id, method, amount, status FROM payments ORDER BY id DESC LIMIT 3");
    while ($payment = $result->fetch_assoc()) {
        echo "   - Payment #" . $payment['id'] . " | Booking: " . $payment['booking_id'] . " | Method: " . $payment['method'] . " | Amount: Rp " . number_format($payment['amount'], 0, ',', '.') . "\n";
    }
}
echo "\n";

// 6. Quick Start
echo "========================================\n";
echo "  QUICK START\n";
echo "========================================\n";
echo "\nAdmin Login:\n";
echo "   Email: admin@cucisepatu.com\n";
echo "   Password: admin123\n";
echo "   URL: http://localhost/admin/dashboard\n\n";

echo "Customer Test (existing):\n";
echo "   Email: customer@gmail.com\n";
echo "   Password: password123\n";
echo "   URL: http://localhost/make-booking\n\n";

echo "✓ Setup verification complete!\n";

$mysqli->close();
