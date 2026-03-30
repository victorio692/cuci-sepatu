<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Halaman Header -->
<div class="mb-6 md:mb-8">
    <h1 class="text-xl md:text-2xl font-bold text-gray-800 mb-1 md:mb-2">
        <i class="fas fa-file-chart-line"></i>Laporan
    </h1>
    <p class="text-xs md:text-base text-gray-600">Statistik dan laporan bisnis SYH Cleaning</p>
</div>

<!-- Filter Rentang Tanggal -->
<div class="bg-white rounded-xl shadow-lg p-3 md:p-6 mb-6 md:mb-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 md:gap-4">
        <div>
            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">Tanggal Mulai</label>
            <input 
                type="date" 
                id="startDate"
                value="<?= date('Y-m-d', strtotime('-30 days')) ?>"
                class="w-full px-3 md:px-4 py-2 md:py-2.5 text-xs md:text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" 
            >
        </div>
        <div>
            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">Tanggal Akhir</label>
            <input 
                type="date" 
                id="endDate"
                value="<?= date('Y-m-d') ?>"
                class="w-full px-3 md:px-4 py-2 md:py-2.5 text-xs md:text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" 
            >
        </div>
        <div class="flex items-end">
            <button type="button" onclick="loadReports()" class="w-full px-4 md:px-6 py-2 md:py-2.5 text-xs md:text-sm bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-medium flex items-center justify-center space-x-1 md:space-x-2">
                <i class="fas fa-filter text-xs md:text-sm"></i>
                <span>Filter</span>
            </button>
        </div>
        <div class="flex items-end">
            <!-- Split Button Export -->
            <div class="w-full relative">
                <div class="flex w-full">
                    <!-- Main Button - Export dengan format yang dipilih -->
                    <button type="button" id="exportMainBtn" onclick="doExport()" class="flex-1 px-4 md:px-6 py-2 md:py-2.5 text-xs md:text-sm bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-l-lg hover:shadow-lg hover:from-emerald-600 hover:to-emerald-700 transform hover:-translate-y-0.5 transition font-medium flex items-center justify-center space-x-1 md:space-x-2">
                        <i id="exportMainIcon" class="fas fa-file-earmark-excel text-xs md:text-sm"></i>
                        <span id="exportMainText" class="hidden sm:inline">Export Excel</span>
                        <span id="exportMainTextSmall" class="sm:hidden">Excel</span>
                    </button>
                    
                    <!-- Dropdown Trigger - untuk pilih format -->
                    <button type="button" onclick="toggleExportDropdown(event)" class="px-2 md:px-4 py-2 md:py-2.5 text-xs md:text-sm bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-r-lg hover:shadow-lg hover:from-emerald-600 hover:to-emerald-700 transform hover:-translate-y-0.5 transition font-medium border-l border-emerald-400">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                </div>
                
                <!-- Dropdown Menu - Pilihan Format -->
                <div id="exportDropdown" class="absolute hidden right-0 mt-1 w-48 bg-white rounded-lg shadow-2xl border border-gray-100 overflow-hidden z-50 transition">
                    <!-- Export PDF Option -->
                    <button type="button" onclick="selectExportFormat('pdf')" class="w-full px-4 py-3 text-left text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 flex items-center space-x-3 transition font-medium">
                        <i class="fas fa-file-earmark-pdf text-red-500"></i>
                        <div>
                            <div>Export ke PDF</div>
                            <div class="text-xs text-gray-500">Siap cetak dengan format profesional</div>
                        </div>
                    </button>
                    
                    <!-- Divider -->
                    <div class="border-t border-gray-100"></div>
                    
                    <!-- Export Excel Option -->
                    <button type="button" onclick="selectExportFormat('excel')" class="w-full px-4 py-3 text-left text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 flex items-center space-x-3 transition font-medium">
                        <i class="fas fa-file-earmark-excel text-green-500"></i>
                        <div>
                            <div>Export ke Excel</div>
                            <div class="text-xs text-gray-500">Download data terstruktur untuk analisis</div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Kartu Statistik -->
<div id="statsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 md:gap-3 mb-6 md:mb-8">
    <div class="bg-gray-100 rounded-xl shadow-lg p-3 md:p-4 animate-pulse"></div>
    <div class="bg-gray-100 rounded-xl shadow-lg p-3 md:p-4 animate-pulse"></div>
    <div class="bg-gray-100 rounded-xl shadow-lg p-3 md:p-4 animate-pulse"></div>
    <div class="bg-gray-100 rounded-xl shadow-lg p-3 md:p-4 animate-pulse"></div>
</div>

<!-- Statistik Layanan -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <!-- Header Kartu -->
    <div class="px-4 md:px-6 py-3 md:py-4 border-b border-gray-200">
        <h3 class="text-lg md:text-xl font-bold text-gray-800">Statistik Layanan</h3>
        <p class="text-xs md:text-sm text-gray-600 mt-1">Performa setiap layanan dalam periode yang dipilih</p>
    </div>

    <!-- Tabel -->
    <div id="serviceStatsContainer" class="overflow-x-auto">
        <div class="p-8 md:p-12 text-center text-gray-500">
            <i class="fas fa-spinner text-4xl md:text-5xl mb-4 text-gray-300 animate-spin"></i>
            <p class="text-sm md:text-lg">Memuat data laporan...</p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
// Load reports data from API
async function loadReports() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    if (!startDate || !endDate) {
        showToast('Pilih tanggal terlebih dahulu', 'error');
        return;
    }
    
    try {
        console.log('🚀 Loading reports from API...', { startDate, endDate });
        
        const url = `/api/admin/reports?start_date=${startDate}&end_date=${endDate}`;
        console.log('📍 API URL:', url);
        
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include'
        });
        
        console.log('📊 Response Status:', response.status);
        
        if (!response.ok) {
            const errorBody = await response.text();
            console.error('❌ API Error:', response.status, errorBody);
            throw new Error(`HTTP error! status: ${response.status} - ${errorBody}`);
        }
        
        const result = await response.json();
        console.log('✅ Full API Response:', result);
        console.log('📈 Stats:', result.data?.ringkasan);
        console.log('🏢 Service Stats:', result.data?.statistik_layanan);
        
        if (result.data) {
            renderStats(result.data.ringkasan);
            renderServiceStats(result.data.statistik_layanan);
            console.log('✅ Laporan berhasil dimuat');
        }
    } catch (error) {
        console.error('❌ Error loading reports:', error);
        showToast('Gagal memuat laporan: ' + error.message, 'error');
    }
}

// Render statistik kartu
function renderStats(ringkasan) {
    const container = document.getElementById('statsContainer');
    
    const stats = [
        {
            title: 'Total Pesanan',
            value: ringkasan.total_booking,
            color: 'from-blue-500 to-blue-600',
            icon: 'fa-shopping-bag',
            subtitle: 'Periode ini'
        },
        {
            title: 'Selesai',
            value: ringkasan.booking_selesai,
            color: 'from-green-500 to-emerald-600',
            icon: 'fa-check-circle',
            subtitle: 'Booking selesai'
        },
        {
            title: 'Menunggu Konfirmasi',
            value: ringkasan.booking_pending,
            color: 'from-blue-500 to-blue-700',
            icon: 'fa-clock',
            subtitle: 'Menunggu proses'
        },
        {
            title: 'Total Pendapatan',
            value: 'Rp ' + formatCurrency(ringkasan.total_pendapatan),
            color: 'from-purple-500 to-indigo-600',
            icon: 'fa-money-bill-wave',
            subtitle: 'Dari pesanan selesai',
            isAmount: true
        }
    ];
    
    const html = stats.map(stat => `
        <div class="bg-gradient-to-br ${stat.color} rounded-lg md:rounded-xl shadow-md p-3 md:p-4 text-white transition">
            <div class="flex flex-row items-center justify-between gap-2">
                <div class="flex-1 min-w-0">
                    <p class="opacity-90 text-xs font-semibold uppercase tracking-tight line-clamp-2">${stat.title}</p>
                    <h3 class="text-lg md:text-2xl font-bold mt-1 truncate">${stat.isAmount ? stat.value : stat.value}</h3>
                    <p class="opacity-75 text-xs mt-1 truncate">${stat.subtitle}</p>
                </div>
                <div class="w-12 h-12 md:w-14 md:h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas ${stat.icon} text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
    `).join('');
    
    container.innerHTML = html;
}

// Render tabel statistik layanan
function renderServiceStats(serviceStats) {
    const container = document.getElementById('serviceStatsContainer');
    
    if (!serviceStats || serviceStats.length === 0) {
        container.innerHTML = `
            <div class="p-8 md:p-12 text-center text-gray-500">
                <i class="fas fa-inbox text-4xl md:text-5xl mb-4 text-gray-300"></i>
                <p class="text-sm md:text-lg">Belum ada data untuk periode ini</p>
                <p class="text-xs md:text-sm mt-2">Silakan pilih periode lain atau tunggu hingga ada booking</p>
            </div>
        `;
        return;
    }
    
    const totalOrders = serviceStats.reduce((sum, s) => sum + s.jumlah, 0);
    const totalRevenue = serviceStats.reduce((sum, s) => sum + s.pendapatan, 0);
    
    // DESKTOP TABLE VIEW
    const tableRows = serviceStats.map(stat => `
        <tr class="hover:bg-gray-50 transition">
            <td class="px-4 md:px-6 py-3 md:py-4 text-sm">
                <div class="flex items-center">
                    <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-xs md:text-sm mr-2 md:mr-3 flex-shrink-0">
                        <i class="fas fa-shoe-prints text-xs"></i>
                    </div>
                    <span class="font-medium text-gray-800 truncate">${stat.layanan || '-'}</span>
                </div>
            </td>
            <td class="px-4 md:px-6 py-3 md:py-4 whitespace-nowrap text-sm">
                <span class="px-2 md:px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs md:text-sm font-medium">
                    ${stat.jumlah} order
                </span>
            </td>
            <td class="px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                <span class="font-semibold text-gray-800 text-xs md:text-sm">Rp ${formatCurrency(stat.pendapatan)}</span>
            </td>
            <td class="px-4 md:px-6 py-3 md:py-4 whitespace-nowrap">
                <span class="text-gray-700 text-xs md:text-sm">Rp ${formatCurrency(Math.round(stat.pendapatan / stat.jumlah))}</span>
            </td>
        </tr>
    `).join('');
    
    // MOBILE CARD VIEW
    const mobileCards = serviceStats.map(stat => `
        <div class="bg-white rounded-lg shadow border border-gray-100 p-4 mb-3">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center space-x-2 flex-1 min-w-0">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        <i class="fas fa-shoe-prints text-xs"></i>
                    </div>
                    <span class="font-bold text-gray-900 text-sm truncate">${stat.layanan || '-'}</span>
                </div>
            </div>
            <div class="space-y-2 text-xs">
                <div class="flex justify-between">
                    <span class="text-gray-600 font-medium">Jumlah Order:</span>
                    <span class="font-semibold text-blue-600">${stat.jumlah} pesanan</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 font-medium">Total Pendapatan:</span>
                    <span class="font-semibold text-gray-900">Rp ${formatCurrency(stat.pendapatan)}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 font-medium">Rata-rata/Pesanan:</span>
                    <span class="font-semibold text-gray-900">Rp ${formatCurrency(Math.round(stat.pendapatan / stat.jumlah))}</span>
                </div>
            </div>
        </div>
    `).join('');
    
    const html = `
        <!-- Tampilan Mobile (Kartu) -->
        <div class="block md:hidden p-4">
            ${mobileCards}
        </div>
        
        <!-- Tampilan Desktop (Tabel) -->
        <div class="hidden md:block overflow-x-auto table-responsive">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Pesanan</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pendapatan</th>
                    <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rata-rata/Pesanan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                ${tableRows}
            </tbody>
        </table>
        </div>
    `;
    
    container.innerHTML = html;
}

// Format currency
function formatCurrency(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

// Show toast notification
function showToast(message, type) {
    const bgColors = {
        'success': 'bg-green-500',
        'error': 'bg-red-500'
    };
    
    const icons = {
        'success': 'fa-check-circle',
        'error': 'fa-exclamation-circle'
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

// Load reports on page load
document.addEventListener('DOMContentLoaded', loadReports);

// Toggle Export Dropdown
function toggleExportDropdown(event) {
    if (event) {
        event.stopPropagation();
    }
    const dropdown = document.getElementById('exportDropdown');
    dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('exportDropdown');
    const dropdownContainer = event.target.closest('.relative');
    
    if (dropdownContainer && dropdownContainer.querySelector('#exportDropdown')) {
        // Clicked inside dropdown container, don't close
        return;
    }
    
    if (!dropdown.classList.contains('hidden')) {
        dropdown.classList.add('hidden');
    }
});

// Export format state (default: excel)
let currentExportFormat = 'excel';

// Select export format dan update tombol
function selectExportFormat(format) {
    currentExportFormat = format;
    updateExportButton(format);
    
    // Close dropdown
    document.getElementById('exportDropdown').classList.add('hidden');
    
    // Show notification
    const formatName = format === 'pdf' ? 'PDF' : 'Excel';
    showToast(` Format export diubah ke ${formatName}`, 'success');
}

// Update tampilan tombol utama
function updateExportButton(format) {
    const mainIcon = document.getElementById('exportMainIcon');
    const mainText = document.getElementById('exportMainText');
    const mainTextSmall = document.getElementById('exportMainTextSmall');
    
    if (format === 'pdf') {
        mainIcon.className = 'fas fa-file-earmark-pdf text-xs md:text-sm';
        if (mainText) mainText.textContent = 'Export PDF';
        if (mainTextSmall) mainTextSmall.textContent = 'PDF';
    } else {
        mainIcon.className = 'fas fa-file-earmark-excel text-xs md:text-sm';
        if (mainText) mainText.textContent = 'Export Excel';
        if (mainTextSmall) mainTextSmall.textContent = 'Excel';
    }
}

// Download dengan format saat ini
async function doExport() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    if (!startDate || !endDate) {
        showToast('Pilih tanggal terlebih dahulu', 'error');
        return;
    }
    
    const format = currentExportFormat;
    
    if (format === 'pdf') {
        // PDF Export - buka di tab baru
        console.log('📄 Exporting to PDF...', { startDate, endDate });
        window.open(`/admin/reports/print?start_date=${startDate}&end_date=${endDate}`, '_blank');
        showToast('📄 Membuka jendela baru untuk PDF...', 'success');
    } else if (format === 'excel') {
        // Excel Export
        console.log('📊 Exporting to Excel...', { startDate, endDate });
        try {
            showToast('⏳ Mempersiapkan file Excel...', 'success');
            
            const response = await fetch(`/api/admin/reports/export-excel?start_date=${startDate}&end_date=${endDate}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'include'
            });
            
            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.error || 'Gagal download Excel');
            }
            
            // Create blob and download
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `Laporan_Pesanan_${startDate}_${endDate}.csv`;
            document.body.appendChild(link);
            link.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(link);
            
            showToast('✅ Excel berhasil didownload!', 'success');
            console.log('✅ Excel export completed');
        } catch (error) {
            console.error('❌ Error export Excel:', error);
            showToast('❌ Gagal download Excel: ' + error.message, 'error');
        }
    }
}
</script>
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

@keyframes slide-down {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slide-in {
    animation: slide-in 0.3s ease;
}

/* Export Dropdown Styles */
#exportDropdown {
    animation: slide-down 0.2s ease;
    right: 0;
    min-width: 220px;
}

#exportDropdown:not(.hidden) {
    display: block;
}

#exportDropdown.hidden {
    display: none;
}

/* Split Button responsiveness */
@media (max-width: 640px) {
    .relative button {
        font-size: 0.75rem;
    }
    
    #exportDropdown {
        min-width: 180px;
        left: 50%;
        transform: translateX(-50%);
        right: auto !important;
    }
}

/* Smooth dropdown transitions */
.group:hover #exportDropdown:not(.hidden) {
    animation: slide-down 0.2s ease;
}

/* Icon colors for dropdown */
.fa-file-earmark-pdf {
    font-weight: 600;
}

.fa-file-earmark-excel {
    font-weight: 600;
}
</style>
<?= $this->endSection() ?>
