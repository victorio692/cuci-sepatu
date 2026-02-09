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
                <!-- Delivery Method -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">
                        <i class="fas fa-truck text-blue-600 mr-2"></i>Opsi Pengiriman <span class="text-red-500">*</span>
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Ambil di Tempat -->
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="delivery_method" value="langsung" class="peer hidden" checked>
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

                        <!-- Diantar ke Rumah -->
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="delivery_method" value="antar" class="peer hidden">
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

                <!-- Shoe Photos -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-camera text-blue-600 mr-2"></i>Foto Sepatu
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Upload Foto Sepatu (Maks. 5 foto)
                            </label>
                            <input 
                                type="file" 
                                id="shoe_photos" 
                                name="shoe_photos[]" 
                                accept="image/*"
                                multiple
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, max 2MB per foto</p>
                        </div>
                        
                        <div id="photoPreview" class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <!-- Preview will be shown here -->
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <form id="checkoutForm" class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Informasi Pengiriman</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="pickup_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>Tanggal Pickup/Antar
                            </label>
                            <input 
                                type="date" 
                                id="pickup_date" 
                                name="pickup_date" 
                                required
                                min="<?= date('Y-m-d') ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <p class="text-xs text-gray-500 mt-1">Bisa pilih mulai hari ini</p>
                        </div>

                        <div id="addressField">
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>Alamat
                            </label>
                            <textarea 
                                id="address" 
                                name="address" 
                                rows="3"
                                required
                                placeholder="Masukkan alamat lengkap"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            ><?= $user['address'] ?? $user['alamat'] ?? '' ?></textarea>
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
            </div>

            <!-- Summary Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                    
                    <div id="itemsList" class="space-y-3 mb-4 max-h-60 overflow-y-auto">
                        <!-- Items will be loaded here -->
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 space-y-2">
                        <div class="flex justify-between text-gray-600">
                            <span>Total Item:</span>
                            <span id="totalQuantity" class="font-semibold">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">Total Bayar:</span>
                            <span id="totalPrice" class="text-2xl font-bold text-blue-600">Rp 0</span>
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

// Handle delivery method change
document.addEventListener('DOMContentLoaded', function() {
    const deliveryRadios = document.querySelectorAll('input[name="delivery_method"]');
    const addressField = document.getElementById('addressField');
    const addressInput = document.getElementById('address');
    const addressLabel = addressField.querySelector('label');
    
    deliveryRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'langsung') {
                addressField.classList.add('hidden');
                addressInput.removeAttribute('required');
            } else {
                addressField.classList.remove('hidden');
                addressInput.setAttribute('required', 'required');
                
                // Update label text
                if (this.value === 'antar') {
                    addressLabel.innerHTML = '<i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>Alamat Pengiriman';
                    addressInput.placeholder = 'Masukkan alamat lengkap untuk pengiriman';
                }
            }
        });
    });
    
    loadCheckoutItems();
});

// Photo preview
document.getElementById('shoe_photos').addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    const preview = document.getElementById('photoPreview');
    
    if (files.length > 5) {
        alert('Maksimal 5 foto');
        this.value = '';
        return;
    }
    
    preview.innerHTML = '';
    
    files.forEach((file, index) => {
        if (file.size > 2 * 1024 * 1024) {
            alert(`File ${file.name} terlalu besar. Maksimal 2MB per foto`);
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(event) {
            const div = document.createElement('div');
            div.className = 'relative group';
            div.innerHTML = `
                <img src="${event.target.result}" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                <button type="button" onclick="removePhoto(${index})" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                    <i class="fas fa-times text-xs"></i>
                </button>
            `;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});

function removePhoto(index) {
    const input = document.getElementById('shoe_photos');
    const dt = new DataTransfer();
    const files = Array.from(input.files);
    
    files.forEach((file, i) => {
        if (i !== index) dt.items.add(file);
    });
    
    input.files = dt.files;
    input.dispatchEvent(new Event('change'));
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
            <div class="flex justify-between items-start py-2 border-b border-gray-100">
                <div class="flex-1">
                    <p class="font-semibold text-gray-900 text-sm">${item.service_name}</p>
                    <p class="text-xs text-gray-500">${item.quantity} x Rp ${item.price.toLocaleString('id-ID')}</p>
                </div>
                <p class="font-bold text-blue-600">Rp ${itemTotal.toLocaleString('id-ID')}</p>
            </div>
        `;
    });
    
    document.getElementById('totalQuantity').textContent = `${totalQuantity} item`;
    document.getElementById('totalPrice').textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
}

// Submit checkout
function submitCheckout() {
    const form = document.getElementById('checkoutForm');
    
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    const deliveryMethod = document.querySelector('input[name="delivery_method"]:checked');
    if (!deliveryMethod) {
        alert('Pilih metode pengiriman');
        return;
    }
    
    const pickupDate = document.getElementById('pickup_date').value;
    const address = document.getElementById('address').value;
    const notes = document.getElementById('notes').value;
    const checkoutItems = JSON.parse(sessionStorage.getItem('checkoutItems') || '[]');
    const photoFiles = document.getElementById('shoe_photos').files;
    
    if (checkoutItems.length === 0) {
        alert('Tidak ada item untuk checkout');
        return;
    }
    
    // Show loading
    const button = event.target;
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
    
    // Prepare form data for file upload
    const formData = new FormData();
    formData.append('items', JSON.stringify(checkoutItems));
    formData.append('pickup_date', pickupDate);
    formData.append('address', address);
    formData.append('notes', notes);
    formData.append('delivery_method', deliveryMethod.value);
    
    // Append photos
    for (let i = 0; i < photoFiles.length; i++) {
        formData.append('shoe_photos[]', photoFiles[i]);
    }
    
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

<?= $this->endSection() ?>
