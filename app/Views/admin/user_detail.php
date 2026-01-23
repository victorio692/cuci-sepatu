<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <div style="margin-bottom: 2rem;">
        <a href="/admin/users" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Pengguna
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
        <!-- Profile Card -->
        <div>
            <div class="admin-card">
                <div class="card-body" style="text-align: center;">
                    <div class="user-avatar" style="
                        width: 80px;
                        height: 80px;
                        border-radius: 50%;
                        background: #3b82f6;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin: 0 auto 1rem;
                        color: white;
                        font-size: 2rem;
                    ">
                        <i class="fas fa-user"></i>
                    </div>

                    <h2 style="margin: 0 0 0.5rem 0; color: #1f2937;">
                        <?= $user['nama_lengkap'] ?>
                    </h2>

                    <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; justify-content: center;">
                        <button 
                            class="status-badge-detail <?= $user['aktif'] ? 'active' : 'inactive' ?>"
                            onclick="toggleActive()"
                        >
                            <i class="fas fa-<?= $user['aktif'] ? 'check-circle' : 'ban' ?>"></i>
                            <?= $user['aktif'] ? 'Active' : 'Inactive' ?>
                        </button>
                    </div>

                    <div style="border-top: 1px solid #e5e7eb; padding-top: 1.5rem;">
                        <div class="info-item">
                            <span style="color: #6b7280; font-size: 0.9rem;">Bergabung</span>
                            <strong><?= date('d M Y', strtotime($user['created_at'])) ?></strong>
                        </div>
                        <div class="info-item">
                            <span style="color: #6b7280; font-size: 0.9rem;">Total Pesanan</span>
                            <strong><?= count($bookings) ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details & Bookings -->
        <div>
            <!-- User Information -->
            <div class="admin-card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 style="margin: 0; color: #1f2937;">
                        <i class="fas fa-user"></i> Informasi Customer
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <label>Nama:</label>
                        <span><?= $user['nama_lengkap'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Email:</label>
                        <span><?= $user['email'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Nomor WA:</label>
                        <span><?= $user['no_hp'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Alamat:</label>
                        <span><?= $user['alamat'] ?: '-' ?></span>
                    </div>
                    <div class="info-row">
                        <label>Kota:</label>
                        <span><?= $user['kota'] ? $user['kota'] . ', ' . $user['provinsi'] . ' ' . $user['kode_pos'] : '-' ?></span>
                    </div>
                </div>
            </div>

            <!-- Booking History -->
            <div class="admin-card">
                <div class="card-header">
                    <h3 style="margin: 0; color: #1f2937;">
                        <i class="fas fa-history"></i> Riwayat Pesanan
                    </h3>
                </div>
                <div class="card-body" style="padding: 0;">
                    <?php if (!empty($bookings)): ?>
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Layanan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bookings as $booking): ?>
                                    <tr>
                                        <td><strong>#<?= $booking['id'] ?></strong></td>
                                        <td><?= ucfirst(str_replace('-', ' ', $booking['layanan'])) ?></td>
                                        <td>Rp <?= number_format($booking['total'], 0, ',', '.') ?></td>
                                        <td>
                                            <span class="badge badge-<?= strtolower($booking['status']) ?>">
                                                <?= ucfirst(str_replace('_', ' ', $booking['status'])) ?>
                                            </span>
                                        </td>
                                        <td><?= date('d M Y', strtotime($booking['created_at'])) ?></td>
                                        <td>
                                            <a href="/admin/bookings/<?= $booking['id'] ?>" class="btn-link">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div style="padding: 2rem; text-align: center; color: #6b7280;">
                            <i class="fas fa-inbox" style="font-size: 3rem; color: #d1d5db;"></i>
                            <p style="margin-top: 1rem;">Tidak ada riwayat pesanan</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
<style>
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background-color: #e5e7eb;
    color: #374151;
    text-decoration: none;
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background-color: #d1d5db;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.info-item {
    display: flex;
    flex-direction: column;
    margin-bottom: 1rem;
}

.info-item:last-child {
    margin-bottom: 0;
}

.status-badge-detail {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.status-badge-detail.active {
    background-color: #d1fae5;
    color: #065f46;
}

.status-badge-detail.active:hover {
    background-color: #a7f3d0;
}

.status-badge-detail.inactive {
    background-color: #fee2e2;
    color: #991b1b;
}

.status-badge-detail.inactive:hover {
    background-color: #fecaca;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f3f4f6;
}

.info-row:last-child {
    border-bottom: none;
}

.info-row label {
    font-weight: 600;
    color: #6b7280;
}

.info-row span {
    color: #1f2937;
    text-align: right;
}

.badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.85rem;
    font-weight: 500;
}

.badge-pending {
    background-color: #fef3c7;
    color: #92400e;
}

.badge-approved {
    background-color: #dbeafe;
    color: #0c4a6e;
}

.badge-in_progress {
    background-color: #e9d5ff;
    color: #581c87;
}

.badge-completed {
    background-color: #d1fae5;
    color: #065f46;
}

.badge-cancelled {
    background-color: #fee2e2;
    color: #991b1b;
}

.btn-link {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-link:hover {
    color: #2563eb;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table thead {
    background-color: #f9fafb;
    border-bottom: 2px solid #e5e7eb;
}

.admin-table th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: #374151;
}

.admin-table td {
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
    color: #1f2937;
}

.admin-table tbody tr:hover {
    background-color: #f9fafb;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
function toggleActive() {
    const userId = <?= $user['id'] ?>;

    AdminAPI.post('/users/' + userId + '/toggle', {})
        .then(data => {
            showToast('User status updated', 'success');
            setTimeout(() => location.reload(), 1000);
        })
        .catch(error => {
            showToast('Failed to update user status', 'danger');
        });
}
</script>
<?= $this->endSection() ?>
