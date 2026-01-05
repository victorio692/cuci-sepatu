<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <!-- Admin Header -->
    <div class="admin-header">
        <h1>Dashboard Admin</h1>
        <p>Kelola bisnis SYH Cleaning Anda</p>
    </div>

    <!-- Statistics Cards -->
    <div class="admin-stats">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #7c3aed, #ec4899);">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Users</div>
                <div class="stat-number"><?= $total_users ?? 0 ?></div>
                <div class="stat-change">+<?= $users_this_month ?? 0 ?> bulan ini</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #3b82f6);">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-number"><?= $total_bookings ?? 0 ?></div>
                <div class="stat-change">+<?= $bookings_this_month ?? 0 ?> bulan ini</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #ef4444);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Pesanan Selesai</div>
                <div class="stat-number"><?= $completed_bookings ?? 0 ?></div>
                <div class="stat-change"><?= round(($completed_bookings ?? 0) / max($total_bookings ?? 1, 1) * 100) ?>% completion</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #06b6d4, #8b5cf6);">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-number">Rp <?= number_format($total_revenue ?? 0, 0, ',', '.') ?></div>
                <div class="stat-change">Bulan ini</div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="admin-grid">
        <!-- Recent Bookings -->
        <div class="admin-card" style="grid-column: 1 / -1;">
            <div class="card-header">
                <h3>Pesanan Terbaru</h3>
                <a href="/admin/bookings" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_bookings)): ?>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Layanan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_bookings as $booking): ?>
                                <tr>
                                    <td><strong>#<?= $booking['id'] ?></strong></td>
                                    <td><?= $booking['customer_name'] ?></td>
                                    <td><?= ucfirst(str_replace('-', ' ', $booking['service'])) ?></td>
                                    <td>Rp <?= number_format($booking['total'], 0, ',', '.') ?></td>
                                    <td>
                                        <span class="badge badge-<?= getStatusBadgeClass($booking['status']) ?>">
                                            <?= getStatusLabel($booking['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('d M Y', strtotime($booking['created_at'])) ?></td>
                                    <td>
                                        <a href="/admin/bookings/<?= $booking['id'] ?>" class="btn-sm btn-link">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="text-align: center; color: #6b7280;">Tidak ada pesanan</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pending Bookings -->
        <div class="admin-card">
            <div class="card-header">
                <h3>Pesanan Pending</h3>
                <span class="badge" style="background: #fef3c7; color: #92400e;"><?= $pending_count ?? 0 ?></span>
            </div>
            <div class="card-body">
                <?php if (!empty($pending_bookings)): ?>
                    <ul style="list-style: none; padding: 0;">
                        <?php foreach ($pending_bookings as $booking): ?>
                            <li style="padding: 1rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <strong><?= $booking['customer_name'] ?></strong>
                                    <p style="margin: 0.25rem 0 0 0; font-size: 0.9rem; color: #6b7280;">
                                        <?= ucfirst(str_replace('-', ' ', $booking['service'])) ?>
                                    </p>
                                </div>
                                <a href="/admin/bookings/<?= $booking['id'] ?>" class="btn btn-sm btn-primary">
                                    Proses
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p style="text-align: center; color: #6b7280;">Tidak ada pesanan pending</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Service Performance -->
        <div class="admin-card">
            <div class="card-header">
                <h3>Layanan Populer</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($service_stats)): ?>
                    <ul style="list-style: none; padding: 0;">
                        <?php foreach ($service_stats as $stat): ?>
                            <li style="margin-bottom: 1rem;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span><?= ucfirst(str_replace('-', ' ', $stat['service'])) ?></span>
                                    <strong><?= $stat['count'] ?> order</strong>
                                </div>
                                <div style="background: #e5e7eb; height: 8px; border-radius: 4px; overflow: hidden;">
                                    <div style="background: linear-gradient(90deg, #7c3aed, #ec4899); height: 100%; width: <?= min($stat['count'] * 10, 100) ?>%;"></div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p style="text-align: center; color: #6b7280;">Tidak ada data</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="admin-card">
            <div class="card-header">
                <h3>User Terbaru</h3>
                <a href="/admin/users" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_users)): ?>
                    <ul style="list-style: none; padding: 0;">
                        <?php foreach ($recent_users as $user): ?>
                            <li style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                                <strong><?= $user['full_name'] ?></strong>
                                <p style="margin: 0.25rem 0 0 0; font-size: 0.9rem; color: #6b7280;">
                                    <?= $user['email'] ?>
                                </p>
                                <p style="margin: 0.25rem 0 0 0; font-size: 0.85rem; color: #9ca3af;">
                                    <?= date('d M Y', strtotime($user['created_at'])) ?>
                                </p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p style="text-align: center; color: #6b7280;">Tidak ada user</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
