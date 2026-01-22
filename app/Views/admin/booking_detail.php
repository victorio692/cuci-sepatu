<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <div style="margin-bottom: 2rem;">
        <a href="/admin/bookings" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Pesanan
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Main Details -->
        <div>
            <!-- Order Header -->
            <div class="admin-card" style="margin-bottom: 1.5rem;">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: start; gap: 1rem;">
                        <div>
                            <h1 style="margin: 0 0 0.5rem 0; color: #1f2937;">
                                Pesanan #<?= $booking['id'] ?>
                            </h1>
                            <p style="margin: 0; color: #6b7280;">
                                <?= date('d M Y H:i', strtotime($booking['created_at'])) ?>
                            </p>
                            <?php
                            $statusLabels = [
                                'pending' => 'Menunggu Persetujuan',
                                'disetujui' => 'Disetujui',
                                'proses' => 'Sedang Diproses',
                                'selesai' => 'Selesai',
                                'ditolak' => 'Ditolak'
                            ];
                            $statusColors = [
                                'pending' => '#f59e0b',
                                'disetujui' => '#3b82f6',
                                'proses' => '#8b5cf6',
                                'selesai' => '#10b981',
                                'ditolak' => '#ef4444'
                            ];
                            ?>
                            <div style="margin-top: 1rem;">
                                <span style="background: <?= $statusColors[$booking['status']] ?? '#6b7280' ?>; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; display: inline-block;">
                                    <?= $statusLabels[$booking['status']] ?? ucfirst($booking['status']) ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div style="display: flex; gap: 0.5rem;">
                            <?php if ($booking['status'] === 'pending'): ?>
                                <button onclick="approveBooking()" class="btn" style="background: #10b981; color: white; padding: 0.75rem 1.5rem;">
                                    <i class="fas fa-check"></i> Setujui
                                </button>
                                <button onclick="showRejectModal()" class="btn" style="background: #ef4444; color: white; padding: 0.75rem 1.5rem;">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            <?php elseif ($booking['status'] === 'disetujui'): ?>
                                <button onclick="changeStatus('proses')" class="btn" style="background: #8b5cf6; color: white; padding: 0.75rem 1.5rem;">
                                    <i class="fas fa-cog"></i> Mulai Proses
                                </button>
                            <?php elseif ($booking['status'] === 'proses'): ?>
                                <button onclick="changeStatus('selesai')" class="btn" style="background: #10b981; color: white; padding: 0.75rem 1.5rem;">
                                    <i class="fas fa-check-circle"></i> Tandai Selesai
                                </button>
                            <?php elseif ($booking['status'] === 'selesai'): ?>
                                <button onclick="sendWhatsApp()" class="btn" style="background: #25D366; color: white; padding: 0.75rem 1.5rem;">
                                    <i class="fab fa-whatsapp"></i> Kabari via WhatsApp
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Alasan Penolakan (jika ditolak) -->
                    <?php if ($booking['status'] === 'ditolak' && !empty($booking['alasan_penolakan'])): ?>
                        <div style="margin-top: 1.5rem; padding: 1rem; background: #fee2e2; border-left: 4px solid #ef4444; border-radius: 0.375rem;">
                            <div style="display: flex; align-items: start; gap: 0.75rem;">
                                <i class="fas fa-exclamation-circle" style="color: #ef4444; margin-top: 0.25rem;"></i>
                                <div>
                                    <strong style="color: #991b1b;">Alasan Penolakan:</strong>
                                    <p style="margin: 0.5rem 0 0; color: #7f1d1d;"><?= nl2br(esc($booking['alasan_penolakan'])) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="admin-card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 style="margin: 0; color: #1f2937;">
                        <i class="fas fa-user"></i> Informasi Pelanggan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <label>Nama:</label>
                        <span><?= $booking['full_name'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Email:</label>
                        <span><?= $booking['email'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Telepon:</label>
                        <span><?= $booking['phone'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Alamat:</label>
                        <span><?= $booking['address'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Kota:</label>
                        <span><?= $booking['city'] ?>, <?= $booking['province'] ?> <?= $booking['zip_code'] ?></span>
                    </div>
                </div>
            </div>

            <!-- Service & Items -->
            <div class="admin-card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 style="margin: 0; color: #1f2937;">
                        <i class="fas fa-shopping-bag"></i> Detail Pesanan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <label>Layanan:</label>
                        <span><?= ucfirst(str_replace('-', ' ', $booking['service'])) ?></span>
                    </div>
                    <div class="info-row">
                        <label>Tipe Sepatu:</label>
                        <span><?= ucfirst(str_replace('_', ' ', $booking['shoe_type'])) ?></span>
                    </div>
                    <div class="info-row">
                        <label>Kondisi Sepatu:</label>
                        <span><?= ucfirst(str_replace('_', ' ', $booking['shoe_condition'])) ?></span>
                    </div>
                    <div class="info-row">
                        <label>Jumlah:</label>
                        <span><?= $booking['quantity'] ?> pasang</span>
                    </div>
                </div>
            </div>

            <!-- Foto Sepatu -->
            <?php if (!empty($booking['foto_sepatu'])): ?>
                <div class="admin-card" style="margin-bottom: 1.5rem;">
                    <div class="card-header">
                        <h3 style="margin: 0; color: #1f2937;">
                            <i class="fas fa-camera"></i> Foto Kondisi Sepatu
                        </h3>
                    </div>
                    <div class="card-body">
                        <div style="text-align: center;">
                            <img 
                                src="<?= base_url('uploads/' . $booking['foto_sepatu']) ?>" 
                                alt="Foto Sepatu" 
                                style="max-width: 100%; height: auto; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); cursor: pointer;"
                                onclick="openPhotoModal(this.src)"
                            >
                            <p style="margin: 1rem 0 0; color: #6b7280; font-size: 0.9rem;">
                                <i class="fas fa-info-circle"></i> Klik gambar untuk memperbesar
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Delivery Info -->
            <div class="admin-card">
                <div class="card-header">
                    <h3 style="margin: 0; color: #1f2937;">
                        <i class="fas fa-truck"></i> Pengiriman
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <label>Tipe Pengiriman:</label>
                        <span><?= ucfirst(str_replace('-', ' ', $booking['delivery_option'])) ?></span>
                    </div>
                    <div class="info-row">
                        <label>Tanggal Pengiriman:</label>
                        <span><?= date('d M Y', strtotime($booking['delivery_date'])) ?></span>
                    </div>
                    <div class="info-row">
                        <label>Alamat Pengiriman:</label>
                        <span><?= $booking['delivery_address'] ?></span>
                    </div>
                    <?php if (!empty($booking['notes'])): ?>
                        <div class="info-row">
                            <label>Catatan:</label>
                            <span><?= $booking['notes'] ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar Summary -->
        <div>
            <!-- Price Summary -->
            <div class="admin-card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 style="margin: 0; color: #1f2937;">
                        <i class="fas fa-receipt"></i> Ringkasan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>Rp <?= number_format($booking['subtotal'], 0, ',', '.') ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Biaya Pengiriman:</span>
                        <span>Rp <?= number_format($booking['delivery_fee'], 0, ',', '.') ?></span>
                    </div>
                    <div class="summary-row" style="border-top: 1px solid #e5e7eb; padding-top: 1rem; margin-top: 1rem;">
                        <strong>Total:</strong>
                        <strong style="color: #3b82f6; font-size: 1.25rem;">
                            Rp <?= number_format($booking['total'], 0, ',', '.') ?>
                        </strong>
                    </div>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="admin-card">
                <div class="card-header">
                    <h3 style="margin: 0; color: #1f2937;">
                        <i class="fas fa-clock"></i> Timeline
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline-item">
                        <div class="timeline-status completed">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <strong>Dibuat</strong>
                            <p style="margin: 0.25rem 0 0; color: #6b7280; font-size: 0.9rem;">
                                <?= date('d M Y H:i', strtotime($booking['created_at'])) ?>
                            </p>
                        </div>
                    </div>

                    <?php
                    $statuses = ['pending' => 'Pending', 'approved' => 'Disetujui', 'in_progress' => 'Sedang Diproses', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];
                    $status_order = ['pending', 'approved', 'in_progress', 'completed'];
                    $current_status = $booking['status'];
                    ?>

                    <?php foreach ($status_order as $status): ?>
                        <?php if ($status !== 'pending'): ?>
                            <div class="timeline-item">
                                <div class="timeline-status <?= (array_search($current_status, $status_order) >= array_search($status, $status_order)) ? 'completed' : 'pending' ?>">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div>
                                    <strong><?= $statuses[$status] ?></strong>
                                    <p style="margin: 0.25rem 0 0; color: #6b7280; font-size: 0.9rem;">
                                        <?= (array_search($current_status, $status_order) >= array_search($status, $status_order)) ? 'Selesai' : 'Menunggu' ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Photo Modal -->
<div id="photoModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.9);" onclick="closePhotoModal()">
    <span style="position: absolute; top: 20px; right: 40px; color: white; font-size: 40px; font-weight: bold; cursor: pointer;">&times;</span>
    <img id="modalPhoto" style="margin: auto; display: block; max-width: 90%; max-height: 90%; margin-top: 50px;">
</div>

<!-- Reject Modal -->
<div id="rejectModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
    <div style="background: white; max-width: 500px; margin: 100px auto; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
        <h3 style="margin: 0 0 1rem 0; color: #1f2937;">
            <i class="fas fa-times-circle" style="color: #ef4444;"></i> Tolak Pesanan
        </h3>
        <p style="color: #6b7280; margin-bottom: 1.5rem;">Berikan alasan kenapa pesanan ini ditolak:</p>
        
        <textarea 
            id="rejectReason" 
            rows="4" 
            style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; font-family: inherit;"
            placeholder="Contoh: Stok bahan habis, jadwal penuh, dll..."
        ></textarea>
        
        <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
            <button onclick="confirmReject()" class="btn" style="flex: 1; background: #ef4444; color: white; padding: 0.75rem;">
                <i class="fas fa-times"></i> Tolak Pesanan
            </button>
            <button onclick="closeRejectModal()" class="btn" style="flex: 1; background: #6b7280; color: white; padding: 0.75rem;">
                <i class="fas fa-ban"></i> Batal
            </button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
<style>
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background-color: #e5e7eb;
    color: #374151;
    text-decoration: none;
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background-color: #d1d5db;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f3f4f6;
}

.info-row:last-child {
    border-bottom: none;
}

.info-row label {
    font-weight: 600;
    color: #6b7280;
}

.info-row span {
    color: #1f2937;
    text-align: right;
}

.status-select-detail {
    padding: 0.75rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
    background-color: white;
}

.status-select-detail:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    color: #374151;
}

.timeline-item {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    position: relative;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 12px;
    top: 40px;
    width: 2px;
    height: calc(100% + 0.5rem);
    background-color: #e5e7eb;
}

.timeline-status {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 0.75rem;
}

.timeline-status.completed {
    background-color: #d1fae5;
    color: #065f46;
}

.timeline-status.pending {
    background-color: #fee2e2;
    color: #991b1b;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
const bookingId = <?= $booking['id'] ?>;

function approveBooking() {
    if (!confirm('Apakah Anda yakin ingin menyetujui pesanan ini?')) return;
    
    changeStatus('disetujui');
}

function showRejectModal() {
    document.getElementById('rejectModal').style.display = 'block';
}

function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
    document.getElementById('rejectReason').value = '';
}

function confirmReject() {
    const reason = document.getElementById('rejectReason').value.trim();
    
    if (!reason) {
        alert('Alasan penolakan harus diisi!');
        return;
    }
    
    fetch('<?= base_url() ?>/admin/bookings/' + bookingId + '/status', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
            status: 'ditolak',
            alasan_penolakan: reason
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Pesanan berhasil ditolak');
            location.reload();
        } else {
            alert(data.message || 'Gagal menolak pesanan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

function changeStatus(newStatus) {
    fetch('<?= base_url() ?>/admin/bookings/' + bookingId + '/status', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Status berhasil diubah');
            
            // If completed, show WhatsApp option
            if (data.show_whatsapp) {
                if (confirm('Status berhasil diubah menjadi Selesai. Apakah Anda ingin langsung mengirim notifikasi WhatsApp ke customer?')) {
                    sendWhatsApp();
                } else {
                    location.reload();
                }
            } else {
                location.reload();
            }
        } else {
            alert(data.message || 'Gagal mengubah status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

function sendWhatsApp() {
    fetch('<?= base_url() ?>/notifications/sendWhatsApp/' + bookingId)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.open(data.whatsapp_link, '_blank');
        } else {
            alert(data.message || 'Gagal membuat link WhatsApp');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

function openPhotoModal(src) {
    const modal = document.getElementById('photoModal');
    const modalImg = document.getElementById('modalPhoto');
    modal.style.display = 'block';
    modalImg.src = src;
}

function closePhotoModal() {
    document.getElementById('photoModal').style.display = 'none';
}

// Close modal when ESC key is pressed
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closePhotoModal();
        closeRejectModal();
    }
});
</script>
<?= $this->endSection() ?>
