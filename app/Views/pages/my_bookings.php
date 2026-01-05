<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="/dashboard">
                    <span class="sidebar-icon"><i class="fas fa-home"></i></span>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/my-bookings" class="active">
                    <span class="sidebar-icon"><i class="fas fa-calendar-check"></i></span>
                    Pesanan Saya
                </a>
            </li>
            <li>
                <a href="/profile">
                    <span class="sidebar-icon"><i class="fas fa-user-circle"></i></span>
                    Profil
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
            <h1><i class="fas fa-calendar-check"></i> Pesanan Saya</h1>
        </div>

        <?php if (!empty($bookings)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>No Pesanan</th>
                        <th>Layanan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><strong>#<?= $booking['id'] ?></strong></td>
                            <td><?= $booking['service_name'] ?></td>
                            <td><?= formatDate($booking['created_at']) ?></td>
                            <td>
                                <span class="badge badge-<?= getStatusBadgeClass($booking['status']) ?>">
                                    <?= getStatusLabel($booking['status']) ?>
                                </span>
                            </td>
                            <td>Rp <?= number_format($booking['total'], 0, ',', '.') ?></td>
                            <td>
                                <a href="/booking-detail/<?= $booking['id'] ?>" class="btn btn-sm">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="card">
                <div class="card-body text-center p-5">
                    <i class="fas fa-inbox" style="font-size: 4rem; color: #d1d5db;"></i>
                    <h3 style="color: #6b7280; margin-top: 1rem;">Belum Ada Pesanan</h3>
                    <p style="color: #9ca3af; margin-bottom: 1.5rem;">Anda belum memiliki pesanan apapun.</p>
                    <a href="/make-booking" class="btn btn-primary">Pesan Sekarang</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
