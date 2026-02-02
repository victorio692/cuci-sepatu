<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="/dashboard">
                    <span class="sidebar-icon"><i class="fas fa-home"></i></span>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/my-bookings">
                    <span class="sidebar-icon"><i class="fas fa-calendar-check"></i></span>
                    Pesanan Saya
                </a>
            </li>
            <li>
                <a href="/make-booking">
                    <span class="sidebar-icon"><i class="fas fa-plus-circle"></i></span>
                    Pesan Baru
                </a>
            </li>
            <li>
                <a href="/profile" class="active">
                    <span class="sidebar-icon"><i class="fas fa-user-circle"></i></span>
                    Profil
                </a>
            </li>
            <li>
                <a href="#" onclick="confirmLogout(event)" style="color: #ef4444;">
                    <span class="sidebar-icon"><i class="fas fa-sign-out-alt"></i></span>
                    Logout
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <h1><i class="fas fa-user-circle"></i> Profil Saya</h1>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 300px 1fr; gap: 2rem; max-width: 1000px;">
            <!-- Profile Image -->
            <div class="card">
                <div class="card-body text-center">
                    <form id="profilePhotoForm" action="/update-profile-photo" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="file" id="profilePhoto" name="profile_photo" accept="image/png,image/jpeg,image/jpg" style="display: none;">
                        
                        <div style="position: relative; display: inline-block;">
                            <?php if (!empty($user['foto_profil'])): ?>
                                <img id="profileImg" src="<?= base_url('uploads/' . $user['foto_profil']) ?>" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin: 0 auto 1rem; border: 3px solid #3b82f6;">
                            <?php else: ?>
                                <div id="profileImg" style="width: 120px; height: 120px; background: #3b82f6; border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                    <i class="fas fa-user"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                    
                    <h3><?= $user['nama_lengkap'] ?></h3>
                    <p style="color: #6b7280; margin: 0.5rem 0 1.5rem 0;"><?= $user['email'] ?></p>
                    <button type="button" onclick="document.getElementById('profilePhoto').click()" class="btn btn-primary btn-sm btn-block">
                        <i class="fas fa-camera"></i> Ubah Foto
                    </button>
                </div>
            </div>

            <!-- Profile Form -->
            <form action="/update-profile" method="POST">
                <?= csrf_field() ?>

                <div class="card">
                    <div class="card-header">
                        <h3>Informasi Pribadi</h3>
                    </div>
                    <div class="card-body">
                <div class="form-group">
                    <label for="full_name">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="full_name" 
                        name="full_name" 
                        class="form-control"
                        value="<?= $user['nama_lengkap'] ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control"
                        value="<?= $user['email'] ?>"
                        readonly
                        style="background-color: #f3f4f6;"
                    >
                </div>

                <div class="form-group">
                    <label for="phone">No WhatsApp</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        class="form-control"
                        value="<?= $user['no_hp'] ?>"
                    >
                </div>                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea 
                                id="address" 
                                name="address" 
                                class="form-control" 
                                rows="3"
                            ><?= $user['alamat'] ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Security Section -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Keamanan</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 0; border-bottom: 1px solid #e5e7eb;">
                    <div>
                        <h4 style="margin: 0;">Ubah Password</h4>
                        <p style="margin: 0.5rem 0 0 0; color: #6b7280; font-size: 0.9rem;">Perbarui password akun Anda secara berkala</p>
                    </div>
                    <button class="btn btn-outline" onclick="openModal('changePasswordModal')">
                        Ubah
                    </button>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 0;">
                    <div>
                        <h4 style="margin: 0;">Aktivitas Login</h4>
                        <p style="margin: 0.5rem 0 0 0; color: #6b7280; font-size: 0.9rem;">Lihat riwayat login dan perangkat aktif</p>
                    </div>
                    <a href="/login-activity" class="btn btn-outline">
                        Lihat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div id="changePasswordModal" class="modal">
    <div class="modal-content" style="max-width: 400px;">
        <div class="modal-header">
            <h3>Ubah Password</h3>
            <button class="modal-close" onclick="closeModal('changePasswordModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="/change-password" method="POST" id="changePasswordForm">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="current_password">Password Lama</label>
                <input 
                    type="password" 
                    id="current_password" 
                    name="current_password" 
                    class="form-control"
                    required
                >
            </div>

            <div class="form-group">
                <label for="new_password">Password Baru</label>
                <input 
                    type="password" 
                    id="new_password" 
                    name="new_password" 
                    class="form-control"
                    required
                    minlength="6"
                >
            </div>

            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password Baru</label>
                <input 
                    type="password" 
                    id="confirm_password" 
                    name="confirm_password" 
                    class="form-control"
                    required
                    minlength="6"
                >
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="button" class="btn btn-outline btn-block" onclick="closeModal('changePasswordModal')">
                    Batal
                </button>
                <button type="submit" class="btn btn-primary btn-block">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('extra_js') ?>
<script>
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
                profileImg.outerHTML = '<img id="profileImg" src="' + event.target.result + '" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin: 0 auto 1rem; border: 3px solid #3b82f6;">';
            }
        };
        reader.readAsDataURL(file);
        
        // Auto submit form
        document.getElementById('profilePhotoForm').submit();
    }
});
</script>
<?= $this->endSection() ?>