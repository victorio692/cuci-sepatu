CREATE DATABASE IF NOT EXISTS `cuciriobabang` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cuciriobabang`;

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `address` text,
  `city` varchar(100),
  `province` varchar(100),
  `zip_code` varchar(10),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `bookings` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `service` varchar(100) NOT NULL,
  `shoe_type` varchar(100) DEFAULT NULL,
  `shoe_condition` varchar(100) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `delivery_date` date DEFAULT NULL,
  `delivery_option` varchar(50) NOT NULL,
  `delivery_address` text,
  `notes` text,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `delivery_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`full_name`, `email`, `phone`, `password_hash`, `address`, `city`, `province`, `zip_code`, `is_active`, `is_admin`, `created_at`, `updated_at`) VALUES
('Rio Babang', 'rio@cuciriobabang.com', '081298765432', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jl. Raya Bogor KM 23 No. 45', 'Jakarta Timur', 'DKI Jakarta', '13720', 1, 1, '2025-11-12 08:23:11', '2026-01-20 14:32:45'),
('Andi Wijaya', 'andiwijaya88@gmail.com', '085721334455', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Citra Garden 2 Blok B12/8', 'Tangerang', 'Banten', '15810', 1, 0, '2025-12-03 10:15:23', '2026-01-18 09:45:12'),
('Siti Nurhaliza', 'siti.nur22@yahoo.com', '081367889012', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jl. Margonda Raya 156 Kel. Limo', 'Depok', 'Jawa Barat', '16514', 1, 0, '2025-12-18 15:42:09', '2026-01-19 11:23:34'),
('Rudi Hartono', 'rudihartono99@outlook.com', '082145678923', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Permata Hijau F18', 'Bekasi', 'Jawa Barat', '17133', 1, 0, '2026-01-02 13:28:47', '2026-01-20 16:12:03'),
('Dewi Lestari', 'dewi.lestari@hotmail.com', '087823456712', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jl. Kartini Gg 5/23A Bintaro', 'Tangerang Selatan', 'Banten', '15220', 1, 0, '2026-01-08 09:17:55', '2026-01-08 09:17:55'),
('Agus Priyanto', 'aguspriyanto.id@gmail.com', '081556789234', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jl. Raya Bogor KM 28/99 Cibubur', 'Jakarta Timur', 'DKI Jakarta', '13720', 1, 0, '2026-01-12 16:33:22', '2026-01-19 08:54:17'),
('Fitri Handayani', 'fitri.handayani93@gmail.com', '089634521789', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Komp. Griya Asri C8 Ciputat', 'Tangerang Selatan', 'Banten', '15411', 1, 0, '2026-01-15 11:42:30', '2026-01-15 11:42:30');

INSERT INTO `bookings` (`user_id`, `service`, `shoe_type`, `shoe_condition`, `quantity`, `delivery_date`, `delivery_option`, `delivery_address`, `notes`, `subtotal`, `delivery_fee`, `total`, `status`, `created_at`, `updated_at`) VALUES
(2, 'deep-cleaning', 'Adidas NMD', 'kotor bgt bro', 1, '2026-01-23', 'home', 'Citra Garden 2 Blok B12/8, Tangerang', 'kalo bisa cepet ya mas', 20000.00, 5000.00, 25000.00, 'pending', '2026-01-20 10:32:11', '2026-01-20 10:32:11'),
(3, 'white-shoes', 'Converse', 'udah kuning nih', 2, '2026-01-24', 'pickup', NULL, '', 70000.00, 0.00, 70000.00, 'approved', '2026-01-19 14:22:45', '2026-01-20 09:15:33'),
(2, 'fast-cleaning', 'Vans Old Skool', 'kotor dikit aja', 1, '2026-01-22', 'home', 'Citra Garden 2 Blok B12/8', NULL, 15000.00, 5000.00, 20000.00, 'completed', '2026-01-17 11:45:23', '2026-01-19 15:23:12'),
(4, 'repair', 'Timberland', 'Sol nya copot', 1, '2026-01-25', 'pickup', NULL, 'sol depan kiri lepas, bisa diperbaiki kan?', 50000.00, 0.00, 50000.00, 'in_progress', '2026-01-18 16:52:34', '2026-01-20 08:34:22'),
(3, 'coating', 'Nike Air Max 90', 'msh bgs kok', 1, '2026-01-26', 'home', 'Jl. Margonda Raya 156 Kel. Limo, Depok', 'pgn sepatunya awet', 25000.00, 5000.00, 30000.00, 'completed', '2026-01-15 09:23:11', '2026-01-17 14:12:45'),
(5, 'dyeing', 'New Balance 574', 'warnanya pudar', 1, '2026-01-27', 'home', 'Jl. Kartini Gg 5/23A Bintaro, Tangerang Selatan', 'mau di cat ulang warna hitam ya', 40000.00, 5000.00, 45000.00, 'approved', '2026-01-19 13:42:09', '2026-01-20 11:28:56'),
(6, 'deep-cleaning', 'Puma Suede', 'bau banget anjir', 2, '2026-01-28', 'pickup', NULL, 'sepatu abis dipake hiking ke gunung', 40000.00, 0.00, 40000.00, 'pending', '2026-01-20 15:17:33', '2026-01-20 15:17:33'),
(4, 'white-shoes', 'Adidas Stan Smith', 'kuning di sole nya', 1, '2026-01-24', 'home', 'Permata Hijau F18, Bekasi', NULL, 35000.00, 5000.00, 40000.00, 'completed', '2026-01-16 10:28:44', '2026-01-18 16:45:29'),
(7, 'fast-cleaning', 'Nike Blazer', 'kena hujan tadi', 1, '2026-01-25', 'home', 'Komp. Griya Asri C8 Ciputat, Tangerang Selatan', 'secepatnya ya bang', 15000.00, 5000.00, 20000.00, 'pending', '2026-01-21 08:15:44', '2026-01-21 08:15:44'),
(5, 'repair', 'Dr. Martens', 'tali nya putus', 1, '2026-01-29', 'pickup', NULL, 'minta ganti tali yg agak tebal', 50000.00, 0.00, 50000.00, 'approved', '2026-01-20 17:23:11', '2026-01-21 09:42:18'),
(2, 'coating', 'Adidas Superstar', 'baru beli', 1, '2026-01-30', 'home', 'Citra Garden 2 Blok B12/8', 'pengen dikasih pelindung biar awet', 25000.00, 5000.00, 30000.00, 'pending', '2026-01-21 11:08:27', '2026-01-21 11:08:27');
