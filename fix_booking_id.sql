-- Script untuk memastikan ID booking urut dari 1
USE cuciriobabang;

-- Lihat ID booking yang ada saat ini
SELECT id, id_user, layanan, status, dibuat_pada 
FROM bookings 
ORDER BY id;

-- Cek auto_increment saat ini
SELECT AUTO_INCREMENT 
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'cuciriobabang' 
AND TABLE_NAME = 'bookings';

-- OPSI 1: Jika ingin reset dan mulai dari 1 (HATI-HATI: hanya gunakan jika tidak ada data penting)
-- TRUNCATE TABLE bookings;
-- ALTER TABLE bookings AUTO_INCREMENT = 1;

-- OPSI 2: Jika ada data dan ingin tetap urut ke depannya (tidak reset data lama)
-- SET @num := 0;
-- UPDATE bookings SET id = @num := (@num+1) ORDER BY dibuat_pada;
-- ALTER TABLE bookings AUTO_INCREMENT = (SELECT MAX(id) + 1 FROM bookings);

-- OPSI 3: Reset auto_increment ke angka setelah ID terakhir (untuk data baru)
-- ALTER TABLE bookings AUTO_INCREMENT = 1;
