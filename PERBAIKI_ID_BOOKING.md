# Panduan Memperbaiki ID Booking Agar Urut

## Masalah
ID booking tidak urut (misalnya loncat ke 13) karena:
- Data pernah dihapus
- Auto_increment counter tidak dimulai dari 1
- Ada kesalahan dalam proses insert

## Solusi

### Opsi 1: Reset Total (Untuk Development/Testing)
⚠️ **PERHATIAN**: Ini akan menghapus SEMUA data booking!

```sql
USE cuciriobabang;

-- Hapus semua data booking
TRUNCATE TABLE bookings;

-- Reset auto_increment ke 1
ALTER TABLE bookings AUTO_INCREMENT = 1;
```

### Opsi 2: Renumbering Data yang Ada (Tetap Simpan Data)
Jika Anda memiliki data booking yang penting dan ingin dipertahankan:

```sql
USE cuciriobabang;

-- Nonaktifkan foreign key check sementara
SET FOREIGN_KEY_CHECKS = 0;

-- Backup dulu id lama ke kolom temporary
ALTER TABLE bookings ADD COLUMN old_id INT;
UPDATE bookings SET old_id = id;

-- Renumber ID dari 1
SET @num := 0;
UPDATE bookings SET id = @num := (@num+1) ORDER BY dibuat_pada;

-- Update foreign key di tabel lain jika ada (misalnya notifications)
-- UPDATE notifications n 
-- INNER JOIN bookings b ON n.booking_id = b.old_id 
-- SET n.booking_id = b.id;

-- Hapus kolom temporary
ALTER TABLE bookings DROP COLUMN old_id;

-- Reset auto_increment
SET @max_id := (SELECT MAX(id) FROM bookings);
SET @alter_sql := CONCAT('ALTER TABLE bookings AUTO_INCREMENT = ', @max_id + 1);
PREPARE stmt FROM @alter_sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Aktifkan kembali foreign key check
SET FOREIGN_KEY_CHECKS = 1;
```

### Opsi 3: Hanya Reset Counter (Data Lama Tetap)
Jika hanya ingin memastikan data baru dimulai dari nomor yang benar:

```sql
USE cuciriobabang;

-- Cek ID terakhir
SELECT MAX(id) FROM bookings;

-- Reset auto_increment ke 1 jika tabel kosong
ALTER TABLE bookings AUTO_INCREMENT = 1;

-- ATAU jika ada data, set ke ID setelah yang terakhir
-- Ganti [NUMBER] dengan angka setelah ID terakhir
-- ALTER TABLE bookings AUTO_INCREMENT = [NUMBER];
```

## Cara Menjalankan

### Via phpMyAdmin (Laragon):
1. Buka http://localhost/phpmyadmin
2. Login (username: root, password: kosong)
3. Pilih database `cuciriobabang`
4. Klik tab "SQL"
5. Copy-paste salah satu opsi di atas
6. Klik "Go"

### Via MySQL Client:
```bash
mysql -u root -p cuciriobabang < fix_booking_id.sql
```

### Via Laragon Terminal:
```bash
cd c:\laragon\www\cuci-sepatu
mysql -u root cuciriobabang
# Lalu paste salah satu opsi di atas
```

## Verifikasi

Setelah menjalankan, cek hasilnya:

```sql
-- Lihat data booking
SELECT id, id_user, layanan, status, dibuat_pada 
FROM bookings 
ORDER BY id;

-- Cek auto_increment saat ini
SHOW TABLE STATUS WHERE Name = 'bookings';
```

## Rekomendasi

1. **Untuk Development/Testing**: Gunakan Opsi 1 (reset total)
2. **Untuk Production dengan Data**: Gunakan Opsi 2 (renumbering)
3. **Untuk Production Tanpa Ubah Data Lama**: Gunakan Opsi 3 (reset counter saja)

## Catatan Penting

- ✅ ID akan urut mulai dari 1 untuk data baru
- ✅ Auto_increment akan otomatis naik urut
- ⚠️ Jika hapus booking, ID akan tetap ada gap (ini normal untuk MySQL)
- 💡 Untuk display ke user, bisa gunakan format custom seperti "BK-0001", "BK-0002" dst

## Alternatif: Format Display

Jika Anda ingin ID tetap seperti sekarang (dengan gap) tapi tampilan lebih rapi, bisa gunakan format booking number:

```php
// Di Controller atau Model
public function generateBookingNumber($id) {
    return 'BK-' . str_pad($id, 5, '0', STR_PAD_LEFT);
}

// Contoh output:
// ID 1 → BK-00001
// ID 13 → BK-00013
// ID 100 → BK-00100
```

Ini akan membuat tampilan lebih profesional tanpa perlu mengubah struktur database.
