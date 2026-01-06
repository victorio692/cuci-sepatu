<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin Dashboard') ?> - Cuci Sepatu</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        /* Sidebar Styling */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: #fff;
            font-weight: 600;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .navbar-admin {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- SIDEBAR -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar p-0">
                <div class="position-sticky pt-4">
                    <!-- Logo/Brand -->
                    <div class="text-center mb-4">
                        <h4 class="text-white fw-bold">
                            <i class="bi bi-gem"></i> Cuci Sepatu
                        </h4>
                        <p class="text-white-50 small">Admin Panel</p>
                    </div>
                    
                    <!-- User Info -->
                    <div class="px-3 mb-4">
                        <div class="bg-white bg-opacity-10 rounded p-3 text-white">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person-circle fs-4"></i>
                                </div>
                                <div class="ms-2">
                                    <div class="fw-bold"><?= esc(session()->get('nama')) ?></div>
                                    <small class="text-white-50">Administrator</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Menu -->
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('admin/dashboard') ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('admin/services*') ? 'active' : '' ?>" href="<?= base_url('admin/services') ?>">
                                <i class="bi bi-box-seam"></i> Kelola Layanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('admin/bookings*') ? 'active' : '' ?>" href="<?= base_url('admin/bookings') ?>">
                                <i class="bi bi-calendar-check"></i> Kelola Booking
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('admin/users*') ? 'active' : '' ?>" href="<?= base_url('admin/users') ?>">
                                <i class="bi bi-people"></i> Kelola Pelanggan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/reports') ?>">
                                <i class="bi bi-bar-chart"></i> Laporan
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <a class="nav-link" href="<?= base_url('logout') ?>" onclick="return confirm('Yakin ingin logout?')">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <!-- MAIN CONTENT -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg navbar-admin py-3 mb-4">
                    <div class="container-fluid">
                        <h5 class="mb-0"><?= esc($title ?? 'Dashboard') ?></h5>
                        <div class="d-flex align-items-center">
                            <span class="text-muted small me-3">
                                <i class="bi bi-clock"></i> <?= date('d M Y, H:i') ?>
                            </span>
                        </div>
                    </div>
                </nav>
                
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
                <div class="content-wrapper">
                    <?= $this->renderSection('content') ?>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>
