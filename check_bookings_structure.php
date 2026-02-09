<?php
$conn = new mysqli('localhost', 'root', '', 'cuciriobabang');
$result = $conn->query('DESCRIBE bookings');
while($row = $result->fetch_assoc()) {
    echo $row['Field'] . ' - ' . $row['Type'] . "\n";
}
$conn->close();
