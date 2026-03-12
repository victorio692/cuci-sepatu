<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-plus text-white text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Daftar Akun</h1>
                <p class="text-gray-600 mt-2">Buat akun untuk mulai booking</p>
            </div>

            <!-- Toast Container -->
            <div id="toastContainer" class="fixed top-4 right-4 z-50"></div>

            <!-- Form -->
            <div id="registerFormContainer" class="space-y-5">

                <!-- Alert Box (untuk error message) -->
                <div id="alertBox" class="hidden p-3 border-l-4 border-red-500 bg-red-50 rounded flex items-center gap-2 animate-fadeIn">
                    <div class="flex-shrink-0">
                        <i class="fas fa-times-circle text-red-500 text-lg"></i>
                    </div>
                    <div class="flex-grow">
                        <p id="alertMessage" class="text-red-800 font-medium text-sm m-0"></p>
                    </div>
                    <button type="button" onclick="closeAlert()" class="flex-shrink-0 text-red-400 hover:text-red-600 focus:outline-none">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="full_name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Masukkan nama lengkap"
                        required
                    >
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input 
                        type="email" 
                        id="email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Masukkan email"
                        required
                    >
                </div>

                <!-- No WhatsApp -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">No WhatsApp</label>
                    <input 
                        type="tel" 
                        id="phone"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Masukkan nomor WhatsApp"
                        required
                    >
                    <p class="text-gray-500 text-sm mt-1">
                        <i class="fas fa-info-circle"></i> Nomor WhatsApp valid untuk verifikasi (minimal 10 digit)
                    </p>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password"
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Minimal 6 karakter"
                            required
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password', this)" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none"
                        >
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <p class="text-gray-500 text-sm mt-1">
                        <i class="fas fa-info-circle"></i> Minimal 6 karakter, kombinasi huruf dan angka lebih aman
                    </p>
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="confirm_password"
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Ulangi kata sandi"
                            required
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('confirm_password', this)" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none"
                        >
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div>
                    <div class="flex items-start">
                        <input 
                            type="checkbox" 
                            id="terms"
                            class="w-5 h-5 mt-0.5 text-blue-600 border-gray-300 rounded cursor-pointer custom-checkbox"
                            required
                        >
                        <label for="terms" class="ml-3 text-sm text-gray-700 cursor-pointer">
                            Saya setuju dengan <a href="/syarat" target="_blank" class="text-blue-600 hover:text-blue-700 font-medium">Syarat & Ketentuan</a> dan <a href="/kebijakan" target="_blank" class="text-blue-600 hover:text-blue-700 font-medium">Kebijakan Privasi</a>
                        </label>
                    </div>
                    <!-- Warning message untuk terms tidak dicentang -->
                    <div id="termsWarning" class="hidden mt-2 text-red-600 text-xs flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Anda harus setuju dengan Syarat & Ketentuan</span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="button" onclick="submitRegisterForm()" id="registerBtn" class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-user-check mr-2"></i> Daftar Sekarang
                </button>

                <!-- Footer Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        Sudah punya akun? <a href="/login" class="text-blue-600 hover:text-blue-700 font-medium">Login di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Register Loading Overlay -->
<div id="registerOverlay" class="hidden fixed inset-0 bg-gradient-to-br from-blue-600 to-blue-800 z-50 flex flex-col items-center justify-center">
    <div class="relative">
        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-2xl animate-bounce-slow">
            <i class="fas fa-user-check text-blue-600 text-4xl"></i>
        </div>
        <div class="absolute inset-0 border-4 border-white border-t-transparent rounded-full animate-spin-slow"></div>
    </div>
    
    <h2 class="text-white text-2xl font-bold mt-8 animate-fade-in">Mendaftar...</h2>
    <p class="text-blue-100 text-sm mt-2 animate-fade-in-delay">Mohon tunggu sebentar</p>
    
    <div class="flex space-x-2 mt-6">
        <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0s"></div>
        <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
        <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}
</style>

<script>
// Fungsi untuk menampilkan alert error
function showAlert(message) {
    const alertBox = document.getElementById('alertBox');
    const alertMessage = document.getElementById('alertMessage');
    
    alertMessage.textContent = message;
    alertBox.classList.remove('hidden');
    alertBox.classList.add('block');
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        closeAlert();
    }, 5000);
}

// Fungsi untuk menutup alert
function closeAlert() {
    const alertBox = document.getElementById('alertBox');
    alertBox.classList.add('hidden');
    alertBox.classList.remove('block');
}

// Toast notification function
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    toast.className = `${bgColor} text-white px-6 py-4 rounded-lg shadow-lg mb-4 transition-all duration-300 transform translate-x-0 flex items-center space-x-3`;
    toast.innerHTML = `
        <i class="fas ${icon}"></i>
        <span>${message}</span>
    `;
    
    toastContainer.appendChild(toast);
    
    setTimeout(() => {
        toast.style.transform = 'translateX(400px)';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

function togglePassword(fieldId, button) {
    const field = document.getElementById(fieldId);
    const icon = button.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Submit register form via API
async function submitRegisterForm() {
    console.log('🚀 Starting registration process...');
    
    const fullName = document.getElementById('full_name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const password = document.getElementById('password').value.trim();
    const confirmPassword = document.getElementById('confirm_password').value.trim();
    const terms = document.getElementById('terms').checked;
    
    // Validation
    if (!fullName || !email || !phone || !password || !confirmPassword) {
        showAlert('Semua field harus diisi');
        return;
    }
    
    if (!terms) {
        // Tampilkan warning kecil di bawah checkbox, jangan gunakan alert box
        const warningDiv = document.getElementById('termsWarning');
        warningDiv.classList.remove('hidden');
        warningDiv.classList.add('block');
        return;
    } else {
        // Sembunyikan warning jika checkbox di-centang
        const warningDiv = document.getElementById('termsWarning');
        warningDiv.classList.add('hidden');
        warningDiv.classList.remove('block');
    }
    
    if (password !== confirmPassword) {
        showAlert('Konfirmasi password tidak sesuai');
        return;
    }
    
    if (password.length < 6) {
        showAlert('Password minimal 6 karakter');
        return;
    }
    
    // Show overlay
    const overlay = document.getElementById('registerOverlay');
    const btn = document.getElementById('registerBtn');
    
    if (overlay) {
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
    }
    
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mendaftar...';
    }
    
    try {
        console.log('📍 Sending register request to API...');
        console.log('👤 Full Name:', fullName);
        console.log('📧 Email:', email);
        console.log('📱 Phone:', phone);
        
        const response = await fetch('/api/auth/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include',
            body: JSON.stringify({
                nama_lengkap: fullName,
                email: email,
                no_hp: phone,
                password: password,
                confirm_password: confirmPassword,
                alamat: ''
            })
        });
        
        console.log('📊 Response Status:', response.status);
        const result = await response.json();
        console.log('✅ Full API Response:', result);
        
        if (result.status === 'success') {
            showToast(result.message || 'Registrasi berhasil!', 'success');
            console.log('✅ Registration successful, redirecting...');
            console.log('👤 User:', result.data?.user);
            
            // Redirect to home
            setTimeout(() => {
                window.location.href = '/login';
            }, 1000);
        } else {
            // Error response - jika email sudah terdaftar atau error lainnya
            console.log('❌ Registration failed:', result.message);
            
            // Show error messages
            if (result.errors) {
                // Show validation errors from API
                const errorMessages = Object.values(result.errors).join(', ');
                showAlert(errorMessages);
            } else {
                const errorMessage = result.message || 'Email sudah terdaftar. Silakan gunakan email lain atau masuk';
                showAlert(errorMessage);
            }
            
            // Hide overlay
            if (overlay) {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
            }
            
            // Re-enable button
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-user-check mr-2"></i> Daftar Sekarang';
            }
        }
    } catch (error) {
        console.error('❌ Registration error:', error);
        showAlert('Terjadi kesalahan. Silakan coba lagi!');
        
        // Hide overlay
        if (overlay) {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }
        
        // Re-enable button
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-user-check mr-2"></i> Daftar Sekarang';
        }
    }
}

// Allow Enter key to submit
document.addEventListener('DOMContentLoaded', function() {
    const inputs = ['full_name', 'email', 'phone', 'password', 'confirm_password'];
    
    inputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    submitRegisterForm();
                }
            });
        }
    });
    
    // Event listener untuk checkbox terms - sembunyikan warning ketika di-centang
    const termsCheckbox = document.getElementById('terms');
    if (termsCheckbox) {
        termsCheckbox.addEventListener('change', function() {
            const warningDiv = document.getElementById('termsWarning');
            if (this.checked) {
                warningDiv.classList.add('hidden');
                warningDiv.classList.remove('block');
            }
        });
    }
});
</script>
<?= $this->endSection() ?>
