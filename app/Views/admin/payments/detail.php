<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1>Detail Pembayaran #<?= $payment['id'] ?></h1>
            <p class="subtitle">Kelola pembayaran pelanggan</p>
        </div>
        <div class="header-actions">
            <a href="/admin/payments" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="admin-grid">
        <!-- Payment Information -->
        <div class="info-card">
            <div class="card-header">
                <h2>Informasi Pembayaran</h2>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Kode Pembayaran</span>
                        <span class="info-value">
                            <code><?= htmlspecialchars($payment['payment_code']) ?></code>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Booking ID</span>
                        <span class="info-value">
                            <a href="/customer/booking/<?= $booking['id'] ?>" class="link">
                                #<?= $booking['id'] ?>
                            </a>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Metode Pembayaran</span>
                        <span class="info-value">
                            <span class="badge badge-<?= htmlspecialchars($payment['payment_method']) ?>">
                                <?= ucfirst(str_replace('_', ' ', $payment['payment_method'])) ?>
                            </span>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Jumlah</span>
                        <span class="info-value text-success">
                            <strong>Rp <?= number_format($payment['amount'], 0, ',', '.') ?></strong>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status Pembayaran</span>
                        <span class="info-value">
                            <span class="status-badge status-<?= htmlspecialchars($payment['status']) ?>">
                                <?= ucfirst($payment['status']) ?>
                            </span>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Waktu Pembuatan</span>
                        <span class="info-value">
                            <?= date('d F Y H:i:s', strtotime($payment['created_at'])) ?>
                        </span>
                    </div>
                </div>

                <?php if (!empty($payment['notes'])): ?>
                <div class="info-item" style="grid-column: 1 / -1; margin-top: 1rem; border-top: 1px solid var(--border-color); padding-top: 1rem;">
                    <span class="info-label">Catatan</span>
                    <span class="info-value"><?= nl2br(htmlspecialchars($payment['notes'])) ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Booking Information -->
        <?php if ($booking): ?>
        <div class="info-card">
            <div class="card-header">
                <h2>Informasi Pesanan</h2>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Jenis Layanan</span>
                        <span class="info-value"><?= htmlspecialchars(ucfirst($booking['service'] ?? '-')) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Jenis Sepatu</span>
                        <span class="info-value"><?= htmlspecialchars(ucfirst($booking['shoe_type'] ?? '-')) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Jumlah Pasang</span>
                        <span class="info-value"><?= htmlspecialchars($booking['quantity'] ?? '-') ?> pasang</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status Pesanan</span>
                        <span class="info-value">
                            <span class="status-badge status-<?= htmlspecialchars($booking['status']) ?>">
                                <?= ucfirst(str_replace('_', ' ', $booking['status'])) ?>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Update Status Form -->
        <div class="info-card">
            <div class="card-header">
                <h2>Perbarui Status Pembayaran</h2>
            </div>
            <div class="card-body">
                <form method="post" action="/admin/payments/update-status/<?= $payment['id'] ?>" class="form">
                    <?= csrf_field() ?>
                    
                    <div class="form-group">
                        <label for="status">Status Baru:</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="pending" <?= $payment['status'] === 'pending' ? 'selected' : '' ?>>
                                Pending (Menunggu)
                            </option>
                            <option value="approved" <?= $payment['status'] === 'approved' ? 'selected' : '' ?>>
                                Approved (Disetujui)
                            </option>
                            <option value="failed" <?= $payment['status'] === 'failed' ? 'selected' : '' ?>>
                                Failed (Gagal)
                            </option>
                            <option value="cancelled" <?= $payment['status'] === 'cancelled' ? 'selected' : '' ?>>
                                Cancelled (Dibatalkan)
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="notes">Catatan (Opsional):</label>
                        <textarea name="notes" id="notes" class="form-control" rows="4" placeholder="Tambahkan catatan untuk pembayaran ini...">
                        </textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="/admin/payments" class="btn btn-outline">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
