<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="/dashboard" class="active">
                    <span class="sidebar-icon"><i class="fas fa-home"></i></span>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/my-bookings">
                    <span class="sidebar-icon"><i class="fas fa-calendar-check"></i></span>
                    Pesanan Saya
                </a>
            </li>
            <li>
                <a href="/make-booking">
                    <span class="sidebar-icon"><i class="fas fa-plus-circle"></i></span>
                    Pesan Baru
                </a>
            </li>
            <li>
                <a href="/profile">
                    <span class="sidebar-icon"><i class="fas fa-user-circle"></i></span>
                    Profil
                </a>
            </li>
            <li>
                <a href="#" onclick="confirmLogout(event)" style="color: #ef4444;">
                    <span class="sidebar-icon"><i class="fas fa-sign-out-alt"></i></span>
                    Logout
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <div class="dashboard-title">
                <div>
                    <h1>Selamat Datang, <?= $user['nama_lengkap'] ?? 'Guest' ?>!</h1>
                    <p style="color: #6b7280; margin: 0;">Kelola pesanan dan layanan cuci sepatu Anda</p>
                </div>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <!-- Notification Bell -->
                    <div class="notification-bell-customer" onclick="toggleCustomerNotifications()">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge-customer" id="notificationBadgeCustomer" style="display: none;">0</span>
                        
                        <!-- Notification Dropdown -->
                        <div class="notification-dropdown-customer" id="notificationDropdownCustomer" style="display: none;">
                            <div class="notification-header-customer">
                                <span>Notifikasi</span>
                                <button onclick="markAllAsReadCustomer(event)" class="mark-all-read-customer">Tandai semua dibaca</button>
                            </div>
                            <div class="notification-list-customer" id="notificationListCustomer">
                                <div class="notification-empty-customer">
                                    <i class="fas fa-inbox"></i>
                                    <p>Tidak ada notifikasi baru</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="/make-booking" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Pesan Sekarang
                    </a>
                </div>
            </div>

            <!-- Stats -->
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-label">Total Pesanan</div>
                    <div class="stat-value"><?= $total_bookings ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Pesanan Aktif</div>
                    <div class="stat-value" style="color: #f59e0b;"><?= $active_bookings ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Selesai</div>
                    <div class="stat-value" style="color: #10b981;"><?= $completed_bookings ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Pengeluaran</div>
                    <div class="stat-value">Rp <?= number_format($total_spent, 0, ',', '.') ?></div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="card">
            <div class="card-header">
                <h3>Pesanan Terbaru</h3>
            </div>
            <div class="card-body">
                <div class="text-center p-4">
                    <i class="fas fa-inbox" style="font-size: 3rem; color: #d1d5db;"></i>
                    <p style="color: #6b7280; margin-top: 1rem;">Anda belum memiliki pesanan.</p>
                    <a href="/make-booking" class="btn btn-primary mt-2">Pesan Sekarang</a>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 2rem;">
            <div class="card">
                <div class="card-body">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 50px; height: 50px; background: #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0;">Pesan Baru</h4>
                            <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">Mulai pesanan baru</p>
                        </div>
                    </div>
                    <a href="/make-booking" style="display: block; margin-top: 1rem; text-align: center;" class="btn btn-primary btn-sm">
                        Pesan
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 50px; height: 50px; background: #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0;">Profil</h4>
                            <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">Update data pribadi</p>
                        </div>
                    </div>
                    <a href="/profile" style="display: block; margin-top: 1rem; text-align: center;" class="btn btn-primary btn-sm">
                        Lihat
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 50px; height: 50px; background: #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0;">Dukungan</h4>
                            <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">Hubungi customer service</p>
                        </div>
                    </div>
                    <a href="/kontak" style="display: block; margin-top: 1rem; text-align: center;" class="btn btn-primary btn-sm">
                        Hubungi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
// Notification functionality for customer
let customerNotificationDropdownOpen = false;

// Load notifications on page load
document.addEventListener('DOMContentLoaded', function() {
    loadCustomerNotifications();
    // Refresh every 30 seconds
    setInterval(loadCustomerNotifications, 30000);
});

function toggleCustomerNotifications() {
    const dropdown = document.getElementById('notificationDropdownCustomer');
    customerNotificationDropdownOpen = !customerNotificationDropdownOpen;
    dropdown.style.display = customerNotificationDropdownOpen ? 'block' : 'none';
    
    if (customerNotificationDropdownOpen) {
        loadCustomerNotifications();
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const bell = document.querySelector('.notification-bell-customer');
    if (bell && !bell.contains(event.target) && customerNotificationDropdownOpen) {
        document.getElementById('notificationDropdownCustomer').style.display = 'none';
        customerNotificationDropdownOpen = false;
    }
});

async function loadCustomerNotifications() {
    try {
        const response = await fetch('/notifications/getUnread');
        const data = await response.json();
        
        const badge = document.getElementById('notificationBadgeCustomer');
        const list = document.getElementById('notificationListCustomer');
        
        if (data.count > 0) {
            badge.textContent = data.count > 9 ? '9+' : data.count;
            badge.style.display = 'flex';
            
            list.innerHTML = '';
            data.notifications.forEach(notif => {
                const div = document.createElement('div');
                div.className = 'notification-item-customer';
                div.onclick = () => markAsReadCustomer(notif.id, notif.booking_id);
                
                const timeAgo = getTimeAgo(notif.created_at);
                
                div.innerHTML = `
                    <div class="notification-icon-customer ${notif.tipe}">
                        <i class="fas ${getNotificationIcon(notif.tipe)}"></i>
                    </div>
                    <div class="notification-content-customer">
                        <div class="notification-title-customer">${notif.judul}</div>
                        <div class="notification-message-customer">${notif.pesan}</div>
                        <div class="notification-time-customer">${timeAgo}</div>
                    </div>
                `;
                list.appendChild(div);
            });
        } else {
            badge.style.display = 'none';
            list.innerHTML = `
                <div class="notification-empty-customer">
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

async function markAsReadCustomer(id, bookingId) {
    try {
        await fetch(`/notifications/markAsRead/${id}`, {
            method: 'POST'
        });
        
        if (bookingId) {
            window.location.href = `/booking-detail/${bookingId}`;
        } else {
            loadCustomerNotifications();
        }
    } catch (error) {
        console.error('Error marking as read:', error);
    }
}

async function markAllAsReadCustomer(event) {
    event.stopPropagation();
    
    try {
        await fetch('/notifications/markAllAsRead', {
            method: 'POST'
        });
        loadCustomerNotifications();
    } catch (error) {
        console.error('Error marking all as read:', error);
    }
}

// Logout confirmation
function confirmLogout(e) {
    e.preventDefault();
    if (confirm('Apakah Anda yakin ingin logout?')) {
        window.location.href = '/logout';
    }
}

// Helper functions untuk status
function getStatusBadgeClass(status) {
    const classes = {
        'pending': 'warning',
        'approved': 'info',
        'in_progress': 'info',
        'completed': 'success',
        'cancelled': 'danger'
    };
    return classes[status] || 'primary';
}

function getStatusLabel(status) {
    const labels = {
        'pending': 'Menunggu Persetujuan',
        'approved': 'Disetujui',
        'in_progress': 'Sedang Diproses',
        'completed': 'Selesai',
        'cancelled': 'Dibatalkan'
    };
    return labels[status] || status;
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}
</script>
<?= $this->endSection() ?>
