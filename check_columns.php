<?php
$db = new mysqli('localhost', 'root', '', 'cuci_sepatu');

if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}

echo "=== TABEL BOOKINGS ===\n";
$result = $db->query('SHOW COLUMNS FROM bookings');
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . ' - ' . $row['Type'] . "\n";
}

echo "\n=== TABEL CUSTOMER_DETAILS ===\n";
$result = $db->query('SHOW COLUMNS FROM customer_details');
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . ' - ' . $row['Type'] . "\n";
}

echo "\n=== TABEL NOTIFICATIONS ===\n";
$result = $db->query('SHOW COLUMNS FROM notifications');
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . ' - ' . $row['Type'] . "\n";
}

$db->close();
?>
