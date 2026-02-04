<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- Main Content Without Sidebar -->
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="/" class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-blue-400 hover:text-blue-600 transition-all duration-300 font-medium shadow-sm hover:shadow-md transform hover:-translate-x-1">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-6">Buat Booking Baru</h1>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                    <span class="text-green-800"><?= session()->getFlashdata('success') ?></span>
                </div>
            </div>
        <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        <span class="text-red-800"><?= session()->getFlashdata('error') ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Form -->
                <div class="lg:col-span-2">
                    <form action="/submit-booking" method="POST" id="bookingForm" enctype="multipart/form-data" class="bg-white rounded-xl shadow-lg p-6">
                        <?= csrf_field() ?>

                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Pilih Layanan</h2>

                        <!-- Service Selection -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <?php 
                        $serviceIcons = [
                            'fast-cleaning' => 'fa-running',
                            'deep-cleaning' => 'fa-socks',
                            'white-shoes' => 'fa-shoe-prints',
                            'suede-treatment' => 'fa-mitten',
                            'unyellowing' => 'fa-star'
                        ];
                        
                        // Get service from URL parameter
                        $selectedService = $_GET['service'] ?? '';
                        
                        foreach ($services as $index => $service): 
                            $icon = $serviceIcons[$service['kode_layanan']] ?? 'fa-shoe-prints';
                            // Check if this service should be selected
                            $isSelected = ($selectedService === $service['kode_layanan']) || ($index === 0 && empty($selectedService));
                        ?>
                        <!-- <?= htmlspecialchars($service['nama_layanan']) ?> -->
                        <label class="relative block cursor-pointer border-2 border-gray-200 rounded-xl p-5 transition hover:border-blue-500 hover:shadow-lg bg-white group">
                            <input type="radio" name="service" value="<?= $service['kode_layanan'] ?>" data-price="<?= intval($service['harga_dasar']) ?>" <?= $isSelected ? 'checked' : '' ?> <?= $index === 0 ? 'required' : '' ?> class="absolute opacity-0">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900"><?= htmlspecialchars($service['nama_layanan']) ?></h3>
                                    <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($service['deskripsi']) ?></p>
                                </div>
                                <i class="fas <?= $icon ?> text-blue-500 text-xl"></i>
                            </div>
                            <div class="mt-3">
                                <span class="text-blue-600 font-semibold text-lg">Rp <?= number_format($service['harga_dasar'], 0, ',', '.') ?></span>
                                <span class="text-gray-400 text-sm">/pasang</span>
                            </div>
                            <div class="text-gray-400 text-xs mt-2"><?= $service['durasi_hari'] ?> hari pengerjaan</div>
                        </label>
                        <?php endforeach; ?>
                        </div>

                    <!-- Hidden fields for shoe details -->
                    <input type="hidden" name="shoe_type" value="sneaker">
                    <input type="hidden" name="shoe_condition" value="normal">

                    <h2 class="text-2xl font-bold text-gray-900 mb-6 mt-8">Detail Pesanan</h2>

                    <!-- Jumlah Sepatu -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Jumlah Sepatu</label>
                        <div class="flex items-center gap-4">
                            <button type="button" id="btnMinus" class="ripple w-10 h-10 border-2 border-gray-300 bg-white rounded-lg hover:border-blue-500 hover:bg-blue-50 hover:text-blue-600 transition flex items-center justify-center">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input 
                                type="number" 
                                id="quantity" 
                                name="quantity" 
                                value="1" 
                                min="1"
                                readonly
                                class="w-20 text-center border border-gray-300 rounded-lg py-2 text-lg font-semibold focus:outline-none focus:border-blue-500"
                                required
                            >
                            <button type="button" id="btnPlus" class="ripple w-10 h-10 border-2 border-gray-300 bg-white rounded-lg hover:border-blue-500 hover:bg-blue-50 hover:text-blue-600 transition flex items-center justify-center">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Opsi Pengiriman -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-3">
                            <i class="fas fa-shipping-fast text-blue-500 mr-1"></i> Opsi Pengiriman <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Ambil di Tempat -->
                            <label class="delivery-option relative block cursor-pointer border-2 border-gray-300 rounded-lg p-4 transition hover:border-blue-500 hover:shadow-md bg-white">
                                <input type="radio" name="delivery_option" value="pickup" checked required class="absolute opacity-0">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-store text-blue-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Ambil di Tempat</h4>
                                        <p class="text-sm text-gray-600">Ambil sendiri di SYH.CLEANING</p>
                                    </div>
                                </div>
                            </label>

                            <!-- Diantar ke Rumah -->
                            <label class="delivery-option relative block cursor-pointer border-2 border-gray-300 rounded-lg p-4 transition hover:border-blue-500 hover:shadow-md bg-white">
                                <input type="radio" name="delivery_option" value="delivery" required class="absolute opacity-0">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-home text-green-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Diantar ke Rumah</h4>
                                        <p class="text-sm text-gray-600">Kami antar ke alamat Anda</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Alamat Pengiriman (conditional) -->
                    <div id="deliveryAddressSection" class="mb-6 hidden">
                        <label for="delivery_address" class="block text-gray-700 font-medium mb-2">
                            <i class="fas fa-map-marker-alt text-green-500 mr-1"></i> Alamat Pengiriman <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="delivery_address" 
                            name="delivery_address" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                            rows="3" 
                            placeholder="Masukkan alamat lengkap untuk pengiriman..."
                        ></textarea>
                        <small class="text-gray-500 text-sm mt-1 block">
                            <i class="fas fa-info-circle"></i> Pastikan alamat lengkap dan jelas agar sepatu dapat diantar dengan tepat
                        </small>
                    </div>

                    <!-- Tanggal Masuk -->
                    <div class="mb-6">
                        <label for="delivery_date" class="block text-gray-700 font-medium mb-2">Tanggal masuk</label>
                        <input 
                            type="date" 
                            id="delivery_date" 
                            name="delivery_date" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required
                        >
                    </div>

                    <!-- Jam Booking -->
                    <div class="mb-6">
                        <label for="booking_time" class="block text-gray-700 font-medium mb-2">Jam Booking</label>
                        <input 
                            type="time" 
                            id="booking_time" 
                            name="booking_time" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required
                        >
                        <small class="text-gray-500 text-sm mt-1 block">
                            Waktu saat ini: <span id="currentTime"></span>
                        </small>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-6">
                        <label for="notes" class="block text-gray-700 font-medium mb-2">Catatan</label>
                        <textarea 
                            id="notes" 
                            name="notes" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                            rows="4" 
                            placeholder="Tulis catatan di sini..."
                        ></textarea>
                    </div>

                    <!-- Foto Sepatu -->
                    <div class="mb-8">
                        <label class="block text-gray-700 font-medium mb-2">
                            Foto Sepatu <span class="text-red-500">*</span>
                        </label>
                        <input type="file" id="shoe_photo" name="shoe_photo" accept="image/png,image/jpeg,image/jpg" required class="hidden">
                        
                        <div id="uploadArea" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center bg-gray-50 transition hover:border-blue-500 hover:bg-blue-50">
                            <div class="mb-4">
                                <i class="fas fa-image text-6xl text-blue-500"></i>
                            </div>
                            <p class="text-gray-800 font-medium mb-1">Upload Foto Sepatu Anda</p>
                            <p class="text-gray-600 text-sm mb-4">PNG, JPG, JPEG (Maks. 5 MB)</p>
                            
                            <button type="button" onclick="document.getElementById('shoe_photo').click()" class="ripple inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
                                <i class="fas fa-camera"></i> Pilih Foto
                            </button>
                            
                            <p class="text-gray-400 text-xs mt-4">
                                <i class="fas fa-hand-pointer"></i> atau seret file kesini
                            </p>
                            <p class="text-red-500 text-sm mt-2">
                                <i class="fas fa-exclamation-circle"></i> Wajib upload foto sepatu
                            </p>
                        </div>
                        
                        <div id="imagePreview" class="hidden mt-4">
                            <div class="relative inline-block">
                                <img id="previewImg" src="" class="max-w-full max-h-80 rounded-lg border-2 border-blue-500 shadow-lg">
                                <div class="absolute -top-2 -right-2">
                                    <button type="button" onclick="removeImage()" class="ripple w-8 h-8 bg-red-500 text-white rounded-full hover:bg-red-600 flex items-center justify-center border-2 border-white shadow-md transition hover:scale-110">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <button type="button" onclick="document.getElementById('shoe_photo').click()" class="ripple inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                                    <i class="fas fa-sync-alt"></i> Ganti Foto
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="ripple w-full px-8 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-bold text-lg hover:shadow-xl transform hover:-translate-y-0.5 transition">
                        <i class="fas fa-check-circle mr-2"></i> Buat Booking
                    </button>
                </form>
            </div>

            <!-- Right Column: Summary -->
            <div>
                <div class="bg-white rounded-xl shadow-lg sticky top-8 overflow-hidden transition-all duration-300 hover:shadow-2xl">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-t-xl p-6">
                        <h3 class="text-xl font-bold flex items-center gap-2">
                            <i class="fas fa-clipboard-list"></i> Ringkasan Booking
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Layanan</span>
                                <span id="summaryService" class="font-semibold text-gray-900">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Harga/Sepatu</span>
                                <span id="summaryPrice" class="font-semibold text-gray-900">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Jumlah</span>
                                <span id="summaryQuantity" class="font-semibold text-gray-900">1 pasang</span>
                            </div>
                        </div>
                        
                        <hr class="border-gray-300 my-4">
                        
                        <div class="flex justify-between items-center mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200 transition-all duration-300 hover:shadow-md">
                            <span class="font-bold text-gray-900 text-xl">Total</span>
                            <span id="summaryTotal" class="font-bold text-blue-600 text-2xl">Rp 0</span>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex gap-3">
                                <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                <p class="text-blue-900 text-sm">
                                    Anda dapat booking untuk hari ini atau hari lainnya. Untuk konfirmasi lebih lanjut hubungi kami.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<style>
/* Button Animation Styles */
button, a.inline-flex {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

button:active, a.inline-flex:active {
    transform: scale(0.95);
}

button:hover:not(:disabled), a.inline-flex:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

/* Gradient Button Glow Effect */
button.bg-gradient-to-r:hover,
button[type="submit"]:hover {
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.6), 0 10px 25px rgba(0, 0, 0, 0.15);
}

/* Red Button Glow */
.bg-red-500:hover {
    box-shadow: 0 0 15px rgba(239, 68, 68, 0.6), 0 5px 15px rgba(0, 0, 0, 0.15);
}

/* Service and Delivery Cards Animation */
label {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

label:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
}

label:active {
    transform: scale(0.98);
}

/* Ripple Effect */
@keyframes ripple {
    0% {
        transform: scale(0);
        opacity: 1;
    }
    100% {
        transform: scale(4);
        opacity: 0;
    }
}

.ripple {
    position: relative;
    overflow: hidden;
}

.ripple::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    background: rgba(255, 255, 255, 0.5);
    border-radius: 50%;
    transform: scale(0);
    pointer-events: none;
}

.ripple:active::after {
    animation: ripple 0.6s ease-out;
}

/* Pulse Animation for Selected Items */
@keyframes pulse {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.5);
    }
    50% {
        box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
    }
}

/* Sidebar Menu Animation */
aside ul li a {
    transition: all 0.3s ease;
    position: relative;
}

aside ul li a:hover {
    transform: translateX(5px);
}

aside ul li a:active {
    transform: scale(0.97);
}

/* Total Section Highlight */
#summaryTotal {
    transition: all 0.3s ease;
}

#summaryTotal:hover {
    transform: scale(1.05);
}

/* Smooth transitions for all elements */
* {
    -webkit-tap-highlight-color: transparent;
}

/* Smooth Scroll */
html {
    scroll-behavior: smooth;
}

/* Loading State for Buttons */
button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

button.loading {
    position: relative;
    color: transparent;
}

button.loading::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-left: -8px;
    margin-top: -8px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spinner 0.6s linear infinite;
}

@keyframes spinner {
    to {
        transform: rotate(360deg);
    }
}

/* Shake Animation for Errors */
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

.shake {
    animation: shake 0.5s ease-in-out;
}

/* Fade In Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 0.5s ease-out;
}

/* Selected service card styling */
label:has(input[type="radio"]:checked) {
    border-color: #3b82f6 !important;
    background-color: #eff6ff !important;
    animation: pulse 2s infinite;
}

label:has(input[type="radio"]:checked)::after {
    content: '\f058';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    top: 1rem;
    right: 1rem;
    color: #3b82f6;
    font-size: 1.5rem;
}

/* Delivery option styling */
.delivery-option:has(input[type="radio"]:checked) {
    border-color: #3b82f6 !important;
    background-color: #eff6ff !important;
}

.delivery-option:has(input[type="radio"]:checked)::after {
    content: '\f058';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    color: #3b82f6;
    font-size: 1.25rem;
}
</style>

<script>
// Quantity buttons
document.getElementById('btnMinus').addEventListener('click', () => {
    const input = document.getElementById('quantity');
    const value = parseInt(input.value);
    if (value > 1) {
        input.value = value - 1;
        updateSummary();
    }
});

document.getElementById('btnPlus').addEventListener('click', () => {
    const input = document.getElementById('quantity');
    const value = parseInt(input.value);
    input.value = value + 1;
    updateSummary();
});

// Quantity input change
document.getElementById('quantity').addEventListener('change', updateSummary);
document.getElementById('quantity').addEventListener('input', updateSummary);

// Service selection
const serviceRadios = document.querySelectorAll('input[name="service"]');
serviceRadios.forEach(radio => {
    radio.addEventListener('change', updateSummary);
});

// Delivery option handling
const deliveryOptions = document.querySelectorAll('input[name="delivery_option"]');
const deliveryAddressSection = document.getElementById('deliveryAddressSection');
const deliveryAddressInput = document.getElementById('delivery_address');

deliveryOptions.forEach(option => {
    option.addEventListener('change', function() {
        if (this.value === 'delivery') {
            deliveryAddressSection.classList.remove('hidden');
            deliveryAddressInput.required = true;
        } else {
            deliveryAddressSection.classList.add('hidden');
            deliveryAddressInput.required = false;
            deliveryAddressInput.value = '';
        }
    });
});

// Update summary with animation
function updateSummary() {
    const selectedService = document.querySelector('input[name="service"]:checked');
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    
    const summaryTotal = document.getElementById('summaryTotal');
    const summaryService = document.getElementById('summaryService');
    const summaryPrice = document.getElementById('summaryPrice');
    const summaryQuantity = document.getElementById('summaryQuantity');
    
    if (selectedService) {
        const price = parseInt(selectedService.dataset.price);
        const total = price * quantity;
        
        // Get service name - perbaikan: label langsung parent dari input
        const serviceLabel = selectedService.closest('label');
        const serviceName = serviceLabel.querySelector('h3').textContent;
        
        // Add fade animation
        [summaryTotal, summaryService, summaryPrice, summaryQuantity].forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(10px)';
        });
        
        setTimeout(() => {
            summaryService.textContent = serviceName;
            summaryPrice.textContent = 'Rp ' + price.toLocaleString('id-ID');
            summaryQuantity.textContent = quantity + ' pasang';
            summaryTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
            
            [summaryTotal, summaryService, summaryPrice, summaryQuantity].forEach((el, index) => {
                setTimeout(() => {
                    el.style.transition = 'all 0.3s ease-out';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 50);
            });
        }, 150);
    } else {
        // Jika belum ada layanan dipilih
        summaryService.textContent = '-';
        summaryPrice.textContent = 'Rp 0';
        summaryQuantity.textContent = quantity + ' pasang';
        summaryTotal.textContent = 'Rp 0';
    }
}

// Set minimum date (today)
const today = new Date();
document.getElementById('delivery_date').min = today.toISOString().split('T')[0];

// Update current time every second
function updateCurrentTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    document.getElementById('currentTime').textContent = `${hours}:${minutes}:${seconds}`;
}

updateCurrentTime();
setInterval(updateCurrentTime, 1000);

// Set default time to current time
const now = new Date();
const currentHours = String(now.getHours()).padStart(2, '0');
const currentMinutes = String(now.getMinutes()).padStart(2, '0');
document.getElementById('booking_time').value = `${currentHours}:${currentMinutes}`;

// Form submission
document.getElementById('bookingForm').addEventListener('submit', (e) => {
    const selectedService = document.querySelector('input[name="service"]:checked');
    if (!selectedService) {
        e.preventDefault();
        alert('Pilih layanan terlebih dahulu');
        // Scroll to service section with shake animation
        const serviceSection = document.querySelector('[name="service"]').closest('.grid');
        serviceSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
        serviceSection.classList.add('shake');
        setTimeout(() => serviceSection.classList.remove('shake'), 500);
        return;
    }
    
    const shoePhoto = document.getElementById('shoe_photo');
    if (!shoePhoto.files || shoePhoto.files.length === 0) {
        e.preventDefault();
        alert('Wajib upload foto sepatu terlebih dahulu');
        const photoSection = document.getElementById('uploadArea');
        photoSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
        photoSection.classList.add('shake');
        setTimeout(() => photoSection.classList.remove('shake'), 500);
        return;
    }
    
    // Check delivery address if delivery option is selected
    const deliveryOption = document.querySelector('input[name="delivery_option"]:checked');
    if (deliveryOption && deliveryOption.value === 'delivery') {
        const deliveryAddress = document.getElementById('delivery_address').value.trim();
        if (!deliveryAddress) {
            e.preventDefault();
            alert('Alamat pengiriman wajib diisi jika memilih opsi Diantar ke Rumah');
            const addressInput = document.getElementById('delivery_address');
            addressInput.focus();
            addressInput.classList.add('shake');
            setTimeout(() => addressInput.classList.remove('shake'), 500);
            return;
        }
    }
    
    // Add loading state to submit button
    const submitBtn = e.target.querySelector('button[type="submit"]');
    submitBtn.classList.add('loading');
    submitBtn.disabled = true;
});

// File upload handling
const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('shoe_photo');
const imagePreview = document.getElementById('imagePreview');
const previewImg = document.getElementById('previewImg');

fileInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Check file size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file maksimal 5 MB');
            fileInput.value = '';
            uploadArea.classList.add('shake');
            setTimeout(() => uploadArea.classList.remove('shake'), 500);
            return;
        }
        
        // Check file type
        if (!file.type.match('image/(png|jpeg|jpg)')) {
            alert('Format file harus PNG, JPG, atau JPEG');
            fileInput.value = '';
            uploadArea.classList.add('shake');
            setTimeout(() => uploadArea.classList.remove('shake'), 500);
            return;
        }
        
        // Show preview with animation
        const reader = new FileReader();
        reader.onload = function(event) {
            previewImg.src = event.target.result;
            uploadArea.style.display = 'none';
            imagePreview.classList.remove('hidden');
            imagePreview.classList.add('fade-in');
            imagePreview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

// Remove image
function removeImage() {
    fileInput.value = '';
    uploadArea.style.display = 'block';
    imagePreview.style.display = 'none';
    previewImg.src = '';
}

// Drag and drop
uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '#3b82f6';
    uploadArea.style.background = '#eff6ff';
});

uploadArea.addEventListener('dragleave', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '#e5e7eb';
    uploadArea.style.background = '#f9fafb';
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '#e5e7eb';
    uploadArea.style.background = '#f9fafb';
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        fileInput.dispatchEvent(new Event('change'));
    }
});

// Auto-select service from URL parameter and Initialize
window.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const serviceParam = urlParams.get('service');
    
    if (serviceParam) {
        const serviceRadio = document.querySelector(`input[name="service"][value="${serviceParam}"]`);
        if (serviceRadio) {
            serviceRadio.checked = true;
            // Trigger change event to update summary
            updateSummary();
            // Add visual feedback - scroll to service section
            serviceRadio.closest('label').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    } else {
        // If no URL parameter, check if there are services and update summary anyway
        const checkedService = document.querySelector('input[name="service"]:checked');
        if (checkedService) {
            updateSummary();
        } else {
            // Initialize with default state
            updateSummary();
        }
    }
});

// Logout confirmation
function confirmLogout(e) {
    e.preventDefault();
    if (confirm('Apakah Anda yakin ingin logout?')) {
        window.location.href = '/logout';
    }
}
</script>
<?= $this->endSection() ?>
