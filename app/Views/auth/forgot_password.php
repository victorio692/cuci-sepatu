<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-key text-white text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Lupa Password</h1>
                <p class="text-gray-600 mt-2">Masukkan email dan nomor HP untuk reset password</p>
            </div>

            <!-- Success Alert -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-green-700"><?= session()->getFlashdata('success') ?></span>
                    </div>
                </div>
            <?php endif; ?>

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
            <form action="/forgot-password" method="POST" class="space-y-6">
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
                        autofocus
                        value="<?= old('email') ?>"
                    >
                    <?php if (session()->getFlashdata('email_error')): ?>
                        <p class="text-red-500 text-sm mt-1">
                            <?= session()->getFlashdata('email_error') ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- No HP Field -->
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
                    <input 
                        type="tel" 
                        id="no_hp" 
                        name="no_hp" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="08123456789"
                        required
                        value="<?= old('no_hp') ?>"
                    >
                    <p class="text-gray-500 text-sm mt-1">
                        <i class="fas fa-info-circle"></i> Masukkan nomor HP yang terdaftar
                    </p>
                    <?php if (session()->getFlashdata('no_hp_error')): ?>
                        <p class="text-red-500 text-sm mt-1">
                            <?= session()->getFlashdata('no_hp_error') ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-paper-plane mr-2"></i> Kirim Link Reset
                </button>

                <!-- Footer Links -->
                <div class="text-center space-y-2 mt-6">
                    <p class="text-gray-600">
                        Sudah ingat password? <a href="/login" class="text-blue-600 hover:text-blue-700 font-medium">Login di sini</a>
                    </p>
                    <p class="text-gray-600">
                        Belum punya akun? <a href="/register" class="text-blue-600 hover:text-blue-700 font-medium">Daftar sekarang</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
