# API Documentation - Auth

Base URL: `http://localhost:8080/api`

## 📋 Endpoints

### 1. Register
**POST** `/api/auth/register`

Daftarkan user baru ke sistem.

**Request Body:**
```json
{
    "nama_lengkap": "Budi Santoso",
    "email": "budi@gmail.com",
    "no_hp": "081234567890",
    "password": "password123",
    "confirm_password": "password123",
    "alamat": "Jl. Mangga No. 10",
    "kota": "Jakarta Selatan",
    "provinsi": "DKI Jakarta",
    "kode_pos": "12430"
}
```

**Response Success (201):**
```json
{
    "status": "success",
    "message": "Registrasi berhasil",
    "data": {
        "user": {
            "id": 8,
            "nama_lengkap": "Budi Santoso",
            "email": "budi@gmail.com",
            "no_hp": "081234567890",
            "alamat": "Jl. Mangga No. 10",
            "kota": "Jakarta Selatan",
            "provinsi": "DKI Jakarta",
            "kode_pos": "12430",
            "aktif": 1,
            "admin": 0,
            "dibuat_pada": "2026-01-21 10:30:00",
            "diupdate_pada": "2026-01-21 10:30:00"
        },
        "token": "session_id_here"
    }
}
```

**Response Error (400):**
```json
{
    "status": "error",
    "message": "Validasi gagal",
    "errors": {
        "email": "Email sudah terdaftar",
        "password": "Password minimal 6 karakter"
    }
}
```

---

### 2. Login
**POST** `/api/auth/login`

Login ke sistem dengan email dan password.

**Request Body:**
```json
{
    "email": "budi@gmail.com",
    "password": "password123"
}
```

**Response Success (200):**
```json
{
    "status": "success",
    "message": "Login berhasil",
    "data": {
        "user": {
            "id": 8,
            "nama_lengkap": "Budi Santoso",
            "email": "budi@gmail.com",
            "no_hp": "081234567890",
            "alamat": "Jl. Mangga No. 10",
            "kota": "Jakarta Selatan",
            "provinsi": "DKI Jakarta",
            "kode_pos": "12430",
            "aktif": 1,
            "admin": 0,
            "dibuat_pada": "2026-01-21 10:30:00",
            "diupdate_pada": "2026-01-21 10:30:00"
        },
        "token": "session_id_here"
    }
}
```

**Response Error (401):**
```json
{
    "status": "error",
    "message": "Email atau password salah"
}
```

**Response Error (403 - Akun Tidak Aktif):**
```json
{
    "status": "error",
    "message": "Akun Anda tidak aktif. Hubungi admin."
}
```

---

### 3. Logout
**POST** `/api/auth/logout`

Logout dari sistem dan hapus session.

**Response Success (200):**
```json
{
    "status": "success",
    "message": "Logout berhasil"
}
```

---

### 4. Get Profile
**GET** `/api/auth/profile`

Ambil data profile user yang sedang login.

**Headers:**
```
Cookie: ci_session=your_session_id
```

**Response Success (200):**
```json
{
    "status": "success",
    "data": {
        "user": {
            "id": 8,
            "nama_lengkap": "Budi Santoso",
            "email": "budi@gmail.com",
            "no_hp": "081234567890",
            "alamat": "Jl. Mangga No. 10",
            "kota": "Jakarta Selatan",
            "provinsi": "DKI Jakarta",
            "kode_pos": "12430",
            "aktif": 1,
            "admin": 0,
            "dibuat_pada": "2026-01-21 10:30:00",
            "diupdate_pada": "2026-01-21 10:30:00"
        }
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

---

### 5. Update Profile
**PUT** `/api/auth/profile`

Update data profile user.

**Headers:**
```
Cookie: ci_session=your_session_id
Content-Type: application/json
```

**Request Body:**
```json
{
    "nama_lengkap": "Budi Santoso Updated",
    "no_hp": "081234567899",
    "alamat": "Jl. Mangga No. 15",
    "kota": "Jakarta Pusat",
    "provinsi": "DKI Jakarta",
    "kode_pos": "10110"
}
```

**Response Success (200):**
```json
{
    "status": "success",
    "message": "Profile berhasil diupdate",
    "data": {
        "user": {
            "id": 8,
            "nama_lengkap": "Budi Santoso Updated",
            "email": "budi@gmail.com",
            "no_hp": "081234567899",
            "alamat": "Jl. Mangga No. 15",
            "kota": "Jakarta Pusat",
            "provinsi": "DKI Jakarta",
            "kode_pos": "10110",
            "aktif": 1,
            "admin": 0,
            "dibuat_pada": "2026-01-21 10:30:00",
            "diupdate_pada": "2026-01-21 10:45:00"
        }
    }
}
```

---

### 6. Change Password
**POST** `/api/auth/change-password`

Ubah password user.

**Headers:**
```
Cookie: ci_session=your_session_id
```

**Request Body:**
```json
{
    "old_password": "password123",
    "new_password": "newpassword456",
    "confirm_password": "newpassword456"
}
```

**Response Success (200):**
```json
{
    "status": "success",
    "message": "Password berhasil diubah"
}
```

**Response Error (400):**
```json
{
    "status": "error",
    "message": "Password lama tidak sesuai"
}
```

---

## 🧪 Testing dengan cURL

### Register
```bash
curl -X POST http://localhost:8080/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "nama_lengkap": "Test User",
    "email": "testuser@gmail.com",
    "no_hp": "081234567890",
    "password": "password123",
    "confirm_password": "password123",
    "alamat": "Jl. Test",
    "kota": "Jakarta",
    "provinsi": "DKI Jakarta",
    "kode_pos": "12345"
  }'
```

### Login
```bash
curl -X POST http://localhost:8080/api/auth/login \
  -H "Content-Type: application/json" \
  -c cookies.txt \
  -d '{
    "email": "testuser@gmail.com",
    "password": "password123"
  }'
```

### Get Profile (dengan session)
```bash
curl -X GET http://localhost:8080/api/auth/profile \
  -b cookies.txt
```

### Update Profile
```bash
curl -X PUT http://localhost:8080/api/auth/profile \
  -H "Content-Type: application/json" \
  -b cookies.txt \
  -d '{
    "nama_lengkap": "Test User Updated",
    "no_hp": "081999888777",
    "alamat": "Jl. Updated No. 20"
  }'
```

### Change Password
```bash
curl -X POST http://localhost:8080/api/auth/change-password \
  -H "Content-Type: application/json" \
  -b cookies.txt \
  -d '{
    "old_password": "password123",
    "new_password": "newpass456",
    "confirm_password": "newpass456"
  }'
```

### Logout
```bash
curl -X POST http://localhost:8080/api/auth/logout \
  -b cookies.txt
```

---

## 🔐 Authentication

API menggunakan **Session-based authentication** dari CodeIgniter 4.

Setelah login berhasil:
1. Session ID disimpan di cookie `ci_session`
2. Gunakan cookie ini untuk setiap request yang memerlukan autentikasi
3. Simpan cookie dengan flag `-c cookies.txt` dan gunakan dengan `-b cookies.txt`

---

## 📝 Validation Rules

### Register:
- `nama_lengkap`: required, min 3 karakter, max 100 karakter
- `email`: required, valid email, unique (belum terdaftar)
- `no_hp`: required, min 10 digit, max 15 digit
- `password`: required, min 6 karakter
- `confirm_password`: required, harus sama dengan password
- `alamat`, `kota`, `provinsi`, `kode_pos`: optional

### Login:
- `email`: required, valid email
- `password`: required

### Update Profile:
- Semua field optional (permit_empty)
- `nama_lengkap`: min 3, max 100 karakter (jika diisi)
- `no_hp`: min 10, max 15 digit (jika diisi)

### Change Password:
- `old_password`: required
- `new_password`: required, min 6 karakter
- `confirm_password`: required, harus sama dengan new_password

---

## 🧾 Status Codes

- `200 OK` - Request berhasil
- `201 Created` - Resource berhasil dibuat (register)
- `400 Bad Request` - Validasi gagal
- `401 Unauthorized` - Tidak login atau kredensial salah
- `403 Forbidden` - Akun tidak aktif
- `404 Not Found` - Resource tidak ditemukan
- `500 Internal Server Error` - Error server

---

## 💡 Notes

1. Password di-hash dengan **bcrypt** ($2y$10$)
2. Session timeout sesuai config CodeIgniter (default 2 jam)
3. Email otomatis di-lowercase saat register/login
4. Field `aktif` default = 1 (aktif)
5. Field `admin` default = 0 (bukan admin)
6. Timestamp menggunakan format `Y-m-d H:i:s`
7. Password tidak pernah di-return di response (unset dari array)
