<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <div class="dashboard-header" style="margin-bottom: 2rem;">
        <h1><i class="fas fa-user-circle"></i> Profil Admin</h1>
        <p style="margin: 0.5rem 0 0; color: #6b7280;">Kelola informasi akun Anda</p>
    </div>

    <?php if (session()->has('success')): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?= session('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger">
            <i class="fas fa-times-circle"></i> <?= session('error') ?>
        </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Profile Information -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-user"></i> Informasi Profil</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= base_url('admin/profile/update') ?>">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="<?= $user['nama_lengkap'] ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?= $user['email'] ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>No. HP</label>
                        <input type="text" name="no_hp" value="<?= $user['no_hp'] ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" rows="3" class="form-control"><?= $user['alamat'] ?? '' ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-lock"></i> Ubah Password</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= base_url('admin/profile/change-password') ?>">
                    <div class="form-group">
                        <label>Password Lama</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-key"></i> Ubah Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Account Info -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h3><i class="fas fa-info-circle"></i> Informasi Akun</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
                <div>
                    <label style="font-weight: 600; color: #6b7280; display: block; margin-bottom: 0.5rem;">Role:</label>
                    <span style="display: inline-block; background: #7c3aed; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 500;">
                        <?= $user['is_admin'] ? 'Admin' : 'Customer' ?>
                    </span>
                </div>
                <div>
                    <label style="font-weight: 600; color: #6b7280; display: block; margin-bottom: 0.5rem;">Terdaftar Sejak:</label>
                    <span><?= date('d M Y', strtotime($user['created_at'])) ?></span>
                </div>
                <div>
                    <label style="font-weight: 600; color: #6b7280; display: block; margin-bottom: 0.5rem;">Status:</label>
                    <span style="color: #10b981; font-weight: 600;">
                        <i class="fas fa-check-circle"></i> Aktif
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
<style>
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #374151;
}

.form-control {
    padding: 0.75rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    width: 100%;
    font-size: 1rem;
}

.form-control:focus {
    outline: none;
    border-color: #7c3aed;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #7c3aed;
    color: white;
}

.btn-primary:hover {
    background: #6d28d9;
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #10b981;
}

.alert-danger {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #ef4444;
}

.card-header h3 {
    margin: 0;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
</style>
<?= $this->endSection() ?>
