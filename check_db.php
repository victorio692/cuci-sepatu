<?php
require 'vendor/autoload.php';

$db = \Config\Database::connect();
$fields = $db->getFieldNames('bookings');

echo "Kolom di tabel bookings:\n";
print_r($fields);
