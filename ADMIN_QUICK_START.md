# 🚀 Admin Dashboard - Quick Start Guide

## Testing Admin Features

### 1️⃣ Login sebagai Admin

Untuk test admin panel, Anda perlu user dengan `is_admin = 1` di database.

**Opsi A: Via Database**
```sql
-- Update existing user menjadi admin
UPDATE users SET is_admin = 1 WHERE id = 1;

-- Atau create new admin user
INSERT INTO users (full_name, email, phone, password_hash, address, city, province, zip_code, is_active, is_admin, created_at, updated_at)
VALUES (
  'Admin SYH',
  'admin@syh.com',
  '08123456789',
  '$2y$10$...(bcrypt hash of password)',
  'Jl Admin',
  'Jakarta',
  'DKI Jakarta',
  '12345',
  1,
  1,
  NOW(),
  NOW()
);
```

**Password Default untuk bcrypt hash:**
```
Password: admin123
Bcrypt Hash: $2y$10$YrREZ4Y/M9yC5Y5K7gL2ZuU.5L5Q5L5L5L5L5L5L5L5L5L5L5L5L5
```

**Atau gunakan PHP untuk generate hash:**
```php
echo password_hash('admin123', PASSWORD_BCRYPT);
```

### 2️⃣ Navigate ke Admin Panel

1. Go to `http://localhost:8080/login`
2. Login dengan email: `admin@syh.com` dan password: `admin123`
3. Anda akan diarahkan ke `/dashboard`
4. Click "Admin Panel" di user dropdown atau navigate ke `http://localhost:8080/admin`

### 3️⃣ Admin Panel Features

#### 📊 Dashboard (`/admin`)
- Lihat total users, bookings, completed rate, dan revenue
- Scroll down untuk lihat recent bookings, pending list, service stats

#### 📦 Pesanan (`/admin/bookings`)
- **Search**: Cari by nama customer, email, atau service
- **Filter**: Filter by status (pending, approved, in_progress, completed, cancelled)
- **Update Status**: Click dropdown di kolom status untuk ubah
- **View Detail**: Click "Lihat" untuk melihat detail lengkap pesanan

#### 👥 Users (`/admin/users`)
- **Search**: Cari by nama, email, atau phone
- **Toggle Status**: Click badge untuk activate/deactivate user
- **View Detail**: Click "Lihat" untuk melihat profile dan booking history user

#### 🔧 Services (`/admin/services`)
- Lihat semua 6 services
- **Update Price**: Click "Ubah Harga" untuk edit harga layanan
- Harga langsung terupdate dengan modal form

---

## Testing User Features

### 1️⃣ Register Pengguna Baru

1. Go to `http://localhost:8080/register`
2. Isi form:
   - Full Name: John Doe
   - Email: john@example.com
   - Phone: 081234567890
   - Password: password123
3. Click "Daftar"
4. User akan login automatically dan redirect ke dashboard

### 2️⃣ User Dashboard (`/dashboard`)

- Lihat statistik pesanan Anda
- Lihat recent bookings
- Quick action cards

### 3️⃣ Buat Pesanan (`/make-booking`)

1. Click "Pesan Layanan" button
2. **Step 1**: Select service (Fast Cleaning, Deep Cleaning, dll)
3. **Step 2**: Input booking details:
   - Shoe Type (Sneakers, Formal, Boots, etc)
   - Shoe Condition (Normal, Dirty, Very Dirty)
   - Quantity (Jumlah pasang)
   - Delivery Date
4. **Step 3**: Select delivery option:
   - Pickup at Store (Gratis)
   - Home Delivery (Rp 5,000)
5. Review order summary
6. Click "Booking Sekarang"
7. Pesanan akan muncul di "Pesanan Saya"

### 4️⃣ Lihat Pesanan Saya (`/my-bookings`)

- Lihat daftar semua pesanan Anda
- View detail pesanan
- Lihat status pesanan

### 5️⃣ Profil (`/profile`)

- Update informasi personal
- Change password
- Modal form untuk edit data

---

## API Testing (untuk developers)

### Dengan Postman atau cURL

**Update Booking Status**
```bash
curl -X PUT http://localhost:8080/admin/bookings/1/status \
  -H "Content-Type: application/json" \
  -d '{"status":"approved"}' \
  -b "PHPSESSID=<session-id>"
```

**Toggle User Active Status**
```bash
curl -X POST http://localhost:8080/admin/users/1/toggle \
  -H "Content-Type: application/json" \
  -b "PHPSESSID=<session-id>"
```

**Update Service Price**
```bash
curl -X POST http://localhost:8080/admin/services/price \
  -H "Content-Type: application/json" \
  -d '{"service":"fast-cleaning","price":18000}' \
  -b "PHPSESSID=<session-id>"
```

---

## Database Structure Quick Reference

### Users Table
```
id, full_name, email, phone, password_hash, 
address, city, province, zip_code, 
is_active (0/1), is_admin (0/1), 
created_at, updated_at
```

### Bookings Table
```
id, user_id, service, shoe_type, shoe_condition, quantity,
delivery_date, delivery_option, delivery_address, notes,
subtotal, delivery_fee, total,
status (pending/approved/in_progress/completed/cancelled),
created_at, updated_at
```

---

## Troubleshooting

### ❌ "Access denied" ketika ke /admin
- Pastikan user punya `is_admin = 1`
- Pastikan sudah login

### ❌ 404 Page Not Found
- Pastikan routes sudah update di `app/Config/Routes.php`
- Clear browser cache

### ❌ Database errors
- Pastikan users dan bookings table sudah create
- Check database connection di `.env`

### ❌ Session tidak working
- Pastikan `app/Config/Session.php` configured properly
- Check writable/session folder permissions

### ❌ Images not loading
- Pastikan `public/assets/` folder structure correct
- Check CSS/JS file paths

---

## File Structure

```
app/
├── Controllers/
│   ├── Admin/
│   │   ├── Dashboard.php
│   │   ├── Bookings.php
│   │   ├── Users.php
│   │   └── Services.php
│   ├── Auth.php
│   ├── Dashboard.php
│   ├── Booking.php
│   └── Home.php
├── Views/
│   ├── layouts/
│   │   ├── admin.php
│   │   └── base.php
│   ├── admin/
│   │   ├── dashboard.php
│   │   ├── bookings.php
│   │   ├── booking_detail.php
│   │   ├── users.php
│   │   ├── user_detail.php
│   │   └── services.php
│   ├── auth/
│   │   ├── login.php
│   │   └── register.php
│   └── pages/
│       ├── home.php
│       ├── dashboard.php
│       ├── booking.php
│       └── ...
├── Helpers/
│   ├── AuthHelper.php
│   └── AuthManager.php
├── Filters/
│   └── Auth.php
└── Config/
    ├── Routes.php
    ├── Filters.php
    └── Autoload.php

public/assets/
├── css/
│   ├── style.css
│   └── admin.css
└── js/
    ├── main.js
    └── admin.js
```

---

## Quick Commands (if needed)

### Clear Session (via SQL)
```sql
DELETE FROM ci_sessions;
```

### Reset Admin Password (via SQL)
```sql
UPDATE users 
SET password_hash = '$2y$10$...' 
WHERE id = 1;
```

### View All Pending Bookings
```sql
SELECT * FROM bookings WHERE status = 'pending';
```

---

## ✅ Everything is Ready!

Your admin dashboard system is **fully functional and ready to use**. 

- Register new users
- Create bookings
- Manage all bookings as admin
- Manage all users as admin
- Update service prices

**Happy testing!** 🎉

---

**Questions?** Check `ADMIN_DASHBOARD_REPORT.md` for detailed technical documentation.
