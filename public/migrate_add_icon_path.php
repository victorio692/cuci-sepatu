<?php
// Migration script to add icon_path column to services table
// Run this via command or web access

require 'vendor/autoload.php';

try {
    $db = \Config\Database::connect();
    
    // Check if icon_path column exists
    $fields = $db->getFieldData('services');
    $hasIconPathColumn = false;
    
    foreach ($fields as $field) {
        if (strtolower($field->name) === 'icon_path') {
            $hasIconPathColumn = true;
            break;
        }
    }
    
    // Add icon_path column if it doesn't exist
    if (!$hasIconPathColumn) {
        $db->query("ALTER TABLE services ADD COLUMN icon_path VARCHAR(255) NULL DEFAULT NULL");
        echo "✅ icon_path column added to services table successfully!";
    } else {
        echo "✅ icon_path column already exists";
    }
    
    echo "\n\n=== Current Services ===\n";
    $services = $db->table('services')->get()->getResult();
    foreach ($services as $service) {
        echo "ID: {$service->id}, Code: {$service->kode_layanan}, Name: {$service->nama_layanan}\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>