<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1>Statistik Pembayaran</h1>
            <p class="subtitle">Analisis pembayaran dan performa</p>
        </div>
        <div class="header-actions">
            <a href="/admin/payments" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Statistics Overview -->
    <?php if (!empty($stats)): ?>
    <div class="stats-grid">
        <?php 
            $totalPayments = 0;
            $totalAmount = 0;
            foreach ($stats as $stat) {
                $totalPayments += $stat['total'] ?? 0;
                $totalAmount += $stat['total_amount'] ?? 0;
            }
        ?>
        <div class="stat-card stat-card-large">
            <div class="stat-icon large">
                <i class="fas fa-money-bill"></i>
            </div>
            <div class="stat-content">
                <h3>Total Pembayaran</h3>
                <p class="stat-number"><?= $totalPayments ?> Transaksi</p>
                <p class="stat-amount">Rp <?= number_format($totalAmount, 0, ',', '.') ?></p>
            </div>
        </div>

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
                    $colors = [
                        'pending' => '#f59e0b',
                        'approved' => '#10b981',
                        'failed' => '#ef4444',
                        'cancelled' => '#6b7280'
                    ];
                    $icon = $icons[$stat['status']] ?? 'fa-credit-card';
                    $color = $colors[$stat['status']] ?? '#0066cc';
                ?>
                <i class="fas <?= $icon ?>" style="color: <?= $color ?>"></i>
            </div>
            <div class="stat-content">
                <h3><?= ucfirst($stat['status']) ?></h3>
                <p class="stat-number"><?= $stat['total'] ?? 0 ?></p>
                <p class="stat-amount">Rp <?= number_format($stat['total_amount'] ?? 0, 0, ',', '.') ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Detailed Statistics -->
    <div class="info-card" style="margin-top: 2rem;">
        <div class="card-header">
            <h2>Rincian Pembayaran Berdasarkan Status</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($stats)): ?>
            <div class="stats-table">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th class="text-center">Jumlah Transaksi</th>
                            <th class="text-right">Total Jumlah</th>
                            <th class="text-center">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $totalPayments = array_sum(array_column($stats, 'total'));
                            $totalAmount = array_sum(array_column($stats, 'total_amount'));
                        ?>
                        <?php foreach ($stats as $stat): ?>
                        <tr>
                            <td>
                                <span class="status-badge status-<?= htmlspecialchars($stat['status']) ?>">
                                    <?= ucfirst($stat['status']) ?>
                                </span>
                            </td>
                            <td class="text-center"><?= $stat['total'] ?? 0 ?></td>
                            <td class="text-right">
                                <strong>Rp <?= number_format($stat['total_amount'] ?? 0, 0, ',', '.') ?></strong>
                            </td>
                            <td class="text-center">
                                <?php 
                                    $percentage = $totalPayments > 0 ? ($stat['total'] / $totalPayments) * 100 : 0;
                                ?>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?= $percentage ?>%; background-color: <?php
                                        $colors = [
                                            'pending' => '#f59e0b',
                                            'approved' => '#10b981',
                                            'failed' => '#ef4444',
                                            'cancelled' => '#6b7280'
                                        ];
                                        echo $colors[$stat['status']] ?? '#0066cc';
                                    ?>"></div>
                                </div>
                                <span><?= number_format($percentage, 1) ?>%</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-chart-bar"></i>
                <h3>Tidak ada data statistik</h3>
                <p>Belum ada pembayaran yang tercatat</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="info-card" style="margin-top: 2rem;">
        <div class="card-header">
            <h2>Metrik Utama</h2>
        </div>
        <div class="card-body">
            <div class="metrics-grid">
                <?php 
                    $approvedAmount = 0;
                    $approvedCount = 0;
                    foreach ($stats as $stat) {
                        if ($stat['status'] === 'approved') {
                            $approvedAmount = $stat['total_amount'] ?? 0;
                            $approvedCount = $stat['total'] ?? 0;
                        }
                    }
                ?>
                <div class="metric-item">
                    <h4>Pendapatan yang Disetujui</h4>
                    <p class="metric-value">Rp <?= number_format($approvedAmount, 0, ',', '.') ?></p>
                    <p class="metric-subtext"><?= $approvedCount ?> transaksi</p>
                </div>
                
                <div class="metric-item">
                    <h4>Total Transaksi</h4>
                    <p class="metric-value"><?= $totalPayments ?></p>
                    <p class="metric-subtext">Rp <?= number_format($totalAmount, 0, ',', '.') ?></p>
                </div>

                <div class="metric-item">
                    <h4>Rata-rata Pembayaran</h4>
                    <p class="metric-value">
                        Rp <?= number_format($totalPayments > 0 ? $totalAmount / $totalPayments : 0, 0, ',', '.') ?>
                    </p>
                    <p class="metric-subtext">Per transaksi</p>
                </div>

                <div class="metric-item">
                    <h4>Tingkat Keberhasilan</h4>
                    <p class="metric-value">
                        <?php
                            $successRate = $totalPayments > 0 ? ($approvedCount / $totalPayments) * 100 : 0;
                            echo number_format($successRate, 1);
                        ?>%
                    </p>
                    <p class="metric-subtext">Pembayaran berhasil</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.progress-bar {
    width: 100%;
    height: 20px;
    background-color: #e5e7eb;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.progress-fill {
    height: 100%;
    transition: width 0.3s ease;
    border-radius: 4px;
}

.metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.metric-item {
    padding: 1.5rem;
    background-color: var(--light-color);
    border-radius: var(--radius);
    border-left: 4px solid var(--primary-color);
}

.metric-item h4 {
    margin: 0 0 0.75rem 0;
    font-size: 0.95rem;
    color: var(--text-light);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.metric-value {
    margin: 0;
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--primary-color);
}

.metric-subtext {
    margin: 0.5rem 0 0 0;
    font-size: 0.9rem;
    color: var(--text-light);
}
</style>

<?= $this->endSection() ?>
