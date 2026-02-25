<?php
require 'vendor/autoload.php';

$db = \Config\Database::connect();

echo "=== STRUKTUR TABLE SERVICES ===\n\n";

$fields = $db->getFieldData('services');

foreach ($fields as $field) {
    echo "Kolom: " . $field->name . " | Type: " . $field->type . " | Max Length: " . $field->max_length . "\n";
}

echo "\n=== DATA SERVICES ===\n\n";
$data = $db->table('services')->get()->getResult();
print_r($data);
