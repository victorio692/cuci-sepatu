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
                    <h1>Detail Pesanan #<?= htmlspecialchars($booking->id) ?></h1>
                    <p class="subtitle">Informasi lengkap pesanan cuci sepatu Anda</p>
                </div>
                <a href="/customer/my-bookings" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Booking Information -->
        <div class="booking-detail">
            <!-- Service Information -->
            <div class="info-card">
                <div class="card-header">
                    <h2>Informasi Layanan</h2>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Jenis Layanan</span>
                            <span class="info-value"><?= htmlspecialchars(ucfirst($booking->service)) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Jenis Sepatu</span>
                            <span class="info-value"><?= htmlspecialchars(ucfirst($booking->shoe_type)) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Kondisi Sepatu</span>
                            <span class="info-value"><?= htmlspecialchars(ucfirst($booking->shoe_condition)) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Jumlah Pasang</span>
                            <span class="info-value"><?= htmlspecialchars($booking->quantity) ?> pasang</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Information -->
            <div class="info-card">
                <div class="card-header">
                    <h2>Informasi Pengiriman</h2>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Tanggal Pengiriman</span>
                            <span class="info-value"><?= date('d F Y', strtotime($booking->delivery_date)) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Opsi Pengiriman</span>
                            <span class="info-value"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $booking->delivery_option))) ?></span>
                        </div>
                    </div>
                    <div class="info-item" style="grid-column: 1 / -1;">
                        <span class="info-label">Alamat Pengiriman</span>
                        <span class="info-value"><?= htmlspecialchars($booking->delivery_address) ?></span>
                    </div>
                </div>
            </div>

            <!-- Status Information -->
            <div class="info-card">
                <div class="card-header">
                    <h2>Status Pesanan</h2>
                </div>
                <div class="card-body">
                    <div class="status-container">
                        <?php 
                            $status = htmlspecialchars($booking->status);
                            $status_class = 'status-' . $status;
                            $status_text = htmlspecialchars(ucfirst(str_replace('_', ' ', $status)));
                        ?>
                        <span class="status-badge <?= $status_class ?>"><?= $status_text ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Dibuat Pada</span>
                        <span class="info-value"><?= date('d F Y H:i', strtotime($booking->created_at)) ?></span>
                    </div>
                    <?php if ($booking->updated_at): ?>
                        <div class="info-item">
                            <span class="info-label">Terakhir Diperbarui</span>
                            <span class="info-value"><?= date('d F Y H:i', strtotime($booking->updated_at)) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Pricing Details -->
            <div class="info-card">
                <div class="card-header">
                    <h2>Rincian Harga</h2>
                </div>
                <div class="card-body">
                    <div class="pricing-breakdown">
                        <div class="pricing-row">
                            <span class="pricing-label">Subtotal</span>
                            <span class="pricing-value">Rp <?= number_format($booking->subtotal, 0, ',', '.') ?></span>
                        </div>
                        <div class="pricing-row">
                            <span class="pricing-label">Biaya Pengiriman</span>
                            <span class="pricing-value">Rp <?= number_format($booking->delivery_fee, 0, ',', '.') ?></span>
                        </div>
                        <div class="pricing-row total">
                            <span class="pricing-label"><strong>Total</strong></span>
                            <span class="pricing-value"><strong>Rp <?= number_format($booking->total, 0, ',', '.') ?></strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <?php if (!empty($booking->notes)): ?>
                <div class="info-card">
                    <div class="card-header">
                        <h2>Catatan</h2>
                    </div>
                    <div class="card-body">
                        <p class="notes-content"><?= nl2br(htmlspecialchars($booking->notes)) ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Actions -->
            <div class="action-buttons">
                <a href="/customer/my-bookings" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Kembali ke Pesanan
                </a>
                <?php if ($booking->status === 'pending'): ?>
                    <a href="/payment/select/<?= $booking->id ?>" class="btn btn-success">
                        <i class="fas fa-credit-card"></i> Lanjut Pembayaran
                    </a>
                <?php elseif ($booking->status === 'approved'): ?>
                    <span class="btn btn-disabled">
                        <i class="fas fa-check-circle"></i> Pembayaran Diterima
                    </span>
                <?php endif; ?>
                <a href="/make-booking" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Pesan Lagi
                </a>
            </div>
        </div>
    </main>
</div>

<?= $this->endSection() ?>
