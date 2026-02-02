-- Populate customer_details dari data bookings yang sudah ada
USE cuciriobabang;

-- Hapus data lama (jika ada)
TRUNCATE TABLE customer_details;

-- Insert customer_details berdasarkan data bookings
INSERT INTO customer_details (id_user, total_pesanan, total_belanja, catatan, dibuat_pada, diupdate_pada)
SELECT 
    u.id as id_kenapa user,
    COUNT(b.id) as total_pesanan,
    IFNULL(SUM(CASE WHEN b.status = 'selesai' THEN b.total_harga ELSE 0 END), 0) as total_belanja,
    NULL as catatan,
    MIN(b.dibuat_pada) as dibuat_pada,
    NOW() as diupdate_pada
FROM users u
LEFT JOIN bookings b ON u.id = b.id_user
WHERE u.admin = 0  -- Hanya customer, bukan admin
GROUP BY u.id;

-- Buat trigger untuk auto-update saat booking baru
DELIMITER //

-- Trigger saat booking baru dibuat
DROP TRIGGER IF EXISTS after_booking_insert//
CREATE TRIGGER after_booking_insert
AFTER INSERT ON bookings
FOR EACH ROW
BEGIN
    -- Cek apakah customer_details sudah ada
    IF EXISTS (SELECT 1 FROM customer_details WHERE id_user = NEW.id_user) THEN
        -- Update existing
        UPDATE customer_details 
        SET total_pesanan = total_pesanan + 1,
            diupdate_pada = NOW()
        WHERE id_user = NEW.id_user;
    ELSE
        -- Insert new
        INSERT INTO customer_details (id_user, total_pesanan, total_belanja, dibuat_pada, diupdate_pada)
        VALUES (NEW.id_user, 1, 0, NOW(), NOW());
    END IF;
END//

-- Trigger saat booking diupdate ke status selesai
DROP TRIGGER IF EXISTS after_booking_update//
CREATE TRIGGER after_booking_update
AFTER UPDATE ON bookings
FOR EACH ROW
BEGIN
    -- Jika status berubah menjadi selesai
    IF NEW.status = 'selesai' AND OLD.status != 'selesai' THEN
        UPDATE customer_details 
        SET total_belanja = total_belanja + NEW.total_harga,
            diupdate_pada = NOW()
        WHERE id_user = NEW.id_user;
    END IF;
    
    -- Jika status berubah dari selesai ke status lain (rollback)
    IF OLD.status = 'selesai' AND NEW.status != 'selesai' THEN
        UPDATE customer_details 
        SET total_belanja = total_belanja - OLD.total_harga,
            diupdate_pada = NOW()
        WHERE id_user = OLD.id_user;
    END IF;
END//

-- Trigger saat booking dihapus
DROP TRIGGER IF EXISTS after_booking_delete//
CREATE TRIGGER after_booking_delete
AFTER DELETE ON bookings
FOR EACH ROW
BEGIN
    UPDATE customer_details 
    SET total_pesanan = total_pesanan - 1,
        total_belanja = CASE 
            WHEN OLD.status = 'selesai' THEN total_belanja - OLD.total_harga
            ELSE total_belanja
        END,
        diupdate_pada = NOW()
    WHERE id_user = OLD.id_user;
END//

DELIMITER ;

-- Verifikasi hasil
SELECT 
    cd.id,
    cd.id_user,
    u.nama_lengkap,
    cd.total_pesanan,
    cd.total_belanja,
    cd.dibuat_pada,
    cd.diupdate_pada
FROM customer_details cd
JOIN users u ON cd.id_user = u.id
ORDER BY cd.id;
