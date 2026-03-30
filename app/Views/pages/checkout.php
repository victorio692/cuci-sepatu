<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="min-h-screen bg-gray-50 py-6 sm:py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-4 sm:mb-6">
            <a href="/cart" class="inline-flex items-center gap-2 px-3 py-2 sm:px-4 sm:py-2 bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-blue-400 hover:text-blue-600 transition-all duration-300 font-medium shadow-sm hover:shadow-md transform hover:-translate-x-1 text-sm sm:text-base">
                <i class="fas fa-arrow-left"></i> Kembali ke Keranjang
            </a>
        </div>

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 sm:mb-6">
            <i class="fas fa-credit-card text-blue-600 mr-2"></i> Checkout
        </h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Section -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Opsi Barang Masuk -->
                <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 mb-6">
                    <span class="block text-gray-700 font-medium mb-3">
                        <i class="fas fa-box text-purple-500 mr-1"></i> Opsi Barang Masuk <span class="text-red-500">*</span>
                    </span>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Diantar ke Tempat -->
                        <label class="item-entry-option relative block cursor-pointer border-2 border-gray-300 rounded-lg p-4 transition hover:border-blue-500 hover:shadow-md bg-white">
                            <input type="radio" name="item_entry_option" value="dropoff" checked required class="absolute opacity-0">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user-check text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Diantar ke Tempat</h4>
                                    <p class="text-sm text-gray-600">Saya antar barang ke SYH.CLEANING</p>
                                </div>
                            </div>
                        </label>

                        <!-- Dijemput -->
                        <label class="item-entry-option relative block cursor-pointer border-2 border-gray-300 rounded-lg p-4 transition hover:border-blue-500 hover:shadow-md bg-white">
                            <input type="radio" name="item_entry_option" value="pickup" required class="absolute opacity-0">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-truck text-indigo-600 text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Dijemput</h4>
                                    <p class="text-sm text-gray-600">Tim kami jemput barang Anda</p>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Jam Antar/Jemput (di dalam section Opsi Barang Masuk) -->
                    <div class="mt-4">
                        <span id="bookingTimeLabel" for="booking_time" class="block text-gray-700 font-medium mb-2">
                            <i class="fas fa-clock text-blue-500 mr-1"></i>
                            <span id="timeLabelText">Jam Antar</span> <span class="text-red-500">*</span>
                        </span>
                        <input 
                            type="text" 
                            id="booking_time" 
                            name="booking_time" 
                            placeholder="HH:MM (contoh: 14:30)"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            pattern="([01][0-9]|2[0-3]):[0-5][0-9]"
                            required
                        >
                        <small class="text-gray-500 text-sm mt-1 block">
                            <i class="fas fa-info-circle mr-1"></i>
                            Waktu saat ini: <span id="currentTime"></span> | <span id="suggestedTime" class="text-blue-600 font-medium cursor-pointer" onclick="useCurrentTime()">Gunakan waktu saat ini</span>
                        </small>
                    </div>
                </div>

                <!-- Alamat Penjemputan (conditional) -->
                <div id="pickupAddressSection" class="bg-white rounded-xl shadow-lg p-4 sm:p-6 mb-6 hidden">
                    <span for="pickup_address" class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-map-marker-alt text-indigo-500 mr-1"></i> Alamat Penjemputan <span class="text-red-500">*</span>
                    </span>
                    <textarea 
                        id="pickup_address" 
                        name="pickup_address" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                        rows="3" 
                        placeholder="Masukkan alamat lengkap untuk penjemputan..."
                    ></textarea>
                    <small class="text-gray-500 text-sm mt-1 block">
                        <i class="fas fa-info-circle"></i> Pastikan alamat lengkap dan jelas agar barang dapat dijemput dengan tepat
                    </small>
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mt-3">
                        <div class="flex gap-2">
                            <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5 text-sm"></i>
                            <p class="text-amber-800 text-sm">
                                <span class="font-semibold">Biaya penjemputan: Rp 5.000</span> diterapkan untuk 1 sepatu. Gratis untuk 2 sepatu atau lebih.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Opsi Pengiriman -->
                <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 mb-6">
                    <span class="block text-gray-700 font-medium mb-3">
                        <i class="fas fa-shipping-fast text-blue-500 mr-1"></i> Opsi Pengiriman <span class="text-red-500">*</span>
                    </span>
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
                <div id="deliveryAddressSection" class="bg-white rounded-xl shadow-lg p-4 sm:p-6 mb-6 hidden">
                    <span for="delivery_address" class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-map-marker-alt text-green-500 mr-1"></i> Alamat Pengiriman <span class="text-red-500">*</span>
                    </span>
                    <textarea 
                        id="delivery_address" 
                        name="delivery_address" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                        rows="3" 
                        placeholder="Masukkan alamat lengkap untuk pengiriman..."
                    ><?= $user['address'] ?? $user['alamat'] ?? '' ?></textarea>
                    <small class="text-gray-500 text-sm mt-1 block">
                        <i class="fas fa-info-circle"></i> Pastikan alamat lengkap dan jelas agar sepatu dapat diantar dengan tepat
                    </small>
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mt-3">
                        <div class="flex gap-2">
                            <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5 text-sm"></i>
                            <p class="text-amber-800 text-sm">
                                <span class="font-semibold">Biaya pengiriman: Rp 5.000</span> diterapkan untuk 1 sepatu. Gratis untuk 2 sepatu atau lebih.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Booking -->
                <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">Informasi Booking</h2>

                    <form id="checkoutForm">
                        <div class="mb-6">
                            <span for="delivery_date" class="block text-gray-700 font-medium mb-2">Tanggal masuk</span>
                            <input 
                                type="date" 
                                id="delivery_date" 
                                name="delivery_date" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                min="<?= date('Y-m-d') ?>"
                                value="<?= date('Y-m-d') ?>"
                                required
                            >
                        </div>

                        <!-- Estimasi Selesai -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-4 mb-6">
                            <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                                <i class="fas fa-calendar-check text-green-600"></i>
                                Estimasi Barang Selesai & Siap Diambil
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="estimated_finish_date" class="block text-gray-700 text-sm font-medium mb-2">
                                        Tanggal Selesai
                                    </label>
                                    <input 
                                        type="date" 
                                        id="estimated_finish_date" 
                                        name="estimated_finish_date" 
                                        class="w-full px-4 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white"
                                        readonly
                                    >
                                </div>
                                
                                <div>
                                    <label for="estimated_finish_time" class="block text-gray-700 text-sm font-medium mb-2">
                                        Jam Siap Diambil
                                    </label>
                                    <input 
                                        type="text" 
                                        id="estimated_finish_time" 
                                        name="estimated_finish_time" 
                                        placeholder="HH:MM"
                                        class="w-full px-4 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white"
                                        readonly
                                    >
                                </div>
                            </div>
                            
                            <p class="text-xs text-gray-600 mt-3">
                                <i class="fas fa-info-circle text-green-600 mr-1"></i>
                                Estimasi ini dihitung otomatis berdasarkan layanan yang dipilih. Waktu sebenarnya bisa berbeda.
                            </p>
                        </div>

                        <div class="mb-6">
                            <span for="notes" class="block text-gray-700 font-medium mb-2">Catatan</span>
                            <textarea 
                                id="notes" 
                                name="notes" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                rows="4" 
                                placeholder="Tulis catatan di sini..."
                            ></textarea>
                        </div>
                    </form>
                </div>

                <!-- Foto Sepatu -->
                <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 mb-6 sm:mb-8">
                    <span class="block text-gray-700 font-medium mb-3 text-sm sm:text-base">
                        Foto Sepatu <span class="text-red-500">*</span>
                    </span>
                    <input type="file" id="shoe_photo" name="shoe_photo" accept="image/png,image/jpeg,image/jpg" required class="hidden">
                    
                    <div id="uploadArea" class="border-2 border-dashed border-gray-300 rounded-lg p-6 sm:p-8 text-center bg-gray-50 transition hover:border-blue-500 hover:bg-blue-50">
                        <div class="mb-3 sm:mb-4">
                            <i class="fas fa-image text-4xl sm:text-5xl md:text-6xl text-blue-500"></i>
                        </div>
                        <p class="text-gray-800 font-medium mb-1 text-sm sm:text-base">Unggah Foto Sepatu Anda</p>
                        <p class="text-gray-600 text-xs sm:text-sm mb-3 sm:mb-4">PNG, JPG, JPEG (Maks. 5 MB)</p>
                        
                        <button type="button" onclick="document.getElementById('shoe_photo').click()" class="ripple inline-flex items-center gap-2 px-4 py-2 sm:px-6 sm:py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:shadow-lg transition text-sm sm:text-base">
                            <i class="fas fa-camera"></i> Pilih Foto
                        </button>
                        
                        <p class="text-gray-400 text-xs mt-3 sm:mt-4">
                            <i class="fas fa-hand-pointer"></i> atau seret file kesini
                        </p>
                        <p class="text-red-500 text-xs sm:text-sm mt-2">
                            <i class="fas fa-exclamation-circle"></i> Wajib unggah foto sepatu
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
            </div>

            <!-- Summary Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-file-invoice text-blue-600 mr-2"></i>Ringkasan Pesanan
                    </h3>
                    
                    <div id="itemsList" class="space-y-3 mb-4 max-h-60 overflow-y-auto">
                        <!-- Items will be loaded here -->
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="flex justify-between text-gray-600">
                            <span>Jumlah:</span>
                            <span id="totalQuantity" class="font-semibold">0 pasang</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal:</span>
                            <span id="subtotalPrice" class="font-semibold">Rp 0</span>
                        </div>
                        <div id="additionalFeeSection" class="flex justify-between text-gray-600 hidden">
                            <span>Biaya Tambahan:</span>
                            <span id="additionalFee" class="font-semibold text-orange-600">Rp 0</span>
                        </div>
                        
                        <div id="feeInfoSection" class="bg-amber-50 border border-amber-200 rounded-lg p-3 hidden">
                            <p class="text-xs text-amber-800">
                                <i class="fas fa-info-circle mr-1"></i>
                                <strong>Biaya tambahan:</strong> <span id="feeInfoText"></span>
                            </p>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900">Total:</span>
                                <span id="totalPrice" class="text-2xl font-bold text-blue-600">Rp 0</span>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-3">
                            <p class="text-xs text-blue-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Anda dapat pesan untuk hari ini atau hari lainnya. Untuk konfirmasi lebih lanjut hubungi kami.
                            </p>
                        </div>
                    </div>
                    
                    <button 
                        type="button"
                        onclick="submitCheckout()" 
                        class="w-full mt-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition transform hover:scale-105 shadow-lg">
                        <i class="fas fa-check-circle mr-2"></i> Pesan Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Get cart key for current user
function getCartKey() {
    <?php if (session()->get('user_id')): ?>
        return 'cart_user_<?= session()->get('user_id') ?>';
    <?php else: ?>
        return 'cart_guest';
    <?php endif; ?>
}

// Update current time display
function updateCurrentTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const currentTimeEl = document.getElementById('currentTime');
    if (currentTimeEl) {
        currentTimeEl.textContent = `${hours}:${minutes}:${seconds}`;
    }
}

// Function to use current time
function useCurrentTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    document.getElementById('booking_time').value = `${hours}:${minutes}`;
}

// Handle item entry option change
document.addEventListener('DOMContentLoaded', function() {
    const itemEntryOptions = document.querySelectorAll('input[name="item_entry_option"]');
    const pickupAddressSection = document.getElementById('pickupAddressSection');
    const pickupAddressInput = document.getElementById('pickup_address');
    const timeLabelText = document.getElementById('timeLabelText');
    
    itemEntryOptions.forEach(option => {
        option.addEventListener('change', function() {
            // Update label jam booking
            if (this.value === 'pickup') {
                timeLabelText.textContent = 'Jam Jemput';
                pickupAddressSection.classList.remove('hidden');
                pickupAddressInput.setAttribute('required', 'required');
            } else {
                timeLabelText.textContent = 'Jam Antar';
                pickupAddressSection.classList.add('hidden');
                pickupAddressInput.removeAttribute('required');
                pickupAddressInput.value = '';
            }
            updateSummary();
        });
    });
    
    // Trigger initial label update
    const selectedItemEntry = document.querySelector('input[name="item_entry_option"]:checked');
    if (selectedItemEntry) {
        timeLabelText.textContent = selectedItemEntry.value === 'pickup' ? 'Jam Jemput' : 'Jam Antar';
    }
    
    // Calculate estimated finish date/time
    function calculateEstimatedFinish() {
        const deliveryDate = document.getElementById('delivery_date').value;
        if (!deliveryDate) return;
        
        // Default 3 hari pengerjaan (bisa disesuaikan per layanan)
        const serviceDays = 3;
        
        const startDate = new Date(deliveryDate);
        const finishDate = new Date(startDate);
        finishDate.setDate(finishDate.getDate() + serviceDays);
        
        // Format tanggal
        const year = finishDate.getFullYear();
        const month = String(finishDate.getMonth() + 1).padStart(2, '0');
        const day = String(finishDate.getDate()).padStart(2, '0');
        
        document.getElementById('estimated_finish_date').value = `${year}-${month}-${day}`;
        
        // Gunakan jam yang sama dengan jam antar/jemput
        const bookingTime = document.getElementById('booking_time').value;
        if (bookingTime) {
            document.getElementById('estimated_finish_time').value = bookingTime;
        } else {
            document.getElementById('estimated_finish_time').value = '17:00'; // Default jam 5 sore jika belum diisi
        }
    }
    
    // Update estimasi saat tanggal atau jam booking berubah
    document.getElementById('delivery_date').addEventListener('change', calculateEstimatedFinish);
    document.getElementById('booking_time').addEventListener('input', calculateEstimatedFinish);
    
    // Hitung estimasi saat load
    calculateEstimatedFinish();
    
    // Handle delivery option change
    const deliveryOptions = document.querySelectorAll('input[name="delivery_option"]');
    const deliveryAddressSection = document.getElementById('deliveryAddressSection');
    const deliveryAddressInput = document.getElementById('delivery_address');
    
    deliveryOptions.forEach(option => {
        option.addEventListener('change', function() {
            if (this.value === 'delivery') {
                deliveryAddressSection.classList.remove('hidden');
                deliveryAddressInput.setAttribute('required', 'required');
            } else {
                deliveryAddressSection.classList.add('hidden');
                deliveryAddressInput.removeAttribute('required');
            }
            updateSummary();
        });
    });
    
    // Initialize booking time with current time
    useCurrentTime();
    
    // Update current time display
    updateCurrentTime();
    setInterval(updateCurrentTime, 1000);
    
    loadCheckoutItems();
});

// Photo preview
const uploadArea = document.getElementById('uploadArea');
const imagePreview = document.getElementById('imagePreview');
const shoePhotoInput = document.getElementById('shoe_photo');

function handlePhotoFile(file) {
    if (!file) return;
    
    if (file.size > 5 * 1024 * 1024) {
        if (Modal) {
            Modal.error('Ukuran file terlalu besar. Maksimal 5MB');
        } else {
            alert('Ukuran file terlalu besar. Maksimal 5MB');
        }
        return;
    }
    
    const validTypes = ['image/png', 'image/jpg', 'image/jpeg'];
    if (!validTypes.includes(file.type)) {
        if (Modal) {
            Modal.error('Format file harus PNG, JPG, atau JPEG');
        } else {
            alert('Format file harus PNG, JPG, atau JPEG');
        }
        return;
    }
    
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    shoePhotoInput.files = dataTransfer.files;
    
    const reader = new FileReader();
    reader.onload = function(event) {
        document.getElementById('previewImg').src = event.target.result;
        uploadArea.classList.add('hidden');
        imagePreview.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

shoePhotoInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) handlePhotoFile(file);
});

uploadArea.addEventListener('dragover', e => {
    e.preventDefault();
    uploadArea.classList.add('border-blue-500', 'bg-blue-100');
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('border-blue-500', 'bg-blue-100');
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('border-blue-500', 'bg-blue-100');
    const file = e.dataTransfer.files[0];
    if (file) handlePhotoFile(file);
});

function removeImage() {
    const input = document.getElementById('shoe_photo');
    const dataTransfer = new DataTransfer();
    input.files = dataTransfer.files;
    document.getElementById('previewImg').src = '';
    uploadArea.classList.remove('hidden');
    imagePreview.classList.add('hidden');
}

// Load checkout items
function loadCheckoutItems() {
    const checkoutItems = JSON.parse(sessionStorage.getItem('checkoutItems') || '[]');
    
    if (checkoutItems.length === 0) {
        window.location.href = '/cart';
        return;
    }
    
    const itemsList = document.getElementById('itemsList');
    let totalQuantity = 0;
    let totalPrice = 0;
    
    itemsList.innerHTML = '';
    
    checkoutItems.forEach(item => {
        const itemTotal = item.price * item.quantity;
        totalQuantity += item.quantity;
        totalPrice += itemTotal;
        
        itemsList.innerHTML += `
            <div class="py-2 border-b border-gray-100">
                <div class="flex justify-between items-start mb-1">
                    <p class="font-semibold text-gray-900 text-sm">${item.service_name}</p>
                </div>
                <div class="flex justify-between items-center">
                    <p class="text-xs text-gray-500">Rp ${parseInt(item.price).toLocaleString('id-ID')} x ${item.quantity}</p>
                    <p class="font-bold text-blue-600 text-sm">Rp ${parseInt(itemTotal).toLocaleString('id-ID')}</p>
                </div>
            </div>
        `;
    });
    
    // Store total quantity for fee calculation
    window.checkoutTotalQuantity = totalQuantity;
    window.checkoutSubtotal = totalPrice;
    
    updateSummary();
}

// Update summary with fees
function updateSummary() {
    const itemEntryOption = document.querySelector('input[name="item_entry_option"]:checked')?.value;
    const deliveryOption = document.querySelector('input[name="delivery_option"]:checked')?.value;
    
    const totalQuantity = window.checkoutTotalQuantity || 0;
    const subtotal = window.checkoutSubtotal || 0;
    
    // Calculate additional fees
    let additionalFee = 0;
    let feeReasons = [];
    
    // Single shoe pickup fee (only for 1 shoe)
    if (itemEntryOption === 'pickup' && totalQuantity === 1) {
        additionalFee += 5000;
        feeReasons.push('Penjemputan 1 sepatu');
    }
    
    // Delivery fee (only for 1 shoe, free for 2+)
    if (deliveryOption === 'delivery' && totalQuantity === 1) {
        additionalFee += 5000;
        feeReasons.push('Pengiriman ke rumah');
    }
    
    const total = subtotal + additionalFee;
    
    // Update display
    document.getElementById('totalQuantity').textContent = `${totalQuantity} pasang`;
    document.getElementById('subtotalPrice').textContent = `Rp ${parseInt(subtotal).toLocaleString('id-ID')}`;
    
    const additionalFeeSection = document.getElementById('additionalFeeSection');
    const feeInfoSection = document.getElementById('feeInfoSection');
    const feeInfoText = document.getElementById('feeInfoText');
    const additionalFeeEl = document.getElementById('additionalFee');
    
    if (additionalFee > 0) {
        additionalFeeSection.classList.remove('hidden');
        feeInfoSection.classList.remove('hidden');
        additionalFeeEl.textContent = `Rp ${parseInt(additionalFee).toLocaleString('id-ID')}`;
        feeInfoText.textContent = feeReasons.join(' + ');
    } else {
        additionalFeeSection.classList.add('hidden');
        feeInfoSection.classList.add('hidden');
    }
    
    document.getElementById('totalPrice').textContent = `Rp ${parseInt(total).toLocaleString('id-ID')}`;
}

// Submit checkout
function submitCheckout() {
    const form = document.getElementById('checkoutForm');
    
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    // Validate all required fields
    const itemEntryOption = document.querySelector('input[name="item_entry_option"]:checked');
    if (!itemEntryOption) {
        if (Modal) {
            Modal.warning('Pilih opsi barang masuk');
        } else {
            alert('Pilih opsi barang masuk');
        }
        return;
    }
    
    const deliveryOption = document.querySelector('input[name="delivery_option"]:checked');
    if (!deliveryOption) {
        if (Modal) {
            Modal.warning('Pilih opsi pengiriman');
        } else {
            alert('Pilih opsi pengiriman');
        }
        return;
    }
    
    const deliveryDate = document.getElementById('delivery_date').value;
    if (!deliveryDate) {
        if (Modal) {
            Modal.warning('Pilih tanggal masuk');
        } else {
            alert('Pilih tanggal masuk');
        }
        return;
    }
    
    const bookingTime = document.getElementById('booking_time').value;
    if (!bookingTime) {
        if (Modal) {
            Modal.warning('Pilih jam booking');
        } else {
            alert('Pilih jam booking');
        }
        return;
    }
    
    const shoePhoto = document.getElementById('shoe_photo').files[0];
    if (!shoePhoto) {
        if (Modal) {
            Modal.warning('Silakan unggah foto sepatu terlebih dahulu', 'Foto Diperlukan');
        } else {
            alert('Unggah foto sepatu');
        }
        return;
    }
    
    // Validate pickup address if item entry is pickup
    if (itemEntryOption.value === 'pickup') {
        const pickupAddress = document.getElementById('pickup_address').value.trim();
        if (!pickupAddress || pickupAddress.length < 10) {
            if (Modal) {
                Modal.warning('Alamat penjemputan minimal 10 karakter');
            } else {
                alert('Alamat penjemputan minimal 10 karakter');
            }
            return;
        }
    }
    
    // Validate delivery address if delivery option is delivery
    if (deliveryOption.value === 'delivery') {
        const deliveryAddress = document.getElementById('delivery_address').value.trim();
        if (!deliveryAddress || deliveryAddress.length < 10) {
            if (Modal) {
                Modal.warning('Alamat pengiriman minimal 10 karakter');
            } else {
                alert('Alamat pengiriman minimal 10 karakter');
            }
            return;
        }
    }
    
    const notes = document.getElementById('notes').value;
    const checkoutItems = JSON.parse(sessionStorage.getItem('checkoutItems') || '[]');
    
    if (checkoutItems.length === 0) {
        alert('Tidak ada item untuk checkout');
        return;
    }
    
    // Calculate fees
    const totalQuantity = window.checkoutTotalQuantity || 0;
    let additionalFee = 0;
    
    if (itemEntryOption.value === 'pickup' && totalQuantity === 1) {
        additionalFee += 5000;
    }
    if (deliveryOption.value === 'delivery' && totalQuantity === 1) {
        additionalFee += 5000;
    }
    
    // Show loading
    const button = event.target;
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
    
    // Determine delivery method based on options
    let deliveryMethod = 'langsung'; // default
    if (itemEntryOption.value === 'pickup' && deliveryOption.value === 'pickup') {
        deliveryMethod = 'dijemput'; // picked up but self pickup result
    } else if (itemEntryOption.value === 'pickup' && deliveryOption.value === 'delivery') {
        deliveryMethod = 'dijemput-diantar'; // picked up and delivered
    } else if (itemEntryOption.value === 'dropoff' && deliveryOption.value === 'delivery') {
        deliveryMethod = 'diantar'; // self dropoff but delivered
    } else if (itemEntryOption.value === 'dropoff' && deliveryOption.value === 'pickup') {
        deliveryMethod = 'langsung'; // self dropoff and self pickup
    }
    
    // Determine address to send
    let address = '';
    if (deliveryOption.value === 'delivery') {
        // Priority to delivery address if delivery is selected
        address = document.getElementById('delivery_address').value;
    } else if (itemEntryOption.value === 'pickup') {
        // Otherwise use pickup address if pickup is selected
        address = document.getElementById('pickup_address').value;
    }
    
    // Prepare form data for file upload
    const formData = new FormData();
    formData.append('items', JSON.stringify(checkoutItems));
    formData.append('pickup_date', deliveryDate);
    formData.append('delivery_method', deliveryMethod);
    formData.append('address', address);
    formData.append('notes', notes);
    
    // Append photo (as shoe_photos for backend compatibility)
    formData.append('shoe_photos', shoePhoto);
    
    // Submit to server
    fetch('/checkout/submit', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove checked out items from cart
            const cart = JSON.parse(localStorage.getItem(getCartKey()) || '[]');
            const remainingCart = cart.filter(item => item.selected === false);
            localStorage.setItem(getCartKey(), JSON.stringify(remainingCart));
            
            // Clear checkout items
            sessionStorage.removeItem('checkoutItems');
            
            // Show success and redirect
            if (Modal) {
                Modal.success(data.message, 'Berhasil', () => {
                    window.location.href = '/my-bookings';
                });
            } else {
                alert(data.message);
                window.location.href = '/my-bookings';
            }
        } else {
            if (Modal) {
                Modal.error('Error: ' + data.message, 'Gagal');
            } else {
                alert('Error: ' + data.message);
            }
            button.disabled = false;
            button.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (Modal) {
            Modal.error('Terjadi kesalahan saat memproses pesanan', 'Kesalahan');
        } else {
            alert('Terjadi kesalahan saat memproses pesanan');
        }
        button.disabled = false;
        button.innerHTML = originalText;
    });
}

// Load items on page load
document.addEventListener('DOMContentLoaded', loadCheckoutItems);
</script>

<style>
/* Item entry option styling */
.item-entry-option:has(input[type="radio"]:checked) {
    border-color: #3b82f6 !important;
    background-color: #eff6ff !important;
}

.item-entry-option:has(input[type="radio"]:checked)::after {
    content: '\f058';
    font-family: 'Font Awesome 5 Free';
    font-weight: 700;
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    color: #3b82f6;
    font-size: 1.25rem;
}

/* Delivery option styling */
.delivery-option:has(input[type="radio"]:checked) {
    border-color: #3b82f6 !important;
    background-color: #eff6ff !important;
}

.delivery-option:has(input[type="radio"]:checked)::after {
    content: '\f058';
    font-family: 'Font Awesome 5 Free';
    font-weight: 700;
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    color: #3b82f6;
    font-size: 1.25rem;
}

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

/* Fade In Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 0.3s ease-out;
}

/* Smooth transitions */
* {
    -webkit-tap-highlight-color: transparent;
}

html {
    scroll-behavior: smooth;
}

/* Override input autofill styling */
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 1000px white inset !important;
    box-shadow: 0 0 0 1000px white inset !important;
}

input:-webkit-autofill {
    -webkit-text-fill-color: #374151 !important;
}

textarea:-webkit-autofill,
textarea:-webkit-autofill:hover,
textarea:-webkit-autofill:focus {
    -webkit-box-shadow: 0 0 0 1000px white inset !important;
    box-shadow: 0 0 0 1000px white inset !important;
}

textarea:-webkit-autofill {
    -webkit-text-fill-color: #374151 !important;
}

/* Fix placeholder color */
input::placeholder,
textarea::placeholder {
    color: #9CA3AF !important;
    opacity: 1 !important;
}

input::-webkit-input-placeholder,
textarea::-webkit-input-placeholder {
    color: #9CA3AF !important;
}

/* Fix text color in input and textarea */
input,
textarea {
    color: #1F2937 !important;
}

/* Fix number input spinner */
input[type="number"],
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
    color: #1F2937 !important;
}

input[type="number"] {
    -moz-appearance: textfield;
}

/* Fix buttons color - ensure they don't turn green */
button.text-white,
button[class*="text-white"],
button.ripple.text-white {
    color: white !important;
}

button.text-white i,
button.text-white .fas {
    color: white !important;
}
</style>

<?= $this->endSection() ?>
