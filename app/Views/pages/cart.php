<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="min-h-screen bg-gray-50 py-6 sm:py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-4 sm:mb-6">
            <a href="/" class="inline-flex items-center gap-2 px-3 py-2 sm:px-4 sm:py-2 bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-blue-400 hover:text-blue-600 transition-all duration-300 font-medium shadow-sm hover:shadow-md transform hover:-translate-x-1 text-sm sm:text-base">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 sm:mb-6">
            <i class="fas fa-shopping-cart text-blue-600 mr-2"></i> Keranjang Belanja
        </h1>

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

        <!-- Cart Container (will be filled by JavaScript) -->
        <div id="cartContainer">
            <!-- Loading state -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <i class="fas fa-spinner fa-spin text-blue-600 text-4xl mb-4"></i>
                <p class="text-gray-600">Memuat keranjang...</p>
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

// Load cart from localStorage
function loadCart() {
    const cart = JSON.parse(localStorage.getItem(getCartKey()) || '[]');
    const cartContainer = document.getElementById('cartContainer');
    
    if (cart.length === 0) {
        // Empty cart
        cartContainer.innerHTML = `
            <div class="bg-white rounded-xl shadow-lg p-8 sm:p-12 text-center">
                <i class="fas fa-shopping-cart text-gray-300 text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-700 mb-2">Keranjang Kosong</h2>
                <p class="text-gray-500 mb-6">Belum ada layanan yang ditambahkan ke keranjang</p>
                <a href="/" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali Belanja
                </a>
            </div>
        `;
        updateNavbarCart();
        return;
    }
    
    // Build cart HTML
    let cartHTML = '<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">';
    
    // Cart items
    cartHTML += '<div class="lg:col-span-2 space-y-4">';
    
    // Select All header
    cartHTML += `
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" id="selectAll" onchange="toggleSelectAll()" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                <span class="font-semibold text-gray-900">Pilih Semua (${cart.length} Layanan)</span>
            </label>
        </div>
    `;
    
    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        const isChecked = item.selected !== false ? 'checked' : ''; // Default checked
        cartHTML += `
            <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6 hover:shadow-xl transition">
                <div class="flex gap-4">
                    <!-- Checkbox -->
                    <div class="flex items-start pt-1">
                        <input type="checkbox" 
                               id="item-${index}" 
                               onchange="toggleItemSelection(${index})" 
                               ${isChecked}
                               class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                    </div>
                    
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-200 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-t from-white/30 to-transparent"></div>
                        <div class="relative z-10 text-4xl">👟</div>
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold text-gray-900">${item.service_name}</h3>
                            <button type="button" onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-700 p-2">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        
                        <div class="flex items-center justify-between mt-3">
                            <div class="flex items-center space-x-3">
                                <button type="button" onclick="updateQuantity(${index}, -1)" class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span class="font-semibold text-gray-900 w-8 text-center">${item.quantity}</span>
                                <button type="button" onclick="updateQuantity(${index}, 1)" class="w-8 h-8 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">Rp ${item.price.toLocaleString('id-ID')} / pasang</div>
                                <div class="text-lg font-bold text-blue-600">Rp ${itemTotal.toLocaleString('id-ID')}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    cartHTML += '</div>';
    
    // Summary - Calculate only selected items
    const selectedItems = cart.filter(item => item.selected !== false);
    const totalItems = selectedItems.reduce((sum, item) => sum + item.quantity, 0);
    const totalPrice = selectedItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    
    cartHTML += `
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6 sticky top-20">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between text-gray-600">
                        <span>Jumlah Item:</span>
                        <span class="font-semibold">${totalItems} item dipilih</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-2xl font-bold text-blue-600">Rp ${totalPrice.toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                </div>
                
                <button onclick="proceedToCheckout()" ${totalItems === 0 ? 'disabled' : ''} class="w-full ${totalItems === 0 ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 transform hover:scale-105'} text-white py-3 rounded-lg font-semibold transition shadow-lg">
                    <i class="fas fa-check-circle mr-2"></i> Checkout (${totalItems} item)
                </button>
                
                <a href="/" class="block w-full mt-3 text-center py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                    <i class="fas fa-plus mr-2"></i> Tambah Layanan
                </a>
            </div>
        </div>
    `;
    
    cartHTML += '</div>';
    
    cartContainer.innerHTML = cartHTML;
    
    // Set "Select All" checkbox state after rendering
    setTimeout(() => {
        const allSelected = cart.every(item => item.selected !== false);
        const selectAllCheckbox = document.getElementById('selectAll');
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = allSelected;
        }
    }, 0);
    
    updateNavbarCart();
}

// Remove item from cart
function removeFromCart(index) {
    if (confirm('Hapus layanan ini dari keranjang?')) {
        const cart = JSON.parse(localStorage.getItem(getCartKey()) || '[]');
        cart.splice(index, 1);
        localStorage.setItem(getCartKey(), JSON.stringify(cart));
        loadCart();
        
        // Show notification
        showNotification('Item berhasil dihapus dari keranjang', 'success');
    }
}

// Update quantity
function updateQuantity(index, change) {
    const cart = JSON.parse(localStorage.getItem(getCartKey()) || '[]');
    cart[index].quantity += change;
    
    if (cart[index].quantity < 1) {
        removeFromCart(index);
        return;
    }
    
    localStorage.setItem(getCartKey(), JSON.stringify(cart));
    loadCart();
}

// Toggle select all items
function toggleSelectAll() {
    const cart = JSON.parse(localStorage.getItem(getCartKey()) || '[]');
    const selectAll = document.getElementById('selectAll');
    
    cart.forEach(item => {
        item.selected = selectAll.checked;
    });
    
    localStorage.setItem(getCartKey(), JSON.stringify(cart));
    loadCart();
}

// Toggle individual item selection
function toggleItemSelection(index) {
    const cart = JSON.parse(localStorage.getItem(getCartKey()) || '[]');
    const checkbox = document.getElementById(`item-${index}`);
    
    cart[index].selected = checkbox.checked;
    
    // Update select all checkbox
    const allSelected = cart.every(item => item.selected !== false);
    document.getElementById('selectAll').checked = allSelected;
    
    localStorage.setItem(getCartKey(), JSON.stringify(cart));
    updateSummary();
}

// Update summary without reloading entire cart
function updateSummary() {
    const cart = JSON.parse(localStorage.getItem(getCartKey()) || '[]');
    const selectedItems = cart.filter(item => item.selected !== false);
    const totalItems = selectedItems.reduce((sum, item) => sum + item.quantity, 0);
    const totalPrice = selectedItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    
    // Update summary section
    const summaryContainer = document.querySelector('.lg\\:col-span-1 .bg-white');
    if (summaryContainer) {
        const itemCountElement = summaryContainer.querySelector('.text-gray-600 .font-semibold');
        const totalPriceElement = summaryContainer.querySelector('.text-2xl.font-bold.text-blue-600');
        const checkoutButton = summaryContainer.querySelector('button');
        
        if (itemCountElement) itemCountElement.textContent = `${totalItems} item dipilih`;
        if (totalPriceElement) totalPriceElement.textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
        if (checkoutButton) {
            checkoutButton.innerHTML = `<i class="fas fa-check-circle mr-2"></i> Checkout (${totalItems} item)`;
            if (totalItems === 0) {
                checkoutButton.disabled = true;
                checkoutButton.className = 'w-full bg-gray-300 cursor-not-allowed text-white py-3 rounded-lg font-semibold transition shadow-lg';
            } else {
                checkoutButton.disabled = false;
                checkoutButton.className = 'w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 transform hover:scale-105 text-white py-3 rounded-lg font-semibold transition shadow-lg';
            }
        }
    }
}

// Update navbar cart count
function updateNavbarCart() {
    const cart = JSON.parse(localStorage.getItem(getCartKey()) || '[]');
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    
    // Update desktop cart badge
    const cartBadge = document.getElementById('cartBadge');
    if (cartBadge) {
        if (totalItems > 0) {
            cartBadge.textContent = totalItems;
            cartBadge.classList.remove('hidden');
            cartBadge.classList.add('flex');
        } else {
            cartBadge.classList.add('hidden');
            cartBadge.classList.remove('flex');
        }
    }
    
    // Update mobile cart badge
    const mobileCartBadge = document.getElementById('mobileCartBadge');
    if (mobileCartBadge) {
        if (totalItems > 0) {
            mobileCartBadge.textContent = totalItems;
            mobileCartBadge.classList.remove('hidden');
            mobileCartBadge.classList.add('inline-block');
        } else {
            mobileCartBadge.classList.add('hidden');
            mobileCartBadge.classList.remove('inline-block');
        }
    }
}

// Proceed to checkout
function proceedToCheckout() {
    const cart = JSON.parse(localStorage.getItem(getCartKey()) || '[]');
    const selectedItems = cart.filter(item => item.selected !== false);
    
    if (selectedItems.length === 0) {
        alert('Pilih minimal 1 layanan untuk checkout!');
        return;
    }
    
    // Store selected items in sessionStorage for checkout page
    sessionStorage.setItem('checkoutItems', JSON.stringify(selectedItems));
    
    // Redirect to checkout page
    window.location.href = '/checkout';
}

// Show notification
function showNotification(message, type = 'success') {
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const notification = document.createElement('div');
    notification.className = `fixed bottom-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-up`;
    notification.innerHTML = `
        <div class="flex items-center space-x-2">
            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Load cart on page load
document.addEventListener('DOMContentLoaded', loadCart);
</script>

<style>
.animate-slide-up {
    animation: slide-up 0.3s ease-out;
}

@keyframes slide-up {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>

<?= $this->endSection() ?>
