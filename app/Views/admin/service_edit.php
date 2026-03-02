<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center space-x-4 mb-4">
        <a href="/admin/services" class="text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Layanan</h1>
            <p class="text-gray-600">Update informasi layanan <?= $service['nama_layanan'] ?></p>
        </div>
    </div>
</div>

<!-- Form -->
<div class="bg-white rounded-xl shadow-lg p-8 max-w-3xl">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-6 px-4 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="mb-6 px-4 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <ul class="list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form id="serviceForm" class="space-y-6">
        <input type="hidden" id="serviceId" value="<?= $service['id'] ?>">

        <!-- Kode Layanan -->
        <div>
            <label for="kode_layanan" class="block text-sm font-medium text-gray-700 mb-2">
                Kode Layanan <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                id="kode_layanan" 
                name="kode_layanan" 
                value="<?= old('kode_layanan', $service['kode_layanan']) ?>"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="fast-cleaning"
                required
            >
            <p class="mt-1 text-sm text-gray-500">Gunakan format: huruf-kecil-dengan-tanda-hubung</p>
        </div>

        <!-- Nama Layanan -->
        <div>
            <label for="nama_layanan" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Layanan <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                id="nama_layanan" 
                name="nama_layanan" 
                value="<?= old('nama_layanan', $service['nama_layanan']) ?>"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="Fast Cleaning"
                required
            >
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi <span class="text-red-500">*</span>
            </label>
            <textarea 
                id="deskripsi" 
                name="deskripsi" 
                rows="3"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="Pembersihan cepat untuk sepatu"
                required
            ><?= old('deskripsi', $service['deskripsi']) ?></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Harga Dasar -->
            <div>
                <label for="harga_dasar" class="block text-sm font-medium text-gray-700 mb-2">
                    Harga Dasar (Rp) <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="harga_dasar_display" 
                    value="<?= number_format(old('harga_dasar', intval($service['harga_dasar'])), 0, ',', '.') ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="15.000"
                    onkeyup="formatRupiah(this)"
                    required
                >
                <input type="hidden" id="harga_dasar" name="harga_dasar" value="<?= old('harga_dasar', intval($service['harga_dasar'])) ?>">
            </div>

            <!-- Durasi Hari -->
            <div>
                <label for="durasi_hari" class="block text-sm font-medium text-gray-700 mb-2">
                    Durasi (Hari) <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    id="durasi_hari" 
                    name="durasi_hari" 
                    value="<?= old('durasi_hari', $service['durasi_hari']) ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="1"
                    min="1"
                    required
                >
            </div>
        </div>

        <!-- Status Aktif -->
        <div class="flex items-center">
            <input 
                type="checkbox" 
                id="aktif" 
                name="aktif" 
                value="1"
                <?= old('aktif', $service['aktif']) ? 'checked' : '' ?>
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
            >
            <label for="aktif" class="ml-2 text-sm font-medium text-gray-700">
                Layanan Aktif
            </label>
        </div>

        <!-- Buttons -->
        <div class="flex items-center space-x-4 pt-4">
            <button 
                type="button"
                onclick="submitServiceForm()"
                class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-medium"
            >
                <i class="fas fa-save mr-2"></i>
                Update Layanan
            </button>
            <a 
                href="/admin/services"
                class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium"
            >
                <i class="fas fa-times mr-2"></i>
                Batal
            </a>
        </div>
    </form>
</div>

<script>
function formatRupiah(input) {
    let value = input.value.replace(/\D/g, '');
    
    if (value) {
        value = parseInt(value).toLocaleString('id-ID');
        input.value = value;
        document.getElementById('harga_dasar').value = value.replace(/\./g, '');
    } else {
        input.value = '';
        document.getElementById('harga_dasar').value = '';
    }
}

// Submit form via API
async function submitServiceForm() {
    const form = document.getElementById('serviceForm');
    const serviceId = document.getElementById('serviceId').value;
    const formData = new FormData(form);
    
    // Convert FormData to JSON
    const data = {
        kode_layanan: formData.get('kode_layanan'),
        nama_layanan: formData.get('nama_layanan'),
        deskripsi: formData.get('deskripsi'),
        harga_dasar: parseInt(formData.get('harga_dasar')) || 0,
        durasi_hari: formData.get('durasi_hari') || 1,
        aktif: formData.get('aktif') ? 1 : 0
    };
    
    try {
        console.log('🚀 Updating service...', { id: serviceId, data });
        
        const response = await fetch(`/api/admin/services/${serviceId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-HTTP-Method-Override': 'PUT'
            },
            credentials: 'include',
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        console.log('✅ Response:', result);
        
        if (result.code === 200 || result.success) {
            showToast('Layanan berhasil diupdate!', 'success');
            setTimeout(() => {
                window.location.href = '/admin/services';
            }, 1500);
        } else {
            showToast(result.message || 'Gagal mengupdate layanan', 'error');
        }
    } catch (error) {
        console.error('❌ Error:', error);
        showToast('Error: ' + error.message, 'error');
    }
}

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

// Load service data from API on page load
document.addEventListener('DOMContentLoaded', async function() {
    const serviceId = document.getElementById('serviceId').value;
    
    try {
        console.log('🚀 Loading service detail from API...', { serviceId });
        
        const response = await fetch(`/api/admin/services/${serviceId}`, {
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
        console.log('✅ Service loaded:', result);
        
        if (result.data) {
            const service = result.data;
            // Populate form fields
            document.getElementById('kode_layanan').value = service.kode_layanan || '';
            document.getElementById('nama_layanan').value = service.nama_layanan || service.name || '';
            document.getElementById('deskripsi').value = service.deskripsi || service.description || '';
            document.getElementById('harga_dasar').value = service.harga_dasar || service.price || 0;
            document.getElementById('harga_dasar_display').value = (service.harga_dasar || service.price || 0).toLocaleString('id-ID');
            document.getElementById('durasi_hari').value = service.durasi_hari || 1;
            document.getElementById('aktif').checked = service.aktif ? true : false;
            
            // Update page header
            document.querySelector('.text-gray-600').textContent = `Update informasi layanan ${service.nama_layanan || service.name}`;
        }
    } catch (error) {
        console.error('❌ Error loading service:', error);
        showToast('Gagal memuat data layanan: ' + error.message, 'error');
    }
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
</style>

<?= $this->endSection() ?>
