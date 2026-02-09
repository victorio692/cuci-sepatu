<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- User Dashboard - Shopee Style -->
<div class="min-h-screen bg-gray-50 pt-24 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Profile Section - Clickable -->
        <a href="/profile" class="block bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl shadow-lg p-6 mb-6 hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02]">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <?php if (!empty($user['foto_profil'])): ?>
                        <img src="<?= base_url('uploads/' . $user['foto_profil']) ?>" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover border-4 border-white shadow-lg">
                    <?php else: ?>
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-full flex items-center justify-center text-blue-600 text-2xl sm:text-3xl font-bold border-4 border-white shadow-lg">
                            <?= strtoupper(substr($user['full_name'] ?? $user['nama_lengkap'] ?? 'U', 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    <!-- Online Badge -->
                    <div class="absolute bottom-0 right-0 w-4 h-4 sm:w-5 sm:h-5 bg-green-400 border-2 border-white rounded-full"></div>
                </div>
                <div class="flex-1">
                    <h2 class="text-white font-bold text-lg sm:text-xl"><?= $user['full_name'] ?? $user['nama_lengkap'] ?? 'User' ?></h2>
                    <p class="text-blue-100 text-sm"><?= $user['email'] ?></p>
                </div>
                <i class="fas fa-chevron-right text-white text-xl"></i>
            </div>
        </a>

        <!-- Pesanan Saya Section -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-shopping-bag text-blue-600"></i>
                    Pesanan Saya
                </h3>
                <a href="/my-bookings" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center gap-1">
                    Lihat Semua
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- Order Status Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
                <!-- Menunggu Konfirmasi -->
                <a href="/my-bookings?status=pending" class="relative flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-blue-400 hover:bg-blue-50 transition-all duration-300 group cursor-pointer">
                    <?php if ($statusCounts['pending'] > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg"><?= $statusCounts['pending'] ?></span>
                    <?php endif; ?>
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-blue-100 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-clock text-blue-600 text-xl sm:text-2xl"></i>
                    </div>
                    <span class="text-xs sm:text-sm text-gray-700 font-medium text-center">Menunggu Konfirmasi</span>
                </a>

                <!-- Dikonfirmasi -->
                <a href="/my-bookings?status=disetujui" class="relative flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-blue-400 hover:bg-blue-50 transition-all duration-300 group cursor-pointer">
                    <?php if ($statusCounts['disetujui'] > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg"><?= $statusCounts['disetujui'] ?></span>
                    <?php endif; ?>
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-blue-100 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-check-circle text-blue-500 text-xl sm:text-2xl"></i>
                    </div>
                    <span class="text-xs sm:text-sm text-gray-700 font-medium text-center">Dikonfirmasi</span>
                </a>

                <!-- Proses -->
                <a href="/my-bookings?status=proses" class="relative flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-purple-400 hover:bg-purple-50 transition-all duration-300 group cursor-pointer">
                    <?php if ($statusCounts['proses'] > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg"><?= $statusCounts['proses'] ?></span>
                    <?php endif; ?>
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-purple-100 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-sync-alt text-purple-500 text-xl sm:text-2xl"></i>
                    </div>
                    <span class="text-xs sm:text-sm text-gray-700 font-medium text-center">Proses</span>
                </a>

                <!-- Selesai -->
                <a href="/my-bookings?status=selesai" class="relative flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-green-400 hover:bg-green-50 transition-all duration-300 group cursor-pointer">
                    <?php if ($statusCounts['selesai'] > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg"><?= $statusCounts['selesai'] ?></span>
                    <?php endif; ?>
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-green-100 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-check-double text-green-500 text-xl sm:text-2xl"></i>
                    </div>
                    <span class="text-xs sm:text-sm text-gray-700 font-medium text-center">Selesai</span>
                </a>

                <!-- Dibatalkan -->
                <a href="/my-bookings?status=batal" class="relative flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-gray-400 hover:bg-gray-50 transition-all duration-300 group cursor-pointer">
                    <?php if ($statusCounts['batal'] > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg"><?= $statusCounts['batal'] ?></span>
                    <?php endif; ?>
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gray-100 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-times-circle text-gray-500 text-xl sm:text-2xl"></i>
                    </div>
                    <span class="text-xs sm:text-sm text-gray-700 font-medium text-center">Dibatalkan</span>
                </a>

                <!-- Ditolak -->
                <a href="/my-bookings?status=ditolak" class="relative flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-red-400 hover:bg-red-50 transition-all duration-300 group cursor-pointer">
                    <?php if ($statusCounts['ditolak'] > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg"><?= $statusCounts['ditolak'] ?></span>
                    <?php endif; ?>
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-red-100 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                        <i class="fas fa-ban text-red-500 text-xl sm:text-2xl"></i>
                    </div>
                    <span class="text-xs sm:text-sm text-gray-700 font-medium text-center">Ditolak</span>
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <!-- Booking Baru -->
            <a href="/make-booking" class="bg-white rounded-xl shadow-sm p-4 hover:shadow-lg transition-all duration-300 transform hover:scale-105 border-2 border-transparent hover:border-blue-400">
                <div class="flex flex-col items-center text-center gap-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-plus text-white text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Booking Baru</span>
                </div>
            </a>

            <!-- Keranjang -->
            <a href="/cart" class="bg-white rounded-xl shadow-sm p-4 hover:shadow-lg transition-all duration-300 transform hover:scale-105 border-2 border-transparent hover:border-purple-400">
                <div class="flex flex-col items-center text-center gap-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-white text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Keranjang</span>
                </div>
            </a>

            <!-- Layanan -->
            <a href="/#services" class="bg-white rounded-xl shadow-sm p-4 hover:shadow-lg transition-all duration-300 transform hover:scale-105 border-2 border-transparent hover:border-green-400">
                <div class="flex flex-col items-center text-center gap-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-list text-white text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Layanan</span>
                </div>
            </a>

            <!-- Hubungi Kami -->
            <a href="/kontak" class="bg-white rounded-xl shadow-sm p-4 hover:shadow-lg transition-all duration-300 transform hover:scale-105 border-2 border-transparent hover:border-pink-400">
                <div class="flex flex-col items-center text-center gap-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-headset text-white text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Hubungi Kami</span>
                </div>
            </a>
        </div>

        <!-- Info Banner -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h3 class="text-lg font-bold mb-1">Promo Spesial!</h3>
                    <p class="text-sm text-white/90">Dapatkan diskon 20% untuk layanan Deep Cleaning</p>
                </div>
                <a href="/#services" class="bg-white text-blue-600 px-4 py-2 rounded-lg font-medium text-sm hover:bg-blue-50 transition-colors whitespace-nowrap">
                    Lihat Detail
                </a>
            </div>
        </div>

    </div>
</div>
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
                        <i class="fas fa-plus mr-2"></i> Booking Sekarang
                    </a>
                </div>
            </div>

            <!-- Services Section -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Layanan Kami</h2>
                        <p class="text-gray-600 mt-1">Pilih layanan terbaik untuk sepatu Anda</p>
                    </div>
                </div>

                <!-- Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php 
                    $serviceIcons = [
                        'fast-cleaning' => 'fa-clock',
                        'deep-cleaning' => 'fa-spray-can',
                        'white-shoes' => 'fa-shoe-prints',
                        'suede-treatment' => 'fa-tshirt',
                        'unyellowing' => 'fa-sun'
                    ];
                    
                    foreach ($services as $service): 
                        $icon = $serviceIcons[$service['kode_layanan']] ?? 'fa-shoe-prints';
                    ?>
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group transform hover:-translate-y-2">
                        <!-- Service Header with Gradient -->
                        <div class="bg-blue-600 p-6 text-white relative">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
                            <div class="relative z-10">
                                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mb-4 backdrop-blur-sm">
                                    <i class="fas <?= $icon ?> text-3xl"></i>
                                </div>
                                <h3 class="text-xl font-bold mb-2"><?= htmlspecialchars($service['nama_layanan']) ?></h3>
                                <p class="text-sm opacity-90"><?= $service['durasi_hari'] ?> hari pengerjaan</p>
                            </div>
                        </div>

                        <!-- Service Body -->
                        <div class="p-6">
                            <p class="text-gray-600 mb-6 text-sm leading-relaxed">
                                <?= htmlspecialchars($service['deskripsi']) ?>
                            </p>

                            <!-- Price Section -->
                            <div class="flex items-center justify-between mb-6 pb-6 border-b border-gray-100">
                                <div>
                                    <span class="text-sm text-gray-500">Mulai dari</span>
                                    <div class="text-2xl font-bold text-gray-900">
                                        Rp <?= number_format($service['harga_dasar'], 0, ',', '.') ?>
                                    </div>
                                </div>
                                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white">
                                    <i class="fas fa-tag"></i>
                                </div>
                            </div>

                            <!-- CTA Button -->
                            <a href="/make-booking?service=<?= $service['kode_layanan'] ?>" 
                               class="block w-full py-3 px-6 bg-blue-600 hover:bg-blue-700 text-white text-center rounded-xl font-semibold hover:shadow-xl transition-all duration-300 transform group-hover:scale-105">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Booking Sekarang
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Pesanan Terbaru</h3>
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 mb-4">Anda belum memiliki pesanan.</p>
                    <a href="/make-booking" class="inline-block px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
                        Booking Sekarang
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
        'disetujui': 'info',
        'proses': 'info',
        'selesai': 'success',
        'batal': 'danger',
        'ditolak': 'danger'
    };
    return classes[status] || 'primary';
}

function getStatusLabel(status) {
    const labels = {
        'pending': 'Menunggu Persetujuan',
        'disetujui': 'Disetujui',
        'proses': 'Sedang Diproses',
        'selesai': 'Selesai',
        'batal': 'Dibatalkan',
        'ditolak': 'Ditolak'
    };
    return labels[status] || status;
}
</script>

<?= $this->endSection() ?>
