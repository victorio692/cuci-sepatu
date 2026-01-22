# 🗃️ Database Setup - Cuci Rio Babang

Database sudah berhasil dibuat dan terhubung!

## 📊 Informasi Database

- **Nama Database:** `cuciriobabang`
- **Host:** localhost
- **Username:** root
- **Password:** (kosong)
- **Port:** 3306

## 📋 Struktur Tabel

### 1. Tabel `users`
```
id, full_name, email, phone, password_hash, address, city, 
province, zip_code, is_active, is_admin, created_at, updated_at
```

### 2. Tabel `bookings`
```
id, user_id, service, shoe_type, shoe_condition, quantity, 
delivery_date, delivery_option, delivery_address, notes, 
subtotal, delivery_fee, total, status, created_at, updated_at
```

### 3. Tabel `services`
```
id, service_code, service_name, description, base_price, 
duration_days, is_active, created_at, updated_at
```

### 4. Tabel `customer_details`
```
id, user_id, total_orders, total_spent, member_since, 
last_order_date, loyalty_points, notes, created_at, updated_at
```

### 5. Tabel `payments`
```
id, booking_id, amount, payment_method, payment_status, 
paid_at, payment_proof, notes, created_at, updated_at
```

### 6. Tabel `reports`
```
id, report_date, report_type, total_orders, completed_orders, 
cancelled_orders, total_revenue, total_expenses, net_profit, 
notes, created_at, updated_at
```

## 🔐 Akun Login

### Admin
- **Email:** rio@cuciriobabang.com
- **Password:** password

### Customer Test
- **Email:** andiwijaya88@gmail.com
- **Password:** password

## 📁 File Penting

- **SQL Schema:** [database_schema.sql](../database_schema.sql)
- **Config Database:** [app/Config/Database.php](../app/Config/Database.php)
- **Migration Users:** [app/Database/Migrations/2026-01-21-000001_create_users_table.php](../app/Database/Migrations/2026-01-21-000001_create_users_table.php)
- **Migration Bookings:** [app/Database/Migrations/2026-01-21-000002_create_bookings_table.php](../app/Database/Migrations/2026-01-21-000002_create_bookings_table.php)

## 🚀 Cara Menggunakan

### 1. Import Database (Sudah Dilakukan)
```bash
# Via MySQL CLI
mysql -u root -e "SOURCE c:/laragon/www/cuci-sepatu/database_schema.sql"
```

### 2. Atau Via Migration CodeIgniter
```bash
php spark migrate
php spark db:seed UserSeeder
```

### 3. Test Koneksi
Buka browser dan akses:
```
http://localhost/cuci-sepatu/public/test-database.php
```

## 📊 Data Sample

### Users (7 orang)
1. Rio Babang (Admin) - Jakarta Timur
2. Andi Wijaya - Tangerang
3. Siti Nurhaliza - Depok
4. Rudi Hartono - Bekasi
5. Dewi Lestari - Tangerang Selatan
6. Agus Priyanto - Jakarta Timur
7. Fitri Handayani - Tangerang Selatan

### Services (5 layanan)
- Fast Cleaning - Rp 15.000 (1 hari)
- Deep Cleaning - Rp 20.000 (2 hari)
- White Shoes - Rp 35.000 (2 hari)
- Suede Treatment - Rp 30.000 (2 hari)
- Unyellowing - Rp 30.000 (2 hari)

### Bookings (11 pesanan)
- Status: pending, approved, in_progress, completed
- Delivery: home (+ Rp 5.000) atau pickup (gratis)

### Payments (9 transaksi)
- Method: cash, transfer, gopay, ovo, dana
- Status: paid, pending

### Reports
- Daily: 7 laporan harian
- Monthly: 2 laporan bulanan

## 🔧 Troubleshooting

### Error: Database tidak ditemukan
```sql
CREATE DATABASE cuciriobabang;
```

### Error: Table tidak ada
```bash
mysql -u root -e "SOURCE c:/laragon/www/cuci-sepatu/database_schema.sql"
```

### Error: Connection refused
1. Pastikan Laragon sudah running
2. Cek MySQL service: Start > MySQL
3. Test koneksi: `mysql -u root`

## 📝 Query Berguna

### Lihat semua pesanan
```sql
USE cuciriobabang;
SELECT b.*, u.full_name FROM bookings b 
JOIN users u ON b.user_id = u.id;
```

### Total revenue
```sql
SELECT SUM(total) as revenue FROM bookings WHERE status = 'completed';
```

### Top customer
```sql
SELECT u.full_name, COUNT(b.id) as total_order, SUM(b.total) as spent
FROM users u
JOIN bookings b ON u.id = b.user_id
GROUP BY u.id
ORDER BY spent DESC;
```

---

✅ **Database sudah siap digunakan!**

Test di: http://localhost/cuci-sepatu/public/test-database.php
