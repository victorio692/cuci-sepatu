<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="dashboard-container">
    <!-- Sidebar -->
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
                    <h1>Konfirmasi Pembayaran</h1>
                    <p class="subtitle">Pesanan #<?= htmlspecialchars($booking->id) ?></p>
                </div>
                <a href="/customer/my-bookings" class="btn btn-outline">
                    <i class="fas fa-list"></i> Kembali ke Pesanan
                </a>
            </div>
        </div>

        <!-- Payment Confirmation -->
        <section class="payment-confirmation">
            <!-- Method Info Card -->
            <div class="info-card">
                <div class="card-header">
                    <h2>Informasi Pembayaran</h2>
                </div>
                <div class="card-body">
                    <div class="confirmation-grid">
                        <div class="confirmation-item">
                            <span class="info-label">Metode Pembayaran</span>
                            <span class="info-value">
                                <?php
                                    $method_names = [
                                        'bank_transfer' => 'Transfer Bank',
                                        'e_wallet' => 'E-Wallet',
                                        'cash' => 'Bayar di Tempat'
                                    ];
                                    echo htmlspecialchars($method_names[$booking->payment_method] ?? $booking->payment_method);
                                ?>
                            </span>
                        </div>
                        <div class="confirmation-item">
                            <span class="info-label">Kode Pembayaran</span>
                            <span class="info-value payment-code">
                                <?= htmlspecialchars($payment->payment_code) ?>
                            </span>
                        </div>
                        <div class="confirmation-item">
                            <span class="info-label">Jumlah</span>
                            <span class="info-value">Rp <?= number_format($payment->amount, 0, ',', '.') ?></span>
                        </div>
                        <div class="confirmation-item">
                            <span class="info-label">Status</span>
                            <span class="info-value">
                                <span class="status-badge status-pending">
                                    <i class="fas fa-hourglass-start"></i> Menunggu Pembayaran
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bank Transfer Instructions -->
            <?php if ($booking->payment_method === 'bank_transfer'): ?>
                <div class="info-card">
                    <div class="card-header">
                        <h2>Instruksi Transfer Bank</h2>
                    </div>
                    <div class="card-body">
                        <div class="instruction-steps">
                            <div class="step">
                                <div class="step-number">1</div>
                                <div class="step-content">
                                    <h4>Buka Aplikasi Bank Anda</h4>
                                    <p>Buka aplikasi mobile banking atau internet banking</p>
                                </div>
                            </div>

                            <div class="step">
                                <div class="step-number">2</div>
                                <div class="step-content">
                                    <h4>Pilih Menu Transfer</h4>
                                    <p>Pilih Transfer ke Bank Lain atau Sesama Bank</p>
                                </div>
                            </div>

                            <div class="step">
                                <div class="step-number">3</div>
                                <div class="step-content">
                                    <h4>Masukkan Data Rekening Berikut</h4>
                                    <div class="bank-details">
                                        <div class="detail-row">
                                            <span>Bank</span>
                                            <strong><?= htmlspecialchars($bank_info['bank_name']) ?></strong>
                                        </div>
                                        <div class="detail-row">
                                            <span>Atas Nama</span>
                                            <strong><?= htmlspecialchars($bank_info['account_name']) ?></strong>
                                        </div>
                                        <div class="detail-row highlight">
                                            <span>Nomor Rekening</span>
                                            <strong class="copy-able"><?= htmlspecialchars($bank_info['account_number']) ?></strong>
                                        </div>
                                        <div class="detail-row">
                                            <span>Cabang</span>
                                            <strong><?= htmlspecialchars($bank_info['branch']) ?></strong>
                                        </div>
                                        <div class="detail-row highlight">
                                            <span>Jumlah</span>
                                            <strong>Rp <?= number_format($payment->amount, 0, ',', '.') ?></strong>
                                        </div>
                                        <div class="detail-row">
                                            <span>Referensi/Catatan</span>
                                            <strong class="copy-able"><?= htmlspecialchars($payment->payment_code) ?></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="step">
                                <div class="step-number">4</div>
                                <div class="step-content">
                                    <h4>Konfirmasi Pembayaran</h4>
                                    <p>Setelah transfer, klik tombol "Konfirmasi Pembayaran" di bawah</p>
                                </div>
                            </div>
                        </div>

                        <!-- Timer -->
                        <div class="payment-timer">
                            <i class="fas fa-clock"></i>
                            Abaikan jika sudah transfer, sistem akan otomatis memverifikasi dalam 5 menit
                        </div>
                    </div>
                </div>

                <!-- Verify Button -->
                <form action="/payment/verify/<?= $booking->id ?>" method="POST" class="verify-form">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-check"></i> Konfirmasi Pembayaran Sudah Ditransfer
                    </button>
                </form>

            <?php elseif ($booking->payment_method === 'e_wallet'): ?>
                <!-- E-Wallet Instructions -->
                <div class="info-card">
                    <div class="card-header">
                        <h2>Instruksi Pembayaran E-Wallet</h2>
                    </div>
                    <div class="card-body">
                        <div class="instruction-steps">
                            <div class="step">
                                <div class="step-number">1</div>
                                <div class="step-content">
                                    <h4>Hubungi Tim Kami</h4>
                                    <p>
                                        WhatsApp: <strong>+62 812-3456-7890</strong><br>
                                        Untuk mendapatkan nomor e-wallet penerima
                                    </p>
                                </div>
                            </div>

                            <div class="step">
                                <div class="step-number">2</div>
                                <div class="step-content">
                                    <h4>Lakukan Transfer</h4>
                                    <p>Transfer sejumlah <strong>Rp <?= number_format($payment->amount, 0, ',', '.') ?></strong> via OVO, DANA, atau GCash</p>
                                    <p class="text-muted">Sertakan referensi: <?= htmlspecialchars($payment->payment_code) ?></p>
                                </div>
                            </div>

                            <div class="step">
                                <div class="step-number">3</div>
                                <div class="step-content">
                                    <h4>Konfirmasi</h4>
                                    <p>Tim kami akan mengkonfirmasi pembayaran Anda dalam 1-2 jam</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="contact-card">
                    <a href="https://wa.me/6281234567890?text=Saya%20ingin%20membayar%20pesanan%20<?= $booking->id ?>" 
                       target="_blank" class="btn btn-primary btn-lg">
                        <i class="fab fa-whatsapp"></i> Chat WhatsApp untuk Pembayaran
                    </a>
                </div>

            <?php elseif ($booking->payment_method === 'cash'): ?>
                <!-- Cash Payment Instructions -->
                <div class="info-card">
                    <div class="card-header">
                        <h2>Pembayaran Tunai</h2>
                    </div>
                    <div class="card-body">
                        <div class="instruction-steps">
                            <div class="step">
                                <div class="step-number">✓</div>
                                <div class="step-content">
                                    <h4>Pembayaran akan dilakukan saat pengambilan barang</h4>
                                    <p>
                                        Anda bisa membayar tunai sebesar <strong>Rp <?= number_format($payment->amount, 0, ',', '.') ?></strong> 
                                        saat mengambil pesanan Anda
                                    </p>
                                    <p class="text-muted">Pastikan membawa uang pas atau pas untuk memudahkan transaksi</p>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info" style="margin-top: 1.5rem;">
                            <i class="fas fa-info-circle"></i>
                            <span>Tim kami akan menghubungi Anda untuk mengkonfirmasi jadwal pengambilan pesanan</span>
                        </div>
                    </div>
                </div>

                <!-- Confirm Button -->
                <form action="/payment/verify/<?= $booking->id ?>" method="POST" class="verify-form">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-check"></i> Saya Siap Membayar Tunai
                    </button>
                </form>
            <?php endif; ?>

            <!-- Booking Summary -->
            <div class="info-card">
                <div class="card-header">
                    <h2>Ringkasan Pesanan</h2>
                </div>
                <div class="card-body">
                    <div class="summary-grid">
                        <div class="summary-item">
                            <span class="label">Layanan</span>
                            <span class="value"><?= htmlspecialchars(ucfirst($booking->service)) ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="label">Jenis Sepatu</span>
                            <span class="value"><?= htmlspecialchars(ucfirst($booking->shoe_type)) ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="label">Jumlah Pasang</span>
                            <span class="value"><?= htmlspecialchars($booking->quantity) ?> pasang</span>
                        </div>
                        <div class="summary-item">
                            <span class="label">Tanggal Pengiriman</span>
                            <span class="value"><?= date('d F Y', strtotime($booking->delivery_date)) ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="label">Subtotal</span>
                            <span class="value">Rp <?= number_format($booking->subtotal, 0, ',', '.') ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="label">Biaya Pengiriman</span>
                            <span class="value">Rp <?= number_format($booking->delivery_fee, 0, ',', '.') ?></span>
                        </div>
                        <div class="summary-item total">
                            <span class="label">Total</span>
                            <span class="value">Rp <?= number_format($booking->total, 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="action-buttons">
                <a href="/customer/my-bookings" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Kembali ke Pesanan
                </a>
                <a href="/customer/dashboard" class="btn btn-primary">
                    <i class="fas fa-home"></i> Ke Dashboard
                </a>
            </div>
        </section>
    </main>
</div>

<?= $this->endSection() ?>
