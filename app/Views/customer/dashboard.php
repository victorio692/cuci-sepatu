<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="dashboard-container">
    <!-- Sidebar Navigation -->
    <aside class="dashboard-sidebar">
        <div class="sidebar-header">
            <h3>Menu</h3>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="/customer/dashboard" class="sidebar-link active" title="Dashboard">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/customer/my-bookings" class="sidebar-link" title="Pesanan Saya">
                        <i class="fas fa-list"></i>
                        <span>Pesanan Saya</span>
                    </a>
                </li>
                <li>
                    <a href="/make-booking" class="sidebar-link" title="Pesan Baru">
                        <i class="fas fa-plus-circle"></i>
                        <span>Pesan Baru</span>
                    </a>
                </li>
                <li>
                    <a href="/customer/profile" class="sidebar-link" title="Profil">
                        <i class="fas fa-user"></i>
                        <span>Profil Saya</span>
                    </a>
                </li>
                <li>
                    <a href="/logout" class="sidebar-link" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main">
        <!-- Header -->
        <div class="dashboard-header">
            <div class="header-content">
                <div>
                    <h1>Selamat Datang, <?= htmlspecialchars($user->full_name) ?>! 👋</h1>
                    <p class="subtitle">Kelola pesanan dan profil cuci sepatu Anda</p>
                </div>
                <a href="/make-booking" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus"></i> Pesan Sekarang
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <section class="stats-section">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Pesanan</div>
                    <div class="stat-value"><?= $total_bookings ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon active">
                    <i class="fas fa-hourglass-start"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Pesanan Aktif</div>
                    <div class="stat-value"><?= $active_bookings ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon completed">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Selesai</div>
                    <div class="stat-value"><?= $completed_bookings ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon spent">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Total Pengeluaran</div>
                    <div class="stat-value">Rp <?= number_format($total_spent, 0, ',', '.') ?></div>
                </div>
            </div>
        </section>

        <!-- Recent Bookings -->
        <section class="recent-bookings-section">
            <div class="section-header">
                <h2>Pesanan Terbaru</h2>
                <a href="/customer/my-bookings" class="link-view-all">Lihat Semua →</a>
            </div>

            <?php if (empty($recent_bookings)): ?>
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Belum Ada Pesanan</h3>
                    <p>Anda belum membuat pesanan cuci sepatu. Mulai sekarang!</p>
                    <a href="/make-booking" class="btn btn-primary">Buat Pesanan Pertama Anda</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Layanan</th>
                                <th>Tanggal Pengiriman</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_bookings as $booking): ?>
                                <tr>
                                    <td class="id-cell"><strong>#<?= $booking['id'] ?></strong></td>
                                    <td><?= htmlspecialchars(ucfirst($booking['service'])) ?></td>
                                    <td><?= date('d M Y', strtotime($booking['delivery_date'])) ?></td>
                                    <td><strong>Rp <?= number_format($booking['total'], 0, ',', '.') ?></strong></td>
                                    <td>
                                        <?php 
                                            $status = $booking['status'];
                                            $status_class = 'status-' . $status;
                                            $status_text = htmlspecialchars(ucfirst(str_replace('_', ' ', $status)));
                                        ?>
                                        <span class="status-badge <?= $status_class ?>"><?= $status_text ?></span>
                                    </td>
                                    <td>
                                        <a href="/customer/booking/<?= $booking['id'] ?>" class="btn btn-sm btn-outline">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </main>
</div>

<?= $this->endSection() ?>
