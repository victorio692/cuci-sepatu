<?php
try {
    $mysqli = new mysqli('localhost', 'root', '', 'cuci_sepatu');
    
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }
    
    echo "📝 Menambahkan data pengguna...\n";
    
    // Admin users
    $admin_data = [
        [
            'full_name' => 'Rio Admin',
            'email' => 'admin@syhcleaning.com',
            'phone' => '081234567890',
            'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
            'address' => 'Jl. Sudirman No. 88, Jakarta Pusat',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'zip_code' => '12000',
            'is_active' => 1,
            'is_admin' => 1
        ],
        [
            'full_name' => 'Test User',
            'email' => 'user@example.com',
            'phone' => '081987654321',
            'password_hash' => password_hash('user123', PASSWORD_BCRYPT),
            'address' => 'Jl. Test No. 1',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'zip_code' => '12345',
            'is_active' => 1,
            'is_admin' => 0
        ]
    ];
    
    foreach ($admin_data as $user) {
        $stmt = $mysqli->prepare("INSERT INTO users (full_name, email, phone, password_hash, address, city, province, zip_code, is_active, is_admin, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
        
        $stmt->bind_param('ssssssssii', 
            $user['full_name'],
            $user['email'],
            $user['phone'],
            $user['password_hash'],
            $user['address'],
            $user['city'],
            $user['province'],
            $user['zip_code'],
            $user['is_active'],
            $user['is_admin']
        );
        
        if ($stmt->execute()) {
            echo "✅ User: " . $user['full_name'] . " (" . $user['email'] . ")\n";
        } else {
            echo "❌ Error: " . $stmt->error . "\n";
        }
        $stmt->close();
    }
    
    echo "\n✅ Seeder berhasil!\n";
    echo "\n📋 Akun login:\n";
    echo "  Admin:\n";
    echo "    Email: admin@syhcleaning.com\n";
    echo "    Password: admin123\n\n";
    echo "  User Test:\n";
    echo "    Email: user@example.com\n";
    echo "    Password: user123\n";
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
