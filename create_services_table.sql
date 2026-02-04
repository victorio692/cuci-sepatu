-- Create services table
CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_code` varchar(100) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `base_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `duration_days` int(11) NOT NULL DEFAULT 1,
  `icon` varchar(50) DEFAULT 'star',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `service_code` (`service_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default services
INSERT INTO `services` (`service_code`, `service_name`, `description`, `base_price`, `duration_days`, `icon`, `is_active`, `created_at`, `updated_at`) VALUES
('fast-cleaning', 'Fast Cleaning', 'Pembersihan cepat untuk sepatu', 15000.00, 1, 'bolt', 1, NOW(), NOW()),
('deep-cleaning', 'Deep Cleaning', 'Pembersihan mendalam hingga bersih', 20000.00, 2, 'droplet', 1, NOW(), NOW()),
('white-shoes', 'White Shoes', 'Khusus sepatu putih yang menguning', 35000.00, 2, 'star', 1, NOW(), NOW()),
('suede-treatment', 'Suede Treatment', 'Perawatan khusus untuk sepatu suede', 30000.00, 3, 'brush', 1, NOW(), NOW()),
('unyellowing', 'Unyellowing', 'Menghilangkan kuning pada sole sepatu', 30000.00, 2, 'sun', 1, NOW(), NOW());
