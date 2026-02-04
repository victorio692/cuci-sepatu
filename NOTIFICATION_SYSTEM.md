# Sistem Notifikasi Customer

## 📋 Overview
Sistem notifikasi real-time untuk memberitahu customer ketika admin mengubah status booking mereka.

## 🗄️ Database Setup

Jalankan SQL berikut di phpMyAdmin atau MySQL client:

```sql
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_booking` varchar(50) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `tipe` enum('info','success','warning','danger') DEFAULT 'info',
  `dibaca` tinyint(1) DEFAULT 0,
  `dibuat_pada` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_booking` (`id_booking`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

## 🔧 Cara Kerja

### 1. Admin Update Status Booking
Ketika admin mengubah status booking di halaman admin:
- **Disetujui**: Notifikasi "Booking Disetujui! ✅"
- **Proses**: Notifikasi "Sepatu Sedang Diproses 🧼"
- **Selesai**: Notifikasi "Sepatu Sudah Selesai! 🎉"
- **Ditolak**: Notifikasi "Booking Ditolak ❌"

### 2. Notifikasi Otomatis Dibuat
File: `app/Controllers/Admin/Bookings.php` - method `updateStatus()`

```php
// Create notification for customer
$notificationData = [
    'id_user' => $booking['id_user'],
    'id_booking' => $id,
    'dibaca' => 0,
    'dibuat_pada' => date('Y-m-d H:i:s')
];

switch ($status) {
    case 'selesai':
        $notificationData['judul'] = 'Sepatu Sudah Selesai! 🎉';
        $notificationData['pesan'] = "Booking ID #{$id} sudah selesai dicuci. Silakan ambil sepatu Anda!";
        $notificationData['tipe'] = 'success';
        break;
    // ... status lainnya
}

$this->db->table('notifications')->insert($notificationData);
```

### 3. Customer Melihat Notifikasi
Di navbar landing page, customer bisa:
- Melihat badge merah dengan jumlah notifikasi belum dibaca
- Klik icon bell untuk membuka dropdown notifikasi
- Notifikasi ditampilkan dengan warna sesuai tipe:
  - **success** (hijau): Booking disetujui, selesai
  - **info** (biru): Booking sedang diproses
  - **danger** (merah): Booking ditolak
- Klik notifikasi untuk mark as read
- Klik "Tandai dibaca" untuk mark all as read

## 📡 API Endpoints

### Get Unread Notifications
```
GET /notifications/getUnread
```
Response:
```json
{
  "count": 3,
  "notifications": [
    {
      "id": 1,
      "id_user": 5,
      "id_booking": "22",
      "judul": "Sepatu Sudah Selesai! 🎉",
      "pesan": "Booking ID #22 sudah selesai dicuci...",
      "tipe": "success",
      "dibaca": 0,
      "dibuat_pada": "2026-02-03 13:45:00"
    }
  ]
}
```

### Mark As Read
```
POST /notifications/markAsRead/{id}
```

### Mark All As Read
```
POST /notifications/markAllAsRead
```

## 🎨 UI Components

### Notification Bell
```html
<button onclick="toggleLandingNotifications()">
    <i class="fas fa-bell"></i>
    <span id="landingNotificationBadge">3</span>
</button>
```

### Notification Dropdown
```html
<div id="landingNotificationDropdown">
    <div class="header">
        <span>Notifikasi</span>
        <button onclick="markAllNotificationsAsRead()">Tandai dibaca</button>
    </div>
    <div id="landingNotificationList">
        <!-- Notifications loaded via AJAX -->
    </div>
</div>
```

## 🔄 Auto Refresh

Notifikasi di-refresh otomatis setiap 30 detik:

```javascript
document.addEventListener('DOMContentLoaded', function() {
    loadNotifications();
    // Refresh every 30 seconds
    setInterval(loadNotifications, 30000);
});
```

## 📝 Testing

### Test Flow:
1. Login sebagai customer
2. Buat booking baru
3. Login sebagai admin
4. Update status booking ke "Selesai"
5. Kembali ke customer
6. Lihat notification bell badge (harus muncul angka)
7. Klik bell icon
8. Notifikasi "Sepatu Sudah Selesai! 🎉" muncul
9. Klik notifikasi atau "Tandai dibaca"
10. Badge hilang

### Manual Test Query:
```sql
-- Insert test notification
INSERT INTO notifications (id_user, id_booking, judul, pesan, tipe, dibaca, dibuat_pada)
VALUES (5, '22', 'Sepatu Sudah Selesai! 🎉', 'Booking ID #22 sudah selesai dicuci!', 'success', 0, NOW());

-- Check notifications
SELECT * FROM notifications WHERE id_user = 5 ORDER BY dibuat_pada DESC;

-- Mark as read
UPDATE notifications SET dibaca = 1 WHERE id = 1;
```

## 🎯 Features

✅ **Real-time Notifications** - Auto-created saat admin update status
✅ **Badge Counter** - Menampilkan jumlah notifikasi belum dibaca
✅ **Auto Refresh** - Refresh setiap 30 detik
✅ **Color Coding** - Warna berbeda untuk setiap tipe notifikasi
✅ **Time Ago** - Format waktu relatif (5 menit yang lalu, 2 jam yang lalu)
✅ **Mark as Read** - Individual dan mark all
✅ **Responsive** - Bekerja di mobile dan desktop

## 📂 Files Modified

1. `app/Controllers/Admin/Bookings.php` - Tambah create notification
2. `app/Controllers/Notifications.php` - API endpoints (sudah ada)
3. `app/Views/layouts/base.php` - Navbar dengan notification bell
4. `app/Config/Routes.php` - Routes untuk notifications API
5. `create_notifications_table.sql` - Database schema

## 🚀 Next Steps

1. Jalankan SQL untuk create table `notifications`
2. Test dengan update status booking
3. Verifikasi notifikasi muncul di customer navbar
4. Optional: Tambah push notification atau email notification

---

**Status**: ✅ Implemented & Ready to Test
**Last Updated**: 2026-02-03
