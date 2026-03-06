<?php
// Direct test of the API functionality by accessing the database through CodeIgniter bootstrap

// Simulate being in a web request context
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/api/users';

// Bootstrap CodeIgniter
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/public/index.php';

// Access the database service
$db = \Config\Database::connect();

echo "=== DATABASE USER COUNT TEST ===\n";
$count = $db->table('users')->countAllResults();
echo "Total users in database: $count\n\n";

if ($count > 0) {
    echo "=== First 3 Users ===\n";
    $users = $db->table('users')->limit(3)->get()->getResultArray();
    foreach ($users as $user) {
        echo "ID: {$user['id']}, Name: {$user['nama_lengkap']}, Email: {$user['email']}\n";
    }
}

echo "\n=== SIMULATING API CALL ===\n";

// Set up a logged-in session
session_start();
// Simulate an admin user
$admin = $db->table('users')->where('role', 'admin')->get()->getRowArray();
if ($admin) {
    $_SESSION['user_id'] = $admin['id'];
    echo "✓ Admin user in session: ID=" . $admin['id'] . "\n\n";
    
    // Now simulate the API query
    echo "=== SIMULATING API QUERY ===\n";
    $page = 1;
    $perPage = 10;
    
    $builder = $db->table('users');
    $totalUsers = $builder->countAllResults(false);
    echo "Total count (reset=false): $totalUsers\n";
    
    $users = $builder->orderBy('dibuat_pada', 'DESC')
        ->limit($perPage, ($page - 1) * $perPage)
        ->get()
        ->getResultArray();
    
    echo "Returned users count: " . count($users) . "\n";
    
    if (count($users) > 0) {
        echo "\nFirst user:\n";
        print_r($users[0]);
    }
    
    // Test the API response format
    $response = [
        'success' => true,
        'data' => [
            'users' => $users,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $totalUsers,
                'total_pages' => ceil($totalUsers / $perPage)
            ]
        ]
    ];
    
    echo "\n=== FINAL RESPONSE FORMAT ===\n";
    echo json_encode($response, JSON_PRETTY_PRINT) . "\n";
} else {
    echo "✗ No admin user found\n";
}
?>
