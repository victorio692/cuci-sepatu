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

            <!-- Error Alert -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <span class="text-red-700"><?= session()->getFlashdata('error') ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form action="/login" method="POST" class="space-y-6">
                <?= csrf_field() ?>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Masukkan email"
                        required
                        value="<?= old('email') ?>"
                    >
                    <?php if (session()->getFlashdata('email_error')): ?>
                        <p class="text-red-500 text-sm mt-1">
                            <?= session()->getFlashdata('email_error') ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
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
                    <?php if (session()->getFlashdata('password_error')): ?>
                        <p class="text-red-500 text-sm mt-1">
                            <?= session()->getFlashdata('password_error') ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="remember" 
                        name="remember"
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                    >
                    <label for="remember" class="ml-2 text-sm text-gray-700">Ingat saya</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-300">
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
            </form>
        </div>
    </div>
</div>

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
