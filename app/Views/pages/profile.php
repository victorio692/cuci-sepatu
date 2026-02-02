<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg fixed h-full">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Dashboard</h2>
        </div>
        <nav class="py-4">
            <a href="/dashboard" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition">
                <i class="fas fa-home mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="/my-bookings" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition">
                <i class="fas fa-calendar-check mr-3"></i>
                <span>Pesanan Saya</span>
            </a>
            <a href="/make-booking" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition">
                <i class="fas fa-plus-circle mr-3"></i>
                <span>Pesan Baru</span>
            </a>
            <a href="/profile" class="flex items-center px-6 py-3 text-gray-900 bg-gray-100 border-l-4 border-blue-500">
                <i class="fas fa-user-circle mr-3"></i>
                <span>Profil</span>
            </a>
            <a href="#" onclick="confirmLogout(event)" class="flex items-center px-6 py-3 text-red-600 hover:bg-red-50 transition">
                <i class="fas fa-sign-out-alt mr-3"></i>
                <span>Logout</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 ml-64">
        <div class="p-8">
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-user-circle text-blue-600 mr-3"></i>
                    Profil Saya
                </h1>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                        <span class="text-green-800"><?= session()->getFlashdata('success') ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl">
                <!-- Profile Image -->
                <div class="bg-white rounded-xl shadow-lg p-6 h-fit">
                    <div class="text-center">
                        <form id="profilePhotoForm" action="/update-profile-photo" method="POST" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input type="file" id="profilePhoto" name="profile_photo" accept="image/png,image/jpeg,image/jpg" class="hidden">
                            
                            <div class="relative inline-block mb-4">
                                <?php if (!empty($user['foto_profil'])): ?>
                                    <img id="profileImg" src="<?= base_url('uploads/' . $user['foto_profil']) ?>" class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-blue-500 shadow-lg">
                                <?php else: ?>
                                    <div id="profileImg" class="w-32 h-32 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full mx-auto flex items-center justify-center text-white text-5xl shadow-lg">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </form>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-1"><?= $user['nama_lengkap'] ?></h3>
                        <p class="text-gray-600 text-sm mb-4"><?= $user['email'] ?></p>
                        <button type="button" onclick="document.getElementById('profilePhoto').click()" class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg font-medium hover:bg-blue-600 transition">
                            <i class="fas fa-camera mr-2"></i> Ubah Foto
                        </button>
                    </div>
                </div>

                <!-- Profile Form -->
                <div class="lg:col-span-2">
                    <form action="/update-profile" method="POST">
                        <?= csrf_field() ?>

                        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6">
                                <h3 class="text-xl font-bold">Informasi Pribadi</h3>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label for="full_name" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                                    <input 
                                        type="text" 
                                        id="full_name" 
                                        name="full_name" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        value="<?= $user['nama_lengkap'] ?>"
                                        required
                                    >
                                </div>

                                <div>
                                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                                    <input 
                                        type="email" 
                                        id="email" 
                                        name="email" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed"
                                        value="<?= $user['email'] ?>"
                                        readonly
                                    >
                                </div>

                                <div>
                                    <label for="phone" class="block text-gray-700 font-medium mb-2">No WhatsApp</label>
                                    <input 
                                        type="tel" 
                                        id="phone" 
                                        name="phone" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        value="<?= $user['no_hp'] ?>"
                                    >
                                </div>

                                <div>
                                    <label for="address" class="block text-gray-700 font-medium mb-2">Alamat</label>
                                    <textarea 
                                        id="address" 
                                        name="address" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                        rows="3"
                                    ><?= $user['alamat'] ?></textarea>
                                </div>

                                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
                                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Security Section -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6">
                            <h3 class="text-xl font-bold">Keamanan</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="flex justify-between items-center pb-6 border-b border-gray-200">
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Ubah Password</h4>
                                    <p class="text-gray-600 text-sm">Perbarui password akun Anda secara berkala</p>
                                </div>
                                <button class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition" onclick="openModal('changePasswordModal')">
                                    Ubah
                                </button>
                            </div>

                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="font-bold text-gray-900 mb-1">Aktivitas Login</h4>
                                    <p class="text-gray-600 text-sm">Lihat riwayat login dan perangkat aktif</p>
                                </div>
                                <a href="/login-activity" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                                    Lihat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div id="changePasswordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="if(event.target === this) closeModal('changePasswordModal')">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 flex justify-between items-center">
            <h3 class="text-xl font-bold">Ubah Password</h3>
            <button class="text-white hover:text-gray-200 text-2xl" onclick="closeModal('changePasswordModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="/change-password" method="POST" id="changePasswordForm" class="p-6 space-y-4">
            <?= csrf_field() ?>

            <div>
                <label for="current_password" class="block text-gray-700 font-medium mb-2">Password Lama</label>
                <input 
                    type="password" 
                    id="current_password" 
                    name="current_password" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                >
            </div>

            <div>
                <label for="new_password" class="block text-gray-700 font-medium mb-2">Password Baru</label>
                <input 
                    type="password" 
                    id="new_password" 
                    name="new_password" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                    minlength="6"
                >
            </div>

            <div>
                <label for="confirm_password" class="block text-gray-700 font-medium mb-2">Konfirmasi Password Baru</label>
                <input 
                    type="password" 
                    id="confirm_password" 
                    name="confirm_password" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                    minlength="6"
                >
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" class="flex-1 px-4 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition" onclick="closeModal('changePasswordModal')">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:shadow-lg transition">
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
                profileImg.outerHTML = '<img id="profileImg" src="' + event.target.result + '" class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-blue-500 shadow-lg">';
            }
        };
        reader.readAsDataURL(file);
        
        // Auto submit form
        document.getElementById('profilePhotoForm').submit();
    }
});

// Logout confirmation
function confirmLogout(e) {
    e.preventDefault();
    if (confirm('Apakah Anda yakin ingin logout?')) {
        window.location.href = '/logout';
    }
}
</script>
<?= $this->endSection() ?>