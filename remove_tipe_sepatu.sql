-- Hapus kolom tipe_sepatu dari tabel bookings
-- Jalankan SQL ini di phpMyAdmin atau database client Anda

USE cuciriobabang;

-- Backup data terlebih dahulu (opsional)
-- CREATE TABLE bookings_backup AS SELECT * FROM bookings;

-- Hapus kolom tipe_sepatu
ALTER TABLE bookings DROP COLUMN tipe_sepatu;

-- Verifikasi perubahan
DESCRIBE bookings;
