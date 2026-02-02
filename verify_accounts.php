<?php
// Verify test accounts were created
$db = new \mysqli('localhost', 'root', '', 'cuci_sepatu');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$result = $db->query("SELECT id, full_name, email, is_admin FROM users ORDER BY id DESC LIMIT 2");

echo "Test Accounts in Database:\n";
echo "=".str_repeat("=", 60)."\n";

while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id'] . "\n";
    echo "  Name: " . $row['full_name'] . "\n";
    echo "  Email: " . $row['email'] . "\n";
    echo "  Is Admin: " . ($row['is_admin'] ? 'YES' : 'NO') . "\n";
    echo "\n";
}

$db->close();
?>
