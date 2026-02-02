<?php
// Test database connection speed
$start = microtime(true);
$db = new mysqli('localhost', 'root', '', 'cuci_sepatu', 3306);
$connect_time = (microtime(true) - $start) * 1000;

if ($db->connect_error) {
    echo "MySQL Connection ERROR: " . $db->connect_error;
    exit;
}

echo "MySQL Connection: OK (" . round($connect_time, 2) . "ms)\n";

// Test query
$start = microtime(true);
$result = $db->query('SELECT COUNT(*) as count FROM users');
$query_time = (microtime(true) - $start) * 1000;

echo "Query Time: " . round($query_time, 2) . "ms\n";

$db->close();
?>
