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
                    <a href="/customer/dashboard" class="sidebar-link" title="Dashboard">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/customer/my-bookings" class="sidebar-link active" title="Pesanan Saya">
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
                    <h1>Pesanan Saya</h1>
                    <p class="subtitle">Daftar lengkap semua pesanan cuci sepatu Anda (Total: <?= $total_bookings ?>)</p>
                </div>
                <a href="/make-booking" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus"></i> Pesan Baru
                </a>
            </div>
        </div>

        <!-- Bookings List -->
        <section class="bookings-section">
            <?php if (empty($bookings)): ?>
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
                                <th>ID</th>
                                <th>Layanan</th>
                                <th>Jenis Sepatu</th>
                                <th>Tanggal Pengiriman</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td class="id-cell"><strong>#<?= $booking['id'] ?></strong></td>
                                    <td><?= htmlspecialchars(ucfirst($booking['service'])) ?></td>
                                    <td><?= htmlspecialchars(ucfirst($booking['shoe_type'])) ?></td>
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

                <!-- Pagination -->
                <?php if ($pager): ?>
                    <div class="pagination-container">
                        <?= $pager->links() ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </section>
    </main>
</div>

<?= $this->endSection() ?>
