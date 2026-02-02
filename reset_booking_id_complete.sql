-- SOLUSI LENGKAP: Reset ID Booking ke 1-5 dan auto_increment ke 6
-- Database: cuciriobabang

USE cuciriobabang;

-- Step 1: Backup data bookings
CREATE TEMPORARY TABLE bookings_temp AS SELECT * FROM bookings ORDER BY dibuat_pada;

-- Step 2: Hapus semua data bookings
TRUNCATE TABLE bookings;

-- Step 3: Reset auto_increment ke 1
ALTER TABLE bookings AUTO_INCREMENT = 1;

-- Step 4: Insert kembali data dengan ID urut
INSERT INTO bookings 
(id_user, layanan, tipe_sepatu, kondisi_sepatu, jumlah, tanggal_kirim, jam_booking, foto_sepatu, opsi_kirim, alamat_kirim, catatan, subtotal, biaya_kirim, total, status, dibuat_pada, diupdate_pada)
SELECT id_user, layanan, tipe_sepatu, kondisi_sepatu, jumlah, tanggal_kirim, jam_booking, foto_sepatu, opsi_kirim, alamat_kirim, catatan, subtotal, biaya_kirim, total, status, dibuat_pada, diupdate_pada
FROM bookings_temp
ORDER BY dibuat_pada;

-- Step 5: Update referensi di notifications
-- Mapping: old_id -> new_id
-- 13 -> 1, 14 -> 2, 15 -> 3, 16 -> 4, 17 -> 5
UPDATE notifications SET booking_id = 4 WHERE booking_id IN (16, 1, 2, 3);
UPDATE notifications SET booking_id = 5 WHERE booking_id IN (17, 4, 5, 6, 7, 8, 9);

-- Step 6: Verifikasi hasil
SELECT 'BOOKINGS:' as '';
SELECT id, id_user, layanan, status FROM bookings ORDER BY id;

SELECT 'NOTIFICATIONS:' as '';
SELECT id, booking_id, judul FROM notifications WHERE booking_id IS NOT NULL ORDER BY booking_id;

SELECT 'AUTO_INCREMENT:' as '';
SELECT Auto_increment FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'cuciriobabang' AND TABLE_NAME = 'bookings';

-- Step 7: Drop temporary table
DROP TEMPORARY TABLE bookings_temp;
