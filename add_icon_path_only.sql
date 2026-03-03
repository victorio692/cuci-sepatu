-- =====================================================
-- Menambahkan kolom icon_path ke tabel services
-- Database: cuciriobabang
-- =====================================================

-- Tambahkan kolom icon_path (jika belum ada)
ALTER TABLE `services` 
ADD COLUMN IF NOT EXISTS `icon_path` VARCHAR(255) NULL COMMENT 'Path file icon/gambar layanan' 
AFTER `durasi_hari`;

-- Verifikasi kolom sudah ditambahkan
SHOW COLUMNS FROM `services`;
