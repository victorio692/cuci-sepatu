<?php

// Test API endpoints
echo "Testing API Endpoints\n";
echo str_repeat("=", 50) . "\n\n";

// Test 1: GET services
echo "1. Testing GET /api/admin/services\n";
$url = 'http://localhost/api/admin/services';
$response = @file_get_contents($url);
if ($response === false) {
    echo "❌ Failed to fetch\n";
    echo "Error: " . var_export(error_get_last(), true) . "\n";
} else {
    $data = json_decode($response, true);
    echo "✅ Success! Returned: " . json_encode($data, JSON_PRETTY_PRINT) . "\n";
}

echo "\n" . str_repeat("-", 50) . "\n\n";

// Test 2: GET specific service
echo "2. Testing GET /api/admin/services/1\n";
$url = 'http://localhost/api/admin/services/1';
$response = @file_get_contents($url);
if ($response === false) {
    echo "❌ Failed to fetch\n";
} else {
    $data = json_decode($response, true);
    echo "✅ Response: " . json_encode($data, JSON_PRETTY_PRINT) . "\n";
}

echo "\n" . str_repeat("-", 50) . "\n\n";

// Test 3: POST update service
echo "3. Testing POST /api/admin/services/1 (update)\n";
$url = 'http://localhost/api/admin/services/1';
$data = json_encode([
    'kode_layanan' => 'fast-cleaning',
    'nama_layanan' => 'Fast Cleaning Updated',
    'harga_dasar' => 50000,
    'durasi_hari' => 1,
    'deskripsi' => 'Test Update'
]);
$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => $data
    ]
]);
$response = @file_get_contents($url, false, $context);
if ($response === false) {
    echo "❌ Failed to POST\n";
    echo "Error: " . var_export(error_get_last(), true) . "\n";
} else {
    $result = json_decode($response, true);
    echo "✅ Response: " . json_encode($result, JSON_PRETTY_PRINT) . "\n";
}
?>
