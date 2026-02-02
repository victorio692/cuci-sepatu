<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SYH Cleaning' ?></title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Custom Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#2563eb',
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <?= $this->renderSection('extra_css') ?>
</head>
<body class="font-sans antialiased bg-gray-50">
    <?php 
    // Check if current page is dashboard/user area
    $isDashboard = strpos(current_url(), '/dashboard') !== false 
                || strpos(current_url(), '/my-bookings') !== false 
                || strpos(current_url(), '/make-booking') !== false 
                || strpos(current_url(), '/booking-detail') !== false 
                || strpos(current_url(), '/profile') !== false;
    ?>
    
    <?php if (!$isDashboard): ?>
    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-3">
                    <img src="/assets/images/SYH.CLEANING.png" alt="SYH Cleaning" class="w-12 h-12">
                    <span class="text-xl font-bold text-gray-800">SYH CLEANING</span>
                </a>
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden text-gray-600 hover:text-gray-800 focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
                
                <!-- Desktop Menu -->
                <ul class="hidden md:flex items-center space-x-8">
                    <li><a href="/" class="text-gray-700 hover:text-blue-600 font-medium transition">Home</a></li>
                    <li><a href="/#services" class="text-gray-700 hover:text-blue-600 font-medium transition">Layanan</a></li>
                    <li><a href="/tentang" class="text-gray-700 hover:text-blue-600 font-medium transition">Tentang</a></li>
                    <li><a href="/kontak" class="text-gray-700 hover:text-blue-600 font-medium transition">Kontak</a></li>
                    <li><a href="/login" class="px-4 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition font-medium">Login</a></li>
                    <li><a href="/register" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-medium">Daftar</a></li>
                </ul>
            </div>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <ul class="flex flex-col space-y-2">
                    <li><a href="/" class="block py-2 text-gray-700 hover:text-blue-600 font-medium">Home</a></li>
                    <li><a href="/#services" class="block py-2 text-gray-700 hover:text-blue-600 font-medium">Layanan</a></li>
                    <li><a href="/tentang" class="block py-2 text-gray-700 hover:text-blue-600 font-medium">Tentang</a></li>
                    <li><a href="/kontak" class="block py-2 text-gray-700 hover:text-blue-600 font-medium">Kontak</a></li>
                    <li><a href="/login" class="block py-2 px-4 border border-blue-600 text-blue-600 rounded-lg text-center">Login</a></li>
                    <li><a href="/register" class="block py-2 px-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg text-center">Daftar</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <!-- Main Content -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <?php if (!$isDashboard): ?>
    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <h4 class="text-white text-lg font-bold mb-4">SYH Cleaning</h4>
                    <p class="text-gray-400 mb-4">Layanan cuci sepatu terpercaya dengan hasil maksimal dan harga terjangkau.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-blue-500 transition"><i class="fab fa-facebook text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-pink-500 transition"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-green-500 transition"><i class="fab fa-whatsapp text-xl"></i></a>
                    </div>
                </div>
                
                <!-- Services -->
                <div>
                    <h4 class="text-white text-lg font-bold mb-4">Layanan</h4>
                    <ul class="space-y-2">
                        <li><a href="#services" class="text-gray-400 hover:text-white transition">Fast Cleaning</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white transition">Deep Cleaning</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white transition">White Shoes</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white transition">Suede Treatment</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white transition">Unyelowing</a></li>
                    </ul>
                </div>
                
                <!-- Information -->
                <div>
                    <h4 class="text-white text-lg font-bold mb-4">Informasi</h4>
                    <ul class="space-y-2">
                        <li><a href="/tentang" class="text-gray-400 hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="/kebijakan" class="text-gray-400 hover:text-white transition">Kebijakan Privasi</a></li>
                        <li><a href="/syarat" class="text-gray-400 hover:text-white transition">Syarat & Ketentuan</a></li>
                        <li><a href="/kontak" class="text-gray-400 hover:text-white transition">Hubungi Kami</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="text-white text-lg font-bold mb-4">Kontak</h4>
                    <ul class="space-y-3">
                        <li><a href="tel:+6281234567890" class="text-gray-400 hover:text-white transition flex items-center"><i class="fas fa-phone mr-2"></i> 08985709532</a></li>
                        <li><a href="mailto:info@syhcleaning.com" class="text-gray-400 hover:text-white transition flex items-center"><i class="fas fa-envelope mr-2"></i> syhcleaning@gmail.com</a></li>
                        <li class="text-gray-400 flex items-start"><i class="fas fa-map-marker-alt mr-2 mt-1"></i> Desa Paten RT04, Sumberaguung, Jetis, Bantul</li>
                    </ul>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; 2026 SYH Cleaning. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <?php endif; ?>

    <!-- Mobile Menu Toggle Script -->
    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>
    
    <script src="/assets/js/main.js"></script>
    <?= $this->renderSection('extra_js') ?>
</body>
</html>
