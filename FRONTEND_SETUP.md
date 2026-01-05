# 🎨 SYH Cleaning - Frontend Setup Guide

## Prerequisites

- PHP 7.4+ dengan CodeIgniter 4.x
- MySQL Database
- Laragon atau Server lokal
- Modern Web Browser

## Installation Steps

### 1. Database Setup

Buat table untuk users dan bookings:

```sql
-- Users Table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    address TEXT,
    city VARCHAR(100),
    province VARCHAR(100),
    zip_code VARCHAR(10),
    avatar VARCHAR(255),
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bookings Table
CREATE TABLE bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    service VARCHAR(100) NOT NULL,
    shoe_type VARCHAR(50),
    shoe_condition VARCHAR(50),
    quantity INT DEFAULT 1,
    delivery_date DATE NOT NULL,
    delivery_option VARCHAR(20),
    delivery_address TEXT,
    notes TEXT,
    subtotal DECIMAL(10, 2),
    delivery_fee DECIMAL(10, 2) DEFAULT 0,
    total DECIMAL(10, 2) NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create indexes
CREATE INDEX idx_user_id ON bookings(user_id);
CREATE INDEX idx_status ON bookings(status);
CREATE INDEX idx_delivery_date ON bookings(delivery_date);
```

### 2. File Structure Verification

Pastikan struktur file sudah tersedia:

```
app/
├── Controllers/
│   ├── Auth.php
│   ├── Dashboard.php
│   ├── Booking.php
│   ├── Pages.php
│   └── Home.php
├── Views/
│   ├── layouts/
│   │   └── base.php
│   ├── auth/
│   │   ├── login.php
│   │   └── register.php
│   └── pages/
│       ├── home.php
│       ├── dashboard.php
│       ├── booking.php
│       ├── my_bookings.php
│       ├── profile.php
│       ├── about.php
│       ├── contact.php
│       ├── privacy.php
│       └── terms.php
├── Helpers/
│   └── FrontendHelper.php
└── Config/
    └── Routes.php (updated)

public/
└── assets/
    ├── css/
    │   └── style.css
    ├── js/
    │   └── main.js
    └── images/
```

### 3. Configuration

Load helper di `app/Config/Autoload.php`:

```php
public $helpers = ['FrontendHelper'];
```

### 4. Routes

Pastikan routes sudah dikonfigurasi di `app/Config/Routes.php`

### 5. Environment Setup

Update `.env` file dengan database configuration:

```env
database.default.hostname = localhost
database.default.database = cuci_sepatu
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

### 6. Run Application

```bash
# Di folder project
php spark serve

# Akses di browser
http://localhost:8080
```

## Features Overview

### 🏠 Public Pages
- `/` - Home/Landing Page
- `/login` - Login Page
- `/register` - Register Page
- `/tentang` - About Page
- `/kontak` - Contact Page
- `/kebijakan` - Privacy Policy
- `/syarat` - Terms & Conditions

### 👥 Protected Pages (Require Login)
- `/dashboard` - User Dashboard
- `/my-bookings` - My Bookings
- `/make-booking` - Make New Booking
- `/booking-detail/:id` - Booking Details
- `/profile` - Profile Settings

## 🎯 Workflow

### Registration Workflow
1. User klik "Daftar" di navbar
2. Fill form dengan data pribadi
3. Submit → Validasi di server
4. Redirect ke login dengan success message
5. User login dengan email & password

### Booking Workflow
1. User klik "Pesan Sekarang" di home
2. Jika belum login → redirect ke login
3. Pilih service dari 6 pilihan
4. Fill detail booking (shoe type, quantity, date)
5. Pilih delivery option (pickup/home)
6. Review order summary
7. Submit booking → create record di database
8. Redirect ke payment page

### Dashboard Workflow
1. User login
2. Redirect ke dashboard
3. Lihat statistik bookings
4. Manage bookings dan profile
5. Logout

## 🔒 Security Features

### Authentication
- Password hashing dengan PHP password_hash()
- CSRF token pada semua form
- Session-based authentication

### Input Validation
- Client-side validation dengan JavaScript
- Server-side validation di Controllers
- SQL injection prevention dengan query builder

### Authorization
- Auth filter untuk protected routes
- User ownership verification pada update/delete

## 📱 Responsive Design

### Breakpoints
- **Mobile**: < 480px
- **Tablet**: 480px - 768px
- **Desktop**: > 768px

### Mobile Features
- Hamburger menu toggle
- Touch-friendly buttons
- Optimized form inputs
- Responsive grid layouts

## 🎨 Customization

### Branding
1. Update colors di `style.css` CSS variables:
```css
:root {
    --primary-color: #7c3aed;
    --secondary-color: #ec4899;
    /* ... */
}
```

2. Update navbar branding di `layouts/base.php`:
```html
<a href="/" class="navbar-logo">
    <i class="fas fa-shoe-prints"></i>
    SYH CLEANING
</a>
```

3. Add logo di `public/assets/images/`

### Service Configuration
Update service list di:
- `pages/home.php` - Services section
- `pages/booking.php` - Booking form
- `Controllers/Booking.php` - Service prices

## 🚀 Performance Tips

1. **Optimize Images**: Compress images sebelum upload
2. **Caching**: Enable browser caching di .htaccess
3. **Minify**: Minify CSS dan JS di production
4. **Database**: Create indexes untuk frequently queried columns
5. **API**: Use pagination untuk large datasets

## 🐛 Troubleshooting

### Issue: Routes not working
**Solution**: Clear cache dengan `php spark cache:clear`

### Issue: CSS/JS tidak load
**Solution**: Clear browser cache atau hard refresh (Ctrl+Shift+R)

### Issue: Database connection error
**Solution**: Check `.env` database configuration

### Issue: CSRF token error
**Solution**: Ensure `csrf_field()` di semua form

## 📚 Additional Resources

- [CodeIgniter 4 Documentation](https://codeigniter.com/user_guide/)
- [Bootstrap CSS Framework](https://getbootstrap.com/)
- [Font Awesome Icons](https://fontawesome.com/)
- [MDN Web Docs](https://developer.mozilla.org/)

## 🤝 Support

Untuk bantuan tambahan:
- Email: `info@syhcleaning.com`
- Phone: `+62 812-3456-7890`

---

**Last Updated**: 5 Januari 2025  
**Version**: 1.0.0
