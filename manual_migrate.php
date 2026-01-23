<?php
try {
    $mysqli = new mysqli('localhost', 'root', '', 'cuci_sepatu');
    
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }
    
    echo "🔄 Membuat tabel users...\n";
    
    // Create users table
    $sql_users = "CREATE TABLE IF NOT EXISTS users (
        id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        phone VARCHAR(20) NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        address TEXT NULL,
        city VARCHAR(100) NULL,
        province VARCHAR(100) NULL,
        zip_code VARCHAR(10) NULL,
        is_active TINYINT(1) DEFAULT 1,
        is_admin TINYINT(1) DEFAULT 0,
        created_at DATETIME NULL,
        updated_at DATETIME NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    
    if ($mysqli->query($sql_users)) {
        echo "✅ Tabel users berhasil dibuat!\n";
    } else {
        echo "❌ Error: " . $mysqli->error . "\n";
    }
    
    echo "\n🔄 Membuat tabel bookings...\n";
    
    // Create bookings table
    $sql_bookings = "CREATE TABLE IF NOT EXISTS bookings (
        id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) UNSIGNED NOT NULL,
        service VARCHAR(100) NOT NULL COMMENT 'fast-cleaning, deep-cleaning, white-shoes, coating, dyeing, repair',
        shoe_type VARCHAR(100) NULL,
        shoe_condition VARCHAR(100) NULL,
        quantity INT(11) DEFAULT 1,
        delivery_date DATE NULL,
        delivery_option VARCHAR(50) NOT NULL COMMENT 'pickup or home',
        delivery_address TEXT NULL,
        notes TEXT NULL,
        subtotal DECIMAL(10,2) DEFAULT 0,
        delivery_fee DECIMAL(10,2) DEFAULT 0,
        total DECIMAL(10,2) DEFAULT 0,
        status VARCHAR(50) DEFAULT 'pending' COMMENT 'pending, approved, in_progress, completed, cancelled',
        created_at DATETIME NULL,
        updated_at DATETIME NULL,
        KEY user_id (user_id),
        KEY status (status),
        KEY created_at (created_at),
        CONSTRAINT fk_bookings_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    
    if ($mysqli->query($sql_bookings)) {
        echo "✅ Tabel bookings berhasil dibuat!\n";
    } else {
        echo "❌ Error: " . $mysqli->error . "\n";
    }
    
    // Create migrations table to track migrations
    echo "\n🔄 Membuat tabel migrations...\n";
    $sql_migrations = "CREATE TABLE IF NOT EXISTS migrations (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        version BIGINT UNSIGNED NOT NULL,
        class VARCHAR(255) NOT NULL,
        `group` VARCHAR(255) NOT NULL,
        namespace VARCHAR(255) NOT NULL,
        time INT(11) NOT NULL,
        batch INT(11) UNSIGNED NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    
    if ($mysqli->query($sql_migrations)) {
        echo "✅ Tabel migrations berhasil dibuat!\n";
    } else {
        echo "❌ Error: " . $mysqli->error . "\n";
    }
    
    // Insert migration records
    echo "\n📝 Mencatat migration history...\n";
    $migrations_to_insert = [
        [
            'version' => 20260121000001,
            'class' => 'CreateUsersTable',
            'namespace' => 'App\\Database\\Migrations',
            'group' => 'App',
        ],
        [
            'version' => 20260121000002,
            'class' => 'CreateBookingsTable',
            'namespace' => 'App\\Database\\Migrations',
            'group' => 'App',
        ]
    ];
    
    $batch = 1;
    foreach ($migrations_to_insert as $migration) {
        $time = time();
        $stmt = $mysqli->prepare("INSERT INTO migrations (version, class, `group`, namespace, time, batch) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('isssii', 
            $migration['version'],
            $migration['class'],
            $migration['group'],
            $migration['namespace'],
            $time,
            $batch
        );
        
        if ($stmt->execute()) {
            echo "✅ Recorded: " . $migration['class'] . "\n";
        } else {
            echo "⚠️  Error: " . $stmt->error . "\n";
        }
        $stmt->close();
    }
    
    echo "\n✅ Database setup berhasil!\n";
    echo "Sekarang jalankan seeder: php spark db:seed UserSeeder\n";
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
