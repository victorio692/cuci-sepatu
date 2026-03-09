<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Beranda Admin</h1>
    <p class="text-gray-600">Kelola semua Pesanan dan layanan SYH Cleaning</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-8">
    <!-- Total Booking Card -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-3 md:p-5 text-white hover:shadow-lg hover:scale-102 transition duration-300">
        <div class="flex items-center justify-between gap-3">
            <div class="flex-1 min-w-0">
                <p class="text-blue-100 text-xs font-semibold uppercase tracking-wide">Total Pesanan</p>
                <h3 class="text-3xl md:text-4xl font-bold mt-2" data-stat="total_bookings">0</h3>
                <p class="text-blue-100 text-xs mt-2">Total semua pesanan</p>
            </div>
            <div class="w-12 h-12 md:w-16 md:h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-shopping-bag text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Dalam Proses Card -->
    <div class="bg-gradient-to-br from-cyan-500 to-blue-600 rounded-lg shadow-md p-3 md:p-5 text-white hover:shadow-lg hover:scale-102 transition duration-300">
        <div class="flex items-center justify-between gap-3">
            <div class="flex-1 min-w-0">
                <p class="text-cyan-100 text-xs font-semibold uppercase tracking-wide">Dalam Proses</p>
                <h3 class="text-3xl md:text-4xl font-bold mt-2" data-stat="proses_bookings">0</h3>
                <p class="text-cyan-100 text-xs mt-2">Sedang dikerjakan</p>
            </div>
            <div class="w-12 h-12 md:w-16 md:h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-cog text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Selesai Card -->
    <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-lg shadow-md p-3 md:p-5 text-white hover:shadow-lg hover:scale-102 transition duration-300">
        <div class="flex items-center justify-between gap-3">
            <div class="flex-1 min-w-0">
                <p class="text-emerald-100 text-xs font-semibold uppercase tracking-wide">Selesai</p>
                <h3 class="text-3xl md:text-4xl font-bold mt-2" data-stat="completed_bookings">0</h3>
                <p class="text-emerald-100 text-xs mt-2">Siap diambil</p>
            </div>
            <div class="w-12 h-12 md:w-16 md:h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check-circle text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Pendapatan Card -->
    <div class="bg-gradient-to-br from-violet-500 to-purple-600 rounded-lg shadow-md p-3 md:p-5 text-white hover:shadow-lg hover:scale-102 transition duration-300">
        <div class="flex items-center justify-between gap-3">
            <div class="flex-1 min-w-0">
                <p class="text-violet-100 text-xs font-semibold uppercase tracking-wide">Total Pendapatan</p>
                <h3 class="text-2xl md:text-3xl font-bold mt-2" data-stat="total_revenue">Rp 0</h3>
                <p class="text-violet-100 text-xs mt-2">Dari pesanan selesai</p>
            </div>
            <div class="w-12 h-12 md:w-16 md:h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-money-bill-wave text-lg md:text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Data Booking Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
    <!-- Card Header -->
    <div class="px-4 md:px-6 py-4 border-b border-gray-200 flex flex-col gap-3 md:flex-row md:items-center md:justify-between bg-gray-50">
        <div>
            <h3 class="text-base md:text-lg font-bold text-gray-900">Data Pesanan</h3>
            <p class="text-xs md:text-sm text-gray-600 mt-1">Kelola semua pesanan customer</p>
        </div>
        <div class="relative w-full md:w-64">
            <input 
                type="text" 
                id="searchBooking" 
                placeholder="Cari pesanan..." 
                onkeyup="searchTable()"
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-xs md:text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
            >
            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>

    <!-- Table -->
    <div id="bookingsTableContainer">
        <div class="p-16 text-center">
            <i class="fas fa-spinner fa-spin text-blue-600 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg font-medium">Memuat data pesanan...</p>
        </div>
    </div>
    
    <!-- Pagination -->
    <div id="paginationContainer" class="px-4 md:px-6 py-4 border-t border-gray-200 bg-gray-50 hidden">
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
// Pagination state for dashboard
let currentDashboardPage = 1;

// Load data on page load
document.addEventListener('DOMContentLoaded', function() {
    loadDashboardStatistics();
    loadRecentBookings();
    
    // Auto refresh every 30 seconds
    setInterval(() => {
        loadDashboardStatistics();
        loadRecentBookings();
    }, 30000);
});

// Load dashboard statistics from API
async function loadDashboardStatistics() {
    console.log('🚀 Loading admin dashboard statistics...');
    
    try {
        const response = await fetch('/api/admin/dashboard/', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include'
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        console.log('✅ Dashboard statistics loaded:', result);

        const data = result.data || result;
        
        // Update statistics cards - match API response structure
        document.querySelector('[data-stat="total_bookings"]').textContent = (data.booking?.total || 0);
        document.querySelector('[data-stat="proses_bookings"]').textContent = (data.booking?.proses || 0);
        document.querySelector('[data-stat="completed_bookings"]').textContent = (data.booking?.selesai || 0);
        
        // Format currency for revenue
        const revenue = parseInt(data.pendapatan?.total || 0);
        document.querySelector('[data-stat="total_revenue"]').textContent = 'Rp ' + revenue.toLocaleString('id-ID');
        
        console.log('📊 Cards updated:', {
            total: data.booking?.total,
            proses: data.booking?.proses,
            selesai: data.booking?.selesai,
            revenue: revenue
        });

    } catch (error) {
        console.error('❌ Error loading dashboard statistics:', error);
    }
}

// Load recent bookings from API with pagination
async function loadRecentBookings(page = 1) {
    console.log('🚀 Loading recent bookings...', { page });
    currentDashboardPage = page;
    
    const container = document.getElementById('bookingsTableContainer');
    
    try {
        let url = '/api/admin/dashboard/recent-bookings';
        if (page > 1) {
            url += '?page=' + page;
        }
        
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include'
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        console.log('✅ Recent bookings loaded:', result);

        // Extract bookings and pagination from API response
            const bookings = result.data?.booking || result.bookings || [];
            const halaman = result.data?.halaman || {};

        //Convert API structure to pagination format
        const pagination ={
            current_page: halaman.current || 1,
            last_page: halaman.total_halaman || 1,
            total: halaman.total_data || 0,
            per_page: halaman.per_halaman || 10,
            from: ((halaman.current ||1)-1)*(halaman.per_halaman || 10) + 1,
            to: Math.min((halaman.current ||1)*(halaman.per_halaman || 10), halaman.total_data || 0)
        };


        console.log('📋 Bookings to render:', bookings);
        console.log('📄 Pagination:', pagination);

        if (bookings.length > 0) {
            renderBookingsTable(bookings, pagination);
        } else {
            renderEmptyBookings();
        }

    } catch (error) {
        console.error('❌ Error loading bookings:', error);
        container.innerHTML = `
            <div class="p-16 text-center">
                <i class="fas fa-exclamation-circle text-red-500 text-6xl mb-4"></i>
                <p class="text-red-600 text-lg font-medium">Gagal memuat data booking</p>
                <button onclick="loadRecentBookings()" class="mt-4 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                    <i class="fas fa-redo mr-2"></i>Coba Lagi
                </button>
            </div>
        `;
    }
}

// Render bookings table
function renderBookingsTable(bookings, pagination = {}) {
    const container = document.getElementById('bookingsTableContainer');
    
    const statusClasses = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'disetujui': 'bg-blue-100 text-blue-800',
        'proses': 'bg-purple-100 text-purple-800',
        'selesai': 'bg-green-100 text-green-800',
        'ditolak': 'bg-red-100 text-red-800',
        'batal': 'bg-gray-100 text-gray-800'
    };
    
    const statusLabels = {
        'pending': 'Menunggu',
        'disetujui': 'Disetujui',
        'proses': 'Sedang Dikerjakan',
        'selesai': 'Selesai',
        'ditolak': 'Ditolak',
        'batal': 'Dibatalkan'
    };
    
    // Desktop table
    let tableHTML = `
        <div class="overflow-x-auto table-responsive hidden md:block">
        <table class="w-full" id="bookingTable">
            <thead class="bg-gray-100 border-b-2 border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kontak</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Layanan</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Jumlah</th>
                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Total</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
    `;
    
    // Mobile card layout
    let cardHTML = `
        <div class="md:hidden space-y-3 p-4">
    `;
    
    bookings.forEach(booking => {
        const bookingId = String(booking.id).padStart(3, '0');
        const customerName = booking.nama_customer || booking.customer_name || '?';
        const customerInitial = customerName.charAt(0).toUpperCase();
        const statusClass = statusClasses[booking.status] || 'bg-gray-100 text-gray-800';
        const isDisabled = ['selesai', 'ditolak'].includes(booking.status);
        
        // Format date
        const date = new Date(booking.created_at);
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const formattedDate = `${date.getDate()} ${months[date.getMonth()]}`;
        
        // Format phone number for WhatsApp
        const phone = (booking.no_hp || '').replace(/[^0-9]/g, '');
        
        // Format service name
        const serviceName = booking.layanan ? booking.layanan.split('-').map(word => 
            word.charAt(0).toUpperCase() + word.slice(1)
        ).join(' ') : '-';
        
        // Desktop row
        tableHTML += `
            <tr class="hover:bg-blue-50 transition duration-200">
                <td class="px-4 py-3 whitespace-nowrap">
                    <span class="font-semibold text-gray-800 text-sm">BK${bookingId}</span>
                </td>
                <td class="px-4 py-3 text-sm">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                            ${customerInitial}
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">${customerName}</div>
                            <div class="text-xs text-gray-500">${formattedDate}</div>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3 text-sm">
                    <a href="https://wa.me/${phone}" target="_blank" class="text-green-600 hover:text-green-700 text-sm inline-flex items-center space-x-1">
                        <i class="fab fa-whatsapp"></i>
                        <span>${booking.no_hp || '-'}</span>
                    </a>
                </td>
                <td class="px-4 py-3 text-sm text-gray-700">${serviceName}</td>
                <td class="px-4 py-3 text-center text-sm text-gray-700 font-medium">${booking.jumlah || 1}</td>
                <td class="px-4 py-3 text-right text-sm font-semibold text-gray-900">Rp ${parseInt(booking.total || 0).toLocaleString('id-ID')}</td>
                <td class="px-4 py-3 text-sm">
                    <select 
                        class="px-2 py-1 rounded text-xs font-semibold border-0 focus:ring-2 focus:ring-blue-500 transition cursor-pointer ${statusClass}"
                        data-booking-id="${booking.id}"
                        data-original-status="${booking.status}"
                        onchange="updateBookingStatus(this)"
                        ${isDisabled ? 'disabled' : ''}
                    >
                        <option value="pending" ${booking.status === 'pending' ? 'selected' : ''}>Menunggu</option>
                        <option value="disetujui" ${booking.status === 'disetujui' ? 'selected' : ''}>Disetujui</option>
                        <option value="proses" ${booking.status === 'proses' ? 'selected' : ''}>Sedang Dikerjakan</option>
                        <option value="selesai" ${booking.status === 'selesai' ? 'selected' : ''}>Selesai</option>
                        <option value="ditolak" ${booking.status === 'ditolak' ? 'selected' : ''}>Ditolak</option>
                    </select>
                </td>
                <td class="px-4 py-3 text-center text-sm">
                    <div class="flex items-center justify-center space-x-0.5">
                        <a href="/admin/bookings/${booking.id}" 
                           class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-xs"
                           title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button onclick="deleteBooking(${booking.id})" 
                                class="inline-flex items-center justify-center w-8 h-8 bg-red-50 text-red-600 rounded hover:bg-red-100 transition text-xs"
                                title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
        
        // Mobile card
        cardHTML += `
            <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                            ${customerInitial}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900 text-sm">${customerName}</div>
                            <div class="text-xs text-gray-500">BK${bookingId}</div>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold ${statusClass}">
                        ${statusLabels[booking.status] || booking.status}
                    </span>
                </div>
                
                <div class="space-y-2 mb-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Layanan:</span>
                        <span class="font-medium text-gray-900">${serviceName}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah:</span>
                        <span class="font-medium text-gray-900">${booking.jumlah || 1}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total:</span>
                        <span class="font-semibold text-gray-900">Rp ${parseInt(booking.total || 0).toLocaleString('id-ID')}</span>
                    </div>
                </div>
                
                <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                    <a href="https://wa.me/${phone}" target="_blank" class="text-green-600 hover:text-green-700 text-sm flex items-center space-x-1">
                        <i class="fab fa-whatsapp"></i>
                        <span>${booking.no_hp || '-'}</span>
                    </a>
                    <div class="flex items-center space-x-0.5">
                        <a href="/admin/bookings/${booking.id}" 
                           class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-xs"
                           title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button onclick="deleteBooking(${booking.id})" 
                                class="inline-flex items-center justify-center w-8 h-8 bg-red-50 text-red-600 rounded hover:bg-red-100 transition text-xs"
                                title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
    
    tableHTML += `
            </tbody>
        </table>
        </div>
    `;
    
    cardHTML += `
        </div>
    `;

    container.innerHTML = tableHTML + cardHTML;

    // Render pagination separately in pagination container
    const paginationContainer = document.getElementById('paginationContainer');
    if (pagination && pagination.total > 0) {
        paginationContainer.classList.remove('hidden');
        paginationContainer.innerHTML = `
             <div class="flex flex-col sm:flex-row items-center justify-between gap-3 md:gap-4">
                <div class="text-xs md:text-sm text-gray-600">
                    Total: <span class="font-semibold">${pagination.total || 0} pesanan</span> | Halaman <span class="font-semibold">${pagination.current_page || 1}</span> dari <span class="font-semibold">${pagination.last_page || 1}</span>
                </div>
                
                <div class="flex items-center gap-1 md:gap-2 flex-wrap">
                    ${pagination.current_page > 1 ? `<button onclick="loadRecentBookings(${pagination.current_page - 1})" class="px-2 md:px-3 py-1 md:py-2 text-xs bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50 transition font-medium"><i class="fas fa-chevron-left"></i></button>` : `<button disabled class="px-2 md:px-3 py-1 md:py-2 text-xs bg-gray-100 border border-gray-200 text-gray-400 rounded cursor-not-allowed font-medium"><i class="fas fa-chevron-left"></i></button>`}
                    ${generateDashboardPageNumbers(pagination.current_page || 1, pagination.last_page || 1)}
                    ${pagination.current_page < pagination.last_page ? `<button onclick="loadRecentBookings(${pagination.current_page + 1})" class="px-2 md:px-3 py-1 md:py-2 text-xs bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50 transition font-medium"><i class="fas fa-chevron-right"></i></button>` : `<button disabled class="px-2 md:px-3 py-1 md:py-2 text-xs bg-gray-100 border border-gray-200 text-gray-400 rounded cursor-not-allowed font-medium"><i class="fas fa-chevron-right"></i></button>`}
                </div>
            </div>
        `;
        } else {
            paginationContainer.classList.add('hidden');
    }
}

// Generate page numbers for dashboard pagination
function generateDashboardPageNumbers(currentPage, totalPages) {
    let html = '';
    const maxVisible = 5;
    
    let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
    let endPage = Math.min(totalPages, startPage + maxVisible - 1);
    
    if (endPage - startPage + 1 < maxVisible) {
        startPage = Math.max(1, endPage - maxVisible + 1);
    }
    
    // Tombol halaman pertama
    if (startPage > 1) {
        html += `<button onclick="loadRecentBookings(1)" class="px-3 py-2 text-xs bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">1</button>`;
        if (startPage > 2) {
            html += `<span class="px-2 py-2 text-xs text-gray-400">...</span>`;
        }
    }
    
    // Tombol nomor halaman
    for (let i = startPage; i <= endPage; i++) {
        if (i === currentPage) {
            html += `<button class="px-3 py-2 text-xs bg-blue-600 text-white rounded-lg font-medium shadow-sm">${i}</button>`;
        } else {
            html += `<button onclick="loadRecentBookings(${i})" class="px-3 py-2 text-xs bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">${i}</button>`;
        }
    }
    
    // Tombol halaman terakhir
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            html += `<span class="px-2 py-2 text-xs text-gray-400">...</span>`;
        }
        html += `<button onclick="loadRecentBookings(${totalPages})" class="px-3 py-2 text-xs bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">${totalPages}</button>`;
    }
    
    return html;
}

// Render empty bookings state
function renderEmptyBookings() {
    const container = document.getElementById('bookingsTableContainer');
    container.innerHTML = `
        <div class="p-16 text-center">
            <i class="fas fa-inbox text-6xl mb-4 text-gray-300"></i>
            <p class="text-gray-600 text-lg font-medium">Belum ada booking</p>
        </div>
    `;
}

function searchTable() {
    const input = document.getElementById('searchBooking');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('bookingTable');
    const tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        const td = tr[i].getElementsByTagName('td');
        let found = false;
        
        for (let j = 0; j < td.length; j++) {
            if (td[j]) {
                const txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }
        
        tr[i].style.display = found ? '' : 'none';
    }
}

function updateBookingStatus(selectElement) {
    const bookingId = selectElement.getAttribute('data-booking-id');
    const newStatus = selectElement.value;
    const originalStatus = selectElement.getAttribute('data-original-status');
    
    if (!originalStatus) {
        selectElement.setAttribute('data-original-status', newStatus);
    }
    
    if (newStatus === 'selesai') {
        const confirmMsg = 'Status "Selesai" memerlukan foto hasil cucian.\n\nAnda akan diarahkan ke halaman detail booking untuk mengunggah foto hasil cucian.\n\nLanjutkan?';
        if (confirm(confirmMsg)) {
            window.location.href = '/admin/bookings/' + bookingId;
        } else {
            selectElement.value = originalStatus;
        }
        return;
    }
    
    if (newStatus === 'ditolak') {
        const confirmMsg = 'Status "Ditolak" memerlukan alasan penolakan.\n\nAnda akan diarahkan ke halaman detail booking untuk mengisi alasan.\n\nLanjutkan?';
        if (confirm(confirmMsg)) {
            window.location.href = '/admin/bookings/' + bookingId;
        } else {
            selectElement.value = originalStatus;
        }
        return;
    }
    
    fetch('/api/admin/bookings/' + bookingId + '/status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'include',
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success || data.code === 200) {
            selectElement.setAttribute('data-original-status', newStatus);
            showToast('Status berhasil diupdate', 'success');
            
            // Reload statistics and bookings after status update
            setTimeout(() => {
                loadDashboardStatistics();
                loadRecentBookings();
            }, 500);
        } else {
            showToast(data.message || 'Gagal update status', 'error');
            selectElement.value = originalStatus;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan koneksi', 'error');
        selectElement.value = originalStatus;
    });
}

function deleteBooking(id) {
    if (confirm('Yakin ingin menghapus booking ini?')) {
        fetch('/api/admin/bookings/' + id, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'include'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success || data.code === 200) {
                showToast('Booking berhasil dihapus', 'success');
                
                // Reload statistics and bookings after delete
                setTimeout(() => {
                    loadDashboardStatistics();
                    loadRecentBookings();
                }, 500);
            } else {
                showToast('Gagal menghapus booking', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan', 'error');
        });
    }
}

function showToast(message, type) {
    const bgColors = {
        'success': 'bg-green-500',
        'error': 'bg-red-500',
        'info': 'bg-blue-500'
    };
    
    const icons = {
        'success': 'fa-check-circle',
        'error': 'fa-exclamation-circle',
        'info': 'fa-info-circle'
    };
    
    const toast = document.createElement('div');
    toast.className = `fixed top-20 right-4 ${bgColors[type]} text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 z-50 animate-slide-in-right`;
    toast.innerHTML = `
        <i class="fas ${icons[type]} text-xl"></i>
        <span class="font-medium">${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<style>
@keyframes slide-in-right {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
.animate-slide-in-right {
    animation: slide-in-right 0.3s ease;
}
</style>
<?= $this->endSection() ?>
