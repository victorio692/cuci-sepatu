<?php
$conn = new mysqli('localhost', 'root', '', 'cuciriobabang');

echo "Checking booking_photos for booking #35...\n\n";

$result = $conn->query("SELECT * FROM booking_photos WHERE booking_id = 35");
if ($result->num_rows > 0) {
    echo "Found " . $result->num_rows . " photos:\n";
    while($row = $result->fetch_assoc()) {
        echo "  - ID: " . $row['id'] . "\n";
        echo "    Photo: " . $row['photo_path'] . "\n";
        echo "    Created: " . $row['created_at'] . "\n\n";
    }
} else {
    echo "No photos found for booking #35\n";
}

echo "\nChecking booking #35 details:\n";
$result = $conn->query("SELECT * FROM bookings WHERE id = 35");
if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
    echo "  - User ID: " . $booking['id_user'] . "\n";
    echo "  - Status: " . $booking['status'] . "\n";
    echo "  - Created: " . $booking['dibuat_pada'] . "\n";
} else {
    echo "Booking #35 not found\n";
}

$conn->close();
