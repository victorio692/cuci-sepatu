<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="/dashboard" class="active">
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
                <a href="/my-services">
                    <span class="sidebar-icon"><i class="fas fa-list"></i></span>
                    Riwayat Layanan
                </a>
            </li>
            <li>
                <a href="/make-booking">
                    <span class="sidebar-icon"><i class="fas fa-plus-circle"></i></span>
                    Pesan Baru
                </a>
            </li>
            <li>
                <a href="/profile">
                    <span class="sidebar-icon"><i class="fas fa-user-circle"></i></span>
                    Profil
                </a>
            </li>
            <li>
                <a href="/settings">
                    <span class="sidebar-icon"><i class="fas fa-cog"></i></span>
                    Pengaturan
                </a>
            </li>
            <li>
                <a href="/logout">
                    <span class="sidebar-icon"><i class="fas fa-sign-out-alt"></i></span>
                    Logout
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <div class="dashboard-title">
                <div>
                    <h1>Selamat Datang, John Doe!</h1>
                    <p style="color: #6b7280; margin: 0;">Kelola pesanan dan layanan cuci sepatu Anda</p>
                </div>
                <a href="/make-booking" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Pesan Sekarang
                </a>
            </div>

            <!-- Stats -->
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-label">Total Pesanan</div>
                    <div class="stat-value">0</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Pesanan Aktif</div>
                    <div class="stat-value" style="color: #f59e0b;">0</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Selesai</div>
                    <div class="stat-value" style="color: #10b981;">0</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Pengeluaran</div>
                    <div class="stat-value">Rp 0</div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="card">
            <div class="card-header">
                <h3>Pesanan Terbaru</h3>
            </div>
            <div class="card-body">
                <div class="text-center p-4">
                    <i class="fas fa-inbox" style="font-size: 3rem; color: #d1d5db;"></i>
                    <p style="color: #6b7280; margin-top: 1rem;">Anda belum memiliki pesanan.</p>
                    <a href="/make-booking" class="btn btn-primary mt-2">Pesan Sekarang</a>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 2rem;">
            <div class="card">
                <div class="card-body">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #7c3aed, #ec4899); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0;">Pesan Baru</h4>
                            <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">Mulai pesanan baru</p>
                        </div>
                    </div>
                    <a href="/make-booking" style="display: block; margin-top: 1rem; text-align: center;" class="btn btn-primary btn-sm">
                        Pesan
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981, #3b82f6); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0;">Profil</h4>
                            <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">Update data pribadi</p>
                        </div>
                    </div>
                    <a href="/profile" style="display: block; margin-top: 1rem; text-align: center;" class="btn btn-primary btn-sm">
                        Lihat
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #f59e0b, #ef4444); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div>
                            <h4 style="margin: 0;">Dukungan</h4>
                            <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">Hubungi customer service</p>
                        </div>
                    </div>
                    <a href="/kontak" style="display: block; margin-top: 1rem; text-align: center;" class="btn btn-primary btn-sm">
                        Hubungi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
// Helper functions untuk status
function getStatusBadgeClass(status) {
    const classes = {
        'pending': 'warning',
        'approved': 'info',
        'in_progress': 'info',
        'completed': 'success',
        'cancelled': 'danger'
    };
    return classes[status] || 'primary';
}

function getStatusLabel(status) {
    const labels = {
        'pending': 'Menunggu Persetujuan',
        'approved': 'Disetujui',
        'in_progress': 'Sedang Diproses',
        'completed': 'Selesai',
        'cancelled': 'Dibatalkan'
    };
    return labels[status] || status;
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}
</script>
<?= $this->endSection() ?>
