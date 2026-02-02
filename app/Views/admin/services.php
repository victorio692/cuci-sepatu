<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Layanan</h1>
    <p class="text-gray-600">Kelola layanan dan harga SYH Cleaning</p>
</div>

<!-- Services Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($services as $service): ?>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition">
            <!-- Service Header with Gradient -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white">
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-<?= $service['icon'] ?> text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2"><?= $service['name'] ?></h3>
                <p class="text-blue-100 text-sm"><?= $service['description'] ?></p>
            </div>

            <!-- Service Body -->
            <div class="p-6">
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-600 font-medium">Harga Layanan</span>
                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-medium">Per Pasang</span>
                    </div>
                    <div class="text-3xl font-bold text-gray-800">
                        Rp <?= number_format($service['price'], 0, ',', '.') ?>
                    </div>
                </div>

                <button 
                    onclick="openEditPrice('<?= $service['id'] ?>', '<?= $service['name'] ?>', <?= $service['price'] ?>)"
                    class="w-full px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-medium flex items-center justify-center space-x-2"
                >
                    <i class="fas fa-edit"></i>
                    <span>Ubah Harga</span>
                </button>
            </div>
        </div>
    <?php endforeach; ?>
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
function openEditPrice(serviceId, serviceName, currentPrice) {
    document.getElementById('serviceId').value = serviceId;
    document.getElementById('serviceName').textContent = serviceName;
    document.getElementById('newPrice').value = currentPrice;
    const modal = document.getElementById('priceModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closePriceModal() {
    const modal = document.getElementById('priceModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.getElementById('priceForm').reset();
}

document.getElementById('priceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const serviceId = document.getElementById('serviceId').value;
    const price = document.getElementById('newPrice').value;

    fetch('/admin/services/price', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ service: serviceId, price: price })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Harga berhasil diperbarui', 'success');
            closePriceModal();
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Gagal memperbarui harga', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan koneksi', 'error');
    });
});

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    const modal = document.getElementById('priceModal');
    if (event.target === modal) {
        closePriceModal();
    }
});

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
</style>
<?= $this->endSection() ?>
