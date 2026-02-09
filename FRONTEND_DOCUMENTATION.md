# 📱 Frontend SYH Cleaning - Dokumentasi Lengkap

## 🎯 Overview

SYH Cleaning adalah aplikasi web modern untuk layanan cuci sepatu profesional. Frontend dibangun dengan HTML5, CSS3, dan Vanilla JavaScript, terintegrasi dengan backend CodeIgniter 4.

## 📁 Struktur File

```
public/
├── assets/
│   ├── css/
│   │   └── style.css          # Stylesheet utama
│   ├── js/
│   │   └── main.js            # JavaScript utama
│   └── images/                # Folder untuk gambar
│
app/Views/
├── layouts/
│   └── base.php               # Layout dasar
├── auth/
│   ├── login.php              # Halaman login
│   └── register.php           # Halaman register
└── pages/
    ├── home.php               # Halaman utama
    ├── dashboard.php          # Dashboard user
    ├── booking.php            # Halaman pemesanan
    ├── my_bookings.php        # Riwayat pesanan
    ├── profile.php            # Profil user
    ├── about.php              # Tentang kami
    ├── contact.php            # Hubungi kami
    ├── privacy.php            # Kebijakan privasi
    └── terms.php              # Syarat & ketentuan
```

## 🎨 Design System

### Warna Utama
```css
--primary-color: #7c3aed (Purple)
--secondary-color: #ec4899 (Pink)
--success-color: #10b981 (Green)
--danger-color: #ef4444 (Red)
--warning-color: #f59e0b (Orange)
```

### Font
- Font Family: Inter, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto

### Responsive Breakpoints
- Desktop: > 768px
- Tablet: 480px - 768px
- Mobile: < 480px

## 📄 Halaman Utama

### 1. Home Page (/)
Halaman landing page dengan fitur:
- Hero section dengan call-to-action
- Daftar layanan dengan harga
- Sektion "Why Us"
- CTA button untuk booking

### 2. Login Page (/login)
- Form email & password
- Remember me checkbox
- Link forgot password
- Login dengan Google (placeholder)
- Link ke register

### 3. Register Page (/register)
- Form: Nama, Email, No WhatsApp, Password
- Validasi real-time
- Checkbox terms & conditions
- Register dengan Google (placeholder)
- Link ke login

### 4. Dashboard (/dashboard)
- Sidebar navigation
- Statistics cards (total, active, completed)
- Recent bookings table
- Quick action cards

### 5. Make Booking (/make-booking)
- Step 1: Pilih layanan (6 pilihan)
- Step 2: Detail pemesanan
- Step 3: Opsi pengiriman
- Order summary
- Integrasi dengan payment gateway

### 6. My Bookings (/my-bookings)
- Tabel pesanan dengan status
- Filter dan sorting
- Detail booking page

### 7. Profile (/profile)
- Edit informasi pribadi
- Ubah password modal
- Section keamanan
- Aktivitas login

### 8. About (/tentang)
- Informasi perusahaan
- Visi & misi
- Timeline

### 9. Contact (/kontak)
- Informasi kontak
- Jam operasional
- Form contact
- Social media links

### 10. Privacy (/kebijakan)
- Kebijakan privasi lengkap

### 11. Terms (/syarat)
- Syarat & ketentuan lengkap

## 🔧 Komponen Reusable

### Buttons
```html
<!-- Primary Button -->
<button class="btn btn-primary">Pesan Sekarang</button>

<!-- Outline Button -->
<button class="btn btn-outline">Login</button>

<!-- Sizes -->
<button class="btn btn-lg">Large</button>
<button class="btn btn-sm">Small</button>

<!-- Block (Full Width) -->
<button class="btn btn-block">Full Width</button>
```

### Forms
```html
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" class="form-control" required>
</div>
```

### Cards
```html
<div class="card">
    <div class="card-header">Header</div>
    <div class="card-body">Content</div>
    <div class="card-footer">Footer</div>
</div>
```

### Alerts
```html
<div class="alert alert-success">Success message</div>
<div class="alert alert-danger">Error message</div>
<div class="alert alert-warning">Warning message</div>
<div class="alert alert-info">Info message</div>
```

### Badges
```html
<span class="badge badge-primary">Primary</span>
<span class="badge badge-success">Success</span>
<span class="badge badge-danger">Danger</span>
```

## 💻 JavaScript API

### API Helper Functions
```javascript
// GET request
API.get('/endpoint')
    .then(data => console.log(data))
    .catch(error => console.error(error));

// POST request
API.post('/endpoint', { data: 'value' })
    .then(data => console.log(data))
    .catch(error => console.error(error));

// PUT request
API.put('/endpoint', { data: 'value' });

// DELETE request
API.delete('/endpoint');
```

### UI Functions
```javascript
// Toast notification
showToast('Pesan sukses', 'success', 3000);
showToast('Pesan error', 'danger', 3000);

// Modal
openModal('modalId');
closeModal('modalId');

// Validation
validateEmail('email@example.com');
validatePhone('08123456789');
validatePassword('password123');

// Formatting
formatCurrency(15000);        // Rp 15.000
formatDate(new Date());       // 5 Januari 2025
formatDateTime(new Date());   // 5 Januari 2025 14:30
```

## 🔐 Authentication

### Routes Terlindungi
Routes dengan filter `auth` memerlukan login:
```php
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/make-booking', 'Booking::makeBooking');
$routes->get('/profile', 'Dashboard::profile');
```

### Session Management
```php
// Check if logged in
if (auth()->loggedIn()) {
    $user = auth()->user();
}

// Logout
auth()->logout();
```

## 📱 Responsive Design

### Mobile-First Approach
```css
/* Mobile (default) */
.container { padding: 0 1rem; }

/* Tablet (768px) */
@media (max-width: 768px) { }

/* Desktop (480px) */
@media (max-width: 480px) { }
```

### Navbar Mobile Toggle
- Toggle button untuk mobile menu
- Auto-close saat link diklik
- Close saat klik outside

## 🚀 Features

### 1. Service Selection
- 6 tipe layanan dengan harga berbeda
- Visual selection dengan highlight
- Real-time price update

### 2. Booking Form
- Multi-step form
- Validasi real-time
- Order summary otomatis
- Delivery option dengan biaya dinamis

### 3. User Dashboard
- Statistics overview
- Recent bookings
- Quick action links
- Responsive grid layout

### 4. Profile Management
- Edit informasi pribadi
- Ubah password dengan modal
- Address management

### 5. Responsive Navigation
- Sticky navbar
- Mobile hamburger menu
- Active link highlighting
- User menu di navbar

## 🔄 Integration Points

### Backend Controllers Required
1. `Auth::login` - Handle login form
2. `Auth::loginSubmit` - Process login
3. `Auth::register` - Show register page
4. `Auth::registerSubmit` - Process registration
5. `Auth::logout` - Handle logout
6. `Dashboard::index` - Show dashboard
7. `Dashboard::myBookings` - Show bookings
8. `Dashboard::profile` - Show profile
9. `Dashboard::updateProfile` - Update profile
10. `Dashboard::changePassword` - Change password
11. `Booking::makeBooking` - Show booking form
12. `Booking::submitBooking` - Process booking
13. `Pages::about` - Show about page
14. `Pages::contact` - Show contact page
15. `Pages::privacy` - Show privacy policy
16. `Pages::terms` - Show terms

## 🎯 CSS Classes Utility

```css
/* Text Alignment */
.text-center, .text-left, .text-right

/* Margins */
.mt-1, .mt-2, .mt-3, .mt-4, .mt-5
.mb-1, .mb-2, .mb-3, .mb-4, .mb-5

/* Padding */
.p-1, .p-2, .p-3, .p-4

/* Display */
.d-none, .d-block, .d-flex

/* Colors */
.text-primary, .text-secondary, .text-success
.bg-primary, .bg-light, .bg-white

/* Gap (Flexbox) */
.gap-1, .gap-2, .gap-3
```

## 📊 Form Validation

### Client-Side Validation
```javascript
const validation = {
    email: (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email),
    phone: (phone) => /^[\d\s\-\+\(\)]{10,}$/.test(phone),
    password: (pass) => pass.length >= 6,
};
```

### Server-Side Validation (Backend)
Semua validasi juga harus dilakukan di backend untuk keamanan.

## 🎨 Color Palette

| Color | Code | Usage |
|-------|------|-------|
| Purple | #7c3aed | Primary, buttons |
| Pink | #ec4899 | Secondary, accents |
| Green | #10b981 | Success messages |
| Red | #ef4444 | Danger, errors |
| Orange | #f59e0b | Warnings |
| Blue | #3b82f6 | Info |
| Dark | #1f2937 | Text, dark backgrounds |
| Light | #f9fafb | Light backgrounds |

## 🔄 Workflow Contoh

### Booking Workflow
1. User click "Booking Sekarang" di home
2. Redirect ke login jika belum login
3. Pilih service → update summary
4. Isi detail booking
5. Pilih delivery option → update fee
6. Submit form → API call ke `/submit-booking`
7. Redirect ke payment page

### Login Workflow
1. User click login button
2. Isi email & password
3. Submit form ke `/login`
4. Server validate credentials
5. Set session & redirect ke `/dashboard`
6. Navbar update to show user menu

## 📝 Notes

- Semua form menggunakan CSRF token
- API calls menggunakan JSON
- Error handling dengan toast notifications
- Modal untuk confirm actions
- Loading states untuk async operations

## 🚀 Getting Started

1. Pastikan backend controllers sudah dibuat
2. Setup database dengan migrations
3. Test semua routes di browser
4. Customize warna dan branding sesuai kebutuhan
5. Add logo dan images di `public/assets/images/`

---

**Frontend Version**: 1.0.0  
**Last Updated**: 5 Januari 2025  
**Status**: Ready for Production ✅
