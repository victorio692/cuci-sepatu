<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SYH Cleaning' ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?= $this->renderSection('extra_css') ?>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <a href="/" class="navbar-logo">
                    <img src="/assets/images/logo.png" alt="SYH Cleaning" class="logo-img">
                    <span class="logo-text">SYH CLEANING</span>
                </a>
                <button class="navbar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <ul class="navbar-menu">
                    <li><a href="/">Home</a></li>
                    <li><a href="/#services">Layanan</a></li>
                    <li><a href="/tentang">Tentang</a></li>
                    <li><a href="/kontak">Kontak</a></li>
                    <li><a href="/login" class="btn btn-outline">Login</a></li>
                    <li><a href="/register" class="btn btn-primary">Daftar</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>SYH Cleaning</h4>
                    <p>Layanan cuci sepatu terpercaya dengan hasil maksimal dan harga terjangkau.</p>
                    <div style="margin-top: 1rem;">
                        <a href="#" style="margin-right: 1rem;"><i class="fab fa-facebook"></i></a>
                        <a href="#" style="margin-right: 1rem;"><i class="fab fa-instagram"></i></a>
                        <a href="#" style="margin-right: 1rem;"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Layanan</h4>
                    <ul>
                        <li><a href="#services">Fast Cleaning</a></li>
                        <li><a href="#services">Deep Cleaning</a></li>
                        <li><a href="#services">White Shoes</a></li>
                        <li><a href="#services">Coating</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Perusahaan</h4>
                    <ul>
                        <li><a href="/tentang">Tentang Kami</a></li>
                        <li><a href="/kebijakan">Kebijakan Privasi</a></li>
                        <li><a href="/syarat">Syarat & Ketentuan</a></li>
                        <li><a href="/kontak">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Kontak</h4>
                    <ul>
                        <li><a href="tel:+6281234567890"><i class="fas fa-phone"></i> +62 812-3456-7890</a></li>
                        <li><a href="mailto:info@syhcleaning.com"><i class="fas fa-envelope"></i> info@syhcleaning.com</a></li>
                        <li><i class="fas fa-map-marker-alt"></i> Jl. tebak No. 123</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 SYH Cleaning. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="/assets/js/main.js"></script>
    <?= $this->renderSection('extra_js') ?>
</body>
</html>
