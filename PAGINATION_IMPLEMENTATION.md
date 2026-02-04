# Pagination Implementation - Admin Dashboard

## 📋 Overview
Pagination telah ditambahkan untuk halaman admin dengan 10 data per halaman untuk meningkatkan performa dan user experience.

## ✅ Halaman yang Mendapat Pagination

### 1. Admin Bookings (`/admin/bookings`)
**File yang diubah:**
- `app/Controllers/Admin/Bookings.php`
- `app/Views/admin/bookings.php`

**Fitur:**
- ✅ 10 pesanan per halaman
- ✅ Filter status tetap berfungsi (pending, proses, selesai, batal)
- ✅ Search tetap berfungsi (nama, email, layanan)
- ✅ Menampilkan total pesanan
- ✅ Menampilkan range data (contoh: "Menampilkan 1 - 10")

### 2. Admin Users (`/admin/users`)
**File yang diubah:**
- `app/Controllers/Admin/Users.php`
- `app/Views/admin/users.php`

**Fitur:**
- ✅ 10 pengguna per halaman
- ✅ Search tetap berfungsi (nama, email, no HP)
- ✅ Menampilkan total pengguna
- ✅ Menampilkan range data

## 🎨 Desain Pagination

### Komponen UI:
```
[<] [1] ... [4] [5] [6] ... [10] [>]
    ^           ^active^           ^
Previous    Current Page       Next
```

### Fitur:
1. **Previous/Next Buttons**
   - Disabled saat di halaman pertama/terakhir
   - Icon arrow untuk navigasi

2. **Nomor Halaman**
   - Maksimal 5 nomor ditampilkan
   - Current page highlight dengan warna biru
   - Ellipsis (...) untuk halaman yang disembunyikan

3. **Info Display**
   - "Halaman X dari Y"
   - "Total: N data"
   - "Menampilkan X - Y"

## 🔧 Implementasi Teknis

### Controller Logic:
```php
$page = $this->request->getVar('page') ?? 1;
$perPage = 10;

// Get total count
$totalItems = $builder->countAllResults(false);

// Get paginated results
$items = $builder
    ->limit($perPage, ($page - 1) * $perPage)
    ->get()
    ->getResultArray();

// Calculate pagination
$totalPages = ceil($totalItems / $perPage);
```

### Data Structure:
```php
'pager' => [
    'currentPage' => (int)$page,
    'perPage' => $perPage,
    'total' => $totalItems,
    'totalPages' => $totalPages,
]
```

## 🎯 URL Parameters

### Bookings:
- `?page=2` - Halaman 2
- `?page=2&status=pending` - Halaman 2 dengan filter pending
- `?page=2&search=john` - Halaman 2 dengan search

### Users:
- `?page=2` - Halaman 2
- `?page=2&search=admin` - Halaman 2 dengan search

## 📱 Responsive Design

Pagination responsive untuk semua ukuran layar:
- **Desktop**: Full pagination dengan 5 nomor halaman
- **Tablet**: 3-5 nomor halaman
- **Mobile**: Previous/Next dengan current page info

## 🚀 Testing

### Test Case 1: Bookings Pagination
1. Buka `/admin/bookings`
2. Pastikan hanya 10 data muncul
3. Klik halaman 2
4. Test dengan filter status
5. Test dengan search

### Test Case 2: Users Pagination
1. Buka `/admin/users`
2. Pastikan hanya 10 data muncul
3. Klik halaman 2
4. Test dengan search

### Test Case 3: Filter + Pagination
1. Filter status = "pending"
2. Navigasi ke halaman 2
3. Filter harus tetap aktif

### Test Case 4: Search + Pagination
1. Search "admin"
2. Navigasi ke halaman 2
3. Search harus tetap aktif

## 💡 Tips Penggunaan

1. **Navigasi Cepat**:
   - Klik nomor halaman untuk jump langsung
   - Previous/Next untuk navigasi berurutan

2. **Kombinasi Filter**:
   - Filter + Search + Pagination bekerja bersamaan
   - URL parameters preserved saat navigasi

3. **Data Range**:
   - Lihat "Menampilkan X - Y" untuk tahu posisi data
   - "Total: N" untuk tahu total keseluruhan

## 🔄 Future Enhancement

Fitur yang bisa ditambahkan:
- [ ] Pilihan perPage (10, 25, 50, 100)
- [ ] Jump to page input field
- [ ] Keyboard navigation (arrow keys)
- [ ] Remember last page per session
- [ ] Export all data (bypass pagination)

## 📊 Performance

### Before Pagination:
- Load all data sekaligus (bisa ratusan/ribuan)
- Slow page load
- High memory usage

### After Pagination:
- ✅ Load 10 data saja
- ✅ Fast page load
- ✅ Low memory usage
- ✅ Better database performance

## 🐛 Troubleshooting

### Pagination tidak muncul?
- Pastikan data lebih dari 10
- Cek console browser untuk error
- Cek `$pager` data di controller

### Page tidak ganti?
- Cek URL parameter `?page=X`
- Pastikan form search/filter pakai GET method
- Clear browser cache

### Filter/Search hilang saat paging?
- Pastikan parameter di-preserve di pagination links
- Cek query string di URL

## 📝 Code Example

### Cara Menambah Pagination ke Halaman Lain:

**Controller:**
```php
public function index()
{
    $page = $this->request->getVar('page') ?? 1;
    $perPage = 10;

    $builder = $this->db->table('table_name');
    
    // Get total
    $total = $builder->countAllResults(false);
    
    // Get data
    $items = $builder
        ->limit($perPage, ($page - 1) * $perPage)
        ->get()
        ->getResultArray();
    
    $data = [
        'items' => $items,
        'pager' => [
            'currentPage' => (int)$page,
            'perPage' => $perPage,
            'total' => $total,
            'totalPages' => ceil($total / $perPage),
        ],
    ];
    
    return view('view_name', $data);
}
```

**View:**
Copy komponen pagination dari `bookings.php` atau `users.php`

---

**Status**: ✅ SELESAI
**Version**: 1.0
**Date**: 03 Februari 2026
