<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title><?= $title ?? 'Admin - SYH Cleaning' ?></title>
    
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
    
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Smooth transitions */
        * { transition: all 0.2s ease; }
        
        /* Notification dropdown animation */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .notification-dropdown { animation: slideDown 0.2s ease; }
        
        /* Bell swing animation */
        @keyframes swing {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(15deg); }
            75% { transform: rotate(-15deg); }
        }
        .animate-swing { animation: swing 0.5s ease-in-out; }
        
        /* Sidebar menu hover shine effect */
        @keyframes shine {
            0% { left: -100%; }
            100% { left: 100%; }
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

        /* MOBILE RESPONSIVE IMPROVEMENTS */
        
        /* Prevent pinch zoom on mobile inputs */
        input, select, textarea, button {
            font-size: 16px !important;
        }
        
        /* Ensure touch targets are at least 44px */
        button, a, .btn, .clickable {
            min-height: 44px;
            min-width: 44px;
        }
        
        /* Responsive margins for main container */
        main {
            max-width: 100%;
        }

        /* Mobile-specific sidebar improvements */
        @media (max-width: 1024px) {
            #sidebar {
                width: 100%;
                max-width: 280px;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            }
            
            #sidebar nav {
                overflow-y-auto;
                max-height: calc(100vh - 12rem);
                padding-bottom: 2rem;
            }
            
            /* Close sidebar when clicking links on mobile */
            aside nav > a {
                position: relative;
            }
            
            aside nav > a::after {
                content: '';
            }
        }

        /* Responsive navbar adjustments */
        @media (max-width: 640px) {
            nav .px-4 {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
            
            nav h1 {
                font-size: 1rem;
            }
            
            nav button {
                padding: 0.5rem;
            }
        }

        /* Responsive main content padding */
        @media (max-width: 768px) {
            main {
                padding: 1rem;
            }
        }

        /* Table responsive - overflow on mobile */
        @media (max-width: 768px) {
            .table-responsive {
                -webkit-overflow-scrolling: touch;
            }
            
            table {
                display: block;
                border: 0;
            }
            
            table thead {
                display: none;
            }
            
            table tbody {
                display: block;
            }
            
            table tbody tr {
                display: block;
                border: 1px solid #e5e7eb;
                margin-bottom: 1rem;
                border-radius: 0.5rem;
                padding: 1rem;
            }
            
            table tbody td {
                display: block;
                text-align: left;
                padding: 0.5rem 0;
                border: 0;
                position: relative;
                padding-left: 50%;
            }
            
            table tbody td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                font-weight: bold;
                color: #6b7280;
                text-align: left;
            }
        }

        /* Form field responsive sizing */
        @media (max-width: 768px) {
            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="number"],
            input[type="tel"],
            select,
            textarea {
                font-size: 16px !important;
                min-height: 44px;
                padding: 0.75rem !important;
            }
            
            label {
                display: block;
                margin-bottom: 0.5rem;
                font-size: 0.95rem;
            }
            
            form button {
                width: 100%;
                min-height: 44px;
                font-size: 1rem;
            }
        }

        /* Card layout responsive */
        @media (max-width: 768px) {
            .card-grid {
                grid-template-columns: 1fr;
            }
            
            .card {
                margin-bottom: 1rem;
            }
        }

        /* Modal responsive */
        @media (max-width: 640px) {
            .modal-dialog {
                margin: 1rem;
                width: auto;
                max-width: calc(100vw - 2rem);
            }
        }

        /* Notification dropdown responsive */
        @media (max-width: 640px) {
            #notificationDropdown {
                position: fixed;
                right: 0;
                left: 0;
                top: auto;
                bottom: 0;
                width: 100% !important;
                max-width: 100% !important;
                border-radius: 1rem 1rem 0 0;
                max-height: 70vh;
            }
        }

        /* Hide elements on mobile if needed */
        @media (max-width: 768px) {
            .hidden-mobile {
                display: none;
            }
            
            .show-mobile {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .show-mobile {
                display: none;
            }
        }

        /* Text size adjustments for mobile */
        @media (max-width: 640px) {
            h1 { font-size: 1.5rem; }
            h2 { font-size: 1.25rem; }
            h3 { font-size: 1.1rem; }
            p { font-size: 0.95rem; }
        }

        /* Prevent text zoom on mobile */
        body {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            -moz-text-size-adjust: 100%;
        }
    </style>
    
    <?= $this->renderSection('extra_css') ?>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Top Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Left: Logo & Menu Toggle -->
                <div class="flex items-center space-x-4">
                    <button id="sidebarToggle" class="lg:hidden text-gray-600 hover:text-blue-600 hover:bg-blue-50 p-2 rounded-lg focus:outline-none transition-all duration-300">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <a href="<?= base_url('admin') ?>" class="flex items-center space-x-2 group">
                        <img src="<?= base_url('assets/images/SYH.CLEANING.png') ?>" alt="SYH Cleaning" class="h-10 w-10 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <span class="text-xs sm:text-sm md:text-lg lg:text-xl font-bold text-black group-hover:text-gray-800 transition-all duration-300 whitespace-nowrap">SYH.CLEANING</span>
                    </a>
                </div>
                
                <!-- Right: Notifications & Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Notification Bell -->
                    <div class="relative">
                        <button onclick="toggleNotifications()" class="relative p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transform hover:scale-110 transition-all duration-300 group">
                            <i class="fas fa-bell text-xl group-hover:animate-swing"></i>
                            <span id="notificationBadge" class="absolute top-1 right-1 hidden items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full animate-pulse">0</span>
                        </button>
                        
                        <!-- Notification Dropdown -->
                        <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-200 notification-dropdown">
                            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                                <span class="font-semibold text-gray-800">Notifikasi</span>
                                <button onclick="markAllAsRead(event)" class="text-xs text-blue-600 hover:text-blue-700 font-medium">Tandai semua dibaca</button>
                            </div>
                            <div id="notificationList" class="max-h-96 overflow-y-auto">
                                <div class="p-8 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-2"></i>
                                    <p class="text-sm">Tidak ada notifikasi baru</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Print Report Button -->
                    <button onclick="cetakLaporan()" class="hidden md:flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 hover:shadow-xl transform hover:scale-105 hover:-translate-y-1 transition-all duration-300 font-medium group">
                        <i class="fas fa-print group-hover:rotate-12 transition-transform duration-300"></i>
                        <span>Cetak Laporan</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed lg:sticky top-16 left-0 z-40 w-64 h-[calc(100vh-4rem)] bg-white border-r border-gray-200 -translate-x-full lg:translate-x-0 transition-transform duration-300">
            <!-- Menu Items -->
            <?php
            $currentPath = uri_string();
            $isDashboard = ($currentPath == 'admin' || $currentPath == 'admin/');
            $isServices = (strpos($currentPath, 'admin/services') !== false);
            $isBookings = (strpos($currentPath, 'admin/bookings') !== false || strpos($currentPath, 'admin/booking-detail') !== false);
            $isUsers = (strpos($currentPath, 'admin/users') !== false || strpos($currentPath, 'admin/user') !== false);
            $isReports = (strpos($currentPath, 'admin/reports') !== false);
            $isProfile = (strpos($currentPath, 'admin/profile') !== false);
            ?>
            <nav class="p-4 space-y-1">
                <a href="<?= base_url('admin') ?>" class="flex items-center space-x-3 px-4 py-3 <?= $isDashboard ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600' ?> rounded-lg font-medium transform hover:translate-x-1 hover:shadow-md transition-all duration-300 group relative overflow-hidden">
                    <span class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                    <i class="fas fa-home w-5 text-center group-hover:scale-125 group-hover:rotate-12 transition-all duration-300"></i>
                    <span class="relative">Beranda</span>
                </a>
                <a href="<?= base_url('admin/services') ?>" class="flex items-center space-x-3 px-4 py-3 <?= $isServices ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600' ?> rounded-lg font-medium transform hover:translate-x-1 hover:shadow-md transition-all duration-300 group relative overflow-hidden">
                    <span class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                    <i class="fas fa-list w-5 text-center group-hover:scale-125 group-hover:rotate-12 transition-all duration-300"></i>
                    <span class="relative">Layanan</span>
                </a>
                <a href="<?= base_url('admin/bookings') ?>" class="flex items-center space-x-3 px-4 py-3 <?= $isBookings ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600' ?> rounded-lg font-medium transform hover:translate-x-1 hover:shadow-md transition-all duration-300 group relative overflow-hidden">
                    <span class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                    <i class="fas fa-shopping-bag w-5 text-center group-hover:scale-125 group-hover:rotate-12 transition-all duration-300"></i>
                    <span class="relative">Pesanan</span>
                </a>
                <a href="<?= base_url('admin/users') ?>" class="flex items-center space-x-3 px-4 py-3 <?= $isUsers ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600' ?> rounded-lg font-medium transform hover:translate-x-1 hover:shadow-md transition-all duration-300 group relative overflow-hidden">
                    <span class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                    <i class="fas fa-users w-5 text-center group-hover:scale-125 group-hover:rotate-12 transition-all duration-300"></i>
                    <span class="relative">Pelanggan</span>
                </a>
                <a href="<?= base_url('admin/reports') ?>" class="flex items-center space-x-3 px-4 py-3 <?= $isReports ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600' ?> rounded-lg font-medium transform hover:translate-x-1 hover:shadow-md transition-all duration-300 group relative overflow-hidden">
                    <span class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                    <i class="fas fa-chart-bar w-5 text-center group-hover:scale-125 group-hover:rotate-12 transition-all duration-300"></i>
                    <span class="relative">Laporan</span>
                </a>
                <a href="<?= base_url('admin/profile') ?>" class="flex items-center space-x-3 px-4 py-3 <?= $isProfile ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600' ?> rounded-lg font-medium transform hover:translate-x-1 hover:shadow-md transition-all duration-300 group relative overflow-hidden">
                    <span class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                    <i class="fas fa-user-circle w-5 text-center group-hover:scale-125 group-hover:rotate-12 transition-all duration-300"></i>
                    <span class="relative">Akun</span>
                </a>
                
                <div class="pt-4 border-t border-gray-200">
                    <a href="#" onclick="showAdminLogoutAnimation(event)" class="flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 hover:text-red-700 rounded-lg font-medium transform hover:translate-x-1 hover:shadow-md transition-all duration-300 group relative overflow-hidden">
                        <span class="absolute inset-0 bg-gradient-to-r from-red-500 to-red-600 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                        <i class="fas fa-sign-out-alt w-5 text-center group-hover:scale-125 group-hover:-rotate-12 transition-all duration-300"></i>
                        <span class="relative">Keluar</span>
                    </a>
                </div>
            </nav>

            <!-- Admin User Info (Bottom) -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        A
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-gray-800 truncate">Admin</div>
                        <div class="text-xs text-gray-600">Dimas Syahrul S (Owner)</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

        <!-- Main Content -->
        <main class="flex-1 p-4 lg:p-8 min-h-screen">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <!-- Admin Logout Animation Overlay -->
    <div id="adminLogoutOverlay" class="hidden fixed inset-0 bg-gradient-to-br from-blue-600 to-blue-800 z-50 flex-col items-center justify-center">
        <div class="relative">
            <!-- Icon dengan background lingkaran -->
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-2xl animate-bounce-slow">
                <i class="fas fa-sign-out-alt text-blue-600 text-4xl"></i>
            </div>
            <!-- Rotating circle border -->
            <div class="absolute inset-0 border-4 border-white border-t-transparent rounded-full animate-spin-slow"></div>
        </div>
        
        <!-- Text -->
        <h2 class="text-white text-2xl font-bold mt-8 animate-fade-in">sedang keluar...</h2>
        <p class="text-blue-100 text-sm mt-2 animate-fade-in-delay">Sampai jumpa lagi, Admin!</p>
        
        <!-- Loading dots -->
        <div class="flex space-x-2 mt-6">
            <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0s"></div>
            <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Sidebar Toggle for Mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        // Function to close sidebar
        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        }
        
        sidebarToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });
        
        sidebarOverlay?.addEventListener('click', () => {
            closeSidebar();
        });

        // Close sidebar when menu item is clicked on mobile
        document.querySelectorAll('aside nav a').forEach(link => {
            link.addEventListener('click', () => {
                // Only close on mobile (when sidebar is visible)
                if (window.innerWidth < 1024) {
                    closeSidebar();
                }
            });
        });
        
        // Active menu highlight
        const currentPath = window.location.pathname;
        document.querySelectorAll('aside nav a').forEach(link => {
            if (link.getAttribute('href') === currentPath || currentPath.startsWith(link.getAttribute('href') + '/')) {
                link.classList.remove('text-gray-700', 'hover:bg-gradient-to-r', 'hover:from-blue-50', 'hover:to-blue-100', 'hover:text-blue-600');
                link.classList.add('bg-gradient-to-r', 'from-blue-500', 'to-blue-600', 'text-white', 'shadow-md');
            }
        });
        
        // Notification handling
        let notificationDropdownOpen = false;

        document.addEventListener('DOMContentLoaded', function() {
            loadNotifications();
            setInterval(loadNotifications, 30000);
        });

        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            notificationDropdownOpen = !notificationDropdownOpen;
            dropdown.classList.toggle('hidden');
            
            if (notificationDropdownOpen) {
                loadNotifications();
            }
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('notificationDropdown');
            const button = event.target.closest('button[onclick="toggleNotifications()"]');
            
            if (!button && !dropdown?.contains(event.target) && notificationDropdownOpen) {
                dropdown.classList.add('hidden');
                notificationDropdownOpen = false;
            }
        });

        async function loadNotifications() {
            try {
                const response = await fetch('<?= base_url("api/notifications/unread") ?>', {
                    credentials: 'include'
                });
                const data = await response.json();
                
                const badge = document.getElementById('notificationBadge');
                const list = document.getElementById('notificationList');
                
                if (data.count > 0) {
                    badge.textContent = data.count > 9 ? '9+' : data.count;
                    badge.classList.remove('hidden');
                    badge.classList.add('flex');
                    
                    list.innerHTML = '';
                    data.notifications.forEach(notif => {
                        const div = document.createElement('div');
                        div.className = 'px-4 py-3 hover:bg-blue-50 border-b border-gray-100 cursor-pointer transition';
                        div.onclick = () => markAsRead(notif.id, notif.booking_id);
                        
                        const timeAgo = getTimeAgo(notif.created_at);
                        const iconClass = getNotificationIcon(notif.tipe);
                        const iconColor = notif.tipe === 'new_booking' ? 'text-green-500' : 'text-blue-500';
                        
                        div.innerHTML = `
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center flex-shrink-0">
                                    <i class="fas ${iconClass} ${iconColor}"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-800 text-sm">${notif.judul}</div>
                                    <div class="text-gray-600 text-xs mt-0.5 line-clamp-2">${notif.pesan}</div>
                                    <div class="text-gray-500 text-xs mt-1">${timeAgo}</div>
                                </div>
                            </div>
                        `;
                        list.appendChild(div);
                    });
                } else {
                    badge.classList.add('hidden');
                    badge.classList.remove('flex');
                    list.innerHTML = `
                        <div class="p-8 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p class="text-sm">Tidak ada notifikasi baru</p>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error loading notifications:', error);
            }
        }

        function getNotificationIcon(type) {
            const icons = {
                'new_booking': 'fa-shopping-bag',
                'status_update': 'fa-sync',
                'info': 'fa-info-circle'
            };
            return icons[type] || 'fa-bell';
        }

        function getTimeAgo(datetime) {
            const now = new Date();
            const past = new Date(datetime);
            const diffMs = now - past;
            const diffMins = Math.floor(diffMs / 60000);
            
            if (diffMins < 1) return 'Baru saja';
            if (diffMins < 60) return diffMins + ' menit lalu';
            
            const diffHours = Math.floor(diffMins / 60);
            if (diffHours < 24) return diffHours + ' jam lalu';
            
            const diffDays = Math.floor(diffHours / 24);
            return diffDays + ' hari lalu';
        }

        async function markAsRead(id, bookingId) {
            try {
                await fetch(`<?= base_url("api/notifications/") ?>${id}/read`, {
                    method: 'PUT',
                    credentials: 'include'
                });
                
                if (bookingId) {
                    window.location.href = `<?= base_url("admin/bookings/detail/") ?>${bookingId}`;
                } else {
                    loadNotifications();
                }
            } catch (error) {
                console.error('Error marking as read:', error);
            }
        }

        async function markAllAsRead(event) {
            event.stopPropagation();
            
            try {
                await fetch('<?= base_url("api/notifications/read-all") ?>', {
                    method: 'PUT',
                    credentials: 'include'
                });
                loadNotifications();
            } catch (error) {
                console.error('Error marking all as read:', error);
            }
        }
        
        // Print Report Function
        function cetakLaporan() {
            window.open('<?= base_url("admin/reports/print") ?>', '_blank');
        }
        
        // Show Admin Logout Animation and call API
        async function showAdminLogoutAnimation(event) {
            event.preventDefault();
            
            const overlay = document.getElementById('adminLogoutOverlay');
            if (overlay) {
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
            }
            
            try {
                console.log('🚀 Admin logging out via API...');
                const response = await fetch('/api/auth/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    credentials: 'include'
                });
                
                console.log('📊 Logout Response Status:', response.status);
                const result = await response.json();
                console.log('✅ Admin Logout API Response:', result);
                
                // Redirect after animation
                setTimeout(function() {
                    window.location.href = '/';
                }, 1500);
            } catch (error) {
                console.error('❌ Logout error:', error);
                // Still redirect even if error
                setTimeout(function() {
                    window.location.href = '/';
                }, 1500);
            }
        }
    </script>
    
    <?= $this->renderSection('extra_js') ?>
</body>
</html>
