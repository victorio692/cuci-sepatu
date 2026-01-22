<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <div class="admin-header">
        <h1>Pesanan</h1>
        <p>Kelola semua pesanan pelanggan</p>
    </div>

    <!-- Filter & Search -->
    <div class="admin-card" style="margin-bottom: 2rem;">
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <form action="/admin/bookings" method="GET" style="display: contents;">
                    <div>
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Cari nama, email, layanan..." 
                            value="<?= $search ?>"
                            class="form-control"
                        >
                    </div>

                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>Menunggu</option>
                        <option value="disetujui" <?= $status === 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
                        <option value="proses" <?= $status === 'proses' ? 'selected' : '' ?>>Sedang Dikerjakan</option>
                        <option value="selesai" <?= $status === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option value="batal" <?= $status === 'batal' ? 'selected' : '' ?>>Ditolak</option>
                    </select>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="admin-card">
        <div class="card-body" style="padding: 0;">
            <?php if (!empty($bookings)): ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Layanan</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><strong>#<?= $booking['id'] ?></strong></td>
                                <td>
                                    <div>
                                        <strong><?= $booking['full_name'] ?></strong>
                                        <p style="margin: 0.25rem 0 0; font-size: 0.9rem; color: #6b7280;">
                                            <?= $booking['email'] ?>
                                        </p>
                                    </div>
                                </td>
                                <td><?= ucfirst(str_replace('-', ' ', $booking['service'])) ?></td>
                                <td><?= date('d M Y', strtotime($booking['created_at'])) ?></td>
                                <td>Rp <?= number_format($booking['total'], 0, ',', '.') ?></td>
                                <td>
                                    <select 
                                        class="status-select" 
                                        data-booking-id="<?= $booking['id'] ?>"
                                        onchange="updateBookingStatus(this)"
                                    >
                                        <option value="pending" <?= $booking['status'] === 'pending' ? 'selected' : '' ?>>Menunggu</option>
                                        <option value="disetujui" <?= $booking['status'] === 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
                                        <option value="proses" <?= $booking['status'] === 'proses' ? 'selected' : '' ?>>Sedang Dikerjakan</option>
                                        <option value="selesai" <?= $booking['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                        <option value="batal" <?= $booking['status'] === 'batal' ? 'selected' : '' ?>>Ditolak</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="/admin/bookings/<?= $booking['id'] ?>" class="btn-link">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Total Bookings -->
                <div style="padding: 1.5rem; border-top: 1px solid #e5e7eb; text-align: center; color: #6b7280;">
                    Total: <?= count($bookings) ?> pesanan
                </div>
            <?php else: ?>
                <div style="padding: 2rem; text-align: center; color: #6b7280;">
                    <i class="fas fa-inbox" style="font-size: 3rem; color: #d1d5db;"></i>
                    <p style="margin-top: 1rem;">Tidak ada pesanan</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
<style>
.status-select {
    padding: 0.5rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    font-size: 0.9rem;
    color: #374151;
    cursor: pointer;
}

.status-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
}
</style>
<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
function updateBookingStatus(element) {
    const bookingId = element.getAttribute('data-booking-id');
    const status = element.value;

    AdminAPI.put('/bookings/' + bookingId + '/status', { status: status })
        .then(data => {
            showToast('Status updated successfully', 'success');
        })
        .catch(error => {
            location.reload();
            showToast('Failed to update status', 'danger');
        });
}
</script>
<?= $this->endSection() ?>
