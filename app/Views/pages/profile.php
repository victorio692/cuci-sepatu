<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- Main Content Without Sidebar -->
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="/" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:border-blue-500 hover:text-blue-600 transition-all duration-300 font-medium">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-50 border border-green-200 p-4 mb-6 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                    <span class="text-green-700"><?= session()->getFlashdata('success') ?></span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Profile Header Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-200">
                <div class="flex items-center gap-6">
                    <!-- Profile Photo -->
                    <div class="relative">
                        <form id="profilePhotoForm" action="/update-profile-photo" method="POST" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input type="file" id="profilePhoto" name="profile_photo" accept="image/png,image/jpeg,image/jpg" class="hidden">
                            
                            <?php if (!empty($user['foto_profil'])): ?>
                                <img id="profileImg" src="<?= base_url('uploads/' . $user['foto_profil']) ?>" class="w-24 h-24 rounded-full object-cover border-4 border-gray-100">
                            <?php else: ?>
                                <div id="profileImg" class="w-24 h-24 bg-blue-500 rounded-full flex items-center justify-center text-white text-3xl border-4 border-gray-100">
                                    <i class="fas fa-user"></i>
                                </div>
                            <?php endif; ?>
                            
                            <button type="button" onclick="document.getElementById('profilePhoto').click()" class="absolute bottom-0 right-0 bg-white border-2 border-gray-200 rounded-full p-2 hover:bg-gray-50 transition">
                                <i class="fas fa-camera text-gray-600 text-sm"></i>
                            </button>
                        </form>
                    </div>
                    
                    <!-- User Info -->
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 mb-1"><?= $user['nama_lengkap'] ?></h1>
                        <p class="text-gray-500 mb-2"><?= $user['email'] ?></p>
                        <span class="inline-block px-3 py-1 bg-blue-50 text-blue-600 text-sm font-medium rounded-full">
                            <i class="fas fa-user-check mr-1"></i> Member Aktif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-900">Informasi Pribadi</h3>
                    </div>
                    <form action="/update-profile" method="POST" class="p-6 space-y-5">
                        <?= csrf_field() ?>
                        
                        <div>
                            <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                            <input 
                                type="text" 
                                id="full_name" 
                                name="full_name" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                value="<?= $user['nama_lengkap'] ?>"
                                required
                            >
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <div class="relative">
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-500"
                                    value="<?= $user['email'] ?>"
                                    readonly
                                >
                                <i class="fas fa-lock absolute right-4 top-3.5 text-gray-400"></i>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah</p>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">No WhatsApp</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3 text-gray-500">+62</span>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    class="w-full pl-14 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    value="<?= $user['no_hp'] ?>"
                                    placeholder="8123456789"
                                >
                            </div>
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                            <textarea 
                                id="address" 
                                name="address" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none" 
                                rows="3"
                                placeholder="Masukkan alamat lengkap Anda"
                            ><?= $user['alamat'] ?></textarea>
                        </div>

                        <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sidebar Actions -->
            <div class="space-y-6">
                <!-- Security Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-900">Keamanan</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <button onclick="openModal('changePasswordModal')" class="w-full flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition">
                                    <i class="fas fa-key text-blue-600"></i>
                                </div>
                                <div class="text-left">
                                    <p class="font-semibold text-gray-900 text-sm">Ubah Password</p>
                                    <p class="text-xs text-gray-500">Perbarui password</p>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600"></i>
                        </button>
                    </div>
                </div>

                <!-- Account Stats -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-900">Statistik</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Pesanan</span>
                            <span class="font-bold text-gray-900">0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Pesanan Selesai</span>
                            <span class="font-bold text-green-600">0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Bergabung Sejak</span>
                            <span class="font-bold text-gray-900"><?= date('M Y', strtotime($user['dibuat_pada'])) ?></span>
                        </div>
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
