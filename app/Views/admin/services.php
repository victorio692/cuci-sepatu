<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md flex items-center" role="alert">
        <i class="fas fa-check-circle text-2xl mr-3"></i>
        <div>
            <p class="font-semibold">Berhasil!</p>
            <p><?= session()->getFlashdata('success') ?></p>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md flex items-center" role="alert">
        <i class="fas fa-exclamation-circle text-2xl mr-3"></i>
        <div>
            <p class="font-semibold">Gagal!</p>
            <p><?= session()->getFlashdata('error') ?></p>
        </div>
    </div>
<?php endif; ?>

<!-- Page Header -->
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Layanan</h1>
        <p class="text-gray-600">Kelola layanan dan harga SYH Cleaning</p>
    </div>
    <a href="/admin/services/create" class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-medium flex items-center space-x-2">
        <i class="fas fa-plus"></i>
        <span>Tambah Layanan</span>
    </a>
</div>

<!-- Services Grid -->
<div id="servicesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Loading State -->
    <div class="col-span-full flex justify-center py-12">
        <div class="animate-spin flex items-center justify-center">
            <i class="fas fa-spinner text-blue-500 text-4xl"></i>
        </div>
    </div>
</div>

<!-- Edit Price Modal -->
<div id="priceModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">
                Ubah Harga - <span id="serviceName" class="text-blue-600"></span>
            </h2>
            <button onclick="closePriceModal()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="priceForm" class="p-6">
            <input type="hidden" id="serviceId" name="service_id">
            
            <div class="mb-6">
                <label for="newPrice" class="block text-sm font-medium text-gray-700 mb-2">
                    Harga Baru (Rupiah)
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                    <input 
                        type="number" 
                        id="newPrice" 
                        name="price" 
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-lg font-semibold"
                        placeholder="0"
                        min="0"
                        step="1000"
                        required
                    >
                </div>
                <p class="mt-2 text-xs text-gray-500">
                    <i class="fas fa-info-circle"></i> Minimal kelipatan Rp 1.000
                </p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-medium flex items-center justify-center space-x-2">
                    <i class="fas fa-save"></i>
                    <span>Simpan</span>
                </button>
                <button type="button" onclick="closePriceModal()" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
// Load services from API
async function loadServices() {
    const container = document.getElementById('servicesContainer');
    
    try {
        console.log('🚀 Loading services from API...');
        const response = await fetch('/api/admin/services', {
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
        console.log('✅ Services loaded:', result);

        if (result.data && result.data.length > 0) {
            renderServicesGrid(result.data);
        } else {
            renderEmptyState();
        }
    } catch (error) {
        console.error('❌ Error loading services:', error);
        container.innerHTML = `
            <div class="col-span-full bg-red-50 rounded-xl shadow-lg p-12 text-center">
                <i class="fas fa-exclamation-circle text-red-500 text-6xl mb-4"></i>
                <h3 class="text-xl font-bold text-red-700 mb-2">Gagal Memuat Layanan</h3>
                <p class="text-red-600 mb-4">${error.message}</p>
                <button onclick="loadServices()" 
                        class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition">
                    <i class="fas fa-redo mr-2"></i>Coba Lagi
                </button>
            </div>
        `;
    }
}

// Render services grid
function renderServicesGrid(services) {
    const container = document.getElementById('servicesContainer');
    
    const html = services.map(service => {
        // Check if service has an image
        const hasImage = service.icon_type === 'image' && service.icon;
        const backgroundStyle = hasImage 
            ? `background-image: url('${service.icon.startsWith('http') ? service.icon : '/' + service.icon}'); background-size: cover; background-position: center;`
            : `background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);`;
        
        const overlayClass = hasImage ? 'bg-black/35' : '';
        const durationText = (service.durasi_hari || service.duration || 1) == 1 ? '1 hari' : `1-${service.durasi_hari || service.duration || 1} hari`;
        
        return `
        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all overflow-hidden border border-gray-200 h-full flex flex-col service-card">
            <!-- Service Header with Background Image (h-40) -->
            <div class="relative h-40 overflow-hidden flex items-center justify-center" style="${backgroundStyle}">
                <!-- Overlay for better text readability -->
                <div class="absolute inset-0 ${overlayClass} transition"></div>
            </div>
            
            <!-- White Content Area - Horizontal Layout -->
            <div class="p-6 flex-1 flex flex-col justify-between">
                <!-- Row 1: Nama Layanan (left) | Harga (right) -->
                <div class="flex justify-between items-start mb-3 pb-3 border-b border-gray-200">
                    <!-- Nama Layanan -->
                    <h3 class="text-xl font-bold text-gray-800 line-clamp-1 flex-1">${service.name || service.nama_layanan}</h3>
                    <!-- Harga -->
                    <p class="text-2xl font-bold text-blue-600 ml-4 whitespace-nowrap">Rp ${formatCurrency(service.harga_dasar || service.base_price || service.price || 0)}</p>
                </div>

                <!-- Row 2: Deskripsi (left) | Durasi (right) -->
                <div class="flex justify-between items-start mb-4 pb-4 border-b border-gray-200 flex-1">
                    <!-- Deskripsi -->
                    <p class="text-sm text-gray-600 line-clamp-2 flex-1">${service.description || service.deskripsi || 'Tidak ada deskripsi'}</p>
                    <!-- Durasi -->
                    <p class="text-xs text-gray-600 ml-4 whitespace-nowrap">⏱️ ${durationText}</p>
                </div>

                <!-- Row 3: 3 Action Buttons -->
                <div class="grid grid-cols-3 gap-3">
                    <button type="button" 
                       onclick="openEditPrice(${service.id}, '${(service.name || service.nama_layanan || '').replace(/'/g, "\\'")}', ${service.harga_dasar || service.base_price || service.price || 0})"
                       class="py-2 px-4 bg-yellow-500 hover:bg-yellow-600 text-white rounded font-semibold text-sm transition flex items-center justify-center"
                       title="Edit Harga">
                        Edit
                    </button>
                    <a href="/admin/services/edit/${service.id}" 
                       class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded font-semibold text-sm transition flex items-center justify-center"
                       title="Detail/Edit">
                        Detail
                    </a>
                    <button type="button" 
                       onclick="deleteService(${service.id}, '${(service.name || service.nama_layanan || '').replace(/'/g, "\\'")}')"
                       class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white rounded font-semibold text-sm transition flex items-center justify-center"
                       title="Hapus">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
        `;
    }).join('');
    
    container.innerHTML = html;
}

// Render empty state
function renderEmptyState() {
    const container = document.getElementById('servicesContainer');
    container.innerHTML = `
        <div class="col-span-full bg-blue-50 rounded-xl shadow-lg p-12 text-center">
            <i class="fas fa-inbox text-blue-500 text-6xl mb-4"></i>
            <h3 class="text-xl font-bold text-blue-700 mb-2">Tidak Ada Layanan</h3>
            <p class="text-blue-600 mb-4">Belum ada layanan yang terdaftar. Silakan buat layanan baru.</p>
        </div>
    `;
}

// Format currency
function formatCurrency(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

// Load services on page load
document.addEventListener('DOMContentLoaded', loadServices);

// Confirm delete function
function confirmDelete(serviceId, serviceName) {
    if (confirm('Yakin ingin menghapus layanan "' + serviceName + '"?\n\nLayanan yang sudah digunakan dalam pesanan tidak dapat dihapus.')) {
        // Create form dynamically
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/services/delete/' + serviceId;
        
        // Add CSRF token if using CSRF protection
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = csrfToken.content;
            form.appendChild(csrfInput);
        }
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Delete service with API
function deleteService(serviceId, serviceName) {
    // Show confirmation dialog
    const confirmDelete = confirm(`Yakin ingin menghapus layanan "${serviceName}"?\n\n`);
    
    if (!confirmDelete) {
        return;
    }

    fetch(`/api/admin/services/${serviceId}`, {
        method: 'DELETE',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Delete response:', data);
        
        if (data.code === 200) {
            showToast('Layanan berhasil dihapus', 'success');
            setTimeout(() => {
                loadServices();
            }, 1000);
        } else {
            showToast(data.message || 'Gagal menghapus layanan', 'error');
        }
    })
    .catch(error => {
        console.error('Error deleting service:', error);
        showToast('Terjadi kesalahan: ' + error.message, 'error');
    });
}

// Open edit price modal
function openEditPrice(serviceId, serviceName, currentPrice) {
    document.getElementById('serviceId').value = serviceId;
    document.getElementById('serviceName').textContent = serviceName;
    document.getElementById('newPrice').value = currentPrice;
    const modal = document.getElementById('priceModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

// Close price modal
function closePriceModal() {
    const modal = document.getElementById('priceModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.getElementById('priceForm').reset();
}

// Handle price form submission
document.getElementById('priceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const serviceId = document.getElementById('serviceId').value;
    const price = document.getElementById('newPrice').value;

    fetch(`/api/admin/services/${serviceId}/price`, {
        method: 'POST',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-HTTP-Method-Override': 'PUT'
        },
        body: JSON.stringify({ harga: price })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('✅ Price updated:', data);
        if (data.code === 200 || data.success) {
            showToast('Harga berhasil diperbarui', 'success');
            closePriceModal();
            setTimeout(() => loadServices(), 1000);
        } else {
            showToast(data.message || 'Gagal memperbarui harga', 'error');
        }
    })
    .catch(error => {
        console.error('❌ Error updating price:', error);
        showToast('Terjadi kesalahan koneksi: ' + error.message, 'error');
    });
});

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    const modal = document.getElementById('priceModal');
    if (event.target === modal) {
        closePriceModal();
    }
});

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

/* Service Card Styling */
.service-card {
    transition: all 0.3s ease;
}

.service-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
}

/* Responsive Grid - 3 columns */
@media (max-width: 640px) {
    #servicesContainer {
        grid-template-columns: 1fr;
    }
}

@media (min-width: 641px) and (max-width: 1024px) {
    #servicesContainer {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1025px) {
    #servicesContainer {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* Line clamping for older browsers */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Button hover effects */
.service-card button {
    transition: all 0.2s ease;
}

.service-card button:hover {
    transform: scale(1.05);
}

/* Background image styling */
.service-card .h-40 {
    position: relative;
}

/* Overlay opacity handling */
.bg-black\/40 {
    background-color: rgba(0, 0, 0, 0.4);
}

/* Select dropdown styling */
select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    padding-right: 2.5rem;
}

/* Input focus state */
input:focus, select:focus {
    outline: none;
}
</style>
<?= $this->endSection() ?>
