# Struktur Database - SYH Cleaning

Dokumentasi lengkap struktur database untuk aplikasi Cuci Sepatu SYH Cleaning.

## 📊 Diagram ERD

```
┌─────────────────────────────────────────────────┐
│                     USERS                        │
├─────────────────────────────────────────────────┤
│ PK  id              INT(11)                      │
│     full_name       VARCHAR(255)                 │
│     email           VARCHAR(255) [UNIQUE]        │
│     phone           VARCHAR(20)                  │
│     password_hash   VARCHAR(255)                 │
│     address         TEXT                         │
│     city            VARCHAR(100)                 │
│     province        VARCHAR(100)                 │
│     zip_code        VARCHAR(10)                  │
│     is_active       TINYINT(1) [DEFAULT: 1]      │
│     is_admin        TINYINT(1) [DEFAULT: 0]      │
│     created_at      DATETIME                     │
│     updated_at      DATETIME                     │
└─────────────────────────────────────────────────┘
                       │
                       │ 1:N
                       │
                       ▼
┌─────────────────────────────────────────────────┐
│                   BOOKINGS                       │
├─────────────────────────────────────────────────┤
│ PK  id              INT(11)                      │
│ FK  user_id         INT(11)                      │
│     service         VARCHAR(100)                 │
│     shoe_type       VARCHAR(100)                 │
│     shoe_condition  VARCHAR(100)                 │
│     quantity        INT(11)                      │
│     delivery_date   DATE                         │
│     delivery_option VARCHAR(50)                  │
│     delivery_address TEXT                        │
│     notes           TEXT                         │
│     subtotal        DECIMAL(10,2)                │
│     delivery_fee    DECIMAL(10,2)                │
│     total           DECIMAL(10,2)                │
│     status          VARCHAR(50) [DEFAULT: pending]│
│     created_at      DATETIME                     │
│     updated_at      DATETIME                     │
└─────────────────────────────────────────────────┘
```

## 📋 Detail Tabel

### 1. Tabel `users`
Menyimpan data pengguna (customer dan admin)

| Field | Type | Null | Default | Description |
|-------|------|------|---------|-------------|
| id | INT(11) | NO | AUTO_INCREMENT | Primary Key |
| full_name | VARCHAR(255) | NO | - | Nama lengkap pengguna |
| email | VARCHAR(255) | NO | - | Email (unique) untuk login |
| phone | VARCHAR(20) | NO | - | Nomor telepon |
| password_hash | VARCHAR(255) | NO | - | Password terenkripsi (bcrypt) |
| address | TEXT | YES | NULL | Alamat lengkap |
| city | VARCHAR(100) | YES | NULL | Kota |
| province | VARCHAR(100) | YES | NULL | Provinsi |
| zip_code | VARCHAR(10) | YES | NULL | Kode pos |
| is_active | TINYINT(1) | NO | 1 | Status aktif pengguna |
| is_admin | TINYINT(1) | NO | 0 | Role admin (0=user, 1=admin) |
| created_at | DATETIME | YES | NULL | Waktu pembuatan |
| updated_at | DATETIME | YES | NULL | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY: `id`
- INDEX: `email`

**Contoh Data:**
```sql
INSERT INTO users (full_name, email, phone, password_hash, is_admin) VALUES
('Admin SYH', 'admin@syhcleaning.com', '081234567890', '$2y$10$...', 1),
('John Doe', 'john@example.com', '081234567891', '$2y$10$...', 0);
```

---

### 2. Tabel `bookings`
Menyimpan data pemesanan layanan cuci sepatu

| Field | Type | Null | Default | Description |
|-------|------|------|---------|-------------|
| id | INT(11) | NO | AUTO_INCREMENT | Primary Key |
| user_id | INT(11) | NO | - | Foreign Key ke tabel users |
| service | VARCHAR(100) | NO | - | Jenis layanan |
| shoe_type | VARCHAR(100) | YES | NULL | Jenis sepatu |
| shoe_condition | VARCHAR(100) | YES | NULL | Kondisi sepatu |
| quantity | INT(11) | NO | 1 | Jumlah sepatu |
| delivery_date | DATE | YES | NULL | Tanggal pengiriman yang diinginkan |
| delivery_option | VARCHAR(50) | NO | - | Opsi pengiriman |
| delivery_address | TEXT | YES | NULL | Alamat pengiriman |
| notes | TEXT | YES | NULL | Catatan tambahan |
| subtotal | DECIMAL(10,2) | NO | 0 | Subtotal (harga × quantity) |
| delivery_fee | DECIMAL(10,2) | NO | 0 | Biaya pengiriman |
| total | DECIMAL(10,2) | NO | 0 | Total pembayaran |
| status | VARCHAR(50) | NO | pending | Status pemesanan |
| created_at | DATETIME | YES | NULL | Waktu pembuatan |
| updated_at | DATETIME | YES | NULL | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY: `id`
- INDEX: `user_id`
- INDEX: `status`
- INDEX: `created_at`
- FOREIGN KEY: `user_id` REFERENCES `users(id)` ON DELETE CASCADE ON UPDATE CASCADE

**Enum Values:**

**Service Types:**
- `fast-cleaning` - Fast Cleaning (Rp 15.000)
- `deep-cleaning` - Deep Cleaning (Rp 20.000)
- `white-shoes` - White Shoes Specialist (Rp 35.000)
- `coating` - Coating Protection (Rp 25.000)
- `dyeing` - Dyeing/Pewarnaan (Rp 40.000)
- `repair` - Repair/Perbaikan (Rp 50.000)

**Delivery Options:**
- `pickup` - Ambil di Toko (Gratis)
- `home` - Antar ke Rumah (Rp 5.000)

**Status:**
- `pending` - Menunggu konfirmasi
- `approved` - Disetujui
- `in_progress` - Sedang dikerjakan
- `completed` - Selesai
- `cancelled` - Dibatalkan

**Contoh Data:**
```sql
INSERT INTO bookings (user_id, service, shoe_type, shoe_condition, quantity, delivery_date, delivery_option, delivery_address, subtotal, delivery_fee, total, status) VALUES
(2, 'deep-cleaning', 'Sneakers', 'Kotor', 2, '2026-01-25', 'home', 'Jl. Contoh No. 123, Jakarta', 40000, 5000, 45000, 'pending');
```

---

## 🔐 Relasi Antar Tabel

### users → bookings (One to Many)
- Satu user dapat memiliki banyak bookings
- Foreign Key: `bookings.user_id` → `users.id`
- ON DELETE CASCADE: Jika user dihapus, semua bookings miliknya juga terhapus
- ON UPDATE CASCADE: Jika user.id berubah, bookings.user_id otomatis update

---

## 🚀 Cara Menjalankan Migration

### 1. Membuat Database

```sql
CREATE DATABASE cuci_sepatu;
USE cuci_sepatu;
```

### 2. Konfigurasi Database

Edit file `app/Config/Database.php`:

```php
public array $default = [
    'DSN'      => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'cuci_sepatu',
    'DBDriver' => 'MySQLi',
    'DBPrefix' => '',
    'pConnect' => false,
    'DBDebug'  => true,
    'charset'  => 'utf8mb4',
    'DBCollat' => 'utf8mb4_general_ci',
    'swapPre'  => '',
    'encrypt'  => false,
    'compress' => false,
    'strictOn' => false,
    'failover' => [],
    'port'     => 3306,
];
```

### 3. Jalankan Migration

```bash
# Via Spark CLI
php spark migrate

# Atau rollback
php spark migrate:rollback

# Reset database
php spark migrate:refresh
```

---

## 📝 SQL Manual (Alternatif)

Jika ingin membuat tabel secara manual tanpa migration:

```sql
-- Tabel Users
CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel Bookings
CREATE TABLE `bookings` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `service` varchar(100) NOT NULL COMMENT 'fast-cleaning, deep-cleaning, white-shoes, coating, dyeing, repair',
  `shoe_type` varchar(100) DEFAULT NULL,
  `shoe_condition` varchar(100) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `delivery_date` date DEFAULT NULL,
  `delivery_option` varchar(50) NOT NULL COMMENT 'pickup or home',
  `delivery_address` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `delivery_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(50) NOT NULL DEFAULT 'pending' COMMENT 'pending, approved, in_progress, completed, cancelled',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`),
  CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

---

## 🌱 Data Seeder (Contoh)

Untuk membuat data dummy untuk testing:

```php
// app/Database/Seeds/UserSeeder.php
<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin Account
        $this->db->table('users')->insert([
            'full_name' => 'Admin SYH',
            'email' => 'admin@syhcleaning.com',
            'phone' => '081234567890',
            'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
            'address' => 'Jl. Utama No. 1, Jakarta',
            'city' => 'Jakarta',
            'province' => 'DKI Jakarta',
            'zip_code' => '12345',
            'is_active' => 1,
            'is_admin' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Regular User
        $this->db->table('users')->insert([
            'full_name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '081234567891',
            'password_hash' => password_hash('user123', PASSWORD_BCRYPT),
            'address' => 'Jl. Sample No. 123, Bandung',
            'city' => 'Bandung',
            'province' => 'Jawa Barat',
            'zip_code' => '40123',
            'is_active' => 1,
            'is_admin' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
```

Jalankan seeder:
```bash
php spark db:seed UserSeeder
```

---

## 📊 Statistik Database

**Total Tables:** 2
- `users`
- `bookings`

**Total Relationships:** 1
- users → bookings (1:N)

**Storage Engine:** InnoDB
**Charset:** utf8mb4
**Collation:** utf8mb4_general_ci

---

## 🔍 Query Berguna

### Melihat Semua Pesanan dengan Info User
```sql
SELECT 
    b.id,
    b.service,
    b.quantity,
    b.total,
    b.status,
    b.created_at,
    u.full_name,
    u.email,
    u.phone
FROM bookings b
JOIN users u ON b.user_id = u.id
ORDER BY b.created_at DESC;
```

### Total Pendapatan per Bulan
```sql
SELECT 
    DATE_FORMAT(created_at, '%Y-%m') as month,
    COUNT(*) as total_orders,
    SUM(total) as total_revenue
FROM bookings
WHERE status = 'completed'
GROUP BY month
ORDER BY month DESC;
```

### Top 5 Customer
```sql
SELECT 
    u.full_name,
    u.email,
    COUNT(b.id) as total_orders,
    SUM(b.total) as total_spent
FROM users u
LEFT JOIN bookings b ON u.id = b.user_id
GROUP BY u.id
ORDER BY total_spent DESC
LIMIT 5;
```

### Layanan Terpopuler
```sql
SELECT 
    service,
    COUNT(*) as order_count,
    SUM(quantity) as total_shoes,
    SUM(total) as total_revenue
FROM bookings
GROUP BY service
ORDER BY order_count DESC;
```

---

## 📌 Catatan Penting

1. **Password**: Selalu gunakan `password_hash()` dengan algoritma `PASSWORD_BCRYPT`
2. **Timestamps**: Gunakan format `Y-m-d H:i:s` untuk created_at dan updated_at
3. **Foreign Keys**: Sudah menggunakan CASCADE untuk otomatis menghapus data terkait
4. **Indexes**: Sudah ditambahkan pada field yang sering di-query
5. **Charset**: utf8mb4 untuk mendukung emoji dan karakter khusus
6. **Decimal**: Gunakan DECIMAL(10,2) untuk menyimpan nilai uang

---

Dibuat dengan ❤️ untuk SYH Cleaning
Terakhir diperbarui: 21 Januari 2026
