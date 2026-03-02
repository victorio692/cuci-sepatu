<?php
// Check services table structure and data
require 'app/Config/Database.php';

$config = new \Config\Database();
$db = \CodeIgniter\Database\Database::connect('default');

// Get table structure
echo "<h2>Struktur Tabel Services</h2>";
echo "<pre>";
$fields = $db->getFieldData('services');
foreach ($fields as $field) {
    echo "Kolom: {$field->name} | Type: {$field->type} | Nullable: " . ($field->nullable ? 'Yes' : 'No') . "\n";
}
echo "</pre>";

// Get all services
echo "<h2>Data Layanan</h2>";
echo "<pre>";
$services = $db->table('services')->get()->getResult();
print_r($services);
echo "</pre>";

// Check if there's an image/icon column
echo "<h2>Checking for image-related columns...</h2>";
$hasIconColumn = false;
$hasImageColumn = false;
foreach ($fields as $field) {
    if (strtolower($field->name) === 'icon') $hasIconColumn = true;
    if (strtolower($field->name) === 'image' || strtolower($field->name) === 'foto' || strtolower($field->name) === 'gambar') $hasImageColumn = true;
}
echo "Has 'icon' column: " . ($hasIconColumn ? 'Yes' : 'No') . "<br>";
echo "Has 'image/foto/gambar' column: " . ($hasImageColumn ? 'Yes' : 'No') . "<br>";
?>