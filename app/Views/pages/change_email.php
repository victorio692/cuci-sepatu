<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- Main Content With Sidebar -->
<div class="min-h-screen bg-gray-50 pt-24 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar -->
            <div class="hidden lg:block lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-24">
                    <!-- User Info Header -->
                    <div class="p-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50">
                        <div class="flex flex-col items-center text-center">
                            <?php if (!empty($user['foto_profil'])): ?>
                                <img src="<?= base_url('uploads/' . $user['foto_profil']) ?>" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg mb-3">
                            <?php else: ?>
                                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-bold border-4 border-white shadow-lg mb-3">
                                    <?= strtoupper(substr($user['full_name'] ?? $user['nama_lengkap'] ?? 'U', 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                            <p class="text-base font-bold text-gray-900 mb-1"><?= $user['full_name'] ?? $user['nama_lengkap'] ?? 'User' ?></p>
                            <p class="text-xs text-gray-600"><?= $user['email'] ?></p>
                        </div>
                    </div>

                    <!-- Navigation Menu -->
                    <div class="p-3">
                        <div class="mb-4">
                            <div class="px-3 py-2 text-xs font-bold text-gray-500 uppercase flex items-center gap-2 mb-2">
                                <i class="fas fa-user"></i> Akun Saya
                            </div>
                            <a href="/profile/detail" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition">
                                <i class="fas fa-user-circle w-5"></i> Profil
                            </a>
                            <a href="/profile/change-password" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition">
                                <i class="fas fa-lock w-5"></i> Ubah Password
                            </a>
                            <a href="/profile/change-email" id="menu-email" class="flex items-center gap-3 px-4 py-3 text-sm text-white bg-blue-600 rounded-lg font-medium shadow-sm">
                                <i class="fas fa-envelope w-5"></i> Ubah Email
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="bg-green-50 border border-green-200 p-4 mb-6 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                            <span class="text-green-700"><?= session()->getFlashdata('success') ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="bg-red-50 border border-red-200 p-4 mb-6 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                            <span class="text-red-700"><?= session()->getFlashdata('error') ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Change Email Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Ubah Email</h2>
                        <p class="text-sm text-gray-600 mt-1">Ubah alamat email Anda untuk keamanan akun</p>
                    </div>
                    
                    <div class="p-6">
                        <form action="/change-email" method="POST" class="max-w-2xl">
                            <?= csrf_field() ?>

                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Saat Ini</label>
                                    <input 
                                        type="email" 
                                        value="<?= $user['email'] ?>" 
                                        disabled 
                                        class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg text-gray-600 cursor-not-allowed"
                                    >
                                </div>

                                <div>
                                    <label for="new_email" class="block text-sm font-medium text-gray-700 mb-2">Email Baru</label>
                                    <input 
                                        type="email" 
                                        id="new_email" 
                                        name="new_email" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Masukkan email baru Anda"
                                        required
                                    >
                                    <p class="text-xs text-gray-500 mt-1">Email harus berbeda dari email saat ini</p>
                                </div>

                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                                    <div class="relative">
                                        <input 
                                            type="password" 
                                            id="current_password" 
                                            name="current_password" 
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-12"
                                            placeholder="Masukkan password Anda"
                                            required
                                        >
                                        <button 
                                            type="button" 
                                            onclick="togglePasswordField('current_password', this)" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Kami memerlukan password untuk mengubah email</p>
                                </div>

                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <p class="text-sm font-medium text-blue-900 mb-2">
                                        <i class="fas fa-info-circle"></i> Catatan Penting:
                                    </p>
                                    <ul class="text-sm text-blue-800 space-y-1 ml-5">
                                        <li>• Email harus valid dan belum terdaftar</li>
                                        <li>• Pastikan password yang Anda masukkan benar</li>
                                        <li>• Setelah diubah, Anda akan login dengan email baru</li>
                                    </ul>
                                </div>

                                <div class="flex gap-3 pt-4">
                                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                        <i class="fas fa-check"></i> Ubah Email
                                    </button>
                                    <a href="/profile/detail" class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium rounded-lg transition">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function togglePasswordField(fieldId, button) {
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
