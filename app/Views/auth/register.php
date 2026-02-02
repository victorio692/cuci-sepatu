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
            <form action="/register" method="POST" class="space-y-5">
                <?= csrf_field() ?>

                <!-- Nama Lengkap -->
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="full_name" 
                        name="full_name" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Masukkan nama lengkap"
                        required
                        value="<?= old('full_name') ?>"
                    >
                    <?php if (session()->getFlashdata('full_name_error')): ?>
                        <p class="text-red-500 text-sm mt-1">
                            <?= session()->getFlashdata('full_name_error') ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Email -->
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

                <!-- No WhatsApp -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">No WhatsApp</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Masukkan nomor WhatsApp"
                        required
                        value="<?= old('phone') ?>"
                    >
                    <p class="text-gray-500 text-sm mt-1">
                        <i class="fas fa-info-circle"></i> Nomor WhatsApp valid untuk verifikasi (minimal 10 digit)
                    </p>
                    <?php if (session()->getFlashdata('phone_error')): ?>
                        <p class="text-red-500 text-sm mt-1">
                            <?= session()->getFlashdata('phone_error') ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
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
                    <?php if (session()->getFlashdata('password_error')): ?>
                        <p class="text-red-500 text-sm mt-1">
                            <?= session()->getFlashdata('password_error') ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                            placeholder="Ulangi password"
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
                    <?php if (session()->getFlashdata('confirm_password_error')): ?>
                        <p class="text-red-500 text-sm mt-1">
                            <?= session()->getFlashdata('confirm_password_error') ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start">
                    <input 
                        type="checkbox" 
                        id="terms" 
                        name="terms"
                        class="w-4 h-4 mt-1 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                        required
                    >
                    <label for="terms" class="ml-2 text-sm text-gray-700">
                        Saya setuju dengan <a href="/syarat" target="_blank" class="text-blue-600 hover:text-blue-700 font-medium">Syarat & Ketentuan</a> dan <a href="/kebijakan" target="_blank" class="text-blue-600 hover:text-blue-700 font-medium">Kebijakan Privasi</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-300">
                    <i class="fas fa-user-check mr-2"></i> Daftar Sekarang
                </button>

                <!-- Footer Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-600">
                        Sudah punya akun? <a href="/login" class="text-blue-600 hover:text-blue-700 font-medium">Login di sini</a>
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
