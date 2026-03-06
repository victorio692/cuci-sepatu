<?php
require 'vendor/autoload.php';

$db = \Config\Database::connect();

echo "=== STRUKTUR TABEL NOTIFICATIONS ===\n\n";

try {
    $result = $db->query('DESCRIBE notifications');
    
    if ($result) {
        echo "Kolom-kolom dalam tabel notifications:\n\n";
        foreach($result->getResultArray() as $field) {
            echo "- " . $field['Field'] . " | " . $field['Type'] . "\n";
        }
    } else {
        echo "Query failed\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== CHECKING USERS TABLE ===\n\n";

try {
    $result = $db->query('DESCRIBE users');
    
    if ($result) {
        echo "Kolom-kolom dalam tabel users:\n\n";
        foreach($result->getResultArray() as $field) {
            echo "- " . $field['Field'] . " | " . $field['Type'] . "\n";
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== CHECKING BOOKINGS TABLE ===\n\n";

try {
    $result = $db->query('DESCRIBE bookings');
    
    if ($result) {
        echo "Kolom-kolom dalam tabel bookings:\n\n";
        foreach($result->getResultArray() as $field) {
            echo "- " . $field['Field'] . " | " . $field['Type'] . "\n";
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
