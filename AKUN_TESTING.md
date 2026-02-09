# 🔐 Akun Testing SYH Cleaning

## Akun Admin

### Admin 1 - Owner
- **Nama:** Rio Babang
- **Email:** `rio@cuciriobabang.com`
- **Password:** `password123`
- **Role:** `admin`
- **Deskripsi:** Pemilik utama SYH Cleaning

### Admin 2 - Manager
- **Nama:** Sarah Wijaya
- **Email:** `admin@syhhcleaning@gmail.com`
- **Password:** `admin123`
- **Role:** `admin`
- **Deskripsi:** Manager yang mengelola operasional

---

## Akun Petugas

### Petugas 1
- **Nama:** Andi Prasetyo
- **Email:** `andi@syhhcleaning@gmail.com`
- **Password:** `petugas123`
- **Role:** `petugas`
- **Deskripsi:** Staff operasional yang menangani pesanan

---

## Akun Pelanggan

### Pelanggan 1
- **Nama:** Budi Santoso
- **Email:** `budisantoso88@gmail.com`
- **Password:** `password123`
- **Role:** `pelanggan`
- **Alamat:** Perum Cimanggis Indah Blok A3, Depok

### Pelanggan 2
- **Nama:** Siti Nurhaliza
- **Email:** `siti.nur@yahoo.com`
- **Password:** `password123`
- **Role:** `pelanggan`
- **Alamat:** Jl. Margonda Raya No. 156, Depok

### Pelanggan 3
- **Nama:** Ahmad Fauzi
- **Email:** `ahmadf92@gmail.com`
- **Password:** `password123`
- **Role:** `pelanggan`
- **Alamat:** Komplek Cibubur Country Blok C12, Bekasi

---

## URL Testing

### Admin Dashboard
```
http://localhost:8080/admin
```
Login dengan salah satu akun admin di atas.

### User Dashboard
```
http://localhost:8080/dashboard
```
Login dengan akun pelanggan di atas.

---

## Cara Reset Data (Re-seed)

Jika ingin reset ulang semua user:

```bash
# 1. Hapus semua user
cd C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin
.\mysql.exe -u root -e "USE cuciriobabang; DELETE FROM users;"

# 2. Jalankan seeder
cd c:\laragon\www\cuci-sepatu
php spark db:seed UserSeeder
```

---

## Notes

- Semua password menggunakan bcrypt hashing
- Email harus unique (ada constraint di database)
- Role yang valid: `admin`, `petugas`, `pelanggan`
- Admin memiliki akses penuh ke `/admin` routes
- Petugas akan memiliki dashboard khusus (future development)
- Pelanggan hanya akses `/dashboard` untuk user biasa
