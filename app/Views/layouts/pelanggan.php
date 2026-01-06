<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard') ?> - Cuci Sepatu</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        .navbar-pelanggan {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-pelanggan .navbar-brand {
            font-weight: 700;
            color: #fff !important;
        }
        .navbar-pelanggan .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            transition: all 0.3s;
        }
        .navbar-pelanggan .nav-link:hover,
        .navbar-pelanggan .nav-link.active {
            color: #fff !important;
            background: rgba(255,255,255,0.1);
            border-radius: 6px;
        }
        .navbar-pelanggan .dropdown-menu {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 10px;
            font-weight: bold;
        }
        body {
            background: #f8f9fa;
        }
        .content-wrapper {
            min-height: calc(100vh - 76px);
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-pelanggan navbar-dark">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="<?= base_url('pelanggan/dashboard') ?>">
                <i class="bi bi-gem"></i> Cuci Sepatu
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Left Menu -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= url_is('pelanggan/dashboard') ? 'active' : '' ?>" href="<?= base_url('pelanggan/dashboard') ?>">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= url_is('pelanggan/booking*') ? 'active' : '' ?>" href="<?= base_url('pelanggan/booking') ?>">
                            <i class="bi bi-calendar-plus"></i> Booking Cuci Sepatu
                        </a>
                    </li>
                </ul>
                
                <!-- Right Menu -->
                <ul class="navbar-nav">
                    <!-- Notifikasi -->
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-bell fs-5"></i>
                            <?php 
                            // Hitung notifikasi booking yang statusnya berubah (contoh sederhana)
                            $notifCount = 0; // Bisa diambil dari database
                            if ($notifCount > 0): 
                            ?>
                                <span class="notification-badge"><?= $notifCount ?></span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                            <li><h6 class="dropdown-header">Notifikasi</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item small" href="#">Tidak ada notifikasi baru</a></li>
                        </ul>
                    </li>
                    
                    <!-- Profil Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span class="ms-1"><?= esc(session()->get('nama')) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><h6 class="dropdown-header">Halo, <?= esc(session()->get('nama')) ?>!</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('pelanggan/profile') ?>">
                                    <i class="bi bi-person"></i> Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('pelanggan/booking') ?>">
                                    <i class="bi bi-clock-history"></i> Riwayat Booking
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>" onclick="return confirm('Yakin ingin logout?')">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- MAIN CONTENT -->
    <div class="container content-wrapper">
        <!-- Flash Messages -->
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <?= session('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <?= session('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Content Section -->
        <?= $this->renderSection('content') ?>
    </div>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>
