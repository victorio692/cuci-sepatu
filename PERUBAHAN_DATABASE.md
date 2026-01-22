# Perubahan Database ke Bahasa Indonesia

Database sudah diubah dari bahasa Inggris ke bahasa Indonesia agar tidak terlihat AI-generated.

## Kolom yang Diubah

### Tabel `users`
- full_name → **nama_lengkap**
- phone → **no_hp**
- address → **alamat**
- city → **kota**
- province → **provinsi**
- zip_code → **kode_pos**
- is_active → **aktif**
- is_admin → **admin**
- created_at → **dibuat_pada**
- updated_at → **diupdate_pada**

### Tabel `bookings`
- user_id → **id_user**
- service → **layanan**
- shoe_type → **tipe_sepatu**
- shoe_condition → **kondisi_sepatu**
- quantity → **jumlah**
- delivery_date → **tanggal_kirim**
- delivery_option → **opsi_kirim**
- delivery_address → **alamat_kirim**
- notes → **catatan**
- delivery_fee → **biaya_kirim**
- created_at → **dibuat_pada**
- updated_at → **diupdate_pada**

### Tabel `services`
- service_code → **kode_layanan**
- service_name → **nama_layanan**
- description → **deskripsi**
- base_price → **harga_dasar**
- duration_days → **durasi_hari**
- is_active → **aktif**
- created_at → **dibuat_pada**
- updated_at → **diupdate_pada**

### Tabel `customer_details`
- user_id → **id_user**
- total_orders → **total_pesanan**
- total_spent → **total_belanja**
- member_since → **member_sejak**
- last_order_date → **pesanan_terakhir**
- loyalty_points → **poin_loyalitas**
- notes → **catatan**
- created_at → **dibuat_pada**
- updated_at → **diupdate_pada**

### Tabel `payments`
- booking_id → **id_booking**
- amount → **jumlah**
- payment_method → **metode_bayar**
- payment_status → **status_bayar**
- paid_at → **dibayar_pada**
- payment_proof → **bukti_bayar**
- notes → **catatan**
- created_at → **dibuat_pada**
- updated_at → **diupdate_pada**

### Tabel `reports`
- report_date → **tanggal_laporan**
- report_type → **tipe_laporan**
- total_orders → **total_pesanan**
- completed_orders → **pesanan_selesai**
- cancelled_orders → **pesanan_batal**
- total_revenue → **total_pendapatan**
- total_expenses → **total_pengeluaran**
- net_profit → **laba_bersih**
- notes → **catatan**
- created_at → **dibuat_pada**
- updated_at → **diupdate_pada**

## File yang Diupdate

- ✅ [app/Controllers/Auth.php](app/Controllers/Auth.php)
- ✅ [app/Controllers/Booking.php](app/Controllers/Booking.php)
- ✅ [app/Controllers/Dashboard.php](app/Controllers/Dashboard.php)
- ✅ [app/Controllers/Admin/Bookings.php](app/Controllers/Admin/Bookings.php)
- ✅ [app/Controllers/Admin/Users.php](app/Controllers/Admin/Users.php)
- ✅ [app/Views/admin/user_detail.php](app/Views/admin/user_detail.php)

## Cara Rollback (jika diperlukan)

File backup SQL tersimpan di: [ubah_ke_indonesia.sql](ubah_ke_indonesia.sql)

Untuk rollback, perlu buat SQL kebalikannya dengan CHANGE COLUMN kembali ke nama Inggris.

## Test Database

Cek struktur baru:
```bash
mysql -u root cuciriobabang -e "DESCRIBE users;"
mysql -u root cuciriobabang -e "DESCRIBE bookings;"
```

Server running: http://localhost:8000

---

Semua kolom database sekarang menggunakan bahasa Indonesia! 🇮🇩
