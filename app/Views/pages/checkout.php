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
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">
                        <i class="fas fa-box-open text-blue-600 mr-2"></i>Opsi Barang Masuk <span class="text-red-500">*</span>
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Diantar ke Tempat (Dropoff) -->
                        <label class="relative cursor-pointer group item-entry-option">
                            <input type="radio" name="item_entry_option" value="dropoff" class="peer hidden" checked>
                            <div class="flex items-start gap-4 p-5 border-2 border-gray-200 rounded-xl transition-all duration-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-400 shadow-md hover:shadow-xl peer-checked:shadow-2xl peer-checked:shadow-blue-200 hover:-translate-y-1 transform">
                                <div class="flex-shrink-0 w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center transition-all duration-300 peer-checked:bg-blue-500 group-hover:scale-110 group-hover:rotate-3 shadow-lg">
                                    <i class="fas fa-user text-2xl text-blue-600 transition-all peer-checked:text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 mb-1 text-lg">Diantar ke Tempat</h3>
                                    <p class="text-sm text-gray-500">Saya antar barang ke SYH.CLEANING</p>
                                </div>
                            </div>
                        </label>

                        <!-- Dijemput (Pickup) -->
                        <label class="relative cursor-pointer group item-entry-option">
                            <input type="radio" name="item_entry_option" value="pickup" class="peer hidden">
                            <div class="flex items-start gap-4 p-5 border-2 border-gray-200 rounded-xl transition-all duration-300 peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:border-purple-400 shadow-md hover:shadow-xl peer-checked:shadow-2xl peer-checked:shadow-purple-200 hover:-translate-y-1 transform">
                                <div class="flex-shrink-0 w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center transition-all duration-300 peer-checked:bg-purple-500 group-hover:scale-110 group-hover:rotate-3 shadow-lg">
                                    <i class="fas fa-truck text-2xl text-purple-600 transition-all peer-checked:text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 mb-1 text-lg">Dijemput</h3>
                                    <p class="text-sm text-gray-500">Tim kami jemput barang Anda</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Alamat Penjemputan (conditional) -->
                <div id="pickupAddressSection" class="bg-white rounded-xl shadow-lg p-6 hidden">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">
                        <i class="fas fa-map-marker-alt text-purple-600 mr-2"></i>Alamat Penjemputan <span class="text-red-500">*</span>
                    </h2>
                    <textarea 
                        id="pickup_address" 
                        name="pickup_address" 
                        rows="3"
                        placeholder="Masukkan alamat lengkap untuk penjemputan..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    ></textarea>
                    <small class="text-gray-500 text-sm mt-1 block">Masukkan alamat lengkap dan detail (nama jalan, nomor rumah, patokan)</small>
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mt-3">
                        <p class="text-sm text-amber-800"><i class="fas fa-info-circle mr-2"></i><strong>Biaya Penjemputan:</strong> Rp 5.000 (untuk 1 sepatu), GRATIS untuk 2+ sepatu</p>
                    </div>
                </div>

                <!-- Opsi Pengiriman -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">
                        <i class="fas fa-truck text-blue-600 mr-2"></i>Opsi Pengiriman Barang <span class="text-red-500">*</span>
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Ambil di Tempat (Pickup) -->
                        <label class="relative cursor-pointer group delivery-option">
                            <input type="radio" name="delivery_option" value="pickup" class="peer hidden" checked>
                            <div class="flex items-start gap-4 p-5 border-2 border-gray-200 rounded-xl transition-all duration-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-400 shadow-md hover:shadow-xl peer-checked:shadow-2xl peer-checked:shadow-blue-200 hover:-translate-y-1 transform">
                                <div class="flex-shrink-0 w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center transition-all duration-300 peer-checked:bg-blue-500 group-hover:scale-110 group-hover:rotate-3 shadow-lg">
                                    <i class="fas fa-box text-2xl text-blue-600 transition-all peer-checked:text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 mb-1 text-lg">Ambil di Tempat</h3>
                                    <p class="text-sm text-gray-500">Ambil sendiri di SYH.CLEANING</p>
                                </div>
                            </div>
                        </label>

                        <!-- Diantar (Delivery) -->
                        <label class="relative cursor-pointer group delivery-option">
                            <input type="radio" name="delivery_option" value="delivery" class="peer hidden">
                            <div class="flex items-start gap-4 p-5 border-2 border-gray-200 rounded-xl transition-all duration-300 peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-400 shadow-md hover:shadow-xl peer-checked:shadow-2xl peer-checked:shadow-green-200 hover:-translate-y-1 transform">
                                <div class="flex-shrink-0 w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center transition-all duration-300 peer-checked:bg-green-500 group-hover:scale-110 group-hover:rotate-3 shadow-lg">
                                    <i class="fas fa-home text-2xl text-green-600 transition-all peer-checked:text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 mb-1 text-lg">Diantar ke Rumah</h3>
                                    <p class="text-sm text-gray-500">Kami antar ke alamat Anda</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Alamat Pengiriman (conditional) -->
                <div id="deliveryAddressSection" class="bg-white rounded-xl shadow-lg p-6 hidden">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">
                        <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>Alamat Pengiriman <span class="text-red-500">*</span>
                    </h2>
                    <textarea 
                        id="delivery_address" 
                        name="delivery_address" 
                        rows="3"
                        placeholder="Masukkan alamat lengkap untuk pengiriman..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    ><?= $user['address'] ?? $user['alamat'] ?? '' ?></textarea>
                    <small class="text-gray-500 text-sm mt-1 block">Masukkan alamat lengkap dan detail (nama jalan, nomor rumah, patokan)</small>
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mt-3">
                        <p class="text-sm text-amber-800"><i class="fas fa-info-circle mr-2"></i><strong>Biaya Pengiriman:</strong> Rp 5.000 (untuk 1 sepatu), GRATIS untuk 2+ sepatu</p>
                    </div>
                </div>

                <!-- Shipping Information -->
                <form id="checkoutForm" class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-clipboard-list text-blue-600 mr-2"></i>Informasi Booking
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="delivery_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>Tanggal Masuk <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="date" 
                                id="delivery_date" 
                                name="delivery_date" 
                                required
                                min="<?= date('Y-m-d') ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <p class="text-xs text-gray-500 mt-1">Tanggal barang masuk ke SYH.CLEANING</p>
                        </div>

                        <div>
                            <label for="booking_time" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-clock text-blue-600 mr-2"></i>Jam Booking <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-2">
                                <input 
                                    type="time" 
                                    id="booking_time" 
                                    name="booking_time" 
                                    required
                                    min="12:00"
                                    max="23:59"
                                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                >
                                <button 
                                    type="button" 
                                    onclick="useCurrentTime()" 
                                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition whitespace-nowrap"
                                >
                                    <i class="fas fa-clock mr-1"></i> Waktu Sekarang
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Jam booking (12:00 - 23:59). Waktu sekarang: <span id="currentTime"></span></p>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-sticky-note text-blue-600 mr-2"></i>Catatan (Opsional)
                            </label>
                            <textarea 
                                id="notes" 
                                name="notes" 
                                rows="3"
                                placeholder="Tambahkan catatan khusus untuk pesanan Anda"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            ></textarea>
                        </div>
                    </div>
                </form>

                <!-- Shoe Photos -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-camera text-blue-600 mr-2"></i>Foto Sepatu <span class="text-red-500">*</span>
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Upload Foto Sepatu (Maksimal 1 foto)
                            </label>
                            <input 
                                type="file" 
                                id="shoe_photo" 
                                name="shoe_photo" 
                                accept="image/png,image/jpg,image/jpeg"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <p class="text-xs text-gray-500 mt-1">Format: PNG, JPG, JPEG - Maksimal 5MB</p>
                        </div>
                        
                        <div id="photoPreview" class="hidden">
                            <div class="relative group">
                                <img id="previewImg" src="" class="w-full h-48 object-cover rounded-lg border-2 border-gray-200">
                                <button 
                                    type="button" 
                                    onclick="removePhoto()" 
                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                                >
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-file-invoice text-blue-600 mr-2"></i>Ringkasan Booking
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
                                Anda dapat booking untuk hari ini atau hari lainnya. Untuk konfirmasi lebih lanjut hubungi kami.
                            </p>
                        </div>
                    </div>
                    
                    <button 
                        type="button"
                        onclick="submitCheckout()" 
                        class="w-full mt-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition transform hover:scale-105 shadow-lg">
                        <i class="fas fa-check-circle mr-2"></i> Booking Sekarang
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
    
    itemEntryOptions.forEach(option => {
        option.addEventListener('change', function() {
            if (this.value === 'pickup') {
                pickupAddressSection.classList.remove('hidden');
                pickupAddressInput.setAttribute('required', 'required');
            } else {
                pickupAddressSection.classList.add('hidden');
                pickupAddressInput.removeAttribute('required');
                pickupAddressInput.value = '';
            }
            updateSummary();
        });
    });
    
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
document.getElementById('shoe_photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('photoPreview');
    const previewImg = document.getElementById('previewImg');
    
    if (!file) {
        preview.classList.add('hidden');
        return;
    }
    
    // Check file size (5MB max)
    if (file.size > 5 * 1024 * 1024) {
        alert('Ukuran file terlalu besar. Maksimal 5MB');
        this.value = '';
        preview.classList.add('hidden');
        return;
    }
    
    // Check file type
    const validTypes = ['image/png', 'image/jpg', 'image/jpeg'];
    if (!validTypes.includes(file.type)) {
        alert('Format file harus PNG, JPG, atau JPEG');
        this.value = '';
        preview.classList.add('hidden');
        return;
    }
    
    // Show preview
    const reader = new FileReader();
    reader.onload = function(event) {
        previewImg.src = event.target.result;
        preview.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
});

function removePhoto() {
    const input = document.getElementById('shoe_photo');
    const preview = document.getElementById('photoPreview');
    const previewImg = document.getElementById('previewImg');
    
    input.value = '';
    previewImg.src = '';
    preview.classList.add('hidden');
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
                    <p class="text-xs text-gray-500">Rp ${item.price.toLocaleString('id-ID')} x ${item.quantity}</p>
                    <p class="font-bold text-blue-600 text-sm">Rp ${itemTotal.toLocaleString('id-ID')}</p>
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
    document.getElementById('subtotalPrice').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
    
    const additionalFeeSection = document.getElementById('additionalFeeSection');
    const feeInfoSection = document.getElementById('feeInfoSection');
    const feeInfoText = document.getElementById('feeInfoText');
    const additionalFeeEl = document.getElementById('additionalFee');
    
    if (additionalFee > 0) {
        additionalFeeSection.classList.remove('hidden');
        feeInfoSection.classList.remove('hidden');
        additionalFeeEl.textContent = `Rp ${additionalFee.toLocaleString('id-ID')}`;
        feeInfoText.textContent = feeReasons.join(' + ');
    } else {
        additionalFeeSection.classList.add('hidden');
        feeInfoSection.classList.add('hidden');
    }
    
    document.getElementById('totalPrice').textContent = `Rp ${total.toLocaleString('id-ID')}`;
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
        alert('Pilih opsi barang masuk');
        return;
    }
    
    const deliveryOption = document.querySelector('input[name="delivery_option"]:checked');
    if (!deliveryOption) {
        alert('Pilih opsi pengiriman');
        return;
    }
    
    const deliveryDate = document.getElementById('delivery_date').value;
    if (!deliveryDate) {
        alert('Pilih tanggal masuk');
        return;
    }
    
    const bookingTime = document.getElementById('booking_time').value;
    if (!bookingTime) {
        alert('Pilih jam booking');
        return;
    }
    
    // Validate time range (12:00 - 23:59)
    const [hours, minutes] = bookingTime.split(':').map(Number);
    if (hours < 12 || hours > 23) {
        alert('Jam booking harus antara 12:00 - 23:59');
        return;
    }
    
    const shoePhoto = document.getElementById('shoe_photo').files[0];
    if (!shoePhoto) {
        alert('Upload foto sepatu');
        return;
    }
    
    // Validate pickup address if item entry is pickup
    if (itemEntryOption.value === 'pickup') {
        const pickupAddress = document.getElementById('pickup_address').value.trim();
        if (!pickupAddress || pickupAddress.length < 10) {
            alert('Alamat penjemputan minimal 10 karakter');
            return;
        }
    }
    
    // Validate delivery address if delivery option is delivery
    if (deliveryOption.value === 'delivery') {
        const deliveryAddress = document.getElementById('delivery_address').value.trim();
        if (!deliveryAddress || deliveryAddress.length < 10) {
            alert('Alamat pengiriman minimal 10 karakter');
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
            alert(data.message);
            window.location.href = '/my-bookings';
        } else {
            alert('Error: ' + data.message);
            button.disabled = false;
            button.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memproses pesanan');
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
</style>

<?= $this->endSection() ?>
