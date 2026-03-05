<?php
require 'vendor/autoload.php';
$config = new \Config\Database();
$db = $config->connect();

// Check total bookings
$result = $db->query('SELECT COUNT(*) as total FROM bookings')->getRow();
echo "Total bookings: " . $result->total . "\n";

// Check recent bookings
$bookings = $db->query('SELECT id, created_at, status FROM bookings ORDER BY created_at DESC LIMIT 5')->getResultArray();
echo "\nRecent bookings:\n";
foreach($bookings as $row) {
    echo 'ID: ' . $row['id'] . ' | Date: ' . $row['created_at'] . ' | Status: ' . $row['status'] . "\n";
}

// Check bookings for current month
$startDate = date('Y-m-01');
$endDate = date('Y-m-t');
echo "\nBookings for current month (" . $startDate . " to " . $endDate . "):\n";
$month_bookings = $db->query("SELECT COUNT(*) as total FROM bookings WHERE created_at >= '" . $startDate . " 00:00:00' AND created_at <= '" . $endDate . " 23:59:59'")->getRow();
echo "Total: " . $month_bookings->total . "\n";

// Debug: Show ALL dates in bookings table
echo "\nDates in bookings table:\n";
$all_dates = $db->query('SELECT DISTINCT DATE(created_at) as tanggal FROM bookings ORDER BY tanggal DESC LIMIT 10')->getResultArray();
foreach($all_dates as $row) {
    echo '  ' . $row['tanggal'] . "\n";
}
