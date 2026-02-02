# API Documentation - Customer Details

Base URL: `http://localhost:8080/api`

## 📋 Endpoints

### 1. Get Customer Details
**GET** `/api/customer/details`

Ambil detail statistik customer yang sedang login.

**Headers:**
```
Cookie: ci_session=your_session_id
```

**Response Success (200):**
```json
{
    "status": "success",
    "data": {
        "id": 5,
        "user_id": 8,
        "total_orders": 12,
        "total_spent": 350000.00,
        "notes": null,
        "created_at": "2026-01-10 14:30:00",
        "updated_at": "2026-01-25 16:45:00"
    }
}
```

**Response Error (401):**
```json
{
    "status": "error",
    "message": "Unauthorized. Silakan login terlebih dahulu."
}
```

**Response Error (404):**
```json
{
    "status": "error",
    "message": "Customer details tidak ditemukan"
}
```

---

### 2. Update Customer Notes
**PUT** `/api/customer/notes`

Update catatan customer (hanya untuk admin atau customer sendiri).

**Headers:**
```
Cookie: ci_session=your_session_id
Content-Type: application/json
```

**Request Body:**
```json
{
    "notes": "Customer setia, sering order setiap minggu"
}
```

**Response Success (200):**
```json
{
    "status": "success",
    "message": "Notes berhasil diupdate",
    "data": {
        "id": 5,
        "user_id": 8,
        "total_orders": 12,
        "total_spent": 350000.00,
        "notes": "Customer setia, sering order setiap minggu",
        "created_at": "2026-01-10 14:30:00",
        "updated_at": "2026-01-25 16:50:00"
    }
}
```

---

## 📊 Customer Details Structure

Tabel `customer_details` yang sudah disederhanakan memiliki kolom:

| Field | Type | Description |
|-------|------|-------------|
| `id` | INT | Primary key |
| `user_id` | INT | Foreign key ke tabel users |
| `total_orders` | INT | Total jumlah pesanan |
| `total_spent` | DECIMAL(12,2) | Total pengeluaran dalam Rupiah |
| `notes` | TEXT | Catatan internal (optional) |
| `created_at` | DATETIME | Waktu pembuatan record |
| `updated_at` | DATETIME | Waktu update terakhir |

**Kolom yang dihapus:**
- ❌ `member_since` - Tidak perlu, bisa ambil dari `users.created_at`
- ❌ `last_order_date` - Tidak perlu, bisa query dari `bookings`
- ❌ `loyalty_points` - Tidak perlu untuk sistem sederhana

---

## 🔄 Auto Update Mechanism

Customer details akan **otomatis terupdate** saat:

1. **Booking baru dibuat** → `total_orders` +1
2. **Booking selesai** → `total_spent` + amount
3. **Booking dibatalkan** → tidak ada perubahan
4. **Payment confirmed** → trigger update `total_spent`

Mekanisme ini dihandle oleh backend controller atau database trigger.

---

## 🧪 Testing dengan cURL

### Get Customer Details
```bash
curl -X GET http://localhost:8080/api/customer/details \
  -b cookies.txt
```

### Update Notes (Admin only)
```bash
curl -X PUT http://localhost:8080/api/customer/notes \
  -H "Content-Type: application/json" \
  -b cookies.txt \
  -d '{
    "notes": "Customer VIP, prioritas tinggi"
  }'
```

---

## 💡 Usage Example

### Display Customer Stats in Dashboard
```javascript
// Get customer details
const response = await API.get('/customer/details');
const stats = response.data;

// Display
document.getElementById('totalOrders').textContent = stats.total_orders;
document.getElementById('totalSpent').textContent = formatCurrency(stats.total_spent);
```

### Admin View Customer Details
```javascript
// In admin panel - view customer stats
const customerId = 8;
const response = await AdminAPI.get(`/customers/${customerId}/details`);

console.log(`Total Orders: ${response.data.total_orders}`);
console.log(`Total Spent: Rp ${response.data.total_spent.toLocaleString('id-ID')}`);
```

---

## 🔐 Security Notes

1. **Customer endpoint** hanya bisa akses data sendiri
2. **Admin endpoint** bisa akses semua customer details
3. **Notes field** hanya bisa diubah oleh admin
4. **Auto-update** dihandle backend untuk mencegah manipulasi
5. Session-based authentication wajib untuk semua endpoint

---

## 📈 Business Logic

### Calculation Rules:
- `total_orders` = COUNT bookings where user_id = X
- `total_spent` = SUM amount dari bookings yang status = 'selesai'
- Updates terjadi otomatis via backend hooks/triggers
- Customer tidak bisa manual update `total_orders` atau `total_spent`

### Example Trigger:
```sql
-- Contoh trigger untuk auto-update (optional)
DELIMITER //
CREATE TRIGGER update_customer_stats_after_booking
AFTER INSERT ON bookings
FOR EACH ROW
BEGIN
    UPDATE customer_details 
    SET total_orders = total_orders + 1,
        updated_at = NOW()
    WHERE user_id = NEW.user_id;
END//

CREATE TRIGGER update_customer_spent_after_complete
AFTER UPDATE ON bookings
FOR EACH ROW
BEGIN
    IF NEW.status = 'selesai' AND OLD.status != 'selesai' THEN
        UPDATE customer_details 
        SET total_spent = total_spent + NEW.total_harga,
            updated_at = NOW()
        WHERE user_id = NEW.user_id;
    END IF;
END//
DELIMITER ;
```

---

## 🎯 Frontend Integration

### Dashboard Display
```html
<div class="stats-card">
    <h3>Total Pesanan</h3>
    <p class="stat-value" id="totalOrders">0</p>
</div>
<div class="stats-card">
    <h3>Total Pengeluaran</h3>
    <p class="stat-value" id="totalSpent">Rp 0</p>
</div>
```

```javascript
// Load stats on page load
document.addEventListener('DOMContentLoaded', async () => {
    try {
        const response = await API.get('/customer/details');
        const stats = response.data;
        
        document.getElementById('totalOrders').textContent = stats.total_orders;
        document.getElementById('totalSpent').textContent = 
            'Rp ' + stats.total_spent.toLocaleString('id-ID');
    } catch (error) {
        console.error('Failed to load customer stats:', error);
    }
});
```

---

## 📝 Validation Rules

### Update Notes:
- `notes`: optional, max 1000 characters
- Only admin can update notes
- Customer can view but not edit notes

---

## 🧾 Status Codes

- `200 OK` - Request berhasil
- `400 Bad Request` - Validasi gagal
- `401 Unauthorized` - Tidak login
- `403 Forbidden` - Tidak ada permission
- `404 Not Found` - Customer details tidak ditemukan
- `500 Internal Server Error` - Error server

---

## 💬 Why Simplified?

**Alasan penyederhanaan:**

1. **member_since** → Redundant, sudah ada `users.created_at`
2. **last_order_date** → Bisa di-query langsung dari `bookings` table
3. **loyalty_points** → Tidak digunakan, sistem belum implement loyalty program

**Keuntungan:**
- ✅ Database lebih simple dan maintainable
- ✅ Mengurangi redundant data
- ✅ Update lebih cepat (fewer columns)
- ✅ Easier to query dan analyze
- ✅ Lebih sesuai dengan KISS principle (Keep It Simple, Stupid)

Jika nanti butuh loyalty system, tinggal tambahkan kolom `loyalty_points` lagi.
