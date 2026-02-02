USE cuciriobabang;

-- Ubah nama kolom di tabel users
ALTER TABLE users 
  CHANGE COLUMN full_name nama_lengkap VARCHAR(255) NOT NULL,
  CHANGE COLUMN phone no_hp VARCHAR(20) NOT NULL,
  CHANGE COLUMN address alamat TEXT,
  CHANGE COLUMN city kota VARCHAR(100),
  CHANGE COLUMN province provinsi VARCHAR(100),
  CHANGE COLUMN zip_code kode_pos VARCHAR(10),
  CHANGE COLUMN is_active aktif TINYINT(1) NOT NULL DEFAULT 1,
  CHANGE COLUMN is_admin admin TINYINT(1) NOT NULL DEFAULT 0,
  CHANGE COLUMN created_at dibuat_pada DATETIME DEFAULT NULL,
  CHANGE COLUMN updated_at diupdate_pada DATETIME DEFAULT NULL;

-- Ubah nama kolom di tabel bookings
ALTER TABLE bookings
  CHANGE COLUMN user_id id_user INT(11) UNSIGNED NOT NULL,
  CHANGE COLUMN service layanan VARCHAR(100) NOT NULL,
  CHANGE COLUMN shoe_type tipe_sepatu VARCHAR(100) DEFAULT NULL,
  CHANGE COLUMN shoe_condition kondisi_sepatu VARCHAR(100) DEFAULT NULL,
  CHANGE COLUMN quantity jumlah INT(11) NOT NULL DEFAULT 1,
  CHANGE COLUMN delivery_date tanggal_kirim DATE DEFAULT NULL,
  CHANGE COLUMN delivery_option opsi_kirim VARCHAR(50) NOT NULL,
  CHANGE COLUMN delivery_address alamat_kirim TEXT,
  CHANGE COLUMN notes catatan TEXT,
  CHANGE COLUMN delivery_fee biaya_kirim DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  CHANGE COLUMN total total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  CHANGE COLUMN status status VARCHAR(50) NOT NULL DEFAULT 'pending',
  CHANGE COLUMN created_at dibuat_pada DATETIME DEFAULT NULL,
  CHANGE COLUMN updated_at diupdate_pada DATETIME DEFAULT NULL;

-- Drop foreign key lama dan buat yang baru
ALTER TABLE bookings DROP FOREIGN KEY bookings_ibfk_1;
ALTER TABLE bookings ADD CONSTRAINT bookings_ibfk_1 FOREIGN KEY (id_user) REFERENCES users (id) ON DELETE CASCADE;

-- Ubah nama kolom di tabel services
ALTER TABLE services
  CHANGE COLUMN service_code kode_layanan VARCHAR(50) NOT NULL,
  CHANGE COLUMN service_name nama_layanan VARCHAR(100) NOT NULL,
  CHANGE COLUMN description deskripsi TEXT,
  CHANGE COLUMN base_price harga_dasar DECIMAL(10,2) NOT NULL,
  CHANGE COLUMN duration_days durasi_hari INT(11) DEFAULT 2,
  CHANGE COLUMN is_active aktif TINYINT(1) NOT NULL DEFAULT 1,
  CHANGE COLUMN created_at dibuat_pada DATETIME DEFAULT NULL,
  CHANGE COLUMN updated_at diupdate_pada DATETIME DEFAULT NULL;

-- Ubah nama kolom di tabel customer_details
ALTER TABLE customer_details DROP FOREIGN KEY customer_details_ibfk_1;
ALTER TABLE customer_details
  CHANGE COLUMN user_id id_user INT(11) UNSIGNED NOT NULL,
  CHANGE COLUMN total_orders total_pesanan INT(11) DEFAULT 0,
  CHANGE COLUMN total_spent total_belanja DECIMAL(12,2) DEFAULT 0.00,
  CHANGE COLUMN member_since member_sejak DATE DEFAULT NULL,
  CHANGE COLUMN last_order_date pesanan_terakhir DATETIME DEFAULT NULL,
  CHANGE COLUMN loyalty_points poin_loyalitas INT(11) DEFAULT 0,
  CHANGE COLUMN notes catatan TEXT,
  CHANGE COLUMN created_at dibuat_pada DATETIME DEFAULT NULL,
  CHANGE COLUMN updated_at diupdate_pada DATETIME DEFAULT NULL;
ALTER TABLE customer_details ADD CONSTRAINT customer_details_ibfk_1 FOREIGN KEY (id_user) REFERENCES users (id) ON DELETE CASCADE;

-- Ubah nama kolom di tabel payments
ALTER TABLE payments DROP FOREIGN KEY payments_ibfk_1;
ALTER TABLE payments
  CHANGE COLUMN booking_id id_booking INT(11) UNSIGNED NOT NULL,
  CHANGE COLUMN amount jumlah DECIMAL(10,2) NOT NULL,
  CHANGE COLUMN payment_method metode_bayar VARCHAR(50) DEFAULT NULL,
  CHANGE COLUMN payment_status status_bayar VARCHAR(30) DEFAULT 'pending',
  CHANGE COLUMN paid_at dibayar_pada DATETIME DEFAULT NULL,
  CHANGE COLUMN payment_proof bukti_bayar VARCHAR(255) DEFAULT NULL,
  CHANGE COLUMN notes catatan TEXT,
  CHANGE COLUMN created_at dibuat_pada DATETIME DEFAULT NULL,
  CHANGE COLUMN updated_at diupdate_pada DATETIME DEFAULT NULL;
ALTER TABLE payments ADD CONSTRAINT payments_ibfk_1 FOREIGN KEY (id_booking) REFERENCES bookings (id) ON DELETE CASCADE;

-- Ubah nama kolom di tabel reports
ALTER TABLE reports
  CHANGE COLUMN report_date tanggal_laporan DATE NOT NULL,
  CHANGE COLUMN report_type tipe_laporan VARCHAR(30) DEFAULT 'daily',
  CHANGE COLUMN total_orders total_pesanan INT(11) DEFAULT 0,
  CHANGE COLUMN completed_orders pesanan_selesai INT(11) DEFAULT 0,
  CHANGE COLUMN cancelled_orders pesanan_batal INT(11) DEFAULT 0,
  CHANGE COLUMN total_revenue total_pendapatan DECIMAL(12,2) DEFAULT 0.00,
  CHANGE COLUMN total_expenses total_pengeluaran DECIMAL(12,2) DEFAULT 0.00,
  CHANGE COLUMN net_profit laba_bersih DECIMAL(12,2) DEFAULT 0.00,
  CHANGE COLUMN notes catatan TEXT,
  CHANGE COLUMN created_at dibuat_pada DATETIME DEFAULT NULL,
  CHANGE COLUMN updated_at diupdate_pada DATETIME DEFAULT NULL;

DROP INDEX report_date_type ON reports;
ALTER TABLE reports ADD UNIQUE KEY tanggal_laporan_tipe (tanggal_laporan, tipe_laporan);
