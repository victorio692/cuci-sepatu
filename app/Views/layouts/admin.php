<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin - SYH Cleaning' ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?= $this->renderSection('extra_css') ?>
</head>
<body>
    <!-- Admin Navbar -->
    <nav class="admin-navbar">
        <div class="admin-navbar-content">
            <a href="/admin" class="admin-logo">
                <img src="/assets/images/SYH.CLEANING.png" alt="SYH Cleaning" class="logo-img" style="height: 40px;">
                <span>Admin Panel</span>
            </a>
            <div class="admin-navbar-right">
                <div class="admin-search">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Cari pesanan, user...">
                </div>
                <div class="admin-user-menu">
                    <button class="admin-user-btn" onclick="toggleUserMenu()">
                        <div class="admin-user-avatar">A</div>
                        <span>Admin</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="adminUserMenu" class="admin-user-dropdown">
                        <a href="/admin/profile">
                            <i class="fas fa-user-circle"></i> Profil
                        </a>
                        <a href="/admin/settings">
                            <i class="fas fa-cog"></i> Pengaturan
                        </a>
                        <hr style="margin: 0.5rem 0;">
                        <a href="/logout" style="color: #ef4444;">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Admin Container -->
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-sidebar-logo">
                <img src="/assets/images/logo.png" alt="SYH Cleaning" style="height: 40px;">
                <span>SYH Cleaning</span>
            </div>
            
            <ul class="admin-sidebar-menu">
                <li class="menu-section">MAIN</li>
                <li>
                    <a href="/admin" class="menu-item active">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-section">MANAGEMENT</li>
                <li>
                    <a href="/admin/bookings" class="menu-item">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Pesanan</span>
                        <span class="badge" id="bookingBadge">0</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/users" class="menu-item">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/services" class="menu-item">
                        <i class="fas fa-list"></i>
                        <span>Layanan</span>
                    </a>
                </li>

                <li class="menu-section">REPORTS</li>
                <li>
                    <a href="/admin/reports" class="menu-item">
                        <i class="fas fa-file-alt"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/analytics" class="menu-item">
                        <i class="fas fa-chart-bar"></i>
                        <span>Analytics</span>
                    </a>
                </li>

                <li class="menu-section">SETTINGS</li>
                <li>
                    <a href="/admin/settings" class="menu-item">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
                <li>
                    <a href="/admin/profile" class="menu-item">
                        <i class="fas fa-user-circle"></i>
                        <span>Profil</span>
                    </a>
                </li>
            </ul>

            <div class="admin-sidebar-footer">
                <p>SYH Cleaning Admin v1.0</p>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/admin.js"></script>
    <?= $this->renderSection('extra_js') ?>
</body>
</html>
