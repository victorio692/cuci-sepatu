<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1>Manajemen Pembayaran</h1>
            <p class="subtitle">Kelola semua pembayaran dari pelanggan</p>
        </div>
        <div class="header-actions">
            <a href="/admin/payments/statistics" class="btn btn-primary">
                <i class="fas fa-chart-bar"></i> Statistik
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <?php if (!empty($stats)): ?>
    <div class="stats-grid">
        <?php foreach ($stats as $stat): ?>
        <div class="stat-card">
            <div class="stat-icon">
                <?php
                    $icons = [
                        'pending' => 'fa-clock',
                        'approved' => 'fa-check-circle',
                        'failed' => 'fa-times-circle',
                        'cancelled' => 'fa-ban'
                    ];
                    $icon = $icons[$stat['status']] ?? 'fa-credit-card';
                ?>
                <i class="fas <?= $icon ?>"></i>
            </div>
            <div class="stat-content">
                <h3><?= ucfirst($stat['status']) ?></h3>
                <p class="stat-number"><?= $stat['total'] ?? 0 ?> Pembayaran</p>
                <p class="stat-amount">Rp <?= number_format($stat['total_amount'] ?? 0, 0, ',', '.') ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="get" class="filter-form">
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="pending" <?= $current_status === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="approved" <?= $current_status === 'approved' ? 'selected' : '' ?>>Disetujui</option>
                    <option value="failed" <?= $current_status === 'failed' ? 'selected' : '' ?>>Gagal</option>
                    <option value="cancelled" <?= $current_status === 'cancelled' ? 'selected' : '' ?>>Dibatalkan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="sort">Urutkan:</label>
                <select name="sort" id="sort" class="form-control">
                    <option value="created_at" <?= $current_sort === 'created_at' ? 'selected' : '' ?>>Tanggal</option>
                    <option value="amount" <?= $current_sort === 'amount' ? 'selected' : '' ?>>Jumlah</option>
                    <option value="payment_method" <?= $current_sort === 'payment_method' ? 'selected' : '' ?>>Metode</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i> Filter
            </button>
        </form>
    </div>

    <!-- Payments Table -->
    <div class="table-container">
        <?php if (!empty($payments)): ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Pembayaran</th>
                    <th>Booking ID</th>
                    <th>Metode</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                <tr>
                    <td><?= $payment['id'] ?></td>
                    <td>
                        <code class="payment-code"><?= htmlspecialchars($payment['payment_code']) ?></code>
                    </td>
                    <td>
                        <a href="/customer/booking/<?= $payment['booking_id'] ?>" class="link">
                            #<?= $payment['booking_id'] ?>
                        </a>
                    </td>
                    <td>
                        <span class="badge badge-<?= htmlspecialchars($payment['payment_method']) ?>">
                            <?= ucfirst(str_replace('_', ' ', $payment['payment_method'])) ?>
                        </span>
                    </td>
                    <td class="text-right">
                        <strong>Rp <?= number_format($payment['amount'], 0, ',', '.') ?></strong>
                    </td>
                    <td>
                        <span class="status-badge status-<?= htmlspecialchars($payment['status']) ?>">
                            <?= ucfirst($payment['status']) ?>
                        </span>
                    </td>
                    <td><?= date('d M Y H:i', strtotime($payment['created_at'])) ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="/admin/payments/<?= $payment['id'] ?>" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Tidak ada pembayaran</h3>
            <p>Belum ada pembayaran yang tercatat</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
