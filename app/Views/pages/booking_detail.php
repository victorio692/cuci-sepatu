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
                <a href="/make-booking">
                    <span class="sidebar-icon"><i class="fas fa-plus-circle"></i></span>
                    Pesan Baru
                </a>
            </li>
            <li>
                <a href="/profile">
                    <span class="sidebar-icon"><i class="fas fa-user-circle"></i></span>
                    Profil
                </a>
            </li>
            <li>
                <a href="#" onclick="confirmLogout(event)" style="color: #ef4444;">
                    <span class="sidebar-icon"><i class="fas fa-sign-out-alt"></i></span>
                    Logout
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header" style="margin-bottom: 2rem;">
            <div>
                <a href="/my-bookings" style="color: #7c3aed; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Pesanan Saya
                </a>
                <h1><i class="fas fa-receipt"></i> Detail Pesanan #<?= $booking['id'] ?></h1>
                <p style="margin: 0.5rem 0 0; color: #6b7280;">
                    Dibuat pada <?= date('d M Y H:i', strtotime($booking['created_at'])) ?>
                </p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
            <!-- Main Details -->
            <div>
                <!-- Status Card -->
                <div class="card" style="margin-bottom: 1.5rem;">
                    <div class="card-body">
                        <h3 style="margin-bottom: 1rem;">Status Pesanan</h3>
                        <?php
                        // Status label
                        $statusLabel = match($booking['status']) {
                            'pending' => 'Menunggu Persetujuan',
                            'disetujui' => 'Disetujui Admin',
                            'proses' => 'Sedang Diproses',
                            'selesai' => 'Selesai',
                            'ditolak' => 'Ditolak Admin',
                            default => $booking['status']
                        };
                        
                        // Status color
                        $statusColor = match($booking['status']) {
                            'pending' => '#f59e0b',
                            'disetujui' => '#3b82f6',
                            'proses' => '#8b5cf6',
                            'selesai' => '#10b981',
                            'ditolak' => '#ef4444',
                            default => '#6b7280'
                        };
                        ?>
                        <div style="display: inline-block; background: <?= $statusColor ?>; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; font-size: 1.1rem;">
                            <?= $statusLabel ?>
                        </div>
                        
                        <!-- Alasan Penolakan (jika ditolak) -->
                        <?php if ($booking['status'] === 'ditolak' && !empty($booking['alasan_penolakan'])): ?>
                            <div style="margin-top: 1.5rem; padding: 1.5rem; background: #fee2e2; border-left: 4px solid #ef4444; border-radius: 0.5rem;">
                                <div style="display: flex; align-items: start; gap: 1rem;">
                                    <i class="fas fa-exclamation-triangle" style="color: #ef4444; font-size: 1.5rem; margin-top: 0.25rem;"></i>
                                    <div>
                                        <strong style="color: #991b1b; font-size: 1.1rem; display: block; margin-bottom: 0.5rem;">Alasan Penolakan:</strong>
                                        <p style="margin: 0; color: #7f1d1d; line-height: 1.6;"><?= nl2br(esc($booking['alasan_penolakan'])) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Layanan Info -->
                <div class="card" style="margin-bottom: 1.5rem;">
                    <div class="card-body">
                        <h3 style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
                            <i class="fas fa-shopping-bag" style="color: #7c3aed;"></i> Detail Layanan
                        </h3>
                        
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Layanan:</label>
                                <span>
                                    <?php
                                    $serviceName = match($booking['layanan']) {
                                        'fast-cleaning' => 'Fast Cleaning',
                                        'deep-cleaning' => 'Deep Cleaning',
                                        'white-shoes' => 'White Shoes',
                                        'suede-treatment' => 'Suede Treatment',
                                        'unyellowing' => 'Unyellowing',
                                        default => $booking['layanan']
                                    };
                                    echo $serviceName;
                                    ?>
                                </span>
                            </div>
                            
                            <div class="info-item">
                                <label>Tipe Sepatu:</label>
                                <span><?= ucfirst(str_replace('_', ' ', $booking['tipe_sepatu'])) ?></span>
                            </div>
                            
                            <div class="info-item">
                                <label>Kondisi Sepatu:</label>
                                <span><?= ucfirst(str_replace('_', ' ', $booking['kondisi_sepatu'])) ?></span>
                            </div>
                            
                            <div class="info-item">
                                <label>Jumlah:</label>
                                <span><?= $booking['jumlah'] ?> Pasang</span>
                            </div>
                            
                            <div class="info-item">
                                <label>Tanggal Pengambilan:</label>
                                <span><?= date('d M Y', strtotime($booking['tanggal_kirim'])) ?></span>
                            </div>
                            
                            <div class="info-item">
                                <label>Jam Booking:</label>
                                <span><?= $booking['jam_booking'] ?></span>
                            </div>
                        </div>
                        
                        <?php if (!empty($booking['catatan'])): ?>
                            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
                                <label style="font-weight: 600; color: #374151; display: block; margin-bottom: 0.5rem;">Catatan:</label>
                                <p style="color: #6b7280; margin: 0;"><?= nl2br(esc($booking['catatan'])) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Foto Sepatu -->
                <?php if (!empty($booking['foto_sepatu'])): ?>
                    <div class="card" style="margin-bottom: 1.5rem;">
                        <div class="card-body">
                            <h3 style="margin-bottom: 1rem;">
                                <i class="fas fa-camera" style="color: #7c3aed;"></i> Foto Sepatu
                            </h3>
                            <div style="text-align: center;">
                                <img 
                                    src="<?= base_url('uploads/' . $booking['foto_sepatu']) ?>" 
                                    alt="Foto Sepatu" 
                                    style="max-width: 100%; height: auto; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);"
                                    onclick="openImageModal(this.src)"
                                >
                                <p style="margin: 1rem 0 0; color: #6b7280; font-size: 0.9rem;">
                                    <i class="fas fa-info-circle"></i> Klik gambar untuk memperbesar
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Delivery Info -->
                <div class="card">
                    <div class="card-body">
                        <h3 style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
                            <i class="fas fa-truck" style="color: #7c3aed;"></i> Informasi Pengiriman
                        </h3>
                        
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Opsi Pengiriman:</label>
                                <span>
                                    <?php if ($booking['opsi_kirim'] === 'pickup'): ?>
                                        <i class="fas fa-store"></i> Ambil di Tempat
                                    <?php else: ?>
                                        <i class="fas fa-home"></i> Diantar ke Rumah
                                    <?php endif; ?>
                                </span>
                            </div>
                            
                            <?php if ($booking['opsi_kirim'] === 'home'): ?>
                                <div class="info-item" style="grid-column: 1 / -1;">
                                    <label>Alamat Pengiriman:</label>
                                    <span><?= nl2br(esc($booking['alamat_kirim'])) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Summary -->
            <div>
                <!-- Price Summary -->
                <div class="card" style="margin-bottom: 1.5rem;">
                    <div class="card-body">
                        <h3 style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
                            <i class="fas fa-receipt" style="color: #7c3aed;"></i> Ringkasan Harga
                        </h3>
                        
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span>Rp <?= number_format($booking['subtotal'], 0, ',', '.') ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Biaya Pengiriman:</span>
                            <span>Rp <?= number_format($booking['biaya_kirim'], 0, ',', '.') ?></span>
                        </div>
                        <div class="summary-row" style="border-top: 2px solid #e5e7eb; padding-top: 1rem; margin-top: 1rem; font-weight: 600; font-size: 1.25rem; color: #7c3aed;">
                            <span>Total:</span>
                            <span>Rp <?= number_format($booking['total'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <?php if ($booking['status'] === 'pending'): ?>
                    <div class="card">
                        <div class="card-body">
                            <h3 style="margin-bottom: 1rem;">Aksi</h3>
                            <button 
                                onclick="cancelBooking(<?= $booking['id'] ?>)" 
                                class="btn btn-danger"
                                style="width: 100%; background: #ef4444; border-color: #ef4444;"
                            >
                                <i class="fas fa-times-circle"></i> Batalkan Pesanan
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.9);" onclick="closeImageModal()">
    <span style="position: absolute; top: 20px; right: 40px; color: white; font-size: 40px; font-weight: bold; cursor: pointer;">&times;</span>
    <img id="modalImage" style="margin: auto; display: block; max-width: 90%; max-height: 90%; margin-top: 50px;">
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
<style>
.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-item label {
    font-weight: 600;
    color: #6b7280;
    font-size: 0.9rem;
}

.info-item span {
    color: #1f2937;
    font-size: 1rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
}

.summary-row:not(:last-child) {
    border-bottom: 1px solid #f3f4f6;
}

@media (max-width: 768px) {
    .dashboard {
        grid-template-columns: 1fr;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
function cancelBooking(id) {
    if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
        window.location.href = '/booking/cancel/' + id;
    }
}

function openImageModal(src) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    modal.style.display = 'block';
    modalImg.src = src;
}

function closeImageModal() {
    document.getElementById('imageModal').style.display = 'none';
}

// Close modal when ESC key is pressed
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});
</script>
<?= $this->endSection() ?>
