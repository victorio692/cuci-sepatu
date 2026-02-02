USE cuciriobabang;

CREATE TABLE services (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  service_code varchar(50) NOT NULL,
  service_name varchar(100) NOT NULL,
  description text,
  base_price decimal(10,2) NOT NULL,
  duration_days int(11) DEFAULT 2,
  is_active tinyint(1) NOT NULL DEFAULT 1,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY service_code (service_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE customer_details (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id int(11) UNSIGNED NOT NULL,
  total_orders int(11) DEFAULT 0,
  total_spent decimal(12,2) DEFAULT 0.00,
  member_since date DEFAULT NULL,
  last_order_date datetime DEFAULT NULL,
  loyalty_points int(11) DEFAULT 0,
  notes text,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY (id),
  KEY user_id (user_id),
  CONSTRAINT customer_details_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE payments (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  booking_id int(11) UNSIGNED NOT NULL,
  amount decimal(10,2) NOT NULL,
  payment_method varchar(50) DEFAULT NULL,
  payment_status varchar(30) DEFAULT 'pending',
  paid_at datetime DEFAULT NULL,
  payment_proof varchar(255) DEFAULT NULL,
  notes text,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY (id),
  KEY booking_id (booking_id),
  CONSTRAINT payments_ibfk_1 FOREIGN KEY (booking_id) REFERENCES bookings (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE reports (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  report_date date NOT NULL,
  report_type varchar(30) DEFAULT 'daily',
  total_orders int(11) DEFAULT 0,
  completed_orders int(11) DEFAULT 0,
  cancelled_orders int(11) DEFAULT 0,
  total_revenue decimal(12,2) DEFAULT 0.00,
  total_expenses decimal(12,2) DEFAULT 0.00,
  net_profit decimal(12,2) DEFAULT 0.00,
  notes text,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY report_date_type (report_date, report_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO services (service_code, service_name, description, base_price, duration_days, is_active, created_at, updated_at) VALUES
('fast-cleaning', 'Fast Cleaning', 'buat sepatu yg kotor dikit aja', 15000.00, 1, 1, '2025-11-02 09:15:00', '2025-11-02 09:15:00'),
('deep-cleaning', 'Deep Cleaning', 'cuci dalem2 sampe bersih', 20000.00, 2, 1, '2025-11-02 09:15:00', '2026-01-10 11:20:00'),
('white-shoes', 'White Shoes', 'buat sepatu putih yg udah kuning', 35000.00, 2, 1, '2025-11-02 09:15:00', '2025-11-02 09:15:00'),
('suede-treatment', 'Suede Treatment', 'bersihin sepatu suede biar gak rusak', 30000.00, 2, 1, '2025-11-15 10:30:00', '2025-11-15 10:30:00'),
('unyellowing', 'Unyellowing', 'bikin sole yg kuning jd putih lagi', 30000.00, 2, 1, '2025-12-05 14:30:00', '2025-12-05 14:30:00');

INSERT INTO customer_details (user_id, total_orders, total_spent, member_since, last_order_date, loyalty_points, created_at, updated_at) VALUES
(2, 3, 70000.00, '2025-12-03', '2026-01-21 11:08:27', 70, '2025-12-03 10:15:23', '2026-01-21 11:08:27'),
(3, 2, 100000.00, '2025-12-18', '2026-01-15 09:23:11', 100, '2025-12-18 15:42:09', '2026-01-19 11:23:34'),
(4, 2, 90000.00, '2026-01-02', '2026-01-18 16:52:34', 90, '2026-01-02 13:28:47', '2026-01-20 16:12:03'),
(5, 2, 75000.00, '2026-01-08', '2026-01-20 17:23:11', 75, '2026-01-08 09:17:55', '2026-01-08 09:17:55'),
(6, 1, 40000.00, '2026-01-12', '2026-01-20 15:17:33', 40, '2026-01-12 16:33:22', '2026-01-19 08:54:17'),
(7, 2, 70000.00, '2026-01-15', '2026-01-21 08:15:44', 70, '2026-01-15 11:42:30', '2026-01-15 11:42:30');

INSERT INTO payments (booking_id, amount, payment_method, payment_status, paid_at, created_at, updated_at) VALUES
(3, 20000.00, 'cash', 'paid', '2026-01-19 15:20:00', '2026-01-19 15:20:00', '2026-01-19 15:20:00'),
(5, 30000.00, 'transfer', 'paid', '2026-01-17 14:00:00', '2026-01-17 14:00:00', '2026-01-17 14:00:00'),
(8, 40000.00, 'cash', 'paid', '2026-01-18 16:40:00', '2026-01-18 16:40:00', '2026-01-18 16:40:00'),
(1, 25000.00, 'transfer', 'pending', NULL, '2026-01-20 10:35:00', '2026-01-20 10:35:00'),
(2, 70000.00, 'cash', 'paid', '2026-01-20 09:10:00', '2026-01-20 09:10:00', '2026-01-20 09:10:00'),
(6, 45000.00, 'gopay', 'paid', '2026-01-20 11:25:00', '2026-01-20 11:25:00', '2026-01-20 11:25:00'),
(10, 50000.00, 'ovo', 'pending', NULL, '2026-01-21 09:40:00', '2026-01-21 09:40:00'),
(7, 40000.00, 'cash', 'pending', NULL, '2026-01-20 15:20:00', '2026-01-20 15:20:00'),
(9, 20000.00, 'dana', 'pending', NULL, '2026-01-21 08:20:00', '2026-01-21 08:20:00');

INSERT INTO reports (report_date, report_type, total_orders, completed_orders, cancelled_orders, total_revenue, total_expenses, net_profit, created_at, updated_at) VALUES
('2026-01-15', 'daily', 1, 1, 0, 30000.00, 8000.00, 22000.00, '2026-01-15 23:30:00', '2026-01-15 23:30:00'),
('2026-01-16', 'daily', 1, 1, 0, 40000.00, 11000.00, 29000.00, '2026-01-16 23:30:00', '2026-01-16 23:30:00'),
('2026-01-17', 'daily', 2, 1, 0, 20000.00, 6000.00, 14000.00, '2026-01-17 23:30:00', '2026-01-17 23:30:00'),
('2026-01-18', 'daily', 1, 0, 0, 0.00, 0.00, 0.00, '2026-01-18 23:30:00', '2026-01-18 23:30:00'),
('2026-01-19', 'daily', 2, 0, 0, 0.00, 0.00, 0.00, '2026-01-19 23:30:00', '2026-01-19 23:30:00'),
('2026-01-20', 'daily', 3, 0, 0, 0.00, 0.00, 0.00, '2026-01-20 23:30:00', '2026-01-20 23:30:00'),
('2026-01-21', 'daily', 2, 0, 0, 0.00, 0.00, 0.00, '2026-01-21 11:30:00', '2026-01-21 11:30:00'),
('2025-12-01', 'monthly', 8, 5, 0, 185000.00, 52000.00, 133000.00, '2025-12-31 23:59:00', '2025-12-31 23:59:00'),
('2026-01-01', 'monthly', 11, 3, 0, 90000.00, 25000.00, 65000.00, '2026-01-21 12:00:00', '2026-01-21 12:00:00');
