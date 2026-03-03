# 📋 Dokumentasi Tabel Services

## 📊 Struktur Tabel

**Nama Tabel:** `services`  
**Database:** `cuciriobabang`  
**Engine:** InnoDB  
**Charset:** utf8mb4_general_ci

## 🏗️ Kolom-Kolom

| Kolom | Tipe Data | Null | Default | Keterangan |
|-------|-----------|------|---------|------------|
| `id` | INT(11) | NO | AUTO_INCREMENT | Primary key, ID unik layanan |
| `kode_layanan` | VARCHAR(100) | NO | - | Kode unik layanan (fast-cleaning, dll) |
| `nama_layanan` | VARCHAR(255) | NO | - | Nama layanan yang ditampilkan |
| `deskripsi` | TEXT | YES | NULL | Deskripsi detail layanan |
| `harga_dasar` | DECIMAL(10,2) | NO | 0.00 | Harga dasar dalam Rupiah |
| `durasi_hari` | INT(11) | NO | 1 | Estimasi durasi pengerjaan (hari) |
| `icon_path` | VARCHAR(255) | YES | NULL | Path file icon/gambar |
| `aktif` | TINYINT(1) | NO | 1 | Status: 1=Aktif, 0=Nonaktif |
| `dibuat_pada` | DATETIME | NO | CURRENT_TIMESTAMP | Tanggal dibuat |
| `diupdate_pada` | DATETIME | NO | CURRENT_TIMESTAMP | Tanggal update terakhir |

## 🔑 Index dan Keys

- **PRIMARY KEY:** `id`
- **UNIQUE KEY:** `kode_layanan`
- **INDEX:** `aktif`

## 📝 Cara Instalasi

### Opsi 1: Tabel Baru (Kosong)
```sql
-- Jalankan query di phpMyAdmin atau MySQL client
SOURCE services_table_structure.sql;
```

### Opsi 2: Menambahkan Kolom icon_path Saja
```sql
ALTER TABLE services 
ADD COLUMN icon_path VARCHAR(255) NULL 
AFTER durasi_hari;
```

### Opsi 3: Via phpMyAdmin GUI
1. Buka **phpMyAdmin**: http://localhost/phpmyadmin
2. Pilih database: **cuciriobabang**
3. Klik tab **SQL**
4. Copy-paste isi file `services_table_structure.sql`
5. Klik **Go**

## 📦 Data Sample

File SQL sudah include 5 layanan default:

1. **Fast Cleaning** - Rp 15.000 (1 hari)
2. **Deep Cleaning** - Rp 25.000 (3 hari)
3. **White Shoes Treatment** - Rp 20.000 (2 hari)
4. **Suede Treatment** - Rp 30.000 (3 hari)
5. **Unyellowing** - Rp 35.000 (4 hari)

## 🖼️ Upload Icon/Gambar

### Lokasi Penyimpanan
- **Folder:** `public/uploads/services/`
- **Format:** JPG, PNG, GIF
- **Ukuran Max:** 2MB
- **Recommended Size:** 200x200px

### Format Path di Database
```
uploads/services/service_{id}_{timestamp}.jpg
```

Contoh:
```
uploads/services/service_1_1709510400.png
```

### API Endpoint untuk Upload
```
POST /api/admin/services/{id}/upload-icon
Content-Type: multipart/form-data
Body: icon_image=[FILE]
```

## 🔍 Query Berguna

### Lihat Semua Layanan
```sql
SELECT * FROM services ORDER BY id;
```

### Lihat Hanya Layanan Aktif
```sql
SELECT * FROM services WHERE aktif = 1;
```

### Cek Layanan dengan Icon
```sql
SELECT id, nama_layanan, icon_path 
FROM services 
WHERE icon_path IS NOT NULL;
```

### Update Harga Layanan
```sql
UPDATE services 
SET harga_dasar = 18000 
WHERE kode_layanan = 'fast-cleaning';
```

### Nonaktifkan Layanan
```sql
UPDATE services 
SET aktif = 0 
WHERE kode_layanan = 'unyellowing';
```

## 🚀 Integrasi dengan Aplikasi

### Controller
File: `app/Controllers/Admin/Services.php`
```php
$services = $this->db->table('services')
    ->where('aktif', 1)
    ->orderBy('id', 'ASC')
    ->get()
    ->getResultArray();
```

### API
File: `app/Controllers/Api/AdminServicesApi.php`
- `GET /api/admin/services` - List all
- `GET /api/admin/services/{id}` - Detail
- `POST /api/admin/services` - Create
- `PUT /api/admin/services/{id}` - Update
- `DELETE /api/admin/services/{id}` - Delete
- `POST /api/admin/services/{id}/upload-icon` - Upload icon

### View
File: `app/Views/admin/services.php`
```php
<?php foreach ($services as $service): ?>
    <p><?= $service['nama_layanan'] ?></p>
    <p>Rp <?= number_format($service['harga_dasar']) ?></p>
    <p><?= $service['durasi_hari'] ?> hari</p>
<?php endforeach; ?>
```

## ⚠️ Catatan Penting

1. **Backup Database** sebelum menjalankan query ALTER atau DROP
2. Kolom `kode_layanan` harus **unik** (tidak boleh duplikat)
3. Folder `public/uploads/services/` harus ada dan **writable** (chmod 755)
4. Gunakan **ON DUPLICATE KEY UPDATE** untuk insert/update safe
5. Icon yang diupload tidak auto-delete jika layanan dihapus (manual cleanup diperlukan)

## 🆘 Troubleshooting

### Error: "Unknown column 'icon_path'"
**Solusi:** Jalankan ALTER TABLE untuk menambahkan kolom:
```sql
ALTER TABLE services ADD COLUMN icon_path VARCHAR(255) NULL AFTER durasi_hari;
```

### Error: "Duplicate entry for key 'kode_layanan'"
**Solusi:** Gunakan kode layanan yang berbeda atau UPDATE data existing

### Upload gagal "Permission denied"
**Solusi:** Set permission folder:
```bash
chmod -R 755 public/uploads/services/
```

### Icon tidak muncul di frontend
**Solusi:** Pastikan path menggunakan `base_url()`:
```php
<img src="<?= base_url($service['icon_path']) ?>">
```

## 📞 Support

Jika ada masalah atau pertanyaan:
1. Cek log aplikasi: `writable/logs/`
2. Cek console browser (F12)
3. Verify struktur tabel: `SHOW COLUMNS FROM services;`
