<?php
$db = new mysqli('localhost', 'root', '', 'cuci_sepatu');

if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}

echo "=== TABEL YANG ADA ===\n";
$result = $db->query("SHOW TABLES");
while ($row = $result->fetch_row()) {
    echo $row[0] . "\n";
}

$db->close();
?>
