-- =====================================================
-- Struktur Tabel Services untuk SYH.CLEANING
-- =====================================================
-- Database: cuciriobabang
-- Tabel: services
-- =====================================================

-- Jika tabel sudah ada, hapus dulu (HATI-HATI: Ini akan menghapus data!)
-- DROP TABLE IF EXISTS services;

-- Buat tabel baru dengan struktur lengkap
CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_layanan` varchar(100) NOT NULL COMMENT 'Kode unik layanan (fast-cleaning, deep-cleaning, dll)',
  `nama_layanan` varchar(255) NOT NULL COMMENT 'Nama layanan yang ditampilkan',
  `deskripsi` text DEFAULT NULL COMMENT 'Deskripsi detail layanan',
  `harga_dasar` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Harga dasar layanan dalam Rupiah',
  `durasi_hari` int(11) NOT NULL DEFAULT 1 COMMENT 'Estimasi durasi pengerjaan dalam hari',
  `icon_path` varchar(255) DEFAULT NULL COMMENT 'Path file icon/gambar layanan (uploads/services/...)',
  `aktif` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Aktif, 0=Nonaktif',
  `dibuat_pada` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Tanggal layanan dibuat',
  `diupdate_pada` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Tanggal terakhir diupdate',
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_layanan` (`kode_layanan`),
  KEY `aktif` (`aktif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabel master layanan cuci sepatu';

-- =====================================================
-- Jika tabel sudah ada dan hanya ingin menambahkan kolom icon_path:
-- =====================================================

-- Cek apakah kolom icon_path sudah ada, jika belum tambahkan:
ALTER TABLE `services` 
ADD COLUMN IF NOT EXISTS `icon_path` varchar(255) DEFAULT NULL COMMENT 'Path file icon/gambar layanan' 
AFTER `durasi_hari`;

-- =====================================================
-- Data Sample (Opsional)
-- =====================================================

-- Jika tabel kosong, insert data sample:
INSERT INTO `services` (`kode_layanan`, `nama_layanan`, `deskripsi`, `harga_dasar`, `durasi_hari`, `aktif`) VALUES
('fast-cleaning', 'Fast Cleaning', 'Pembersihan cepat untuk sepatu dengan tingkat kotoran ringan hingga sedang', 15000.00, 1, 1),
('deep-cleaning', 'Deep Cleaning', 'Pembersihan mendalam untuk sepatu dengan kotoran membandel', 25000.00, 3, 1),
('white-shoes', 'White Shoes Treatment', 'Treatment khusus untuk sepatu putih agar kembali bersih cemerlang', 20000.00, 2, 1),
('suede-treatment', 'Suede Treatment', 'Mencuci sepatu berbahan suede secara keseluruhan', 30000.00, 3, 1),
('unyellowing', 'Unyellowing', 'Menghilangkan noda kuning pada sol sepatu', 35000.00, 4, 1)
ON DUPLICATE KEY UPDATE 
  `nama_layanan` = VALUES(`nama_layanan`),
  `deskripsi` = VALUES(`deskripsi`),
  `harga_dasar` = VALUES(`harga_dasar`),
  `durasi_hari` = VALUES(`durasi_hari`);

-- =====================================================
-- Query untuk Cek Struktur Tabel
-- =====================================================

-- Lihat struktur tabel:
-- SHOW COLUMNS FROM services;

-- Lihat semua data:
-- SELECT * FROM services;

-- Lihat hanya layanan aktif:
-- SELECT * FROM services WHERE aktif = 1;
