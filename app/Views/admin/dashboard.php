<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <!-- Admin Header -->
    <div class="admin-header">
        <h1>Dashboard Admin</h1>
        <p>Kelola semua booking dan layanan</p>
    </div>

    <!-- Statistics Cards -->
    <div class="admin-stats">
        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total booking</div>
                <div class="stat-number"><?= $total_bookings ?? 0 ?></div>
                <div class="stat-sublabel">Total semua pesanan</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Dalam Proses</div>
                <div class="stat-number"><?= $proses_bookings ?? 0 ?></div>
                <div class="stat-sublabel">Sedang dikerjakan</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Selesai</div>
                <div class="stat-number"><?= $completed_bookings ?? 0 ?></div>
                <div class="stat-sublabel">Siap Diambil</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-content">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-number">Rp <?= number_format($total_revenue ?? 0, 0, ',', '.') ?></div>
                <div class="stat-sublabel">Dari pesanan selesai</div>
            </div>
        </div>
    </div>

    <!-- Data Booking -->
    <div class="admin-card">
        <div class="card-header-with-search">
            <div>
                <h3>Data Booking</h3>
                <p style="margin: 0.25rem 0 0; color: #6b7280; font-size: 0.9rem;">Kelola semua pesanan customer</p>
            </div>
            <div class="search-box">
                <input type="text" id="searchBooking" placeholder="Cari Booking...." onkeyup="searchTable()">
                <i class="fas fa-search"></i>
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            <?php if (!empty($recent_bookings)): ?>
                <table class="admin-table" id="bookingTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CUSTOMER</th>
                            <th>KONTAK</th>
                            <th>LAYANAN</th>
                            <th>JUMLAH</th>
                            <th>TOTAL</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_bookings as $booking): ?>
                            <tr>
                                <td><strong><?= 'BK' . str_pad($booking['id'], 3, '0', STR_PAD_LEFT) ?></strong></td>
                                <td>
                                    <div>
                                        <strong><?= $booking['customer_name'] ?></strong>
                                        <p style="margin: 0.25rem 0 0; font-size: 0.85rem; color: #6b7280;">
                                            <?= date('d M Y', strtotime($booking['dibuat_pada'])) ?>
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <span style="color: #10b981;">
                                        <i class="fab fa-whatsapp"></i> <?= $booking['no_hp'] ?? '-' ?>
                                    </span>
                                </td>
                                <td><?= ucfirst(str_replace('-', ' ', $booking['layanan'])) ?></td>
                                <td><?= $booking['jumlah'] ?? 1 ?> Pasang</td>
                                <td><strong>Rp <?= number_format($booking['total'], 0, ',', '.') ?></strong></td>
                                <td>
                                    <select 
                                        class="status-select-modern"
                                        data-booking-id="<?= $booking['id'] ?>"
                                        onchange="updateBookingStatus(this)"
                                        <?= in_array($booking['status'], ['selesai', 'ditolak']) ? 'disabled' : '' ?>
                                    >
                                        <option value="pending" <?= $booking['status'] === 'pending' ? 'selected' : '' ?>>Menunggu</option>
                                        <option value="disetujui" <?= $booking['status'] === 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
                                        <option value="proses" <?= $booking['status'] === 'proses' ? 'selected' : '' ?>>Proses</option>
                                        <option value="selesai" <?= $booking['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                        <option value="ditolak" <?= $booking['status'] === 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                    </select>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="<?= base_url('admin/bookings/' . $booking['id']) ?>" class="btn-icon btn-view" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn-icon btn-delete" onclick="deleteBooking(<?= $booking['id'] ?>)" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="padding: 3rem; text-align: center; color: #9ca3af;">
                    <i class="fas fa-inbox" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem;"></i>
                    <p>Belum ada booking</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
function searchTable() {
    const input = document.getElementById('searchBooking');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('bookingTable');
    const tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        const td = tr[i].getElementsByTagName('td');
        let found = false;
        
        for (let j = 0; j < td.length; j++) {
            if (td[j]) {
                const txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }
        
        tr[i].style.display = found ? '' : 'none';
    }
}

function updateBookingStatus(selectElement) {
    const bookingId = selectElement.getAttribute('data-booking-id');
    const status = selectElement.value;
    
    fetch('<?= base_url() ?>/admin/bookings/' + bookingId + '/status', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Status berhasil diupdate', 'success');
        } else {
            showToast('Gagal update status', 'danger');
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan', 'danger');
        location.reload();
    });
}

function deleteBooking(id) {
    if (confirm('Yakin ingin menghapus booking ini?')) {
        fetch('<?= base_url() ?>/admin/bookings/' + id, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Booking berhasil dihapus', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast('Gagal menghapus booking', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan', 'danger');
        });
    }
}

function cetakLaporan() {
    window.print();
}

function showToast(message, type) {
    // Create toast container if doesn't exist
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }
    
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        <span>${message}</span>
    `;
    
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
<?= $this->endSection() ?>
