-- Insert customer_details untuk semua user (bahkan yang belum punya booking)
USE cuciriobabang;

-- Hapus data lama jika ada
DELETE FROM customer_details;

-- Insert untuk semua user
INSERT INTO customer_details (id_user, total_pesanan, total_belanja, catatan, dibuat_pada, diupdate_pada)
SELECT 
    u.id as id_user,
    0 as total_pesanan,
    0.00 as total_belanja,
    NULL as catatan,
    NOW() as dibuat_pada,
    NOW() as diupdate_pada
FROM users u
WHERE u.id NOT IN (SELECT id_user FROM customer_details);

-- Update data yang sudah punya booking
UPDATE customer_details cd
SET 
    total_pesanan = (
        SELECT COUNT(*) 
        FROM bookings b 
        WHERE b.id_user = cd.id_user
    ),
    total_belanja = (
        SELECT IFNULL(SUM(b.total), 0) 
        FROM bookings b 
        WHERE b.id_user = cd.id_user 
        AND b.status = 'selesai'
    ),
    diupdate_pada = NOW();

-- Tampilkan hasilnya
SELECT 
    cd.id,
    u.nama_lengkap,
    u.email,
    cd.total_pesanan,
    cd.total_belanja
FROM customer_details cd
JOIN users u ON cd.id_user = u.id
ORDER BY cd.id;
