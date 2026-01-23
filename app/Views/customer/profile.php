<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="dashboard-container">
    <!-- Sidebar Navigation -->
    <aside class="dashboard-sidebar">
        <div class="sidebar-header">
            <h3>Menu</h3>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="/customer/dashboard" class="sidebar-link" title="Dashboard">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/customer/my-bookings" class="sidebar-link" title="Pesanan Saya">
                        <i class="fas fa-list"></i>
                        <span>Pesanan Saya</span>
                    </a>
                </li>
                <li>
                    <a href="/make-booking" class="sidebar-link" title="Pesan Baru">
                        <i class="fas fa-plus-circle"></i>
                        <span>Pesan Baru</span>
                    </a>
                </li>
                <li>
                    <a href="/customer/profile" class="sidebar-link active" title="Profil">
                        <i class="fas fa-user"></i>
                        <span>Profil Saya</span>
                    </a>
                </li>
                <li>
                    <a href="/logout" class="sidebar-link" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main">
        <!-- Header -->
        <div class="dashboard-header">
            <div class="header-content">
                <div>
                    <h1>Profil Saya</h1>
                    <p class="subtitle">Kelola informasi pribadi dan keamanan akun Anda</p>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
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

        <!-- Profile Information Card -->
        <div class="profile-card">
            <div class="card-header">
                <h2>Informasi Profil</h2>
            </div>
            <div class="card-body">
                <form action="/customer/update-profile" method="POST" class="form-profile">
                    <?= csrf_field() ?>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="full_name">Nama Lengkap <span class="required">*</span></label>
                            <input 
                                type="text" 
                                id="full_name" 
                                name="full_name" 
                                class="form-control"
                                placeholder="Masukkan nama lengkap"
                                value="<?= htmlspecialchars($user->full_name ?? '') ?>"
                                required
                                minlength="3"
                                maxlength="255"
                            >
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="readonly">(Tidak dapat diubah)</span></label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-control"
                                value="<?= htmlspecialchars($user->email ?? '') ?>"
                                disabled
                            >
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Nomor Telepon <span class="required">*</span></label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                class="form-control"
                                placeholder="Contoh: 0812345678 atau +628123456789"
                                value="<?= htmlspecialchars($user->phone ?? '') ?>"
                                required
                                minlength="10"
                                maxlength="15"
                            >
                        </div>

                        <div class="form-group">
                            <label for="city">Kota</label>
                            <input 
                                type="text" 
                                id="city" 
                                name="city" 
                                class="form-control"
                                placeholder="Contoh: Jakarta"
                                value="<?= htmlspecialchars($user->city ?? '') ?>"
                                maxlength="100"
                            >
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="province">Provinsi</label>
                            <input 
                                type="text" 
                                id="province" 
                                name="province" 
                                class="form-control"
                                placeholder="Contoh: DKI Jakarta"
                                value="<?= htmlspecialchars($user->province ?? '') ?>"
                                maxlength="100"
                            >
                        </div>

                        <div class="form-group">
                            <label for="zip_code">Kode Pos</label>
                            <input 
                                type="text" 
                                id="zip_code" 
                                name="zip_code" 
                                class="form-control"
                                placeholder="Contoh: 12345"
                                value="<?= htmlspecialchars($user->zip_code ?? '') ?>"
                                pattern="[0-9]{5,6}"
                                maxlength="10"
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat Lengkap</label>
                        <textarea 
                            id="address" 
                            name="address" 
                            class="form-control"
                            placeholder="Masukkan alamat lengkap Anda"
                            rows="4"
                            maxlength="500"
                        ><?= htmlspecialchars($user->address ?? '') ?></textarea>
                        <small class="form-text-muted">Maksimal 500 karakter</small>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="/customer/dashboard" class="btn btn-outline">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Card -->
        <div class="profile-card">
            <div class="card-header">
                <h2>Ubah Password</h2>
            </div>
            <div class="card-body">
                <form action="/customer/change-password" method="POST" class="form-profile">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="current_password">Password Saat Ini <span class="required">*</span></label>
                        <input 
                            type="password" 
                            id="current_password" 
                            name="current_password" 
                            class="form-control"
                            placeholder="Masukkan password saat ini"
                            required
                            minlength="6"
                        >
                    </div>

                    <div class="form-group">
                        <label for="new_password">Password Baru <span class="required">*</span></label>
                        <input 
                            type="password" 
                            id="new_password" 
                            name="new_password" 
                            class="form-control"
                            placeholder="Masukkan password baru (minimal 8 karakter)"
                            required
                            minlength="8"
                        >
                        <small class="form-text-muted">Gunakan kombinasi huruf, angka, dan simbol untuk keamanan lebih baik</small>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Konfirmasi Password Baru <span class="required">*</span></label>
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            class="form-control"
                            placeholder="Masukkan ulang password baru"
                            required
                            minlength="8"
                        >
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-lock"></i> Ubah Password
                        </button>
                        <a href="/customer/dashboard" class="btn btn-outline">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<?= $this->endSection() ?>
