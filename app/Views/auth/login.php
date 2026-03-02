<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-lock text-white text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Login</h1>
                <p class="text-gray-600 mt-2">Masuk untuk melanjutkan</p>
            </div>

            <!-- Toast Container -->
            <div id="toastContainer" class="fixed top-4 right-4 z-50"></div>

            <!-- Form -->
            <div id="loginFormContainer" class="space-y-6">

                <!-- Email Field -->
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

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password"
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Masukkan password"
                            required
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password', this)" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none"
                        >
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="remember"
                        class="w-5 h-5 text-blue-600 border-gray-300 rounded cursor-pointer custom-checkbox"
                    >
                    <label for="remember" class="ml-3 text-sm text-gray-700 cursor-pointer">Ingat saya</label>
                </div>

                <!-- Submit Button -->
                <button type="button" onclick="submitLoginForm()" id="loginBtn" class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </button>

                <!-- Footer Links -->
                <div class="text-center space-y-2 mt-6">
                    <p class="text-gray-600">
                        Belum punya akun? <a href="/register" class="text-blue-600 hover:text-blue-700 font-medium">Daftar di sini</a>
                    </p>
                    <p>
                        <a href="/forgot-password" class="text-blue-600 hover:text-blue-700 font-medium text-sm">Lupa password?</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login Animation Overlay -->
<div id="loginOverlay" class="hidden fixed inset-0 bg-gradient-to-br from-blue-600 to-blue-800 z-50 flex-col items-center justify-center">
    <div class="relative w-32 h-32">
        <!-- Icon dengan background lingkaran -->
        <div class="absolute inset-0 bg-white rounded-full flex items-center justify-center shadow-2xl animate-bounce-slow">
            <i class="fas fa-arrow-right-from-bracket text-blue-600 text-5xl"></i>
        </div>
        <!-- Rotating circle border -->
        <div class="absolute inset-0 border-4 border-white border-t-transparent rounded-full animate-spin-slow"></div>
    </div>
    
    <!-- Text -->
    <h2 class="text-white text-2xl font-bold mt-8 animate-fade-in">Logging In...</h2>
    <p class="text-blue-100 text-sm mt-2 animate-fade-in-delay">Mohon tunggu sebentar</p>
    
    <!-- Loading dots -->
    <div class="flex space-x-2 mt-6">
        <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0s"></div>
        <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
        <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
    </div>
</div>

<script>
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

// Submit login form via API
async function submitLoginForm() {
    console.log('🚀 Starting login process...');
    
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const remember = document.getElementById('remember').checked;
    
    // Validation
    if (!email || !password) {
        showToast('Email dan password harus diisi', 'error');
        return;
    }
    
    // Show overlay
    const overlay = document.getElementById('loginOverlay');
    const btn = document.getElementById('loginBtn');
    
    if (overlay) {
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
    }
    
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Loading...';
    }
    
    try {
        console.log('📍 Sending login request to API...');
        console.log('📧 Email:', email);
        
        const response = await fetch('/api/auth/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include',
            body: JSON.stringify({
                email: email,
                password: password,
                remember: remember
            })
        });
        
        console.log('📊 Response Status:', response.status);
        const result = await response.json();
        console.log('✅ Full API Response:', result);
        
        if (result.status === 'success') {
            showToast(result.message || 'Login berhasil!', 'success');
            console.log('✅ Login successful, redirecting...');
            console.log('👤 User:', result.data?.user);
            
            // Redirect based on role
            setTimeout(() => {
                if (result.data?.user?.role === 'admin') {
                    window.location.href = '/admin';
                } else {
                    window.location.href = '/';
                }
            }, 500);
        } else {
            // Error response
            console.log('❌ Login failed:', result.message);
            showToast(result.message || 'Login gagal', 'error');
            
            // Hide overlay
            if (overlay) {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
            }
            
            // Re-enable button
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-sign-in-alt mr-2"></i> Login';
            }
        }
    } catch (error) {
        console.error('❌ Login error:', error);
        showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
        
        // Hide overlay
        if (overlay) {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }
        
        // Re-enable button
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-sign-in-alt mr-2"></i> Login';
        }
    }
}

// Allow Enter key to submit
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    
    [emailInput, passwordInput].forEach(input => {
        if (input) {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    submitLoginForm();
                }
            });
        }
    });
});
</script>
<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
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
</script>
<?= $this->endSection() ?>
