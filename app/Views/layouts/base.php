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
    
    <!-- Custom Styles for Cart Badge Animation -->
    <style>
        @keyframes cartBounce {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.3) rotate(-5deg); }
            50% { transform: scale(0.9) rotate(5deg); }
            75% { transform: scale(1.2) rotate(-3deg); }
        }
        
        @keyframes pulse-ring {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }
        
        .cart-badge-animate {
            animation: cartBounce 0.6s ease;
        }
        
        .badge-pulse::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #ef4444;
            animation: pulse-ring 1.5s ease-out infinite;
        }
    </style>
    
    <?= $this->renderSection('extra_css') ?>
</head>
<body class="font-sans antialiased bg-gray-50">
    <?php 
    // Check if current page is dashboard/user area (exclude profile and my-bookings)
    $isDashboard = strpos(current_url(), '/dashboard') !== false 
                || strpos(current_url(), '/make-booking') !== false 
                || strpos(current_url(), '/booking-detail') !== false;
    ?>
    
    <?php if (!$isDashboard): ?>
    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50 transition-shadow duration-300 hover:shadow-2xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-2 sm:space-x-3 group">
                    <img src="/assets/images/SYH.CLEANING.png" alt="SYH Cleaning" class="w-10 h-10 sm:w-12 sm:h-12 transform group-hover:scale-110 transition-transform duration-300">
                    <span class="text-base sm:text-xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors duration-300 whitespace-nowrap">SYH CLEANING</span>
                </a>
                
                <!-- Mobile Right Section (Cart, Notification, Hamburger) -->
                <div class="flex items-center gap-2 md:hidden">
                    <?php if (session()->get('user_id')): ?>
                        <!-- Mobile Cart Icon -->
                        <a href="/cart" class="relative p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transform hover:scale-110 transition-all duration-300">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <span id="mobileNavCartBadge" class="absolute -top-1 -right-1 hidden items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">0</span>
                        </a>
                        
                        <!-- Mobile Notification Bell -->
                        <button onclick="toggleMobileNotifications()" class="relative p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transform hover:scale-110 transition-all duration-300">
                            <i class="fas fa-bell text-xl"></i>
                            <span id="mobileNavNotificationBadge" class="absolute -top-1 -right-1 hidden items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full animate-pulse">0</span>
                        </button>
                    <?php endif; ?>
                    
                    <!-- Hamburger Menu Button -->
                    <button id="mobile-menu-button" class="text-gray-600 hover:text-blue-600 hover:bg-blue-50 p-2 rounded-lg focus:outline-none transition-all duration-300">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
                
                <!-- Desktop Menu -->
                <?php if (session()->get('user_id')): ?>
                    <?php 
                    $db = \Config\Database::connect();
                    $user = $db->table('users')->where('id', session()->get('user_id'))->get()->getRowArray();
                    ?>
                    <?php
                    $currentPath = uri_string();
                    $isHome = ($currentPath == '' || $currentPath == '/');
                    $isTentang = (strpos($currentPath, 'tentang') !== false);
                    $isKontak = (strpos($currentPath, 'kontak') !== false);
                    ?>
                    <!-- Logged In Menu -->
                    <ul class="hidden md:flex items-center space-x-6">
                        <li><a href="/" class="relative <?= $isHome ? 'text-blue-600 font-bold' : 'text-gray-700' ?> hover:text-blue-600 font-medium transition-colors duration-300 group">
                            Home
                            <span class="absolute bottom-0 left-0 <?= $isHome ? 'w-full' : 'w-0' ?> h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a></li>
                        <li class="group"><a href="/#services" class="relative text-gray-700 hover:text-blue-600 font-medium transition-colors duration-300 block">
                            Layanan
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a></li>
                        <li class="group"><a href="/#lokasi" class="relative text-gray-700 hover:text-blue-600 font-medium transition-colors duration-300 block">
                            Lokasi
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a></li>
                        <li><a href="/tentang" class="relative <?= $isTentang ? 'text-blue-600 font-bold' : 'text-gray-700' ?> hover:text-blue-600 font-medium transition-colors duration-300 group">
                            Tentang
                            <span class="absolute bottom-0 left-0 <?= $isTentang ? 'w-full' : 'w-0' ?> h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a></li>
                        <li><a href="/kontak" class="relative <?= $isKontak ? 'text-blue-600 font-bold' : 'text-gray-700' ?> hover:text-blue-600 font-medium transition-colors duration-300 group">
                            Kontak
                            <span class="absolute bottom-0 left-0 <?= $isKontak ? 'w-full' : 'w-0' ?> h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a></li>
                        
                        <!-- Cart Icon -->
                        <li>
                            <a href="/cart" class="relative p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transform hover:scale-110 transition-all duration-300 group">
                                <i class="fas fa-shopping-cart text-xl group-hover:scale-110 transition-transform"></i>
                                <span id="cartBadge" class="absolute -top-1 -right-1 hidden items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">0</span>
                            </a>
                        </li>
                        
                        <!-- Notification Bell -->
                        <li class="relative">
                            <button onclick="toggleLandingNotifications()" class="relative p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transform hover:scale-110 transition-all duration-300 group">
                                <i class="fas fa-bell text-xl group-hover:animate-swing"></i>
                                <span id="landingNotificationBadge" class="absolute top-0 right-0 hidden items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full animate-pulse">0</span>
                            </button>
                            
                            <!-- Notification Dropdown -->
                            <div id="landingNotificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-200 z-50">
                                <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                                    <span class="font-semibold text-gray-800">Notifikasi</span>
                                    <button onclick="markAllNotificationsAsRead()" class="text-xs text-blue-600 hover:text-blue-700 font-medium">Tandai dibaca</button>
                                </div>
                                <div id="landingNotificationList" class="max-h-96 overflow-y-auto">
                                    <div class="p-8 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-2"></i>
                                        <p class="text-sm">Tidak ada notifikasi baru</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        <!-- Profile Dropdown -->
                        <li class="relative">
                            <button onclick="toggleProfileDropdown()" class="flex items-center space-x-2 px-3 py-2 hover:bg-blue-50 rounded-lg transition-all duration-300 group">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold transform group-hover:scale-110 transition-transform duration-300">
                                    <?= strtoupper(substr($user['nama_lengkap'], 0, 1)) ?>
                                </div>
                                <div class="text-left hidden lg:block">
                                    <div class="font-medium text-gray-800 text-sm"><?= substr($user['nama_lengkap'], 0, 15) ?><?= strlen($user['nama_lengkap']) > 15 ? '...' : '' ?></div>
                                </div>
                                <i class="fas fa-chevron-down text-gray-600 text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 z-50 py-2">
                                <a href="/profile" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 group">
                                    <i class="fas fa-user-circle mr-3 group-hover:scale-110 transition-transform"></i>
                                    <span>My Account</span>
                                </a>
                                <div class="border-t border-gray-200 my-2"></div>
                                <a href="#" onclick="showLogoutAnimation(event)" class="flex items-center px-4 py-3 text-red-600 hover:bg-red-50 transition-all duration-300 group">
                                    <i class="fas fa-sign-out-alt mr-3 group-hover:scale-110 transition-transform"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                <?php else: ?>
                    <?php
                    $currentPath = uri_string();
                    $isHome = ($currentPath == '' || $currentPath == '/');
                    $isTentang = (strpos($currentPath, 'tentang') !== false);
                    $isKontak = (strpos($currentPath, 'kontak') !== false);
                    ?>
                    <!-- Guest Menu -->
                    <ul class="hidden md:flex items-center space-x-8">
                        <li><a href="/" class="relative <?= $isHome ? 'text-blue-600 font-bold' : 'text-gray-700' ?> hover:text-blue-600 font-medium transition-colors duration-300 group">
                            Home
                            <span class="absolute bottom-0 left-0 <?= $isHome ? 'w-full' : 'w-0' ?> h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a></li>
                        <li class="group"><a href="/#services" class="relative text-gray-700 hover:text-blue-600 font-medium transition-colors duration-300 block">
                            Layanan
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a></li>
                        <li class="group"><a href="/#lokasi" class="relative text-gray-700 hover:text-blue-600 font-medium transition-colors duration-300 block">
                            Lokasi
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a></li>
                        <li><a href="/tentang" class="relative <?= $isTentang ? 'text-blue-600 font-bold' : 'text-gray-700' ?> hover:text-blue-600 font-medium transition-colors duration-300 group">
                            Tentang
                            <span class="absolute bottom-0 left-0 <?= $isTentang ? 'w-full' : 'w-0' ?> h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a></li>
                        <li><a href="/kontak" class="relative <?= $isKontak ? 'text-blue-600 font-bold' : 'text-gray-700' ?> hover:text-blue-600 font-medium transition-colors duration-300 group">
                            Kontak
                            <span class="absolute bottom-0 left-0 <?= $isKontak ? 'w-full' : 'w-0' ?> h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                        </a></li>
                        <li><a href="/login" class="px-4 py-2 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white hover:shadow-md transform hover:scale-105 transition-all duration-300 font-medium">Login</a></li>
                        <li><a href="/register" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 hover:shadow-xl transform hover:scale-105 hover:-translate-y-1 transition-all duration-300 font-medium">Daftar</a></li>
                    </ul>
                <?php endif; ?>
            </div>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4 px-4">
                <?php if (session()->get('user_id')): ?>
                    <!-- Logged In Mobile Menu -->
                    <ul class="flex flex-col space-y-1">
                        <li><a href="/" class="block py-2.5 px-3 <?= $isHome ? 'text-blue-600 bg-blue-50 font-bold' : 'text-gray-700' ?> hover:text-blue-600 hover:bg-blue-50 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-home mr-2 w-5"></i>Home
                        </a></li>
                        <li><a href="/#services" class="block py-2.5 px-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-concierge-bell mr-2 w-5"></i>Layanan
                        </a></li>
                        <li><a href="/#lokasi" class="block py-2.5 px-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-map-marker-alt mr-2 w-5"></i>Lokasi
                        </a></li>
                        <li><a href="/tentang" class="block py-2.5 px-3 <?= $isTentang ? 'text-blue-600 bg-blue-50 font-bold' : 'text-gray-700' ?> hover:text-blue-600 hover:bg-blue-50 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-info-circle mr-2 w-5"></i>Tentang
                        </a></li>
                        <li><a href="/kontak" class="block py-2.5 px-3 <?= $isKontak ? 'text-blue-600 bg-blue-50 font-bold' : 'text-gray-700' ?> hover:text-blue-600 hover:bg-blue-50 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-envelope mr-2 w-5"></i>Kontak
                        </a></li>
                        <div class="border-t border-gray-200 my-2"></div>
                        <li><a href="/profile" class="block py-2.5 px-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-user-circle mr-2 w-5"></i>My Account
                        </a></li>
                        <li><a href="#" onclick="showLogoutAnimation(event)" class="block py-2.5 px-3 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-sign-out-alt mr-2 w-5"></i>Logout
                        </a></li>
                    </ul>
                <?php else: ?>
                    <!-- Guest Mobile Menu -->
                    <ul class="flex flex-col space-y-1">
                        <li><a href="/" class="block py-2.5 px-3 <?= $isHome ? 'text-blue-600 bg-blue-50 font-bold' : 'text-gray-700' ?> hover:text-blue-600 hover:bg-blue-50 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-home mr-2 w-5"></i>Home
                        </a></li>
                        <li><a href="/#services" class="block py-2.5 px-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-concierge-bell mr-2 w-5"></i>Layanan
                        </a></li>
                        <li><a href="/#lokasi" class="block py-2.5 px-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-map-marker-alt mr-2 w-5"></i>Lokasi
                        </a></li>
                        <li><a href="/tentang" class="block py-2.5 px-3 <?= $isTentang ? 'text-blue-600 bg-blue-50 font-bold' : 'text-gray-700' ?> hover:text-blue-600 hover:bg-blue-50 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-info-circle mr-2 w-5"></i>Tentang
                        </a></li>
                        <li><a href="/kontak" class="block py-2.5 px-3 <?= $isKontak ? 'text-blue-600 bg-blue-50 font-bold' : 'text-gray-700' ?> hover:text-blue-600 hover:bg-blue-50 rounded-lg font-medium transition-all duration-300">
                            <i class="fas fa-envelope mr-2 w-5"></i>Kontak
                        </a></li>
                        <div class="border-t border-gray-200 my-3"></div>
                        <li><a href="/login" class="block py-2.5 px-4 border-2 border-blue-600 text-blue-600 rounded-lg text-center hover:bg-blue-600 hover:text-white hover:shadow-md transition-all duration-300 font-semibold">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a></li>
                        <li><a href="/register" class="block py-2.5 px-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg text-center hover:from-blue-600 hover:to-blue-700 hover:shadow-lg transition-all duration-300 font-semibold">
                            <i class=\"fas fa-user-plus mr-2\"></i>Daftar
                        </a></li>
                    </ul>
                <?php endif; ?>
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
                        <a href="#" class="text-gray-400 hover:text-pink-500 transform hover:scale-125 hover:-translate-y-1 transition-all duration-300"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-green-500 transform hover:scale-125 hover:-translate-y-1 transition-all duration-300"><i class="fab fa-whatsapp text-xl"></i></a>
                    </div>
                </div>
                
                <!-- Services -->
                <div>
                    <h4 class="text-white text-lg font-bold mb-4">Layanan</h4>
                    <ul class="space-y-2">
                        <li><a href="#services" class="text-gray-400 hover:text-white hover:pl-2 transition-all duration-300 inline-block">Fast Cleaning</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white hover:pl-2 transition-all duration-300 inline-block">Deep Cleaning</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white hover:pl-2 transition-all duration-300 inline-block">White Shoes</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white hover:pl-2 transition-all duration-300 inline-block">Suede Treatment</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white hover:pl-2 transition-all duration-300 inline-block">Unyelowing</a></li>
                    </ul>
                </div>
                
                <!-- Information -->
                <div>
                    <h4 class="text-white text-lg font-bold mb-4">Informasi</h4>
                    <ul class="space-y-2">
                        <li><a href="/tentang" class="text-gray-400 hover:text-white hover:pl-2 transition-all duration-300 inline-block">Tentang Kami</a></li>
                        <li><a href="/kebijakan" class="text-gray-400 hover:text-white hover:pl-2 transition-all duration-300 inline-block">Kebijakan Privasi</a></li>
                        <li><a href="/syarat" class="text-gray-400 hover:text-white hover:pl-2 transition-all duration-300 inline-block">Syarat & Ketentuan</a></li>
                        <li><a href="/kontak" class="text-gray-400 hover:text-white hover:pl-2 transition-all duration-300 inline-block">Hubungi Kami</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="text-white text-lg font-bold mb-4">Kontak</h4>
                    <ul class="space-y-3">
                        <li><a href="tel:+6281234567890" class="text-gray-400 hover:text-white hover:pl-2 transition-all duration-300 flex items-center"><i class="fas fa-phone mr-2"></i> 08985709532</a></li>
                        <li><a href="mailto:info@syhhcleaning@gmail.com" class="text-gray-400 hover:text-white hover:pl-2 transition-all duration-300 flex items-center"><i class="fas fa-envelope mr-2"></i> syhhcleaning@gmail.com</a></li>
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

    <!-- Logout Animation Overlay -->
    <div id="logoutOverlay" class="fixed inset-0 bg-gradient-to-br from-blue-600 to-blue-800 hidden items-center justify-center z-[9999]">
        <div class="text-center">
            <!-- Animated Icon -->
            <div class="mb-8 relative">
                <div class="w-32 h-32 mx-auto bg-white rounded-full flex items-center justify-center animate-bounce-slow">
                    <i class="fas fa-sign-out-alt text-6xl text-blue-600 animate-pulse"></i>
                </div>
                <!-- Rotating Circle -->
                <div class="absolute inset-0 border-4 border-white border-t-transparent rounded-full animate-spin-slow"></div>
            </div>
            
            <!-- Text -->
            <h2 class="text-3xl font-bold text-white mb-4 animate-fade-in">Logging Out...</h2>
            <p class="text-blue-100 text-lg animate-fade-in-delay">Terima kasih telah menggunakan layanan kami</p>
            
            <!-- Loading Dots -->
            <div class="flex justify-center space-x-2 mt-8">
                <div class="w-3 h-3 bg-white rounded-full animate-bounce" style="animation-delay: 0s"></div>
                <div class="w-3 h-3 bg-white rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                <div class="w-3 h-3 bg-white rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Toggle Script -->
    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        // Toggle mobile menu
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', (e) => {
                e.stopPropagation();
                mobileMenu.classList.toggle('hidden');
                
                // Close mobile notification dropdown when opening menu
                const mobileNotificationDropdown = document.getElementById('mobileNotificationDropdown');
                if (mobileNotificationDropdown && !mobileNotificationDropdown.classList.contains('hidden')) {
                    mobileNotificationDropdown.classList.add('hidden');
                }
            });
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                const isClickInsideMenu = mobileMenu.contains(e.target);
                const isClickOnButton = mobileMenuButton.contains(e.target);
                
                if (!isClickInsideMenu && !isClickOnButton) {
                    mobileMenu.classList.add('hidden');
                }
            }
        });
        
        // Close mobile menu when clicking any menu link
        if (mobileMenu) {
            const menuLinks = mobileMenu.querySelectorAll('a');
            menuLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                });
            });
        }
        
        // Profile Dropdown Toggle
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            const notifDropdown = document.getElementById('landingNotificationDropdown');
            
            // Close notification dropdown if open
            if (notifDropdown && !notifDropdown.classList.contains('hidden')) {
                notifDropdown.classList.add('hidden');
            }
            
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }
        
        // Notification Dropdown Toggle
        function toggleLandingNotifications() {
            const dropdown = document.getElementById('landingNotificationDropdown');
            const profileDropdown = document.getElementById('profileDropdown');
            
            // Close profile dropdown if open
            if (profileDropdown && !profileDropdown.classList.contains('hidden')) {
                profileDropdown.classList.add('hidden');
            }
            
            if (dropdown) {
                dropdown.classList.toggle('hidden');
                
                // Load notifications when opening dropdown
                if (!dropdown.classList.contains('hidden')) {
                    loadNotifications();
                }
            }
        }
        
        // Mobile Notification Dropdown Toggle
        function toggleMobileNotifications() {
            // Create mobile dropdown if doesn't exist
            let dropdown = document.getElementById('mobileNotificationDropdown');
            if (!dropdown) {
                dropdown = document.createElement('div');
                dropdown.id = 'mobileNotificationDropdown';
                dropdown.className = 'hidden fixed top-16 left-0 right-0 w-full bg-white shadow-2xl border-t border-gray-200 z-50 max-h-96 overflow-y-auto';
                dropdown.innerHTML = `
                    <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between bg-gray-50">
                        <span class="font-semibold text-gray-800">Notifikasi</span>
                        <button onclick="markAllNotificationsAsRead()" class="text-xs text-blue-600 hover:text-blue-700 font-medium">Tandai dibaca</button>
                    </div>
                    <div id="mobileNotificationList">
                        <div class="p-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p class="text-sm">Tidak ada notifikasi baru</p>
                        </div>
                    </div>
                `;
                document.body.appendChild(dropdown);
            }
            
            dropdown.classList.toggle('hidden');
            
            // Load notifications when opening
            if (!dropdown.classList.contains('hidden')) {
                loadNotifications();
            }
        }
        
        // Load notifications via AJAX
        function loadNotifications() {
            fetch('/notifications/getUnread')
                .then(response => response.json())
                .then(data => {
                    const notifList = document.getElementById('landingNotificationList');
                    const mobileNotifList = document.getElementById('mobileNotificationList');
                    const badge = document.getElementById('landingNotificationBadge');
                    const mobileNavBadge = document.getElementById('mobileNavNotificationBadge');
                    
                    if (data.count > 0) {
                        // Update desktop badge
                        if (badge) {
                            badge.classList.remove('hidden');
                            badge.classList.add('flex');
                            badge.textContent = data.count;
                        }
                        
                        // Update mobile nav badge
                        if (mobileNavBadge) {
                            mobileNavBadge.classList.remove('hidden');
                            mobileNavBadge.classList.add('flex');
                            mobileNavBadge.textContent = data.count;
                        }
                        
                        // Build notification HTML
                        let html = '';
                        data.notifications.forEach(notif => {
                            const typeColors = {
                                'success': 'bg-green-50 border-green-200',
                                'info': 'bg-blue-50 border-blue-200',
                                'warning': 'bg-yellow-50 border-yellow-200',
                                'danger': 'bg-red-50 border-red-200'
                            };
                            const bgColor = typeColors[notif.tipe] || 'bg-gray-50 border-gray-200';
                            const isUnread = notif.dibaca == 0 ? 'font-semibold' : '';
                            
                            html += `
                                <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 transition ${bgColor} ${isUnread}" onclick="markAsRead(${notif.id})">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-900">${notif.judul}</p>
                                            <p class="text-xs text-gray-600 mt-1">${notif.pesan}</p>
                                            <p class="text-xs text-gray-400 mt-1">${timeAgo(notif.dibuat_pada)}</p>
                                        </div>
                                        ${notif.dibaca == 0 ? '<div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>' : ''}
                                    </div>
                                </div>
                            `;
                        });
                        
                        if (notifList) notifList.innerHTML = html;
                        if (mobileNotifList) mobileNotifList.innerHTML = html;
                    } else {
                        if (badge) badge.classList.add('hidden');
                        if (mobileNavBadge) mobileNavBadge.classList.add('hidden');
                        
                        const emptyHtml = `
                            <div class="p-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                <p class="text-sm">Tidak ada notifikasi baru</p>
                            </div>
                        `;
                        if (notifList) notifList.innerHTML = emptyHtml;
                        if (mobileNotifList) mobileNotifList.innerHTML = emptyHtml;
                    }
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                });
        }
        
        // Mark notification as read
        function markAsRead(notifId) {
            fetch(`/notifications/markAsRead/${notifId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications();
                }
            });
        }
        
        // Mark all as read
        function markAllNotificationsAsRead() {
            fetch('/notifications/markAllAsRead', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications();
                }
            });
        }
        
        // Time ago helper
        function timeAgo(datetime) {
            const now = new Date();
            const past = new Date(datetime.replace(' ', 'T')); // Convert "YYYY-MM-DD HH:MM:SS" to ISO format
            const diffMs = now - past;
            
            // Handle edge case where time might be in the future (due to clock differences)
            if (diffMs < 0) return 'Baru saja';
            
            const diffMins = Math.floor(diffMs / 60000);
            const diffHours = Math.floor(diffMs / 3600000);
            const diffDays = Math.floor(diffMs / 86400000);
            
            if (diffMins < 1) return 'Baru saja';
            if (diffMins < 60) return `${diffMins} menit yang lalu`;
            if (diffHours < 24) return `${diffHours} jam yang lalu`;
            if (diffDays < 7) return `${diffDays} hari yang lalu`;
            return past.toLocaleDateString('id-ID');
        }
        
        // Load notifications on page load
        <?php if (session()->get('user_id')): ?>
        document.addEventListener('DOMContentLoaded', function() {
            loadNotifications();
            // Refresh every 30 seconds
            setInterval(loadNotifications, 30000);
        });
        <?php endif; ?>
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const profileDropdown = document.getElementById('profileDropdown');
            const notificationDropdown = document.getElementById('landingNotificationDropdown');
            const mobileNotificationDropdown = document.getElementById('mobileNotificationDropdown');
            
            // Check if click is outside profile dropdown
            if (profileDropdown && !profileDropdown.classList.contains('hidden')) {
                const profileButton = event.target.closest('button[onclick=\"toggleProfileDropdown()\"]');
                if (!profileButton && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                }
            }
            
            // Check if click is outside notification dropdown
            if (notificationDropdown && !notificationDropdown.classList.contains('hidden')) {
                const notifButton = event.target.closest('button[onclick=\"toggleLandingNotifications()\"]');
                if (!notifButton && !notificationDropdown.contains(event.target)) {
                    notificationDropdown.classList.add('hidden');
                }
            }
            
            // Check if click is outside mobile notification dropdown
            if (mobileNotificationDropdown && !mobileNotificationDropdown.classList.contains('hidden')) {
                const mobileNotifButton = event.target.closest('button[onclick=\"toggleMobileNotifications()\"]');
                if (!mobileNotifButton && !mobileNotificationDropdown.contains(event.target)) {
                    mobileNotificationDropdown.classList.add('hidden');
                }
            }
        });
        
        // Add swing animation to bell icon
        const style = document.createElement('style');
        style.textContent = `
            @keyframes swing {
                0%, 100% { transform: rotate(0deg); }
                25% { transform: rotate(15deg); }
                75% { transform: rotate(-15deg); }
            }
            .animate-swing {
                animation: swing 0.5s ease-in-out;
            }
            
            /* Logout Animation Styles */
            @keyframes bounce-slow {
                0%, 100% {
                    transform: translateY(0);
                }
                50% {
                    transform: translateY(-20px);
                }
            }
            
            @keyframes spin-slow {
                from {
                    transform: rotate(0deg);
                }
                to {
                    transform: rotate(360deg);
                }
            }
            
            @keyframes fade-in {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .animate-bounce-slow {
                animation: bounce-slow 2s ease-in-out infinite;
            }
            
            .animate-spin-slow {
                animation: spin-slow 2s linear infinite;
            }
            
            .animate-fade-in {
                animation: fade-in 0.8s ease-out forwards;
            }
            
            .animate-fade-in-delay {
                animation: fade-in 0.8s ease-out 0.3s forwards;
                opacity: 0;
            }
        `;
        document.head.appendChild(style);
        
        // Show logout animation
        function showLogoutAnimation(event) {
            event.preventDefault();
            
            const overlay = document.getElementById('logoutOverlay');
            if (overlay) {
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
                
                // Redirect after animation (1.5 seconds)
                setTimeout(function() {
                    window.location.href = '/logout';
                }, 1500);
            }
        }
        
        // Scroll detection for active menu
        document.addEventListener('DOMContentLoaded', function() {
            const sections = {
                services: document.getElementById('services'),
                lokasi: document.getElementById('lokasi')
            };
            
            // Only run on home page
            if (!sections.services) return;
            
            const menuLinks = {
                home: document.querySelectorAll('a[href="/"]'),
                layanan: document.querySelectorAll('a[href="/#services"]'),
                lokasi: document.querySelectorAll('a[href="/#lokasi"]')
            };
            
            function updateActiveMenu() {
                const scrollPos = window.scrollY + 150; // Offset for navbar
                
                // Get section positions
                const servicesTop = sections.services.offsetTop;
                const servicesBottom = servicesTop + sections.services.offsetHeight;
                
                let lokasiTop = 0;
                let lokasiBottom = 0;
                if (sections.lokasi) {
                    lokasiTop = sections.lokasi.offsetTop;
                    lokasiBottom = lokasiTop + sections.lokasi.offsetHeight;
                }
                
                // Determine which section is active
                let activeSection = 'home';
                
                if (scrollPos >= servicesTop && scrollPos < servicesBottom) {
                    activeSection = 'services';
                } else if (sections.lokasi && scrollPos >= lokasiTop && scrollPos < lokasiBottom) {
                    activeSection = 'lokasi';
                }
                
                // Update all menu links
                Object.keys(menuLinks).forEach(key => {
                    const isActive = (key === 'home' && activeSection === 'home') ||
                                   (key === 'layanan' && activeSection === 'services') ||
                                   (key === 'lokasi' && activeSection === 'lokasi');
                    
                    menuLinks[key].forEach(link => {
                        const span = link.querySelector('span');
                        
                        if (isActive) {
                            link.classList.add('text-blue-600', 'font-bold');
                            link.classList.remove('text-gray-700');
                            if (span) span.style.width = '100%';
                        } else {
                            link.classList.remove('text-blue-600', 'font-bold');
                            link.classList.add('text-gray-700');
                            if (span) span.style.width = '0';
                        }
                    });
                });
            }
            
            // Run on scroll with throttle
            let ticking = false;
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    window.requestAnimationFrame(function() {
                        updateActiveMenu();
                        ticking = false;
                    });
                    ticking = true;
                }
            });
            
            // Run on page load
            updateActiveMenu();
        });
        
        // Get cart key for current user
        function getCartKey() {
            <?php if (session()->get('user_id')): ?>
                return 'cart_user_<?= session()->get('user_id') ?>';
            <?php else: ?>
                return 'cart_guest';
            <?php endif; ?>
        }
        
        // Update cart badge on all pages with smooth animation
        function updateCartBadge(animate = false) {
            const cart = JSON.parse(localStorage.getItem(getCartKey()) || '[]');
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            
            // Update desktop cart badge
            const cartBadge = document.getElementById('cartBadge');
            if (cartBadge) {
                const previousValue = parseInt(cartBadge.textContent) || 0;
                
                if (totalItems > 0) {
                    cartBadge.textContent = totalItems;
                    cartBadge.classList.remove('hidden');
                    cartBadge.classList.add('flex');
                    
                    // Add pulse animation on value change
                    if (animate && totalItems !== previousValue) {
                        cartBadge.style.animation = 'none';
                        setTimeout(() => {
                            cartBadge.style.animation = 'cartBounce 0.6s ease';
                        }, 10);
                    }
                } else {
                    cartBadge.classList.add('hidden');
                    cartBadge.classList.remove('flex');
                }
            }
            
            // Update mobile nav cart badge
            const mobileNavCartBadge = document.getElementById('mobileNavCartBadge');
            if (mobileNavCartBadge) {
                const previousValue = parseInt(mobileNavCartBadge.textContent) || 0;
                
                if (totalItems > 0) {
                    mobileNavCartBadge.textContent = totalItems;
                    mobileNavCartBadge.classList.remove('hidden');
                    mobileNavCartBadge.classList.add('flex');
                    
                    // Add pulse animation on value change
                    if (animate && totalItems !== previousValue) {
                        mobileNavCartBadge.style.animation = 'none';
                        setTimeout(() => {
                            mobileNavCartBadge.style.animation = 'cartBounce 0.6s ease';
                        }, 10);
                    }
                } else {
                    mobileNavCartBadge.classList.add('hidden');
                    mobileNavCartBadge.classList.remove('flex');
                }
            }
            
            return totalItems;
        }
        
        // Update cart badge on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartBadge();
        });
    </script>
    
    <script src="/assets/js/main.js"></script>
    <?= $this->renderSection('extra_js') ?>
</body>
</html>
