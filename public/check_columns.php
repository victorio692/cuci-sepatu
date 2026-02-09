<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'cuciriobabang';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("DESCRIBE bookings");

echo "Kolom di tabel bookings:<br><br>";
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . "<br>";
}

$conn->close();
