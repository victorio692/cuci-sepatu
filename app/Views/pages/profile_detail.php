<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- Mobile Profile View -->
<div class="block lg:hidden min-h-screen bg-gray-50">

    <!-- Content -->
    <div class="pb-8 px-4 py-4">
        <!-- Back Button -->
        <a href="javascript:history.back()" class="inline-flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-200 transition mb-4">
            <i class="fas fa-chevron-left text-xl text-gray-700 font-bold"></i>
        </a>

        <!-- User Profile Card -->
        <button onclick="openEditModal('edit-profile')" class="w-full bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6 flex items-center justify-between hover:shadow-md transition">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <?php if (!empty($user['foto_profil'])): ?>
                        <img src="<?= base_url('uploads/' . $user['foto_profil']) ?>" class="w-14 h-14 rounded-full object-cover border-2 border-blue-200">
                    <?php else: ?>
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            <?= strtoupper(substr($user['full_name'] ?? $user['nama_lengkap'] ?? 'U', 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                </div>
                <div class="text-left min-w-0">
                    <p class="font-semibold text-gray-900 text-sm"><?= $user['full_name'] ?? $user['nama_lengkap'] ?? 'User' ?></p>
                    <p class="text-xs text-gray-600 truncate"><?= $user['email'] ?></p>
                </div>
            </div>
            <i class="fas fa-chevron-right text-gray-400"></i>
        </button>

        <!-- Profile Photo Upload -->
        <form id="profilePhotoForm" action="/update-profile-photo" method="POST" enctype="multipart/form-data" class="hidden">
            <?= csrf_field() ?>
            <input type="file" id="profilePhoto" name="profile_photo" accept="image/png,image/jpeg,image/jpg">
        </form>

        <!-- Sections -->
        <div class="space-y-6">
            <!-- Personal Information Section -->
            <div>
                <h3 class="text-xs font-bold text-gray-500 uppercase px-4 mb-2">Informasi Pribadi</h3>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Name -->
                    <button onclick="openEditModal('edit-name')" class="w-full flex items-center justify-between px-4 py-4 border-b border-gray-100 hover:bg-gray-50 transition text-left">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <i class="fas fa-user text-gray-400 w-5 flex-shrink-0"></i>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs text-gray-500 font-medium">Nama</p>
                                <p class="text-sm font-medium text-gray-900 truncate"><?= $user['full_name'] ?? $user['nama_lengkap'] ?? '-' ?></p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 text-sm flex-shrink-0 ml-2"></i>
                    </button>
                    <!-- Email -->
                    <button onclick="openEditModal('edit-email')" class="w-full flex items-center justify-between px-4 py-4 border-b border-gray-100 hover:bg-gray-50 transition text-left">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <i class="fas fa-envelope text-gray-400 w-5 flex-shrink-0"></i>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs text-gray-500 font-medium">Email</p>
                                <p class="text-sm font-medium text-gray-900 truncate"><?= $user['email'] ?></p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 text-sm flex-shrink-0 ml-2"></i>
                    </button>
                    <!-- Phone -->
                    <button onclick="openEditModal('edit-phone')" class="w-full flex items-center justify-between px-4 py-4 border-b border-gray-100 hover:bg-gray-50 transition text-left">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <i class="fas fa-phone text-gray-400 w-5 flex-shrink-0"></i>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs text-gray-500 font-medium">Nomor Telepon</p>
                                <p class="text-sm font-medium text-gray-900 truncate"><?= !empty($user['no_hp']) ? $user['no_hp'] : 'Belum diisi' ?></p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 text-sm flex-shrink-0 ml-2"></i>
                    </button>
                    <!-- Address -->
                    <button onclick="openEditModal('edit-address')" class="w-full flex items-center justify-between px-4 py-4 hover:bg-gray-50 transition text-left">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <i class="fas fa-map-marker-alt text-gray-400 w-5 flex-shrink-0"></i>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs text-gray-500 font-medium">Alamat</p>
                                <p class="text-sm font-medium text-gray-900 truncate"><?= !empty($user['address'] ?? $user['alamat']) ? ($user['address'] ?? $user['alamat']) : 'Belum diisi' ?></p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 text-sm flex-shrink-0 ml-2"></i>
                    </button>
                </div>
            </div>

            <!-- Security Section -->
            <div>
                <h3 class="text-xs font-bold text-gray-500 uppercase px-4 mb-2">Keamanan</h3>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Change Password -->
                    <button onclick="openEditModal('edit-password')" class="w-full flex items-center justify-between px-4 py-4 border-b border-gray-100 hover:bg-gray-50 transition text-left">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <i class="fas fa-lock text-gray-400 w-5 flex-shrink-0"></i>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs text-gray-500 font-medium">Kata Sandi</p>
                                <p class="text-sm font-medium text-gray-900">Ubah Kata Sandi</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-gray-400 text-sm flex-shrink-0 ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Desktop View -->
<div class="hidden lg:block min-h-screen bg-gray-50 pt-24 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar - Hidden on Mobile, Visible on Desktop -->
            <div class="hidden lg:block lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-24">
                    <!-- User Info Header -->
                    <div class="p-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50">
                        <div class="flex flex-col items-center text-center">
                            <?php if (!empty($user['foto_profil'])): ?>
                                <img src="<?= base_url('uploads/' . $user['foto_profil']) ?>" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg mb-3">
                            <?php else: ?>
                                <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center text-white text-2xl font-bold border-4 border-white shadow-lg mb-3">
                                    <?= strtoupper(substr($user['full_name'] ?? $user['nama_lengkap'] ?? 'U', 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                            <p class="text-base font-bold text-gray-900 mb-1"><?= $user['full_name'] ?? $user['nama_lengkap'] ?? 'User' ?></p>
                            <p class="text-xs text-gray-600 mb-2"><?= $user['email'] ?></p>
                            <button onclick="document.getElementById('profilePhoto').click()" class="text-xs text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1 bg-white px-3 py-1.5 rounded-full shadow-sm hover:shadow transition">
                                <i class="fas fa-camera"></i> Ubah Foto
                            </button>
                        </div>
                    </div>

                    <!-- Navigation Menu -->
                    <div class="p-3">
                        <!-- Akun Saya Section -->
                        <div class="mb-4">
                            <div class="px-3 py-2 text-xs font-bold text-gray-500 uppercase flex items-center gap-2 mb-2">
                                <i class="fas fa-user"></i> Akun Saya
                            </div>
                            <a href="#" onclick="showSection('profile'); return false;" id="menu-profile" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 rounded-lg font-medium mb-1 transition cursor-pointer">
                                <i class="fas fa-user-circle w-5"></i> Akun
                            </a>
                            <a href="#" onclick="showSection('email'); return false;" id="menu-email" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg transition mb-1">
                                <i class="fas fa-envelope w-5"></i> Ubah Email
                            </a>
                            <a href="#" onclick="showSection('phone'); return false;" id="menu-phone" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg transition mb-1">
                                <i class="fas fa-phone w-5"></i> Ubah Nomor Telepon
                            </a>
                            <a href="#" onclick="showSection('password'); return false;" id="menu-password" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg transition">
                                <i class="fas fa-lock w-5"></i> Ubah Kata Sandi
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Cards - Visible only on Mobile -->
            <div class="block lg:hidden col-span-1 grid grid-cols-2 gap-3 mb-6">
                <a href="#" onclick="showSection('profile'); return false;" id="mobile-menu-profile" class="bg-blue-600 text-white rounded-xl p-4 shadow-sm flex flex-col items-center justify-center gap-3 transition min-h-24">
                    <i class="fas fa-user-circle text-2xl"></i>
                    <span class="text-sm font-medium">Akun</span>
                </a>
                <a href="#" onclick="showSection('email'); return false;" id="mobile-menu-email" class="group bg-white text-gray-700 rounded-xl p-4 shadow-sm flex flex-col items-center justify-center gap-2 hover:bg-blue-600 hover:text-white transition border border-gray-200">
                    <i class="fas fa-envelope text-2xl group-hover:!text-white"></i>
                    <span class="text-sm font-medium group-hover:!text-white">Ubah Email</span>
                </a>
                <a href="#" onclick="showSection('phone'); return false;" id="mobile-menu-phone" class="group bg-white text-gray-700 rounded-xl p-4 shadow-sm flex flex-col items-center justify-center gap-2 hover:bg-blue-600 hover:text-white transition border border-gray-200">
                    <i class="fas fa-phone text-2xl group-hover:!text-white"></i>
                    <span class="text-sm font-medium group-hover:!text-white">Ubah Nomor Telepon</span>
                </a>
                <a href="#" onclick="showSection('password'); return false;" id="mobile-menu-password" class="group bg-white text-gray-700 rounded-xl p-4 shadow-sm flex flex-col items-center justify-center gap-2 hover:bg-blue-600 hover:text-white transition border border-gray-200">
                    <i class="fas fa-lock text-2xl group-hover:!text-white"></i>
                    <span class="text-sm font-medium group-hover:!text-white">Ubah Kata Sandi</span>
                </a>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">

                <div id="toastContainer" class="fixed top-4 right-4 z-50"></div>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="bg-green-50 border border-green-200 p-4 mb-6 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                            <span class="text-green-700"><?= session()->getFlashdata('success') ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Profile Header Card -->
                <div id="section-profile" class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Profil Saya</h2>
                        <p class="text-sm text-gray-600 mt-1">Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex flex-col lg:flex-row gap-8">
                            <!-- Form Section -->
                            <div class="flex-1">
                                <form id="profilePhotoForm" action="/update-profile-photo" method="POST" enctype="multipart/form-data" class="hidden">
                                    <?= csrf_field() ?>
                                    <input type="file" id="profilePhoto" name="profile_photo" accept="image/png,image/jpeg,image/jpg">
                                </form>

                                <!-- Profile Form -->
                                <form id="profileForm" class="space-y-5">
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                                            <input 
                                                type="text" 
                                                id="full_name" 
                                                name="full_name" 
                                                value="<?= $user['full_name'] ?? $user['nama_lengkap'] ?? '' ?>" 
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            >
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                            <input type="text" id="emailReadonly" value="<?= $user['email'] ?>" disabled class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg text-gray-500 cursor-not-allowed">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                            <input type="text" id="phoneReadonly" value="<?= $user['no_hp'] ?? '-' ?>" disabled class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg text-gray-500 cursor-not-allowed">
                                        </div>

                                        <div>
                                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                                            <textarea 
                                                id="address" 
                                                name="address" 
                                                rows="3"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            ><?= $user['address'] ?? $user['alamat'] ?? '' ?></textarea>
                                        </div>
                                    </div>

                                    

                                    <div class="pt-4">
                                        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Profile Photo Section -->
                            
                        </div>
                    </div>
                </div>

                <!-- Change Password Section -->
                <div id="section-password" class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6 overflow-hidden hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Ubah Kata Sandi</h2>
                        <p class="text-sm text-gray-600 mt-1">Pastikan akun Anda menggunakan kata sandi yang aman</p>
                    </div>
                    
                    <div class="p-6">
                        <form id="passwordForm" class="max-w-2xl">

                            <div class="space-y-5">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi Saat Ini</label>
                                    <div class="relative">
                                        <input 
                                            type="password" 
                                            id="current_password" 
                                            name="current_password" 
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-12"
                                            placeholder="Masukkan kata sandi saat ini"
                                            required
                                        >
                                        <button 
                                            type="button" 
                                            onclick="togglePasswordField('current_password', this)" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi Baru</label>
                                    <div class="relative">
                                        <input 
                                            type="password" 
                                            id="new_password" 
                                            name="new_password" 
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-12"
                                            placeholder="Minimal 6 karakter"
                                            required
                                            minlength="6"
                                        >
                                        <button 
                                            type="button" 
                                            onclick="togglePasswordField('new_password', this)" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
                                </div>

                                <div>
                                    <label for="confirm_password_section" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                                    <div class="relative">
                                        <input 
                                            type="password" 
                                            id="confirm_password_section" 
                                            name="confirm_password" 
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-12"
                                            placeholder="Ulangi kata sandi baru"
                                            required
                                            minlength="6"
                                        >
                                        <button 
                                            type="button" 
                                            onclick="togglePasswordField('confirm_password_section', this)" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <p class="text-sm font-medium text-blue-900 mb-2">
                                        <i class="fas fa-info-circle"></i> Persyaratan Kata Sandi:
                                    </p>
                                    <ul class="text-sm text-blue-800 space-y-1 ml-5">
                                        <li>• Minimal 6 karakter</li>
                                        <li>• Kata sandi baru dan konfirmasi harus sama</li>
                                    </ul>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                        <i class="fas fa-check"></i> Ubah Kata Sandi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Email Section -->
                <div id="section-email" class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6 overflow-hidden hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Ubah Email</h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui alamat email Anda untuk login dan notifikasi</p>
                    </div>
                    
                    <div class="p-6">
                        <form action="/change-email" method="POST" id="emailForm" class="max-w-2xl">
                            <?= csrf_field() ?>

                            <div class="space-y-5">
                                <div>
                                    <label for="current_email_display" class="block text-sm font-medium text-gray-700 mb-2">Email Saat Ini</label>
                                    <input 
                                        type="email" 
                                        id="current_email_display" 
                                        value="<?= $user['email'] ?>" 
                                        disabled
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed"
                                    >
                                </div>

                                <div>
                                    <label for="new_email_input" class="block text-sm font-medium text-gray-700 mb-2">Email Baru</label>
                                    <input 
                                        type="email" 
                                        id="new_email_input" 
                                        name="new_email" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Masukkan email baru"
                                        required
                                    >
                                </div>

                                <div>
                                    <label for="email_current_password" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
                                    <div class="relative">
                                        <input 
                                            type="password" 
                                            id="email_current_password" 
                                            name="current_password" 
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-12"
                                            placeholder="Masukkan kata sandi Anda"
                                            required
                                        >
                                        <button 
                                            type="button" 
                                            onclick="togglePasswordField('email_current_password', this)" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Untuk keamanan, konfirmasi dengan kata sandi Anda</p>
                                </div>

                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <p class="text-sm font-medium text-yellow-900 mb-2">
                                        <i class="fas fa-exclamation-triangle"></i> Perhatian:
                                    </p>
                                    <ul class="text-sm text-yellow-800 space-y-1 ml-5">
                                        <li>• Email baru akan digunakan untuk login</li>
                                        <li>• Pastikan email yang Anda masukkan valid dan aktif</li>
                                    </ul>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                        <i class="fas fa-check"></i> Ubah Email
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Phone Section -->
                <div id="section-phone" class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6 overflow-hidden hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Ubah Nomor Telepon</h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui nomor telepon Anda untuk notifikasi dan verifikasi</p>
                    </div>
                    
                    <div class="p-6">
                        <form action="/change-phone" method="POST" id="phoneForm" class="max-w-2xl">
                            <?= csrf_field() ?>

                            <div class="space-y-5">
                                <div>
                                    <label for="current_phone_display" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon Saat Ini</label>
                                    <input 
                                        type="text" 
                                        id="current_phone_display" 
                                        value="<?= $user['no_hp'] ?? '-' ?>" 
                                        disabled
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed"
                                    >
                                </div>

                                <div>
                                    <label for="new_phone_input" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon Baru</label>
                                    <input 
                                        type="tel" 
                                        id="new_phone_input" 
                                        name="new_phone" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="08xxxxxxxxxx"
                                        pattern="08[0-9]{9,}"
                                        required
                                    >
                                    <p class="text-xs text-gray-500 mt-1">Format: 08xxxxxxxxxx (minimal 11 digit)</p>
                                </div>

                                <div>
                                    <label for="phone_current_password" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
                                    <div class="relative">
                                        <input 
                                            type="password" 
                                            id="phone_current_password" 
                                            name="current_password" 
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-12"
                                            placeholder="Masukkan kata sandi Anda"
                                            required
                                        >
                                        <button 
                                            type="button" 
                                            onclick="togglePasswordField('phone_current_password', this)" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Untuk keamanan, konfirmasi dengan kata sandi Anda</p>
                                </div>

                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <p class="text-sm font-medium text-yellow-900 mb-2">
                                        <i class="fas fa-exclamation-triangle"></i> Perhatian:
                                    </p>
                                    <ul class="text-sm text-yellow-800 space-y-1 ml-5">
                                        <li>• Nomor telepon akan digunakan untuk notifikasi WhatsApp</li>
                                        <li>• Pastikan nomor yang Anda masukkan aktif</li>
                                    </ul>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                        <i class="fas fa-check"></i> Ubah Nomor Telepon
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div> 


<!-- Change Email Modal -->
<div id="changeEmailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) closeModal('changeEmailModal')">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900">Ubah Email</h3>
            <button class="text-gray-400 hover:text-gray-600 text-xl" onclick="closeModal('changeEmailModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="/change-email" method="POST" id="changeEmailForm" class="p-6 space-y-4">
            <?= csrf_field() ?>

            <div>
                <label for="current_email" class="block text-sm font-semibold text-gray-700 mb-2">Email Saat Ini</label>
                <input 
                    type="email" 
                    id="current_email" 
                    value="<?= $user['email'] ?>" 
                    disabled
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed"
                >
            </div>

            <div>
                <label for="new_email" class="block text-sm font-semibold text-gray-700 mb-2">Email Baru</label>
                <input 
                    type="email" 
                    id="new_email" 
                    name="new_email" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Masukkan email baru"
                    required
                >
            </div>

            <div>
                <label for="email_password" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                <input 
                    type="password" 
                    id="email_password" 
                    name="current_password" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Masukkan password Anda"
                    required
                >
                <p class="text-xs text-gray-500 mt-1">Untuk keamanan, konfirmasi dengan password Anda</p>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" class="flex-1 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition" onclick="closeModal('changeEmailModal')">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Ubah Email
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Change Phone Modal -->
<div id="changePhoneModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) closeModal('changePhoneModal')">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900">Ubah Nomor Telepon</h3>
            <button class="text-gray-400 hover:text-gray-600 text-xl" onclick="closeModal('changePhoneModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="/change-phone" method="POST" id="changePhoneForm" class="p-6 space-y-4">
            <?= csrf_field() ?>

            <div>
                <label for="current_phone" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon Saat Ini</label>
                <input 
                    type="text" 
                    id="current_phone" 
                    value="<?= $user['no_hp'] ?? '-' ?>" 
                    disabled
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed"
                >
            </div>

            <div>
                <label for="new_phone" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon Baru</label>
                <input 
                    type="tel" 
                    id="new_phone" 
                    name="new_phone" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="08xxxxxxxxxx"
                    pattern="08[0-9]{9,}"
                    required
                >
                <p class="text-xs text-gray-500 mt-1">Format: 08xxxxxxxxxx (minimal 11 digit)</p>
            </div>

            <div>
                <label for="phone_password" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                <input 
                    type="password" 
                    id="phone_password" 
                    name="current_password" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Masukkan password Anda"
                    required
                >
                <p class="text-xs text-gray-500 mt-1">Untuk keamanan, konfirmasi dengan password Anda</p>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" class="flex-1 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition" onclick="closeModal('changePhoneModal')">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Ubah Nomor Telepon
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Change Password Modal -->
<div id="changePasswordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) closeModal('changePasswordModal')">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900">Ubah Kata Sandi</h3>
            <button class="text-gray-400 hover:text-gray-600 text-xl" onclick="closeModal('changePasswordModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="/change-password" method="POST" id="changePasswordForm" class="p-6 space-y-4">
            <?= csrf_field() ?>

            <div>
                <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Lama</label>
                <input 
                    type="password" 
                    id="current_password" 
                    name="current_password" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    required
                >
            </div>

            <div>
                <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Baru</label>
                <input 
                    type="password" 
                    id="new_password" 
                    name="new_password" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    required
                    minlength="6"
                >
                <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
            </div>

            <div>
                <label for="confirm_password" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                <input 
                    type="password" 
                    id="confirm_password" 
                    name="confirm_password" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    required
                    minlength="6"
                >
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" class="flex-1 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition" onclick="closeModal('changePasswordModal')">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Ubah Kata Sandi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Mobile Edit Modals -->

<!-- Edit Profile Modal (Avatar + Name + Email) -->
<div id="edit-profile" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) closeEditModal('edit-profile')">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900">Profil</h3>
            <button class="text-gray-400 hover:text-gray-600 text-xl" onclick="closeEditModal('edit-profile')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <form id="mobileEditProfileForm" class="space-y-4">
                <?= csrf_field() ?>
                <div class="flex flex-col items-center mb-6">
                    <?php if (!empty($user['foto_profil'])): ?>
                        <img id="mobileProfileImg" src="<?= base_url('uploads/' . $user['foto_profil']) ?>" class="w-32 h-32 rounded-full object-cover border-2 border-gray-200 mb-3">
                    <?php else: ?>
                        <div id="mobileProfileImg" class="w-32 h-32 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-4xl mb-3">
                            <?= strtoupper(substr($user['full_name'] ?? $user['nama_lengkap'] ?? 'U', 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    <button type="button" onclick="document.getElementById('mobileProfilePhoto').click()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-sm transition flex items-center gap-2">
                        <i class="fas fa-camera"></i> Ubah Foto
                    </button>
                    <input type="file" id="mobileProfilePhoto" name="profile_photo" accept="image/png,image/jpeg,image/jpg" style="display: none;">
                    <?= csrf_field() ?>
                </div>
                <div>
                    <label for="mobileFullName" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="mobileFullName" 
                        value="<?= $user['full_name'] ?? $user['nama_lengkap'] ?? '' ?>" 
                        disabled
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed"
                    >
                </div>
                <div>
                    <label for="mobileEmail" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input 
                        type="email" 
                        id="mobileEmail" 
                        value="<?= $user['email'] ?>" 
                        disabled
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed"
                    >
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" class="flex-1 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition" onclick="closeEditModal('edit-profile')">
                        Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Name Modal -->
<div id="edit-name" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) closeEditModal('edit-name')">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900">Ubah Nama</h3>
            <button class="text-gray-400 hover:text-gray-600 text-xl" onclick="closeEditModal('edit-name')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="/api/auth/profile" method="PUT" id="mobileEditNameForm" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <div>
                <label for="mobileNameInput" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input 
                    type="text" 
                    id="mobileNameInput" 
                    name="nama_lengkap" 
                    value="<?= $user['full_name'] ?? $user['nama_lengkap'] ?? '' ?>" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    required
                >
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" class="flex-1 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition" onclick="closeEditModal('edit-name')">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Email Modal -->
<div id="edit-email" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) closeEditModal('edit-email')">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900">Ubah Email</h3>
            <button class="text-gray-400 hover:text-gray-600 text-xl" onclick="closeEditModal('edit-email')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="/change-email" method="POST" id="mobileEditEmailForm" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <div>
                <label for="mobileCurrentEmail" class="block text-sm font-semibold text-gray-700 mb-2">Email Saat Ini</label>
                <input 
                    type="email" 
                    id="mobileCurrentEmail" 
                    value="<?= $user['email'] ?>" 
                    disabled
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed"
                >
            </div>
            <div>
                <label for="mobileNewEmail" class="block text-sm font-semibold text-gray-700 mb-2">Email Baru</label>
                <input 
                    type="email" 
                    id="mobileNewEmail" 
                    name="new_email" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Masukkan email baru"
                    required
                >
            </div>
            <div>
                <label for="mobileEmailPassword" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                <input 
                    type="password" 
                    id="mobileEmailPassword" 
                    name="current_password" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Masukkan password Anda"
                    required
                >
                <p class="text-xs text-gray-500 mt-1">Untuk keamanan, konfirmasi dengan password Anda</p>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" class="flex-1 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition" onclick="closeEditModal('edit-email')">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Ubah Email
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Phone Modal -->
<div id="edit-phone" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) closeEditModal('edit-phone')">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900">Ubah Nomor Telepon</h3>
            <button class="text-gray-400 hover:text-gray-600 text-xl" onclick="closeEditModal('edit-phone')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="/change-phone" method="POST" id="mobileEditPhoneForm" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <div>
                <label for="mobileCurrentPhone" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon Saat Ini</label>
                <input 
                    type="text" 
                    id="mobileCurrentPhone" 
                    value="<?= $user['no_hp'] ?? '-' ?>" 
                    disabled
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed"
                >
            </div>
            <div>
                <label for="mobileNewPhone" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon Baru</label>
                <input 
                    type="tel" 
                    id="mobileNewPhone" 
                    name="new_phone" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="08xxxxxxxxxx"
                    pattern="08[0-9]{9,}"
                    required
                >
                <p class="text-xs text-gray-500 mt-1">Format: 08xxxxxxxxxx (minimal 11 digit)</p>
            </div>
            <div>
                <label for="mobilePhonePassword" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                <input 
                    type="password" 
                    id="mobilePhonePassword" 
                    name="current_password" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Masukkan password Anda"
                    required
                >
                <p class="text-xs text-gray-500 mt-1">Untuk keamanan, konfirmasi dengan password Anda</p>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" class="flex-1 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition" onclick="closeEditModal('edit-phone')">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Ubah Nomor
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Address Modal -->
<div id="edit-address" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) closeEditModal('edit-address')">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900">Ubah Alamat</h3>
            <button class="text-gray-400 hover:text-gray-600 text-xl" onclick="closeEditModal('edit-address')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="/api/auth/profile" method="PUT" id="mobileEditAddressForm" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <div>
                <label for="mobileAddressInput" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                <textarea 
                    id="mobileAddressInput" 
                    name="alamat" 
                    rows="4"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Masukkan alamat Anda"
                ><?= $user['address'] ?? $user['alamat'] ?? '' ?></textarea>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" class="flex-1 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition" onclick="closeEditModal('edit-address')">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Password Modal -->
<div id="edit-password" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) closeEditModal('edit-password')">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900">Ubah Kata Sandi</h3>
            <button class="text-gray-400 hover:text-gray-600 text-xl" onclick="closeEditModal('edit-password')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="/api/auth/change-password" method="POST" id="mobileEditPasswordForm" class="p-6 space-y-4">
            <?= csrf_field() ?>
            <div>
                <label for="mobileCurrentPassword" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi Saat Ini</label>
                <input 
                    type="password" 
                    id="mobileCurrentPassword" 
                    name="old_password" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Masukkan kata sandi saat ini"
                    required
                >
            </div>
            <div>
                <label for="mobileNewPassword" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi Baru</label>
                <input 
                    type="password" 
                    id="mobileNewPassword" 
                    name="new_password" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Masukkan kata sandi baru"
                    required
                    minlength="6"
                >
                <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
            </div>
            <div>
                <label for="mobileConfirmPassword" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                <input 
                    type="password" 
                    id="mobileConfirmPassword" 
                    name="confirm_password" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Konfirmasi kata sandi baru"
                    required
                    minlength="6"
                >
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" class="flex-1 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition" onclick="closeEditModal('edit-password')">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Ubah Kata Sandi
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('extra_js') ?>
<style>
    /* Prevent double hover effect on menu items */
    #menu-profile,
    #menu-email,
    #menu-phone,
    #menu-password {
        transition: all 0.2s ease-in-out;
    }
    
    /* Active state - no hover effect needed */
    #menu-profile.bg-blue-600:hover,
    #menu-email.bg-blue-600:hover,
    #menu-phone.bg-blue-600:hover,
    #menu-password.bg-blue-600:hover {
        background-color: rgb(37, 99, 235); /* Keep current color on hover */
        text-decoration: none;
    }
    
    /* Ensure text is always visible and no conflicts */
    #menu-profile.bg-blue-600,
    #menu-email.bg-blue-600,
    #menu-phone.bg-blue-600,
    #menu-password.bg-blue-600 {
        color: white;
        position: relative;
        z-index: auto;
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
</style>
<script>
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) return;

    const toast = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

    toast.className = `${bgColor} text-white px-6 py-4 rounded-lg shadow-lg mb-4 transition-all duration-300 transform translate-x-0 flex items-center space-x-3`;
    toast.innerHTML = `<i class="fas ${icon}"></i><span>${message}</span>`;
    toastContainer.appendChild(toast);

    setTimeout(() => {
        toast.style.transform = 'translateX(400px)';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

function maskEmail(email) {
    if (!email || !email.includes('@')) return '';
    const [name, domain] = email.split('@');
    const prefix = name.slice(0, 3);
    return `${prefix}${'*'.repeat(Math.max(name.length - 3, 0))}@${domain}`;
}

function maskPhone(phone) {
    if (!phone) return '*********00';
    return `*********${phone.slice(-2)}`;
}

async function loadProfileDetail() {
    try {
        console.log('🚀 Loading profile detail via API...');
        const response = await fetch('/api/auth/profile', {
            method: 'GET',
            credentials: 'include'
        });

        const result = await response.json();
        console.log('✅ Profile detail response:', result);

        if (result.status !== 'success' || !result.data?.user) {
            showToast(result.message || 'Gagal memuat profil', 'error');
            return;
        }

        const user = result.data.user;
        const fullName = user.nama_lengkap || user.full_name || '';
        const email = user.email || '';
        const phone = user.no_hp || user.phone || '';
        const address = user.alamat || user.address || '';

        const fullNameInput = document.getElementById('full_name');
        const emailReadonly = document.getElementById('emailReadonly');
        const emailMasked = document.getElementById('emailMasked');
        const phoneMasked = document.getElementById('phoneMasked');
        const addressInput = document.getElementById('address');

        if (fullNameInput) fullNameInput.value = fullName;
        if (emailReadonly) emailReadonly.value = email;
        if (emailMasked) emailMasked.value = maskEmail(email);
        if (phoneMasked) phoneMasked.value = maskPhone(phone);
        if (addressInput) addressInput.value = address;
    } catch (error) {
        console.error('❌ Error loading profile detail:', error);
        showToast('Terjadi kesalahan saat memuat profil', 'error');
    }
}

async function submitProfileForm(event) {
    event.preventDefault();

    const fullName = document.getElementById('full_name')?.value?.trim() || '';
    const address = document.getElementById('address')?.value?.trim() || '';

    if (!fullName) {
        showToast('Nama wajib diisi', 'error');
        return;
    }

    try {
        const response = await fetch('/api/auth/profile', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include',
            body: JSON.stringify({
                nama_lengkap: fullName,
                alamat: address
            })
        });

        const result = await response.json();
        console.log('✅ Update profile response:', result);

        if (result.status === 'success') {
            showToast(result.message || 'Profil berhasil diperbarui', 'success');
            await loadProfileDetail();
            return;
        }

        if (result.errors) {
            showToast(Object.values(result.errors).join(', '), 'error');
            return;
        }

        showToast(result.message || 'Gagal memperbarui profil', 'error');
    } catch (error) {
        console.error('❌ Error updating profile:', error);
        showToast('Terjadi kesalahan saat memperbarui profil', 'error');
    }
}

async function submitPasswordForm(event) {
    event.preventDefault();

    const form = event.target;
    const currentPassword = form.querySelector('input[name="current_password"]')?.value?.trim() || '';
    const newPassword = form.querySelector('input[name="new_password"]')?.value?.trim() || '';
    const confirmPassword = form.querySelector('input[name="confirm_password"]')?.value?.trim() || '';

    if (!currentPassword || !newPassword || !confirmPassword) {
        showToast('Semua field password wajib diisi', 'error');
        return;
    }

    if (newPassword.length < 6) {
        showToast('Password baru minimal 6 karakter', 'error');
        return;
    }

    if (newPassword !== confirmPassword) {
        showToast('Konfirmasi password tidak sesuai', 'error');
        return;
    }

    try {
        const response = await fetch('/api/auth/change-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include',
            body: JSON.stringify({
                old_password: currentPassword,
                new_password: newPassword,
                confirm_password: confirmPassword
            })
        });

        const result = await response.json();
        console.log('✅ Change password response:', result);

        if (result.status === 'success') {
            showToast(result.message || 'Password berhasil diubah', 'success');
            form.reset();
            return;
        }

        if (result.errors) {
            showToast(Object.values(result.errors).join(', '), 'error');
            return;
        }

        showToast(result.message || 'Gagal mengubah password', 'error');
    } catch (error) {
        console.error('❌ Error changing password:', error);
        showToast('Terjadi kesalahan saat mengubah password', 'error');
    }
}

// Show section function
function showSection(section) {
    // Hide all sections
    document.getElementById('section-profile').classList.add('hidden');
    document.getElementById('section-email').classList.add('hidden');
    document.getElementById('section-phone').classList.add('hidden');
    document.getElementById('section-password').classList.add('hidden');
    
    // Update desktop menu
    const desktopMenus = ['menu-profile', 'menu-email', 'menu-phone', 'menu-password'];
    desktopMenus.forEach(menuId => {
        const menu = document.getElementById(menuId);
        // Remove all active states
        menu.classList.remove('bg-blue-600', 'text-white', 'shadow-sm');
        // Remove potential hover conflicts
        menu.classList.remove('hover:shadow');
    });
    
    // Update mobile menu
    const mobileMenus = ['mobile-menu-profile', 'mobile-menu-email', 'mobile-menu-phone', 'mobile-menu-password'];
    mobileMenus.forEach(menuId => {
        const menu = document.getElementById(menuId);
        menu.classList.remove('bg-blue-600', 'text-white');
        menu.classList.add('bg-white', 'text-gray-700', 'border', 'border-gray-200');
    });
    
    // Show selected section and highlight menu
    const sectionMap = {
        'profile': {
            section: 'section-profile',
            desktop: 'menu-profile',
            mobile: 'mobile-menu-profile'
        },
        'email': {
            section: 'section-email',
            desktop: 'menu-email',
            mobile: 'mobile-menu-email'
        },
        'phone': {
            section: 'section-phone',
            desktop: 'menu-phone',
            mobile: 'mobile-menu-phone'
        },
        'password': {
            section: 'section-password',
            desktop: 'menu-password',
            mobile: 'mobile-menu-password'
        }
    };
    
    if (sectionMap[section]) {
        // Show section
        document.getElementById(sectionMap[section].section).classList.remove('hidden');
        
        // Highlight desktop menu - ADD active state, don't mix with hover states
        const desktopMenu = document.getElementById(sectionMap[section].desktop);
        desktopMenu.classList.add('bg-blue-600', 'text-white', 'shadow-sm');
        desktopMenu.classList.remove('text-gray-700', 'hover:bg-blue-600', 'hover:text-white');
        
        // Add non-active menu classes to other items
        desktopMenus.forEach(menuId => {
            if (menuId !== sectionMap[section].desktop) {
                const menu = document.getElementById(menuId);
                menu.classList.add('text-gray-700', 'hover:bg-blue-600', 'hover:text-white');
            }
        });
        
        // Highlight mobile menu
        const mobileMenu = document.getElementById(sectionMap[section].mobile);
        mobileMenu.classList.remove('bg-white', 'text-gray-700', 'border', 'border-gray-200');
        mobileMenu.classList.add('bg-blue-600', 'text-white');
    }
}

// Toggle password visibility
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

// Modal functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Mobile Edit Modal functions
function openEditModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
}

function closeEditModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

// Profile photo upload
document.getElementById('profilePhoto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Check file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            if (Modal) {
                Modal.error('Ukuran file maksimal 2 MB');
            } else {
                alert('Ukuran file maksimal 2 MB');
            }
            this.value = '';
            return;
        }
        
        // Check file type
        if (!file.type.match('image/(png|jpeg|jpg)')) {
            if (Modal) {
                Modal.error('Format file harus PNG, JPG, atau JPEG');
            } else {
                alert('Format file harus PNG, JPG, atau JPEG');
            }
            this.value = '';
            return;
        }
        
        // Preview image
        const reader = new FileReader();
        reader.onload = function(event) {
            const profileImg = document.getElementById('profileImg');
            if (profileImg.tagName === 'IMG') {
                profileImg.src = event.target.result;
            } else {
                // Replace icon with image
                profileImg.outerHTML = '<img id="profileImg" src="' + event.target.result + '" class="w-24 h-24 rounded-full object-cover border-4 border-gray-100">';
            }
        };
        reader.readAsDataURL(file);
        
        // Auto submit form
        const form = document.getElementById('profilePhotoForm');
        const formData = new FormData(form);
        
        // Submit with AJAX and reload after success
        fetch(form.action, {
            method: 'POST',
            credentials: 'include',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                // Wait a moment for database update, then reload
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Initialize profile section on page load
    showSection('profile');
    
    loadProfileDetail();

    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', submitProfileForm);
    }

    const passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', submitPasswordForm);
    }

    // Handle email form (section)
    const emailForm = document.getElementById('emailForm');
    if (emailForm) {
        emailForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const newEmail = formData.get('new_email');
            const password = formData.get('current_password');
            
            if (!newEmail || !password) {
                showToast('Semua field wajib diisi', 'error');
                return;
            }
            
            // Validate email format
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(newEmail)) {
                showToast('Format email tidak valid', 'error');
                return;
            }
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    credentials: 'include'
                });
                
                if (response.ok || response.redirected) {
                    showToast('Email berhasil diubah!', 'success');
                    this.reset();
                    setTimeout(() => {
                        window.location.href = '/profile/detail';
                    }, 1000);
                } else {
                    showToast('Gagal mengubah email. Periksa password Anda.', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Terjadi kesalahan saat mengubah email', 'error');
            }
        });
    }

    // Handle phone form (section)
    const phoneForm = document.getElementById('phoneForm');
    if (phoneForm) {
        phoneForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const newPhone = formData.get('new_phone');
            const password = formData.get('current_password');
            
            if (!newPhone || !password) {
                showToast('Semua field wajib diisi', 'error');
                return;
            }
            
            // Validate phone format
            if (!/^08[0-9]{9,}$/.test(newPhone)) {
                showToast('Format nomor telepon tidak valid (08xxxxxxxxxx)', 'error');
                return;
            }
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    credentials: 'include'
                });
                
                if (response.ok || response.redirected) {
                    showToast('Nomor telepon berhasil diubah!', 'success');
                    this.reset();
                    setTimeout(() => {
                        window.location.href = '/profile/detail';
                    }, 1000);
                } else {
                    showToast('Gagal mengubah nomor telepon. Periksa password Anda.', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Terjadi kesalahan saat mengubah nomor telepon', 'error');
            }
        });
    }

    // Handle change email form (modal)
    const changeEmailForm = document.getElementById('changeEmailForm');
    if (changeEmailForm) {
        changeEmailForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const newEmail = formData.get('new_email');
            const password = formData.get('current_password');
            
            if (!newEmail || !password) {
                showToast('Semua field wajib diisi', 'error');
                return;
            }
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    credentials: 'include'
                });
                
                if (response.ok) {
                    showToast('Email berhasil diubah!', 'success');
                    closeModal('changeEmailModal');
                    this.reset();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    const text = await response.text();
                    showToast('Gagal mengubah email. Periksa password Anda.', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Terjadi kesalahan saat mengubah email', 'error');
            }
        });
    }

    // Handle change phone form (modal)
    const changePhoneForm = document.getElementById('changePhoneForm');
    if (changePhoneForm) {
        changePhoneForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const newPhone = formData.get('new_phone');
            const password = formData.get('current_password');
            
            if (!newPhone || !password) {
                showToast('Semua field wajib diisi', 'error');
                return;
            }
            
            // Validate phone format
            if (!/^08[0-9]{9,}$/.test(newPhone)) {
                showToast('Format nomor telepon tidak valid (08xxxxxxxxxx)', 'error');
                return;
            }
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    credentials: 'include'
                });
                
                if (response.ok) {
                    showToast('Nomor telepon berhasil diubah!', 'success');
                    closeModal('changePhoneModal');
                    this.reset();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    const text = await response.text();
                    showToast('Gagal mengubah nomor telepon. Periksa password Anda.', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Terjadi kesalahan saat mengubah nomor telepon', 'error');
            }
        });
    }

    // ===== MOBILE EDIT FORMS =====
    
    // Mobile profile photo upload
    const mobileProfilePhoto = document.getElementById('mobileProfilePhoto');
    if (mobileProfilePhoto) {
        mobileProfilePhoto.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Check file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    showToast('Ukuran file maksimal 2 MB', 'error');
                    this.value = '';
                    return;
                }
                
                // Check file type
                if (!file.type.match('image/(png|jpeg|jpg)')) {
                    showToast('Format file harus PNG, JPG, atau JPEG', 'error');
                    this.value = '';
                    return;
                }
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(event) {
                    const profileImg = document.getElementById('mobileProfileImg');
                    if (profileImg.tagName === 'IMG') {
                        profileImg.src = event.target.result;
                    } else {
                        profileImg.outerHTML = '<img id="mobileProfileImg" src="' + event.target.result + '" class="w-32 h-32 rounded-full object-cover border-2 border-gray-200 mb-3">';
                    }
                };
                reader.readAsDataURL(file);
                
                // Get CSRF token
                const csrfInput = document.querySelector('input[name="<?= csrf_token() ?>"]');
                
                // Create FormData
                const formData = new FormData();
                formData.append('profile_photo', file);
                if (csrfInput) {
                    formData.append(csrfInput.name, csrfInput.value);
                }
                
                // Submit with AJAX
                fetch('/update-profile-photo', {
                    method: 'POST',
                    credentials: 'include',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        showToast('Foto profil berhasil diubah', 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 500);
                    } else {
                        showToast('Gagal mengubah foto profil', 'error');
                    }
                });
            }
        });
    }

    // Mobile Edit Name Form
    const mobileEditNameForm = document.getElementById('mobileEditNameForm');
    if (mobileEditNameForm) {
        mobileEditNameForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const fullName = document.getElementById('mobileNameInput')?.value?.trim();
            if (!fullName) {
                showToast('Nama wajib diisi', 'error');
                return;
            }
            
            try {
                const response = await fetch(this.action, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'include',
                    body: JSON.stringify({
                        nama_lengkap: fullName
                    })
                });
                
                const result = await response.json();
                if (result.status === 'success') {
                    showToast(result.message || 'Nama berhasil diubah', 'success');
                    closeEditModal('edit-name');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast(result.message || 'Gagal mengubah nama', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Terjadi kesalahan saat mengubah nama', 'error');
            }
        });
    }

    // Mobile Edit Email Form
    const mobileEditEmailForm = document.getElementById('mobileEditEmailForm');
    if (mobileEditEmailForm) {
        mobileEditEmailForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const newEmail = formData.get('new_email');
            const password = formData.get('current_password');
            
            if (!newEmail || !password) {
                showToast('Semua field wajib diisi', 'error');
                return;
            }
            
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(newEmail)) {
                showToast('Format email tidak valid', 'error');
                return;
            }
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    credentials: 'include'
                });
                
                if (response.ok) {
                    showToast('Email berhasil diubah!', 'success');
                    closeEditModal('edit-email');
                    this.reset();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast('Gagal mengubah email. Periksa password Anda.', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Terjadi kesalahan saat mengubah email', 'error');
            }
        });
    }

    // Mobile Edit Phone Form
    const mobileEditPhoneForm = document.getElementById('mobileEditPhoneForm');
    if (mobileEditPhoneForm) {
        mobileEditPhoneForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const newPhone = formData.get('new_phone');
            const password = formData.get('current_password');
            
            if (!newPhone || !password) {
                showToast('Semua field wajib diisi', 'error');
                return;
            }
            
            if (!/^08[0-9]{9,}$/.test(newPhone)) {
                showToast('Format nomor telepon tidak valid (08xxxxxxxxxx)', 'error');
                return;
            }
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    credentials: 'include'
                });
                
                if (response.ok) {
                    showToast('Nomor telepon berhasil diubah!', 'success');
                    closeEditModal('edit-phone');
                    this.reset();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast('Gagal mengubah nomor telepon. Periksa password Anda.', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Terjadi kesalahan saat mengubah nomor telepon', 'error');
            }
        });
    }

    // Mobile Edit Address Form
    const mobileEditAddressForm = document.getElementById('mobileEditAddressForm');
    if (mobileEditAddressForm) {
        mobileEditAddressForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const address = document.getElementById('mobileAddressInput')?.value?.trim();
            if (!address) {
                showToast('Alamat wajib diisi', 'error');
                return;
            }
            
            try {
                const response = await fetch(this.action, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'include',
                    body: JSON.stringify({
                        alamat: address
                    })
                });
                
                const result = await response.json();
                if (result.status === 'success') {
                    showToast(result.message || 'Alamat berhasil diubah', 'success');
                    closeEditModal('edit-address');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast(result.message || 'Gagal mengubah alamat', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Terjadi kesalahan saat mengubah alamat', 'error');
            }
        });
    }

    // Mobile Edit Password Form
    const mobileEditPasswordForm = document.getElementById('mobileEditPasswordForm');
    if (mobileEditPasswordForm) {
        mobileEditPasswordForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const currentPassword = document.getElementById('mobileCurrentPassword')?.value;
            const newPassword = document.getElementById('mobileNewPassword')?.value;
            const confirmPassword = document.getElementById('mobileConfirmPassword')?.value;
            
            if (!currentPassword || !newPassword || !confirmPassword) {
                showToast('Semua field wajib diisi', 'error');
                return;
            }
            
            if (newPassword.length < 6) {
                showToast('Kata sandi baru minimal 6 karakter', 'error');
                return;
            }
            
            if (newPassword !== confirmPassword) {
                showToast('Konfirmasi kata sandi tidak sesuai', 'error');
                return;
            }
            
            try {
                const response = await fetch('/api/auth/change-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    credentials: 'include',
                    body: JSON.stringify({
                        old_password: currentPassword,
                        new_password: newPassword,
                        confirm_password: confirmPassword
                    })
                });
                
                const result = await response.json();
                if (result.status === 'success') {
                    showToast('Kata sandi berhasil diubah!', 'success');
                    closeEditModal('edit-password');
                    this.reset();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast(result.message || 'Gagal mengubah kata sandi. Periksa password lama Anda.', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Terjadi kesalahan saat mengubah kata sandi', 'error');
            }
        });
    }
});
</script>
<?= $this->endSection() ?>
