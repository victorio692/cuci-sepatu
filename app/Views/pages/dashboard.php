<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg fixed h-full">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Dashboard</h2>
        </div>
        <nav class="py-4">
            <a href="/dashboard" class="flex items-center px-6 py-3 text-gray-900 bg-gray-100 border-l-4 border-blue-500">
                <i class="fas fa-home mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="/my-bookings" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition">
                <i class="fas fa-calendar-check mr-3"></i>
                <span>Pesanan Saya</span>
            </a>
            <a href="/make-booking" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition">
                <i class="fas fa-plus-circle mr-3"></i>
                <span>Pesan Baru</span>
            </a>
            <a href="/profile" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition">
                <i class="fas fa-user-circle mr-3"></i>
                <span>Profil</span>
            </a>
            <a href="#" onclick="confirmLogout(event)" class="flex items-center px-6 py-3 text-red-600 hover:bg-red-50 transition">
                <i class="fas fa-sign-out-alt mr-3"></i>
                <span>Logout</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 ml-64">
        <div class="p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang, <?= $user['nama_lengkap'] ?? 'Guest' ?>!</h1>
                <p class="text-gray-600">Kelola pesanan dan layanan cuci sepatu Anda</p>
            </div>

            <!-- Action Bar -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <!-- Notification Bell -->
                        <div class="relative">
                            <button onclick="toggleCustomerNotifications()" class="relative p-3 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                <i class="fas fa-bell text-xl"></i>
                                <span id="notificationBadgeCustomer" class="hidden absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">0</span>
                            </button>
                            
                            <!-- Notification Dropdown -->
                            <div id="notificationDropdownCustomer" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-200 z-50">
                                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                                    <span class="font-semibold text-gray-800">Notifikasi</span>
                                    <button onclick="markAllAsReadCustomer(event)" class="text-sm text-blue-600 hover:text-blue-700">Tandai semua dibaca</button>
                                </div>
                                <div id="notificationListCustomer" class="max-h-96 overflow-y-auto">
                                    <div class="p-8 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-2"></i>
                                        <p>Tidak ada notifikasi baru</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="/make-booking" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-plus mr-2"></i> Pesan Sekarang
                    </a>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm font-medium text-blue-600 mb-1">Total Pesanan</div>
                    <div class="text-3xl font-bold text-blue-900"><?= $total_bookings ?></div>
                </div>
                <div class="bg-orange-50 rounded-lg p-6 border-l-4 border-orange-500">
                    <div class="text-sm font-medium text-orange-600 mb-1">Pesanan Aktif</div>
                    <div class="text-3xl font-bold text-orange-900"><?= $active_bookings ?></div>
                </div>
                <div class="bg-green-50 rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm font-medium text-green-600 mb-1">Selesai</div>
                    <div class="text-3xl font-bold text-green-900"><?= $completed_bookings ?></div>
                </div>
                <div class="bg-purple-50 rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-sm font-medium text-purple-600 mb-1">Total Pengeluaran</div>
                    <div class="text-3xl font-bold text-purple-900">Rp <?= number_format($total_spent, 0, ',', '.') ?></div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Pesanan Terbaru</h3>
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 mb-4">Anda belum memiliki pesanan.</p>
                    <a href="/make-booking" class="inline-block px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
                        Pesan Sekarang
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
                
                const timeAgo = getTimeAgo(notif.dibuat_pada);
                
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
