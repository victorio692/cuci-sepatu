# Admin Dashboard - Testing Guide

## User Admin untuk Testing

**Email:** rio@cuciriobabang.com  
**Password:** password123  
**Role:** admin

## URL Admin Dashboard

```
http://localhost:8080/admin
```

## Fitur yang Tersedia

### 1. Dashboard Utama (`/admin`)
- ✅ Statistik: Total Users, Total Pesanan, Pesanan Selesai, Revenue
- ✅ Pesanan Terbaru (5 terakhir)
- ✅ Pesanan Pending dengan tombol Proses
- ✅ Layanan Populer dengan bar chart
- ✅ User Terbaru (5 terakhir)

### 2. Pesanan (`/admin/bookings`)
- ✅ Filter berdasarkan status (pending, selesai, batal)
- ✅ Search berdasarkan nama, email, layanan
- ✅ Update status langsung dari dropdown
- ✅ Lihat detail pesanan
- ✅ Pagination (20 per halaman)

### 3. Detail Pesanan (`/admin/bookings/{id}`)
- ✅ Informasi lengkap pelanggan
- ✅ Detail pesanan (layanan, jumlah, dll)
- ✅ Info pengiriman
- ✅ Ringkasan harga
- ✅ Timeline status
- ✅ Update status dengan dropdown

### 4. Users (`/admin/users`)
- ✅ Search berdasarkan nama, email, telepon
- ✅ Status aktif/non-aktif
- ✅ Lihat detail user
- ✅ Pagination (20 per halaman)

### 5. Detail User (`/admin/users/{id}`)
- ✅ Profil lengkap user
- ✅ Toggle status aktif/non-aktif
- ✅ Riwayat pesanan user
- ✅ Total pesanan user

### 6. Layanan (`/admin/services`)
- ✅ 5 layanan dengan harga:
  - Fast Cleaning - Rp 15.000
  - Deep Cleaning - Rp 20.000
  - White Shoes - Rp 35.000
  - Suede Treatment - Rp 30.000
  - Unyellowing - Rp 30.000
- ✅ Edit harga layanan (modal popup)

## Status Pesanan

Database menggunakan 3 status dalam bahasa Indonesia:
- `pending` - Menunggu persetujuan
- `selesai` - Pesanan selesai
- `batal` - Dibatalkan

View admin juga mendukung status English untuk kompatibilitas:
- `approved` → maps to pending
- `in_progress` → maps to pending
- `completed` → maps to selesai
- `cancelled` → maps to batal

## Database Schema

### Tabel: users
- id, nama_lengkap, email, no_hp, password_hash
- foto_profil, alamat, role (pelanggan/admin/petugas)
- dibuat_pada, diupdate_pada

### Tabel: bookings
- id, id_user, layanan, jumlah, total
- tanggal_booking, jam_booking, foto_sepatu
- alamat_pengiriman, tanggal_pengiriman, catatan
- status (pending/selesai/batal)
- dibuat_pada, diupdate_pada

## API Endpoints untuk Admin

### Update Status Booking
```
PUT /admin/bookings/{id}/status
Body: { "status": "pending|selesai|batal" }
```

### Toggle User Active
```
POST /admin/users/{id}/toggle
Body: {}
```

### Update Service Price
```
POST /admin/services/price
Body: { "service": "fast-cleaning", "price": 15000 }
```

## Testing Checklist

- [ ] Login dengan user admin
- [ ] Dashboard menampilkan statistik dengan benar
- [ ] Filter pesanan berfungsi
- [ ] Update status pesanan berfungsi
- [ ] Search users berfungsi
- [ ] View detail user dan bookings
- [ ] Edit harga layanan
- [ ] Toast notifications muncul saat update
- [ ] Sidebar menu highlight aktif
- [ ] User dropdown menu berfungsi
- [ ] Logout redirect ke login page

## Troubleshooting

### Error: Access Denied
- Pastikan user memiliki `role = 'admin'` di database
- Check session user_id

### Error: Column not found
- Pastikan database menggunakan nama kolom Indonesia
- Check mapping di controller

### Toast tidak muncul
- Check console untuk JavaScript errors
- Pastikan admin.js loaded

### Sidebar tidak highlight
- Check current URL path
- Pastikan href pada menu-item sesuai

## Next Steps

1. Implement petugas dashboard
2. Add role-based middleware yang lebih strict
3. Add photo viewing untuk booking photos
4. Implement payment tracking
5. Add reports dan analytics
6. Add admin settings page
