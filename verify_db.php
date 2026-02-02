<?php
try {
    $mysqli = new mysqli('localhost', 'root', '', 'cuci_sepatu');
    
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }
    
    echo "✅ Koneksi database berhasil!\n\n";
    
    // Check tables
    $result = $mysqli->query("SHOW TABLES");
    echo "📊 Tabel yang ada:\n";
    while ($row = $result->fetch_array()) {
        echo "  - " . $row[0] . "\n";
    }
    
    // Check users
    $users = $mysqli->query("SELECT COUNT(*) as total FROM users");
    $user_data = $users->fetch_assoc();
    echo "\n👥 Total users: " . $user_data['total'] . "\n";
    
    // List users
    $user_list = $mysqli->query("SELECT id, full_name, email, is_admin FROM users LIMIT 5");
    echo "\nData users:\n";
    while ($user = $user_list->fetch_assoc()) {
        $role = $user['is_admin'] ? 'Admin' : 'User';
        echo "  - [" . $user['id'] . "] " . $user['full_name'] . " (" . $user['email'] . ") - " . $role . "\n";
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
