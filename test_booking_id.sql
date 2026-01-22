-- Test insert booking baru untuk memastikan ID urut
USE cuciriobabang;

-- Lihat ID terakhir
SELECT MAX(id) as id_terakhir FROM bookings;

-- Test insert (sesuaikan id_user dengan user yang ada)
INSERT INTO bookings 
(id_user, layanan, tipe_sepatu, jumlah, opsi_kirim, alamat_kirim, subtotal, biaya_kirim, total, status, dibuat_pada, diupdate_pada)
VALUES 
(19, 'fast-cleaning', 'Sneakers', 1, 'pickup', 'Test Address', 25000, 0, 25000, 'pending', NOW(), NOW());

-- Lihat hasil
SELECT id, id_user, layanan, status FROM bookings ORDER BY id;

-- Hapus test data (opsional)
-- DELETE FROM bookings WHERE layanan = 'fast-cleaning' AND alamat_kirim = 'Test Address';
