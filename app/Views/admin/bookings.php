<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-6 md:mb-8">
    <h1 class="text-xl md:text-2xl font-bold text-gray-800 mb-1 md:mb-2">Pesanan</h1>
    <p class="text-xs md:text-base text-gray-600">Kelola semua pesanan pelanggan</p>
</div>

<!-- Filter & Search -->
<div class="bg-white rounded-xl shadow-lg p-3 md:p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-4">
        <div>
            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">Cari Pesanan</label>
            <div class="relative">
                <input 
                    type="text" 
                    id="searchInput" 
                    placeholder="Nama, email..." 
                    class="w-full pl-4 md:pl-10 pr-10 md:pr-3 py-2 text-xs md:text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                >
                <i class="fas fa-search absolute right-3 md:right-auto md:left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
            </div>
        </div>

        <div>
            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">Filter Status</label>
            <select id="statusFilter" class="w-full px-3 py-2 text-xs md:text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                <option value="">Semua Status</option>
                <option value="pending">Menunggu</option>
                <option value="disetujui">Disetujui</option>
                <option value="proses">Diproses</option>
                <option value="selesai">Selesai</option>
                <option value="ditolak">Ditolak</option>
            </select>
        </div>

        <div class="flex items-end">
            <button type="button" onclick="applyFilters()" class="w-full px-4 md:px-6 py-2 text-xs md:text-sm bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-medium flex items-center justify-center space-x-1 md:space-x-2">
                <i class="fas fa-search text-xs"></i>
                <span>Cari & Filter</span>
            </button>
        </div>
    </div>
</div>

<!-- Bookings Table -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div id="bookingsTableContainer">
        <div class="p-16 text-center">
            <i class="fas fa-spinner fa-spin text-blue-600 text-6xl mb-4"></i>
            <p class="text-gray-600 text-lg font-medium">Memuat data pesanan...</p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
// Store pagination and filter state
let currentFilters = {
    search: '',
    status: '',
    page: 1
};

// Load bookings on page load
document.addEventListener('DOMContentLoaded', function() {
    loadBookings();
});

// Load bookings from API
async function loadBookings(search = '', status = '', page = 1) {
    console.log('🚀 Loading bookings...', { search, status, page });
    
    // Store current filters and page
    currentFilters = { search, status, page };
    
    const container = document.getElementById('bookingsTableContainer');
    
    try {
        let url = '/api/admin/bookings/';
        const params = new URLSearchParams();
        
        if (search) params.append('search', search);
        if (status) params.append('status', status);
        if (page) params.append('page', page);
        
        if (params.toString()) {
            url += '?' + params.toString();
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
        console.log('✅ Bookings loaded:', result);

        // API returns data.bookings (not result.bookings or result.data)
        const bookings = result.data?.bookings || [];
        const pagination = result.data?.pagination || {};

        console.log('📋 Extracted bookings:', bookings);
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
                <button onclick="loadBookings()" class="mt-4 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                    <i class="fas fa-redo mr-2"></i>Coba Lagi
                </button>
            </div>
        `;
    }
}

// Apply filters
function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('statusFilter').value;
    loadBookings(search, status, 1);  // Reset to page 1 when filtering
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
    
    // Mobile card layout
    let mobileHTML = `<div class="block md:hidden space-y-3">`;
    
    // Desktop table layout
    let tableHTML = `
        <div class="hidden md:block overflow-x-auto table-responsive">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 border-b-2 border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Pelanggan</th>
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
    
    bookings.forEach(booking => {
        const bookingId = String(booking.id).padStart(3, '0');
        const customerName = booking.full_name || booking.customer_name || '?';
        const customerInitial = customerName.charAt(0).toUpperCase();
        const statusClass = statusClasses[booking.status] || 'bg-gray-100 text-gray-800';
        const isDisabled = ['selesai', 'ditolak'].includes(booking.status);
        
        const date = new Date(booking.created_at || booking.created_at);
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const formattedDate = `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
        
        const phone = (booking.no_hp || '').replace(/[^0-9]/g, '');
        
        const serviceName = booking.service || booking.layanan ? 
            (booking.service || booking.layanan).split('-').map(word => 
                word.charAt(0).toUpperCase() + word.slice(1)
            ).join(' ') : '-';
        
        // MOBILE CARD
        mobileHTML += `
            <div class="bg-white rounded-lg shadow p-4 border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm">
                            ${customerInitial}
                        </div>
                        <div class="min-w-0">
                            <div class="font-bold text-sm text-gray-900 truncate">${customerName}</div>
                            <div class="text-xs text-gray-500">BK${bookingId}</div>
                        </div>
                    </div>
                </div>
                <div class="space-y-2 text-xs mb-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600 font-medium">Tanggal:</span>
                        <span class="text-gray-900 font-semibold">${formattedDate}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 font-medium">Layanan:</span>
                        <span class="text-gray-900 font-semibold text-right max-w-xs truncate">${serviceName}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 font-medium">Jumlah:</span>
                        <span class="text-gray-900 font-semibold">${booking.quantity || booking.jumlah || 1}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 font-medium">Total:</span>
                        <span class="text-gray-900 font-semibold">Rp ${parseInt(booking.total || 0).toLocaleString('id-ID')}</span>
                    </div>
                </div>
                <div class="mt-1.5 mb-2 relative">
                    <button 
                        class="w-full px-1.5 py-1 rounded border text-xs font-medium text-left focus:outline-none focus:ring-1 focus:ring-blue-500 transition cursor-pointer leading-tight flex items-center justify-between
                        ${booking.status === 'pending' ? 'bg-yellow-100 text-yellow-800 border-yellow-300' : booking.status === 'disetujui' ? 'bg-blue-100 text-blue-800 border-blue-300' : booking.status === 'proses' ? 'bg-purple-100 text-purple-800 border-purple-300' : booking.status === 'selesai' ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300'}"
                        onclick="toggleStatusDropdown(this, ${booking.id})"
                        ${isDisabled ? 'disabled' : ''}>
                        <span class="flex-1">${booking.status === 'pending' ? ' Menunggu' : booking.status === 'disetujui' ? ' Disetujui' : booking.status === 'proses' ? ' Diproses' : booking.status === 'selesai' ? ' Selesai' : ' Ditolak'}</span>
                        <i class="fas fa-chevron-down text-xs ml-1"></i>
                    </button>
                    <div class="hidden absolute top-full left-0 mt-0.5 w-full sm:w-40 bg-white border border-gray-300 rounded shadow-lg z-50 dropdown-menu-${booking.id}">
                        <button class="block w-full text-left px-2 py-1.5 text-xs hover:bg-yellow-50 transition text-yellow-800" onclick="selectStatus(this, ${booking.id}, 'pending')"> Menunggu</button>
                        <button class="block w-full text-left px-2 py-1.5 text-xs hover:bg-blue-50 transition text-blue-800 border-t border-gray-200" onclick="selectStatus(this, ${booking.id}, 'disetujui')"> Disetujui</button>
                        <button class="block w-full text-left px-2 py-1.5 text-xs hover:bg-purple-50 transition text-purple-800 border-t border-gray-200" onclick="selectStatus(this, ${booking.id}, 'proses')"> Diproses</button>
                        <button class="block w-full text-left px-2 py-1.5 text-xs hover:bg-green-50 transition text-green-800 border-t border-gray-200" onclick="selectStatus(this, ${booking.id}, 'selesai')"> Selesai</button>
                        <button class="block w-full text-left px-2 py-1.5 text-xs hover:bg-red-50 transition text-red-800 border-t border-gray-200" onclick="selectStatus(this, ${booking.id}, 'ditolak')"> Ditolak</button>
                    </div>
                </div>
                <div class="flex items-center justify-center gap-2 pb-1">
                    <a href="https://wa.me/${phone}" target="_blank" class="text-green-600 hover:bg-green-50 px-1.5 py-0.5 rounded text-xs font-medium transition flex items-center justify-center space-x-1 whitespace-nowrap">
                        <i class="fab fa-whatsapp"></i>
                        <span>Chat</span>
                    </a>
                    <a href="/admin/bookings/${booking.id}" class="text-blue-600 hover:bg-blue-50 px-1.5 py-0.5 rounded text-xs font-medium transition flex items-center justify-center space-x-1 whitespace-nowrap">
                        <i class="fas fa-eye"></i>
                        <span>Detail</span>
                    </a>
                    <button onclick="deleteBooking(${booking.id})" class="text-red-600 hover:bg-red-50 px-1.5 py-0.5 rounded text-xs font-medium transition flex items-center justify-center space-x-1 whitespace-nowrap">
                        <i class="fas fa-trash"></i>
                        <span>Hapus</span>
                    </button>
                </div>
            </div>
        `;
        
        // DESKTOP TABLE ROW
        tableHTML += `
            <tr class="hover:bg-blue-50 transition duration-200">
                <td class="px-4 py-3 whitespace-nowrap"><span class="font-semibold text-gray-800 text-sm">BK${bookingId}</span></td>
                <td class="px-4 py-3">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">${customerInitial}</div>
                        <div class="min-w-0"><div class="font-medium text-gray-900 text-sm truncate">${customerName}</div><div class="text-xs text-gray-500">${formattedDate}</div></div>
                    </div>
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                    <a href="https://wa.me/${phone}" target="_blank" class="text-green-600 hover:text-green-700 hover:bg-green-50 px-2 py-1 rounded inline-flex items-center space-x-1 transition text-sm" title="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                        <span>${booking.no_hp || '-'}</span>
                    </a>
                </td>
                <td class="px-4 py-3"><span class="text-sm text-gray-700">${serviceName}</span></td>
                <td class="px-4 py-3 whitespace-nowrap text-center"><span class="text-sm text-gray-700 font-medium">${booking.quantity || booking.jumlah || 1}</span></td>
                <td class="px-4 py-3 whitespace-nowrap text-right"><span class="font-semibold text-gray-900 text-sm">Rp ${parseInt(booking.total || 0).toLocaleString('id-ID')}</span></td>
                <td class="px-4 py-3">
                    <select class="px-2 py-1 rounded text-xs font-semibold border-0 focus:ring-2 focus:ring-blue-500 transition cursor-pointer ${statusClass}"
                        data-booking-id="${booking.id}"
                        data-original-status="${booking.status}"
                        onchange="updateBookingStatus(this)"
                        ${isDisabled ? 'disabled' : ''}>
                        <option value="pending" ${booking.status === 'pending' ? 'selected' : ''}>Menunggu</option>
                        <option value="disetujui" ${booking.status === 'disetujui' ? 'selected' : ''}>Disetujui</option>
                        <option value="proses" ${booking.status === 'proses' ? 'selected' : ''}>Diproses</option>
                        <option value="selesai" ${booking.status === 'selesai' ? 'selected' : ''}>Selesai</option>
                        <option value="ditolak" ${booking.status === 'ditolak' ? 'selected' : ''}>Ditolak</option>
                    </select>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-center">
                    <div class="flex items-center space-x-0.5">
                        <a href="/admin/bookings/${booking.id}" class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-xs"><i class="fas fa-eye"></i></a>
                        <button onclick="deleteBooking(${booking.id})" class="inline-flex items-center justify-center w-8 h-8 bg-red-50 text-red-600 rounded hover:bg-red-100 transition text-xs"><i class="fas fa-trash"></i></button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    mobileHTML += `</div>`;
    tableHTML += `
            </tbody>
        </table>
        </div>
        
        <!-- Pagination & Info -->
        <div class="px-3 md:px-6 py-3 md:py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 md:gap-4">
                <div class="text-xs md:text-sm text-gray-600">
                    Total: <span class="font-semibold">${pagination.total || 0} pesanan</span> | Halaman <span class="font-semibold">${pagination.current_page || 1}</span> dari <span class="font-semibold">${pagination.total_pages || 1}</span>
                </div>
                
                <div class="flex items-center gap-1 md:gap-2 flex-wrap">
                    ${pagination.current_page > 1 ? `<button onclick="loadBookings('${currentFilters.search}', '${currentFilters.status}', ${pagination.current_page - 1})" class="px-2 md:px-3 py-1 md:py-2 text-xs bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50 transition font-medium"><i class="fas fa-chevron-left"></i></button>` : `<button disabled class="px-2 md:px-3 py-1 md:py-2 text-xs bg-gray-100 border border-gray-200 text-gray-400 rounded cursor-not-allowed font-medium"><i class="fas fa-chevron-left"></i></button>`}
                    ${generatePageNumbers(pagination.current_page || 1, pagination.total_pages || 1)}
                    ${pagination.current_page < pagination.total_pages ? `<button onclick="loadBookings('${currentFilters.search}', '${currentFilters.status}', ${pagination.current_page + 1})" class="px-2 md:px-3 py-1 md:py-2 text-xs bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50 transition font-medium"><i class="fas fa-chevron-right"></i></button>` : `<button disabled class="px-2 md:px-3 py-1 md:py-2 text-xs bg-gray-100 border border-gray-200 text-gray-400 rounded cursor-not-allowed font-medium"><i class="fas fa-chevron-right"></i></button>`}
                </div>
            </div>
        </div>
    `;
    
    container.innerHTML = mobileHTML + tableHTML;
}

// Generate page numbers
function generatePageNumbers(currentPage, totalPages) {
    let html = '';
    const maxVisible = 5;
    
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);
    
    // Show first page if not visible
    if (startPage > 1) {
        html += `
            <button onclick="loadBookings('${currentFilters.search}', '${currentFilters.status}', 1)" 
                    class="px-2 md:px-3 py-1 md:py-2 text-xs bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                1
            </button>
        `;
        if (startPage > 2) {
            html += `<span class="px-1 md:px-2 py-1 md:py-2 text-xs text-gray-400">...</span>`;
        }
    }
    
    // Show page numbers
    for (let i = startPage; i <= endPage; i++) {
        if (i === currentPage) {
            html += `
                <button class="px-2 md:px-3 py-1 md:py-2 text-xs bg-blue-600 text-white rounded-lg font-medium">
                    ${i}
                </button>
            `;
        } else {
            html += `
                <button onclick="loadBookings('${currentFilters.search}', '${currentFilters.status}', ${i})" 
                        class="px-2 md:px-3 py-1 md:py-2 text-xs bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                    ${i}
                </button>
            `;
        }
    }
    
    // Show last page if not visible
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            html += `<span class="px-1 md:px-2 py-1 md:py-2 text-xs text-gray-400">...</span>`;
        }
        html += `
            <button onclick="loadBookings('${currentFilters.search}', '${currentFilters.status}', ${totalPages})" 
                    class="px-2 md:px-3 py-1 md:py-2 text-xs bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                ${totalPages}
            </button>
        `;
    }
    
    return html;
}

// Render empty bookings
function renderEmptyBookings() {
    const container = document.getElementById('bookingsTableContainer');
    container.innerHTML = `
        <div class="p-16 text-center">
            <i class="fas fa-inbox text-6xl mb-4 text-gray-300"></i>
            <p class="text-gray-600 text-lg font-medium">Belum ada booking</p>
        </div>
    `;
}

function updateBookingStatus(element) {
    const bookingId = element.getAttribute('data-booking-id');
    // Get status from either select.value (desktop) or button data-value (mobile)
    const newStatus = element.value || element.getAttribute('data-value');
    const originalStatus = element.getAttribute('data-original-status');
    
    if (!originalStatus) {
        element.setAttribute('data-original-status', newStatus);
    }
    
    if (newStatus === 'selesai') {
        const confirmMsg = 'Status "Selesai" memerlukan foto hasil cucian.\n\nAnda akan diarahkan ke halaman detail booking untuk mengunggah foto hasil cucian.\n\nLanjutkan?';
        if (confirm(confirmMsg)) {
            window.location.href = '/admin/bookings/' + bookingId;
        } else {
            if (element.value) element.value = originalStatus;
        }
        return;
    }
    
    if (newStatus === 'ditolak' || newStatus === 'batal') {
        const confirmMsg = 'Status "Ditolak" memerlukan alasan penolakan.\n\nAnda akan diarahkan ke halaman detail booking untuk mengisi alasan.\n\nLanjutkan?';
        if (confirm(confirmMsg)) {
            window.location.href = '/admin/bookings/' + bookingId;
        } else {
            if (element.value) element.value = originalStatus;
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
            element.setAttribute('data-original-status', newStatus);
            showToast('Status berhasil diupdate', 'success');
            
            // Reload bookings with current filters
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            setTimeout(() => loadBookings(search, status), 500);
        } else {
            showToast(data.message || 'Gagal update status', 'error');
            if (element.value) element.value = originalStatus;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan koneksi', 'error');
        if (element.value) element.value = originalStatus;
    });
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
    toast.className = `fixed top-20 right-4 ${bgColors[type]} text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 z-50 animate-slide-in`;
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

// Delete booking function
function deleteBooking(id) {
    if (!confirm('Yakin ingin menghapus pesanan ini?')) {
        return;
    }
    
    fetch(`/api/admin/bookings/${id}`, {
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
            showToast('Pesanan berhasil dihapus', 'success');
            
            // Reload bookings with current filters
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            setTimeout(() => loadBookings(search, status), 500);
        } else {
            showToast(data.message || 'Gagal menghapus pesanan', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan', 'error');
    });
}

// Toggle status dropdown (for custom dropdown)
function toggleStatusDropdown(button, bookingId) {
    const menu = document.querySelector(`.dropdown-menu-${bookingId}`);
    const isHidden = menu.classList.contains('hidden');
    
    // Close all other dropdowns
    document.querySelectorAll('[class*="dropdown-menu-"]').forEach(m => m.classList.add('hidden'));
    
    if (isHidden) {
        menu.classList.remove('hidden');
    } else {
        menu.classList.add('hidden');
    }
}

// Select status from dropdown
function selectStatus(button, bookingId, newStatus) {
    // Close dropdown
    const menu = document.querySelector(`.dropdown-menu-${bookingId}`);
    menu.classList.add('hidden');
    
    // Create a pseudo-element to pass to updateBookingStatus
    const pseudo = {
        getAttribute: (attr) => {
            if (attr === 'data-booking-id') return bookingId;
            if (attr === 'data-original-status') return newStatus;
            return null;
        },
        setAttribute: () => {},
        value: newStatus
    };
    
    updateBookingStatus(pseudo);
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('[class*="relative"]')) {
        document.querySelectorAll('[class*="dropdown-menu-"]').forEach(m => m.classList.add('hidden'));
    }
});
</script>

<style>
@keyframes slide-in {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
.animate-slide-in {
    animation: slide-in 0.3s ease;
}

/* Custom dropdown styling for mobile */
@media (max-width: 768px) {
    .dropdown-menu-{booking.id} {
        min-width: 100%;
        left: 0 !important;
    }
}

/* Ensure dropdown stays within viewport */
div[class*="dropdown-menu-"] {
    z-index: 50;
}
</style>
<?= $this->endSection() ?>
