<?php
// Create or update service icon column and set fast-cleaning service image
require 'app/Config/Database.php';

try {
    $config = new \Config\Database();
    $db = \CodeIgniter\Database\Database::connect('default');
    
    // Check if icon_image column exists
    $fields = $db->getFieldData('services');
    $hasIconImageColumn = false;
    
    foreach ($fields as $field) {
        if (strtolower($field->name) === 'icon_image') {
            $hasIconImageColumn = true;
            break;
        }
    }
    
    // Add icon_image column if it doesn't exist
    if (!$hasIconImageColumn) {
        echo "Adding icon_image column...\n";
        $db->query("ALTER TABLE services ADD COLUMN icon_image VARCHAR(255) NULL AFTER deskripsi");
        echo "✅ icon_image column added successfully!\n";
    } else {
        echo "✅ icon_image column already exists\n";
    }
    
    // Get the fast-cleaning service
    $service = $db->table('services')
        ->where('kode_layanan', 'fast-cleaning')
        ->get()
        ->getRowArray();
    
    if ($service) {
        echo "\n✅ Found fast-cleaning service (ID: {$service['id']})\n";
        echo "Current data: ";
        print_r($service);
    } else {
        echo "\n❌ fast-cleaning service not found\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString();
}
?>