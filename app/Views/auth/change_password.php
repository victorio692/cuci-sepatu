<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-card-header">
            <div class="auth-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h1>Ubah Password</h1>
            <p class="auth-card-description">Ubah password untuk <strong><?= esc($user['email']) ?></strong></p>
        </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="/change-password" method="POST">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="current_password">Password Saat Ini</label>
                    <div style="position: relative;">
                        <input 
                            type="password" 
                            id="current_password" 
                            name="current_password" 
                            class="form-control" 
                            placeholder="Masukkan password saat ini"
                            required
                            autofocus
                            style="padding-right: 3rem;"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('current_password', this)" 
                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: transparent; border: none; cursor: pointer; color: #6b7280; padding: 0.5rem;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="new_password">Password Baru</label>
                    <div style="position: relative;">
                        <input 
                            type="password" 
                            id="new_password" 
                            name="new_password" 
                            class="form-control" 
                            placeholder="Minimal 6 karakter"
                            required
                            minlength="6"
                            style="padding-right: 3rem;"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('new_password', this)" 
                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: transparent; border: none; cursor: pointer; color: #6b7280; padding: 0.5rem;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password Baru</label>
                    <div style="position: relative;">
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            class="form-control" 
                            placeholder="Ulangi password baru"
                            required
                            minlength="6"
                            style="padding-right: 3rem;"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('confirm_password', this)" 
                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: transparent; border: none; cursor: pointer; color: #6b7280; padding: 0.5rem;">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem; padding: 1rem; background: #f3f4f6; border-radius: 0.5rem; font-size: 0.85rem;">
                    <p style="margin: 0 0 0.5rem; font-weight: 600; color: #374151;">
                        <i class="fas fa-info-circle" style="color: #3b82f6;"></i> Persyaratan Password:
                    </p>
                    <ul style="margin: 0; padding-left: 1.5rem; color: #6b7280; line-height: 1.6;">
                        <li>Minimal 6 karakter</li>
                        <li>Password baru dan konfirmasi harus sama</li>
                    </ul>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg mt-3">
                    <i class="fas fa-check"></i> Ubah Password
                </button>

                <div class="auth-footer" style="margin-top: 1.5rem;">
                    Kembali ke <a href="/profile/detail">halaman profil</a>
                </div>
            </form>
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

// Validate password match
const form = document.querySelector('form');
form.addEventListener('submit', function(e) {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (newPassword !== confirmPassword) {
        e.preventDefault();
        alert('Password baru dan konfirmasi password tidak sama!');
        return false;
    }
});
</script>
<?= $this->endSection() ?>
