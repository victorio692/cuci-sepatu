<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-card-header">
            <div class="auth-icon">
                <i class="fas fa-user-lock"></i>
            </div>
            <h1>Login</h1>
            <p class="auth-card-description">Masuk untuk melanjutkan</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <form action="/login" method="POST">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    placeholder="Masukkan email"
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
                <label for="password">Password</label>
                <div style="position: relative;">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control" 
                        placeholder="Masukkan password"
                        style="padding-right: 3rem;"
                        required
                    >
                    <button 
                        type="button" 
                        onclick="togglePassword('password', this)" 
                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #6b7280; cursor: pointer; padding: 0.5rem;"
                    >
                        <i class="fas fa-eye" id="password-icon"></i>
                    </button>
                </div>
                <?php if (session()->getFlashdata('password_error')): ?>
                    <small style="color: #ef4444;">
                        <?= session()->getFlashdata('password_error') ?>
                    </small>
                <?php endif; ?>
            </div>

            <div class="form-check">
                <input 
                    type="checkbox" 
                    id="remember" 
                    name="remember"
                >
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg mt-3">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>

            <div class="auth-footer" style="margin-top: 1.5rem;">
                Belum punya akun? <a href="/register">Daftar di sini</a>
            </div>

            <div class="auth-footer" style="margin-top: 1rem;">
                <a href="/forgot-password">Lupa password?</a>
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
