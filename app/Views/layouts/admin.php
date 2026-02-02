<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <button id="sidebarToggle" class="lg:hidden text-gray-600 hover:text-gray-800 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <a href="<?= base_url('admin') ?>" class="flex items-center space-x-3">
                        <img src="<?= base_url('assets/images/SYH.CLEANING.png') ?>" alt="SYH Cleaning" class="h-10 w-10">
                        <span class="hidden md:block text-xl font-bold bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">ADMIN SYH.CLEANING</span>
                    </a>
                </div>
                
                <!-- Right: Notifications & Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Notification Bell -->
                    <div class="relative">
                        <button onclick="toggleNotifications()" class="relative p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                            <i class="fas fa-bell text-xl"></i>
                            <span id="notificationBadge" class="absolute top-1 right-1 hidden items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">0</span>
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
                    <button onclick="cetakLaporan()" class="hidden md:flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-medium">
                        <i class="fas fa-print"></i>
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
            <nav class="p-4 space-y-1">
                <a href="<?= base_url('admin') ?>" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600 rounded-lg font-medium group">
                    <i class="fas fa-home w-5 text-center group-hover:scale-110 transition"></i>
                    <span>Dashboard</span>
                </a>
                <a href="<?= base_url('admin/services') ?>" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600 rounded-lg font-medium group">
                    <i class="fas fa-list w-5 text-center group-hover:scale-110 transition"></i>
                    <span>Layanan</span>
                </a>
                <a href="<?= base_url('admin/bookings') ?>" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600 rounded-lg font-medium group">
                    <i class="fas fa-shopping-bag w-5 text-center group-hover:scale-110 transition"></i>
                    <span>Booking</span>
                </a>
                <a href="<?= base_url('admin/users') ?>" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600 rounded-lg font-medium group">
                    <i class="fas fa-users w-5 text-center group-hover:scale-110 transition"></i>
                    <span>Customers</span>
                </a>
                <a href="<?= base_url('admin/reports') ?>" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600 rounded-lg font-medium group">
                    <i class="fas fa-chart-bar w-5 text-center group-hover:scale-110 transition"></i>
                    <span>Laporan</span>
                </a>
                <a href="<?= base_url('admin/profile') ?>" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600 rounded-lg font-medium group">
                    <i class="fas fa-user-circle w-5 text-center group-hover:scale-110 transition"></i>
                    <span>Profil</span>
                </a>
                
                <div class="pt-4 border-t border-gray-200">
                    <a href="<?= base_url('logout') ?>" class="flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg font-medium group">
                        <i class="fas fa-sign-out-alt w-5 text-center group-hover:scale-110 transition"></i>
                        <span>Logout</span>
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
                        <div class="text-xs text-gray-600">Administrator</div>
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

    <!-- Scripts -->
    <script>
        // Sidebar Toggle for Mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        sidebarToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });
        
        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
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
                const response = await fetch('<?= base_url("notifications/getUnread") ?>');
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
                        
                        const timeAgo = getTimeAgo(notif.dibuat_pada);
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
                await fetch(`<?= base_url("notifications/markAsRead/") ?>${id}`, {
                    method: 'POST'
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
                await fetch('<?= base_url("notifications/markAllAsRead") ?>', {
                    method: 'POST'
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
    </script>
    
    <?= $this->renderSection('extra_js') ?>
</body>
</html>
