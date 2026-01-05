<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <div style="margin-bottom: 2rem;">
        <a href="/admin/bookings" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Pesanan
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Main Details -->
        <div>
            <!-- Order Header -->
            <div class="admin-card" style="margin-bottom: 1.5rem;">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <h1 style="margin: 0 0 0.5rem 0; color: #1f2937;">
                                Pesanan #<?= $booking['id'] ?>
                            </h1>
                            <p style="margin: 0; color: #6b7280;">
                                <?= date('d M Y H:i', strtotime($booking['created_at'])) ?>
                            </p>
                        </div>
                        <select 
                            id="statusSelect"
                            class="status-select-detail"
                            onchange="updateStatus(this)"
                        >
                            <option value="pending" <?= $booking['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="approved" <?= $booking['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="in_progress" <?= $booking['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="completed" <?= $booking['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="cancelled" <?= $booking['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="admin-card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 style="margin: 0; color: #1f2937;">
                        <i class="fas fa-user"></i> Informasi Pelanggan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <label>Nama:</label>
                        <span><?= $booking['full_name'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Email:</label>
                        <span><?= $booking['email'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Telepon:</label>
                        <span><?= $booking['phone'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Alamat:</label>
                        <span><?= $booking['address'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Kota:</label>
                        <span><?= $booking['city'] ?>, <?= $booking['province'] ?> <?= $booking['zip_code'] ?></span>
                    </div>
                </div>
            </div>

            <!-- Service & Items -->
            <div class="admin-card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 style="margin: 0; color: #1f2937;">
                        <i class="fas fa-shopping-bag"></i> Detail Pesanan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <label>Layanan:</label>
                        <span><?= ucfirst(str_replace('-', ' ', $booking['service'])) ?></span>
                    </div>
                    <div class="info-row">
                        <label>Tipe Sepatu:</label>
                        <span><?= ucfirst(str_replace('-', ' ', $booking['shoe_type'])) ?></span>
                    </div>
                    <div class="info-row">
                        <label>Kondisi Sepatu:</label>
                        <span><?= ucfirst($booking['shoe_condition']) ?></span>
                    </div>
                    <div class="info-row">
                        <label>Jumlah:</label>
                        <span><?= $booking['quantity'] ?> pasang</span>
                    </div>
                </div>
            </div>

            <!-- Delivery Info -->
            <div class="admin-card">
                <div class="card-header">
                    <h3 style="margin: 0; color: #1f2937;">
                        <i class="fas fa-truck"></i> Pengiriman
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <label>Tipe Pengiriman:</label>
                        <span><?= ucfirst(str_replace('-', ' ', $booking['delivery_option'])) ?></span>
                    </div>
                    <div class="info-row">
                        <label>Tanggal Pengiriman:</label>
                        <span><?= date('d M Y', strtotime($booking['delivery_date'])) ?></span>
                    </div>
                    <div class="info-row">
                        <label>Alamat Pengiriman:</label>
                        <span><?= $booking['delivery_address'] ?></span>
                    </div>
                    <?php if (!empty($booking['notes'])): ?>
                        <div class="info-row">
                            <label>Catatan:</label>
                            <span><?= $booking['notes'] ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar Summary -->
        <div>
            <!-- Price Summary -->
            <div class="admin-card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 style="margin: 0; color: #1f2937;">
                        <i class="fas fa-receipt"></i> Ringkasan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>Rp <?= number_format($booking['subtotal'], 0, ',', '.') ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Biaya Pengiriman:</span>
                        <span>Rp <?= number_format($booking['delivery_fee'], 0, ',', '.') ?></span>
                    </div>
                    <div class="summary-row" style="border-top: 1px solid #e5e7eb; padding-top: 1rem; margin-top: 1rem;">
                        <strong>Total:</strong>
                        <strong style="color: #7c3aed; font-size: 1.25rem;">
                            Rp <?= number_format($booking['total'], 0, ',', '.') ?>
                        </strong>
                    </div>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="admin-card">
                <div class="card-header">
                    <h3 style="margin: 0; color: #1f2937;">
                        <i class="fas fa-clock"></i> Timeline
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline-item">
                        <div class="timeline-status completed">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <strong>Dibuat</strong>
                            <p style="margin: 0.25rem 0 0; color: #6b7280; font-size: 0.9rem;">
                                <?= date('d M Y H:i', strtotime($booking['created_at'])) ?>
                            </p>
                        </div>
                    </div>

                    <?php
                    $statuses = ['pending' => 'Pending', 'approved' => 'Disetujui', 'in_progress' => 'Sedang Diproses', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];
                    $status_order = ['pending', 'approved', 'in_progress', 'completed'];
                    $current_status = $booking['status'];
                    ?>

                    <?php foreach ($status_order as $status): ?>
                        <?php if ($status !== 'pending'): ?>
                            <div class="timeline-item">
                                <div class="timeline-status <?= (array_search($current_status, $status_order) >= array_search($status, $status_order)) ? 'completed' : 'pending' ?>">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div>
                                    <strong><?= $statuses[$status] ?></strong>
                                    <p style="margin: 0.25rem 0 0; color: #6b7280; font-size: 0.9rem;">
                                        <?= (array_search($current_status, $status_order) >= array_search($status, $status_order)) ? 'Selesai' : 'Menunggu' ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
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

.status-select-detail {
    padding: 0.75rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
    background-color: white;
}

.status-select-detail:focus {
    outline: none;
    border-color: #7c3aed;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    color: #374151;
}

.timeline-item {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    position: relative;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 12px;
    top: 40px;
    width: 2px;
    height: calc(100% + 0.5rem);
    background-color: #e5e7eb;
}

.timeline-status {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 0.75rem;
}

.timeline-status.completed {
    background-color: #d1fae5;
    color: #065f46;
}

.timeline-status.pending {
    background-color: #fee2e2;
    color: #991b1b;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
function updateStatus(select) {
    const status = select.value;
    const bookingId = <?= $booking['id'] ?>;

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
