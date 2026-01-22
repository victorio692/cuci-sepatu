<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin - SYH Cleaning' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?= $this->renderSection('extra_css') ?>
</head>
<body>
    <!-- Admin Navbar -->
    <nav class="admin-navbar">
        <div class="admin-navbar-content">
            <a href="<?= base_url('admin') ?>" class="admin-logo">
                <img src="<?= base_url('assets/images/SYH.CLEANING.png') ?>" alt="SYH Cleaning" class="logo-img" style="height: 40px;">
                <span>ADMIN SYH.CLEANING</span>
            </a>
            <div class="admin-navbar-right">
                <!-- Notification Bell -->
                <div class="notification-bell" onclick="toggleNotifications()">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge" id="notificationBadge" style="display: none;">0</span>
                    
                    <!-- Notification Dropdown -->
                    <div class="notification-dropdown" id="notificationDropdown" style="display: none;">
                        <div class="notification-header">
                            <span>Notifikasi</span>
                            <button onclick="markAllAsRead(event)" class="mark-all-read">Tandai semua dibaca</button>
                        </div>
                        <div class="notification-list" id="notificationList">
                            <div class="notification-empty">
                                <i class="fas fa-inbox"></i>
                                <p>Tidak ada notifikasi baru</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button class="btn-cetak-laporan" onclick="cetakLaporan()">
                    <i class="fas fa-print"></i> Cetak laporan
                </button>
            </div>
        </div>
    </nav>

    <!-- Admin Container -->
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-sidebar-logo">
                <img src="<?= base_url('assets/images/SYH.CLEANING.png') ?>" alt="SYH Cleaning" style="height: 35px;">
                <span style="font-weight: 700; font-size: 1.1rem;">SYH Cleaning</span>
            </div>
            
            <ul class="admin-sidebar-menu">
                <li>
                    <a href="<?= base_url('admin') ?>" class="menu-item active">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/services') ?>" class="menu-item">
                        <i class="fas fa-list"></i>
                        <span>Layanan</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/bookings') ?>" class="menu-item">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Booking</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/users') ?>" class="menu-item">
                        <i class="fas fa-users"></i>
                        <span>Customers</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/reports') ?>" class="menu-item">
                        <i class="fas fa-file-chart-line"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('admin/profile') ?>" class="menu-item">
                        <i class="fas fa-user-circle"></i>
                        <span>Profil</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('logout') ?>" class="menu-item">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>

            <div class="admin-sidebar-footer">
                <div class="admin-user-info">
                    <div class="user-avatar-small">A</div>
                    <div>
                        <div style="font-weight: 600; font-size: 0.9rem;">Admin</div>
                        <div style="font-size: 0.75rem; color: #9ca3af;">Administrator</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <script src="<?= base_url('assets/js/main.js') ?>"></script>
    <script src="<?= base_url('assets/js/admin.js') ?>"></script>
    
    <!-- Notification Script -->
    <script>
        let notificationDropdownOpen = false;

        // Load notifications on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadNotifications();
            // Refresh every 30 seconds
            setInterval(loadNotifications, 30000);
        });

        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            notificationDropdownOpen = !notificationDropdownOpen;
            dropdown.style.display = notificationDropdownOpen ? 'block' : 'none';
            
            if (notificationDropdownOpen) {
                loadNotifications();
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const bell = document.querySelector('.notification-bell');
            if (!bell.contains(event.target) && notificationDropdownOpen) {
                document.getElementById('notificationDropdown').style.display = 'none';
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
                    badge.style.display = 'flex';
                    
                    list.innerHTML = '';
                    data.notifications.forEach(notif => {
                        const div = document.createElement('div');
                        div.className = 'notification-item';
                        div.onclick = () => markAsRead(notif.id, notif.booking_id);
                        
                        const timeAgo = getTimeAgo(notif.dibuat_pada);
                        
                        div.innerHTML = `
                            <div class="notification-icon ${notif.tipe}">
                                <i class="fas ${getNotificationIcon(notif.tipe)}"></i>
                            </div>
                            <div class="notification-content">
                                <div class="notification-title">${notif.judul}</div>
                                <div class="notification-message">${notif.pesan}</div>
                                <div class="notification-time">${timeAgo}</div>
                            </div>
                        `;
                        list.appendChild(div);
                    });
                } else {
                    badge.style.display = 'none';
                    list.innerHTML = `
                        <div class="notification-empty">
                            <i class="fas fa-inbox"></i>
                            <p>Tidak ada notifikasi baru</p>
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
    </script>
    
    <?= $this->renderSection('extra_js') ?>
</body>
</html>
