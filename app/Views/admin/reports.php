<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <div class="dashboard-header" style="margin-bottom: 2rem;">
        <h1><i class="fas fa-file-chart-line"></i> Laporan</h1>
        <p style="margin: 0.5rem 0 0; color: #6b7280;">Statistik dan laporan bisnis</p>
    </div>

    <!-- Filter Date Range -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-body">
            <form method="GET" action="<?= base_url('admin/reports') ?>" style="display: flex; gap: 1rem; align-items: end;">
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Tanggal Mulai:</label>
                    <input type="date" name="start_date" value="<?= $start_date ?>" class="form-control" required>
                </div>
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Tanggal Akhir:</label>
                    <input type="date" name="end_date" value="<?= $end_date ?>" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="<?= base_url('admin/reports/print?start_date=' . $start_date . '&end_date=' . $end_date) ?>" target="_blank" class="btn btn-primary" style="background: #10b981;">
                    <i class="fas fa-print"></i> Cetak
                </a>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total Booking</div>
                <div class="stat-number"><?= $total_bookings ?></div>
                <div class="stat-sublabel">Periode ini</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Selesai</div>
                <div class="stat-number" style="color: #10b981;"><?= $completed_bookings ?></div>
                <div class="stat-sublabel">Booking selesai</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Pending</div>
                <div class="stat-number" style="color: #f59e0b;"><?= $pending_bookings ?></div>
                <div class="stat-sublabel">Menunggu proses</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-number" style="color: #7c3aed;">Rp <?= number_format($total_revenue / 1000, 0) ?>K</div>
                <div class="stat-sublabel">Dari booking selesai</div>
            </div>
        </div>
    </div>

    <!-- Service Statistics -->
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3>Statistik Layanan</h3>
                <p style="margin: 0.25rem 0 0; color: #6b7280; font-size: 0.9rem;">Performa setiap layanan</p>
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            <?php if (!empty($service_stats)): ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Layanan</th>
                            <th>Jumlah Order</th>
                            <th>Total Pendapatan</th>
                            <th>Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($service_stats as $stat): ?>
                            <tr>
                                <td>
                                    <strong><?= ucfirst(str_replace('-', ' ', $stat['service'])) ?></strong>
                                </td>
                                <td><?= $stat['count'] ?> order</td>
                                <td><strong>Rp <?= number_format($stat['revenue'], 0, ',', '.') ?></strong></td>
                                <td>Rp <?= number_format($stat['revenue'] / $stat['count'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="padding: 2rem; text-align: center; color: #6b7280;">
                    <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                    <p>Belum ada data untuk periode ini</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
<style>
.form-control {
    padding: 0.625rem 1rem;
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
    padding: 0.625rem 1.5rem;
    border: none;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #7c3aed;
    color: white;
}

.btn-primary:hover {
    background: #6d28d9;
}
</style>
<?= $this->endSection() ?>
