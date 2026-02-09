<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- Main Content With Sidebar -->
<div class="min-h-screen bg-gray-50 pt-24 pb-8">
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
                                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-bold border-4 border-white shadow-lg mb-3">
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
                            <a href="#" onclick="showSection('profile'); return false;" id="menu-profile" class="flex items-center gap-3 px-4 py-3 text-sm text-white bg-blue-600 rounded-lg font-medium shadow-sm mb-1">
                                <i class="fas fa-user-circle w-5"></i> Profil
                            </a>
                            <a href="#" onclick="showSection('password'); return false;" id="menu-password" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition">
                                <i class="fas fa-lock w-5"></i> Ubah Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Cards - Visible only on Mobile -->
            <div class="lg:hidden col-span-1 grid grid-cols-2 gap-3 mb-6">
                <a href="#" onclick="showSection('profile'); return false;" id="mobile-menu-profile" class="bg-blue-600 text-white rounded-xl p-4 shadow-sm flex flex-col items-center justify-center gap-2 transition">
                    <i class="fas fa-user-circle text-2xl"></i>
                    <span class="text-sm font-medium">Profil</span>
                </a>
                <a href="#" onclick="showSection('password'); return false;" id="mobile-menu-password" class="bg-white text-gray-700 rounded-xl p-4 shadow-sm flex flex-col items-center justify-center gap-2 hover:bg-gray-50 transition border border-gray-200">
                    <i class="fas fa-lock text-2xl text-gray-600"></i>
                    <span class="text-sm font-medium">Ubah Password</span>
                </a>
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
                                <form action="/update-profile" method="POST" class="space-y-5">
                                    <?= csrf_field() ?>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                            <input type="text" value="<?= $user['email'] ?>" disabled class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg text-gray-500 cursor-not-allowed">
                                        </div>

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
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                            <div class="flex items-center gap-2">
                                                <input type="email" value="<?= substr($user['email'], 0, 3) ?>*****<?= substr($user['email'], strpos($user['email'], '@')) ?>" disabled class="flex-1 px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg text-gray-500 cursor-not-allowed">
                                                <a href="/profile/change-email" class="text-blue-600 hover:text-blue-700 text-sm font-medium whitespace-nowrap">Ubah</a>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                            <div class="flex items-center gap-2">
                                                <input type="text" value="*********<?= substr($user['phone'] ?? $user['no_telepon'] ?? '00', -2) ?>" disabled class="flex-1 px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg text-gray-500 cursor-not-allowed">
                                                <a href="/profile/change-phone" class="text-blue-600 hover:text-blue-700 text-sm font-medium whitespace-nowrap">Ubah</a>
                                            </div>
                                        </div>
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

                                    <div class="pt-4">
                                        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Profile Photo Section -->
                            <div class="flex flex-col items-center">
                                <div class="mb-4">
                                    <?php if (!empty($user['foto_profil'])): ?>
                                        <img id="profileImg" src="<?= base_url('uploads/' . $user['foto_profil']) ?>" class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                                    <?php else: ?>
                                        <div id="profileImg" class="w-32 h-32 bg-purple-500 rounded-full flex items-center justify-center text-white text-5xl font-bold border-4 border-gray-200">
                                            <?= strtoupper(substr($user['full_name'] ?? $user['nama_lengkap'] ?? 'U', 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <button type="button" onclick="document.getElementById('profilePhoto').click()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium text-sm">
                                    Pilih Gambar
                                </button>
                                
                                <div class="mt-3 text-center">
                                    <p class="text-xs text-gray-500">Ukuran gambar: maks. 1 MB</p>
                                    <p class="text-xs text-gray-500">Format gambar: .JPEG, .PNG</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Change Password Section -->
                <div id="section-password" class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6 overflow-hidden hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Ubah Password</h2>
                        <p class="text-sm text-gray-600 mt-1">Pastikan akun Anda menggunakan password yang aman</p>
                    </div>
                    
                    <div class="p-6">
                        <form action="/change-password" method="POST" class="max-w-2xl">
                            <?= csrf_field() ?>

                            <div class="space-y-5">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                                    <div class="relative">
                                        <input 
                                            type="password" 
                                            id="current_password" 
                                            name="current_password" 
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-12"
                                            placeholder="Masukkan password saat ini"
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
                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
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
                                    <label for="confirm_password_section" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                    <div class="relative">
                                        <input 
                                            type="password" 
                                            id="confirm_password_section" 
                                            name="confirm_password" 
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-12"
                                            placeholder="Ulangi password baru"
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
                                        <i class="fas fa-info-circle"></i> Persyaratan Password:
                                    </p>
                                    <ul class="text-sm text-blue-800 space-y-1 ml-5">
                                        <li>• Minimal 6 karakter</li>
                                        <li>• Password baru dan konfirmasi harus sama</li>
                                    </ul>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                        <i class="fas fa-check"></i> Ubah Password
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


<!-- Change Password Modal -->
<div id="changePasswordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) closeModal('changePasswordModal')">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900">Ubah Password</h3>
            <button class="text-gray-400 hover:text-gray-600 text-xl" onclick="closeModal('changePasswordModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="/change-password" method="POST" id="changePasswordForm" class="p-6 space-y-4">
            <?= csrf_field() ?>

            <div>
                <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">Password Lama</label>
                <input 
                    type="password" 
                    id="current_password" 
                    name="current_password" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    required
                >
            </div>

            <div>
                <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
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
                <label for="confirm_password" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
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
                    Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('extra_js') ?>
<script>
// Show section function
function showSection(section) {
    // Hide all sections
    document.getElementById('section-profile').classList.add('hidden');
    document.getElementById('section-password').classList.add('hidden');
    
    // Update desktop menu
    document.getElementById('menu-profile').classList.remove('bg-blue-600', 'text-white');
    document.getElementById('menu-profile').classList.add('text-gray-700', 'hover:bg-gray-50');
    document.getElementById('menu-password').classList.remove('bg-blue-600', 'text-white');
    document.getElementById('menu-password').classList.add('text-gray-700', 'hover:bg-gray-50');
    
    // Update mobile menu
    document.getElementById('mobile-menu-profile').classList.remove('bg-blue-600', 'text-white');
    document.getElementById('mobile-menu-profile').classList.add('bg-white', 'text-gray-700', 'border', 'border-gray-200');
    document.getElementById('mobile-menu-password').classList.remove('bg-blue-600', 'text-white');
    document.getElementById('mobile-menu-password').classList.add('bg-white', 'text-gray-700', 'border', 'border-gray-200');
    
    // Show selected section
    if (section === 'profile') {
        document.getElementById('section-profile').classList.remove('hidden');
        document.getElementById('menu-profile').classList.add('bg-blue-600', 'text-white');
        document.getElementById('menu-profile').classList.remove('text-gray-700', 'hover:bg-gray-50');
        document.getElementById('mobile-menu-profile').classList.add('bg-blue-600', 'text-white');
        document.getElementById('mobile-menu-profile').classList.remove('bg-white', 'text-gray-700', 'border', 'border-gray-200');
    } else if (section === 'password') {
        document.getElementById('section-password').classList.remove('hidden');
        document.getElementById('menu-password').classList.add('bg-blue-600', 'text-white');
        document.getElementById('menu-password').classList.remove('text-gray-700', 'hover:bg-gray-50');
        document.getElementById('mobile-menu-password').classList.add('bg-blue-600', 'text-white');
        document.getElementById('mobile-menu-password').classList.remove('bg-white', 'text-gray-700', 'border', 'border-gray-200');
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

// Profile photo upload
document.getElementById('profilePhoto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Check file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2 MB');
            this.value = '';
            return;
        }
        
        // Check file type
        if (!file.type.match('image/(png|jpeg|jpg)')) {
            alert('Format file harus PNG, JPG, atau JPEG');
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
        document.getElementById('profilePhotoForm').submit();
    }
});
</script>
<?= $this->endSection() ?>
