    <?= $this->extend('layouts/base') ?>

    <?= $this->section('content') ?>

    <!-- Main Content -->
    <div class="min-h-screen bg-gray-50 pt-24 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            <i class="fas fa-calendar-check text-blue-600 mr-3"></i>
                            Pesanan Saya
                        </h1>
                        <p class="text-gray-600 mt-2">Kelola dan lacak semua pesanan cuci sepatu Anda</p>
                    </div>
                    <div>
                        <a href="/profile" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
                            <i class="fas fa-arrow-left"></i>
                            <span class="hidden sm:inline">Kembali ke Profil</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Status Tabs Navigation -->
            <div class="bg-white rounded-xl shadow-lg mb-6 overflow-hidden">
                <div class="border-b border-gray-200">
                    <nav class="flex overflow-x-auto" aria-label="Tabs">
                        <?php 
                        $currentStatus = $_GET['status'] ?? 'all';
                        $tabs = [
                            'all' => ['label' => 'Semua', 'icon' => 'fa-list', 'count' => 0],
                            'pending' => ['label' => 'Menunggu', 'icon' => 'fa-clock', 'count' => 0],
                            'disetujui' => ['label' => 'Dikonfirmasi', 'icon' => 'fa-check-circle', 'count' => 0],
                            'proses' => ['label' => 'Proses', 'icon' => 'fa-sync-alt', 'count' => 0],
                            'selesai' => ['label' => 'Selesai', 'icon' => 'fa-check-double', 'count' => 0],
                            'batal' => ['label' => 'Dibatalkan', 'icon' => 'fa-times-circle', 'count' => 0],
                            'ditolak' => ['label' => 'Ditolak', 'icon' => 'fa-ban', 'count' => 0],
                        ];
                        ?>
                        
                        <?php foreach ($tabs as $status => $tab): ?>
                            <a href="/my-bookings<?= $status !== 'all' ? '?status=' . $status : '' ?>" 
                            class="<?= $currentStatus === $status 
                                    ? 'border-blue-600 text-blue-600 font-semibold' 
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' 
                                ?> whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm flex items-center gap-2 transition">
                                <i class="fas <?= $tab['icon'] ?>"></i>
                                <span><?= $tab['label'] ?></span>
                                <span data-tab-count="<?= $status ?>" class="<?= $currentStatus === $status 
                                    ? 'bg-blue-100 text-blue-600' 
                                    : 'bg-gray-100 text-gray-600' 
                                ?> ml-2 py-0.5 px-2 rounded-full text-xs font-semibold">
                                    0
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </nav>
                </div>
            </div>

            <!-- Bookings Table Container -->
            <div id="bookingsContainer">
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <i class="fas fa-spinner fa-spin text-blue-600 text-6xl mb-4"></i>
                    <p class="text-gray-600">Memuat pesanan...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Get current status filter from URL
    const urlParams = new URLSearchParams(window.location.search);
    const currentStatus = urlParams.get('status') || 'all';

    // Load bookings on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadBookings(currentStatus);
    });

    // Service name mapping
    const serviceNames = {
        'fast-cleaning': 'Fast Cleaning',
        'deep-cleaning': 'Deep Cleaning',
        'white-shoes': 'White Shoes',
        'suede-treatment': 'Suede Treatment',
        'unyellowing': 'Unyellowing'
    };

    // Status badge configuration
    const statusConfig = {
        'pending': {
            label: 'Menunggu',
            class: 'bg-yellow-100 text-yellow-800',
            icon: ''
        },
        'disetujui': {
            label: 'Disetujui',
            class: 'bg-blue-100 text-blue-800',
            icon: ''
        },
        'proses': {
            label: 'Diproses',
            class: 'bg-purple-100 text-purple-800',
            icon: ''
        },
        'selesai': {
            label: 'Selesai',
            class: 'bg-green-100 text-green-800',
            icon: '<i class="fas fa-check-circle mr-1"></i>'
        },
        'ditolak': {
            label: 'Ditolak',
            class: 'bg-red-100 text-red-800',
            icon: ''
        },
        'batal': {
            label: 'Dibatalkan',
            class: 'bg-gray-100 text-gray-800',
            icon: ''
        }
    };

    // Format date
    function formatDate(dateString) {
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const date = new Date(dateString);
        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
    }

    // Format currency
    function formatCurrency(amount) {
        return 'Rp ' + parseInt(amount).toLocaleString('id-ID');
    }

    // Load bookings from API
    async function loadBookings(status = 'all') {
        console.log('🚀 Loading bookings with status:', status);
        
        const container = document.getElementById('bookingsContainer');
        
        try {
            // Fetch all bookings to calculate status counts
            const allUrl = '/api/booking/my-bookings';
            const allResponse = await fetch(allUrl, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'include'
            });

            if (!allResponse.ok) {
                throw new Error(`HTTP error! status: ${allResponse.status}`);
            }

            const allResult = await allResponse.json();
            console.log('✅ All bookings loaded:', allResult);

            // Extract all bookings and calculate status counts
            const allBookings = allResult.data?.bookings || [];
            
            // Calculate status counts
            const statusCounts = {
                all: allBookings.length,
                pending: 0,
                disetujui: 0,
                proses: 0,
                selesai: 0,
                batal: 0,
                ditolak: 0
            };

            allBookings.forEach(booking => {
                const s = booking.status || 'pending';
                if (statusCounts[s] !== undefined) {
                    statusCounts[s]++;
                }
            });

            console.log('📊 Status counts:', statusCounts);

            // Update tab counts
            updateTabCounts(statusCounts);

            // Filter bookings by selected status
            let filteredBookings = allBookings;
            if (status !== 'all') {
                filteredBookings = allBookings.filter(b => b.status === status);
            }

            console.log('📋 Filtered bookings to render:', filteredBookings);

            // Render bookings table
            if (filteredBookings.length > 0) {
                renderBookingsTable(filteredBookings);
            } else {
                renderEmptyState();
            }

        } catch (error) {
            console.error('❌ Error loading bookings:', error);
            container.innerHTML = `
                <div class="bg-red-50 rounded-xl shadow-lg p-12 text-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-6xl mb-4"></i>
                    <h3 class="text-xl font-bold text-red-700 mb-2">Gagal Memuat Pesanan</h3>
                    <p class="text-red-600 mb-4">${error.message}</p>
                    <button onclick="loadBookings('${status}')" 
                            class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition">
                        <i class="fas fa-redo mr-2"></i>Coba Lagi
                    </button>
                </div>
            `;
        }
    }

    // Update tab counts
    function updateTabCounts(counts) {
        // Update all tab
        const allCount = counts.all || 0;
        const allTab = document.querySelector('[data-tab-count="all"]');
        if (allTab) allTab.textContent = allCount;

        // Update individual status tabs
        const statuses = ['pending', 'disetujui', 'proses', 'selesai', 'batal', 'ditolak'];
        statuses.forEach(status => {
            const tab = document.querySelector(`[data-tab-count="${status}"]`);
            if (tab) {
                tab.textContent = counts[status] || 0;
            }
        });
    }

    // Render bookings table
    function renderBookingsTable(bookings) {
        const container = document.getElementById('bookingsContainer');
        
        let tableHTML = `
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100">
                    <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-list text-blue-600"></i>
                        Daftar Pesanan
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No Pesanan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Layanan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
        `;

        bookings.forEach(booking => {
            const status = booking.status || 'pending';
            const statusInfo = statusConfig[status] || statusConfig['pending'];
            const serviceName = serviceNames[booking.layanan] || booking.layanan;
            const tanggal = formatDate(booking.dibuat_pada);
            const hasFoto = booking.status === 'selesai' && booking.foto_hasil;
            
            tableHTML += `
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-bold text-gray-900">#${booking.id}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-gray-900">${serviceName}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-gray-600">${tanggal}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${statusInfo.class}">
                            ${statusInfo.icon}${statusInfo.label}
                        </span>
                        ${hasFoto ? `
                            <div class="mt-1">
                                <span class="text-xs text-green-600 font-medium">
                                    <i class="fas fa-camera"></i> Foto tersedia
                                </span>
                            </div>
                        ` : ''}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-semibold text-gray-900">${formatCurrency(booking.total)}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="/booking-detail/${booking.id}" 
                        class="inline-block px-4 py-2 ${booking.status === 'selesai' ? 'bg-green-500 hover:bg-green-600' : 'bg-blue-500 hover:bg-blue-600'} text-white text-sm font-medium rounded-lg transition-colors duration-200"
                        style="${booking.status === 'selesai' ? 'background-color: #10b981;' : 'background-color: #3b82f6;'} color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; display: inline-block;">
                            ${hasFoto ? '<i class="fas fa-image mr-1"></i> Detail & Foto' : '<i class="fas fa-eye mr-1"></i> Lihat'}
                        </a>
                    </td>
                </tr>
            `;
        });

        tableHTML += `
                        </tbody>
                    </table>
                </div>
            </div>
        `;

        container.innerHTML = tableHTML;
    }

    // Render empty state
    function renderEmptyState() {
        const container = document.getElementById('bookingsContainer');
        container.innerHTML = `
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <div class="mb-6">
                    <i class="fas fa-inbox text-8xl text-gray-300"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-3">Belum Ada Pesanan</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">
                    Anda belum memiliki pesanan apapun. Mulai pesan layanan cuci sepatu sekarang!
                </p>
                <a href="/make-booking" 
                class="inline-block px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition">
                    <i class="fas fa-plus mr-2"></i>
                    Booking Sekarang
                </a>
            </div>
        `;
    }
    </script>

    <?= $this->endSection() ?>
