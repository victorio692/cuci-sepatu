<!DOCTYPE html>
<html>
<head>
    <title>Test Koneksi Database</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .success { color: green; padding: 10px; background: #d4edda; border: 1px solid green; margin: 10px 0; }
        .error { color: red; padding: 10px; background: #f8d7da; border: 1px solid red; margin: 10px 0; }
        .info { padding: 10px; background: #d1ecf1; border: 1px solid #0c5460; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; background: white; }
        th, td { padding: 12px; text-align: left; border: 1px solid #ddd; }
        th { background: #343a40; color: white; }
        tr:hover { background: #f1f1f1; }
    </style>
</head>
<body>
    <h1>🔌 Test Koneksi Database - Cuci Rio Babang</h1>

<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    $db = \Config\Database::connect();
    echo '<div class="success">✅ Koneksi database BERHASIL!</div>';
    
    // Info database
    echo '<div class="info">';
    echo '<strong>Database:</strong> cuciriobabang<br>';
    echo '<strong>Host:</strong> localhost<br>';
    echo '<strong>Status:</strong> Connected';
    echo '</div>';
    
    // Test query users
    $users = $db->query("SELECT id, full_name, email, phone, is_admin, created_at FROM users ORDER BY id")->getResultArray();
    
    echo '<h2>👥 Data Users (' . count($users) . ' users)</h2>';
    echo '<table>';
    echo '<tr><th>ID</th><th>Nama</th><th>Email</th><th>Phone</th><th>Role</th><th>Dibuat</th></tr>';
    foreach ($users as $user) {
        $role = $user['is_admin'] ? '<strong style="color: red;">Admin</strong>' : 'Customer';
        echo '<tr>';
        echo '<td>' . $user['id'] . '</td>';
        echo '<td>' . $user['full_name'] . '</td>';
        echo '<td>' . $user['email'] . '</td>';
        echo '<td>' . $user['phone'] . '</td>';
        echo '<td>' . $role . '</td>';
        echo '<td>' . $user['created_at'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    
    // Test query bookings
    $bookings = $db->query("
        SELECT b.*, u.full_name 
        FROM bookings b 
        JOIN users u ON b.user_id = u.id 
        ORDER BY b.created_at DESC 
        LIMIT 10
    ")->getResultArray();
    
    echo '<h2>📦 Data Bookings Terbaru (' . count($bookings) . ' bookings)</h2>';
    echo '<table>';
    echo '<tr><th>ID</th><th>Customer</th><th>Service</th><th>Sepatu</th><th>Total</th><th>Status</th><th>Tanggal</th></tr>';
    foreach ($bookings as $booking) {
        $statusColor = [
            'pending' => '#ffc107',
            'approved' => '#17a2b8',
            'in_progress' => '#007bff',
            'completed' => '#28a745',
            'cancelled' => '#dc3545'
        ];
        $color = $statusColor[$booking['status']] ?? '#6c757d';
        
        echo '<tr>';
        echo '<td>' . $booking['id'] . '</td>';
        echo '<td>' . $booking['full_name'] . '</td>';
        echo '<td>' . $booking['service'] . '</td>';
        echo '<td>' . $booking['shoe_type'] . '</td>';
        echo '<td>Rp ' . number_format($booking['total'], 0, ',', '.') . '</td>';
        echo '<td><span style="color: ' . $color . '; font-weight: bold;">' . $booking['status'] . '</span></td>';
        echo '<td>' . date('d M Y H:i', strtotime($booking['created_at'])) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    
    // Services
    $services = $db->query("SELECT * FROM services WHERE is_active = 1 ORDER BY base_price")->getResultArray();
    echo '<h2>🧹 Layanan (' . count($services) . ' services)</h2>';
    echo '<table>';
    echo '<tr><th>Kode</th><th>Nama</th><th>Deskripsi</th><th>Harga</th><th>Durasi</th></tr>';
    foreach ($services as $service) {
        echo '<tr>';
        echo '<td>' . $service['service_code'] . '</td>';
        echo '<td>' . $service['service_name'] . '</td>';
        echo '<td>' . $service['description'] . '</td>';
        echo '<td>Rp ' . number_format($service['base_price'], 0, ',', '.') . '</td>';
        echo '<td>' . $service['duration_days'] . ' hari</td>';
        echo '</tr>';
    }
    echo '</table>';
    
    // Payments
    $payments = $db->query("
        SELECT p.*, b.service, u.full_name 
        FROM payments p 
        JOIN bookings b ON p.booking_id = b.id 
        JOIN users u ON b.user_id = u.id 
        ORDER BY p.created_at DESC LIMIT 10
    ")->getResultArray();
    echo '<h2>💰 Pembayaran (' . count($payments) . ' payments)</h2>';
    echo '<table>';
    echo '<tr><th>ID</th><th>Customer</th><th>Service</th><th>Amount</th><th>Method</th><th>Status</th><th>Tanggal</th></tr>';
    foreach ($payments as $payment) {
        $statusColor = $payment['payment_status'] === 'paid' ? '#28a745' : '#ffc107';
        echo '<tr>';
        echo '<td>' . $payment['id'] . '</td>';
        echo '<td>' . $payment['full_name'] . '</td>';
        echo '<td>' . $payment['service'] . '</td>';
        echo '<td>Rp ' . number_format($payment['amount'], 0, ',', '.') . '</td>';
        echo '<td>' . strtoupper($payment['payment_method']) . '</td>';
        echo '<td><span style="color: ' . $statusColor . '; font-weight: bold;">' . $payment['payment_status'] . '</span></td>';
        echo '<td>' . date('d M Y', strtotime($payment['created_at'])) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    
    // Statistics
    $stats = $db->query("
        SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(total) as revenue
        FROM bookings
    ")->getRow();
    
    $paid_total = $db->query("SELECT SUM(amount) as paid FROM payments WHERE payment_status = 'paid'")->getRow();
    
    echo '<h2>📊 Statistik</h2>';
    echo '<div class="info">';
    echo '<strong>Total Pesanan:</strong> ' . $stats->total . ' pesanan<br>';
    echo '<strong>Selesai:</strong> ' . $stats->completed . ' pesanan<br>';
    echo '<strong>Pending:</strong> ' . $stats->pending . ' pesanan<br>';
    echo '<strong>Total Revenue:</strong> Rp ' . number_format($stats->revenue, 0, ',', '.') . '<br>';
    echo '<strong>Sudah Dibayar:</strong> Rp ' . number_format($paid_total->paid, 0, ',', '.') . '<br>';
    echo '</div>';
    
    echo '<div class="success">';
    echo '<h3>Login Credentials:</h3>';
    echo '<strong>Admin:</strong> rio@cuciriobabang.com / password<br>';
    echo '<strong>Customer:</strong> andiwijaya88@gmail.com / password';
    echo '</div>';
    
} catch (Exception $e) {
    echo '<div class="error">❌ Error: ' . $e->getMessage() . '</div>';
}
?>

    <p><a href="/">← Kembali ke Home</a></p>
</body>
</html>
