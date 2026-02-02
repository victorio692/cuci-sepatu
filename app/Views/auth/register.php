<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-card-header">
            <div class="auth-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1>Daftar Akun</h1>
            <p class="auth-card-description">Buat akun untuk mulai booking</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <form action="/register" method="POST">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="full_name">Nama Lengkap</label>
                <input 
                    type="text" 
                    id="full_name" 
                    name="full_name" 
                    class="form-control" 
                    placeholder="Masukkan nama lengkap"
                    required
                    value="<?= old('full_name') ?>"
                >
                <?php if (session()->getFlashdata('full_name_error')): ?>
                    <small style="color: #ef4444;">
                        <?= session()->getFlashdata('full_name_error') ?>
                    </small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    placeholder="email@contoh.com"
                    required
                    value="<?= old('email') ?>"
                >
                <?php if (session()->getFlashdata('email_error')): ?>
                    <small style="color: #ef4444;">
                        <?= session()->getFlashdata('email_error') ?>
                    </small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="phone">No WhatsApp</label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    class="form-control" 
                    placeholder="08123456789"
                    required
                    value="<?= old('phone') ?>"
                >
                <small style="color: #6b7280; display: block; margin-top: 0.25rem;">
                    <i class="fas fa-info-circle"></i> Nomor WhatsApp valid untuk verifikasi (minimal 10 digit)
                </small>
                <?php if (session()->getFlashdata('phone_error')): ?>
                    <small style="color: #ef4444;">
                        <?= session()->getFlashdata('phone_error') ?>
                    </small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div style="position: relative;">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control" 
                        placeholder="Minimal 6 karakter"
                        style="padding-right: 3rem;"
                        required
                    >
                    <button 
                        type="button" 
                        onclick="togglePassword('password', this)" 
                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #6b7280; cursor: pointer; padding: 0.5rem;"
                    >
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <small style="color: #6b7280; display: block; margin-top: 0.25rem;">
                    <i class="fas fa-info-circle"></i> Minimal 6 karakter, kombinasi huruf dan angka lebih aman
                </small>
                <?php if (session()->getFlashdata('password_error')): ?>
                    <small style="color: #ef4444;">
                        <?= session()->getFlashdata('password_error') ?>
                    </small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <div style="position: relative;">
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        class="form-control" 
                        placeholder="Ulangi password"
                        style="padding-right: 3rem;"
                        required
                    >
                    <button 
                        type="button" 
                        onclick="togglePassword('confirm_password', this)" 
                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #6b7280; cursor: pointer; padding: 0.5rem;"
                    >
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <?php if (session()->getFlashdata('confirm_password_error')): ?>
                    <small style="color: #ef4444;">
                        <?= session()->getFlashdata('confirm_password_error') ?>
                    </small>
                <?php endif; ?>
            </div>

            <div class="form-check">
                <input 
                    type="checkbox" 
                    id="terms" 
                    name="terms"
                    required
                >
                <label for="terms">
                    Saya setuju dengan <a href="/syarat" target="_blank">Syarat & Ketentuan</a> dan <a href="/kebijakan" target="_blank">Kebijakan Privasi</a>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg mt-3">
                <i class="fas fa-user-check"></i> Daftar Sekarang
            </button>

            <div class="auth-footer" style="margin-top: 1.5rem;">
                Sudah punya akun? <a href="/login">Login di sini</a>
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
</script>
<?= $this->endSection() ?>
