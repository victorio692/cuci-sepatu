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
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control" 
                    placeholder="Masukkan password"
                    required
                >
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
