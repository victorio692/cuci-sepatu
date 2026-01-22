<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-card-header">
            <div class="auth-icon">
                <i class="fas fa-key"></i>
            </div>
            <h1>Lupa Password</h1>
            <p class="auth-card-description">Masukkan email dan nomor HP untuk reset password</p>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <form action="/forgot-password" method="POST">
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
                    autofocus
                    value="<?= old('email') ?>"
                >
            </div>

            <div class="form-group">
                <label for="no_hp">Nomor HP</label>
                <input 
                    type="tel" 
                    id="no_hp" 
                    name="no_hp" 
                    class="form-control" 
                    placeholder="08123456789"
                    required
                    value="<?= old('no_hp') ?>"
                >
                <small style="color: #6b7280; font-size: 0.85rem; display: block; margin-top: 0.25rem;">
                    Masukkan nomor HP yang terdaftar
                </small>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg mt-3">
                <i class="fas fa-paper-plane"></i> Kirim Link Reset
            </button>

            <div class="auth-footer" style="margin-top: 1.5rem;">
                Sudah ingat password? <a href="/login">Login di sini</a>
            </div>

            <div class="auth-footer" style="margin-top: 1rem;">
                Belum punya akun? <a href="/register">Daftar sekarang</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
