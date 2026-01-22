# Database Cuci Rio Babang

## Tabel

### users
nyimpen data user sama admin

### bookings  
nyimpen pesanan dari customer

### services
daftar layanan yg tersedia

### customer_details
detail lengkap customer (total order, poin, dll)

### payments
pembayaran dari setiap booking

### reports
laporan harian & bulanan

## Data

**Total tabel:** 6
**Total users:** 7 (1 admin, 6 customer)
**Total bookings:** 11
**Total services:** 5
**Total payments:** 9
**Total reports:** 9

## Login

Admin: rio@cuciriobabang.com / password
User: andiwijaya88@gmail.com / password

## Harga Layanan

- Fast Cleaning: 15rb (1 hari)
- Deep Cleaning: 20rb (2 hari)
- White Shoes: 35rb (2 hari)
- Suede Treatment: 30rb (2 hari)
- Unyellowing: 30rb (2 hari)

## Metode Pembayaran

- Cash
- Transfer Bank
- GoPay
- OVO
- DANA

## Status Booking

- pending: nunggu konfirmasi
- approved: udah dikonfirmasi
- in_progress: lg dikerjain
- completed: udah selesai
- cancelled: dibatalin

## File Penting

- database_schema.sql (tabel users & bookings)
- add_tables.sql (tabel tambahan)
- app/Config/Database.php (config db)

## Import Database

```bash
mysql -u root
```

```sql
SOURCE c:/laragon/www/cuci-sepatu/database_schema.sql
SOURCE c:/laragon/www/cuci-sepatu/add_tables.sql
```

atau langsung:

```bash
mysql -u root cuciriobabang < database_schema.sql
mysql -u root cuciriobabang < add_tables.sql
```

## Test

Buka: http://localhost/cuci-sepatu/public/test-database.php

## Query

cek semua tabel:
```sql
USE cuciriobabang;
SHOW TABLES;
```

lihat pesanan:
```sql
SELECT b.*, u.full_name FROM bookings b JOIN users u ON b.user_id = u.id;
```

lihat pembayaran:
```sql
SELECT p.*, b.service FROM payments p JOIN bookings b ON p.booking_id = b.id;
```

total income:
```sql
SELECT SUM(amount) FROM payments WHERE payment_status = 'paid';
```

top customer:
```sql
SELECT * FROM customer_details ORDER BY total_spent DESC;
```
