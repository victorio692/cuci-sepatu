<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <div class="page-header-section">
        <a href="/admin/users" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Pelanggan
        </a>
    </div>

    <div class="user-detail-grid">
        <!-- Profile Card -->
        <div class="profile-section">
            <div class="profile-card">
                <div class="profile-card-body">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>

                    <h2 class="profile-name">
                        <?= $user['nama_lengkap'] ?>
                    </h2>

                    <div class="status-container">
                        <button 
                            class="status-badge-detail <?= $user['aktif'] ? 'active' : 'inactive' ?>"
                            onclick="toggleActive()"
                        >
                            <i class="fas fa-<?= $user['aktif'] ? 'check-circle' : 'ban' ?>"></i>
                            <?= $user['aktif'] ? 'Active' : 'Inactive' ?>
                        </button>
                    </div>

                    <div class="profile-divider">
                        <div class="info-item">
                            <span class="info-label">Bergabung</span>
                            <strong class="info-value"><?= date('d M Y', strtotime($user['created_at'])) ?></strong>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Total Pesanan</span>
                            <strong class="info-value"><?= count($bookings) ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details & Bookings -->
        <div class="details-section">
            <!-- Grid 2 Kolom untuk Info Cards -->
            <div class="info-cards-grid">
                <!-- Card: Informasi Customer -->
                <div class="info-card">
                    <div class="card-header-icon">
                        <i class="fas fa-user"></i>
                        <h3>Informasi Pelanggan</h3>
                    </div>
                    <div class="info-row">
                        <label>Nama:</label>
                        <span><?= $user['nama_lengkap'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Email:</label>
                        <span><?= $user['email'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Nomor WA:</label>
                        <span><?= $user['no_hp'] ?></span>
                    </div>
                </div>

                <!-- Card: Informasi Alamat -->
                <div class="info-card">
                    <div class="card-header-icon">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>Informasi Alamat</h3>
                    </div>
                    <div class="info-row">
                        <label>Alamat:</label>
                        <span><?= $user['alamat'] ?: '-' ?></span>
                    </div>
                    
                    
                </div>
            </div>

            <!-- Card: Riwayat Pesanan (Full Width) -->
            <div class="booking-history-card">
                <div class="card-header-main">
                    <i class="fas fa-history"></i>
                    <h3>Riwayat Pesanan</h3>
                    <?php if ($bookingsPager['total'] > 0): ?>
                        <span class="pagination-badge">
                            <?= $bookingsPager['total'] ?> pesanan
                        </span>
                    <?php endif; ?>
                </div>
                <div class="card-content">
                    <?php if (!empty($bookings)): ?>
                        <div class="table-wrapper">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Layanan</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bookings as $booking): ?>
                                        <tr>
                                            <td data-label="ID"><strong>#<?= $booking['id'] ?></strong></td>
                                            <td data-label="Layanan"><?= ucfirst(str_replace('-', ' ', $booking['layanan'])) ?></td>
                                            <td data-label="Total">Rp <?= number_format($booking['total'], 0, ',', '.') ?></td>
                                            <td data-label="Status">
                                                <span class="badge badge-<?= strtolower($booking['status']) ?>">
                                                    <?= ucfirst(str_replace('_', ' ', $booking['status'])) ?>
                                                </span>
                                            </td>
                                            <td data-label="Tanggal"><?= date('d M Y', strtotime($booking['created_at'])) ?></td>
                                            <td data-label="Aksi">
                                                <a href="/admin/bookings/<?= $booking['id'] ?>" class="action-link">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Controls -->
                        <?php if ($bookingsPager['totalPages'] > 1): ?>
                            <div class="pagination-container">
                                <div class="pagination-controls">
                                    <!-- Previous Button -->
                                    <?php if ($bookingsPager['currentPage'] > 1): ?>
                                        <a href="?page=<?= $bookingsPager['currentPage'] - 1 ?>" class="pagination-btn pagination-btn-prev">
                                            <i class="fas fa-chevron-left"></i> Sebelumnya
                                        </a>
                                    <?php else: ?>
                                        <span class="pagination-btn pagination-btn-disabled">
                                            <i class="fas fa-chevron-left"></i> Sebelumnya
                                        </span>
                                    <?php endif; ?>

                                    <!-- Page Numbers -->
                                    <div class="pagination-numbers">
                                        <?php for ($i = 1; $i <= $bookingsPager['totalPages']; $i++): ?>
                                            <?php if ($i === $bookingsPager['currentPage']): ?>
                                                <span class="pagination-number active"><?= $i ?></span>
                                            <?php else: ?>
                                                <a href="?page=<?= $i ?>" class="pagination-number"><?= $i ?></a>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>

                                    <!-- Next Button -->
                                    <?php if ($bookingsPager['currentPage'] < $bookingsPager['totalPages']): ?>
                                        <a href="?page=<?= $bookingsPager['currentPage'] + 1 ?>" class="pagination-btn pagination-btn-next">
                                            Selanjutnya <i class="fas fa-chevron-right"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="pagination-btn pagination-btn-disabled">
                                            Selanjutnya <i class="fas fa-chevron-right"></i>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="pagination-info">
                                    Halaman <?= $bookingsPager['currentPage'] ?> dari <?= $bookingsPager['totalPages'] ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Tidak ada riwayat pesanan</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
<style>
/* Page Header */
.page-header-section {
    margin-bottom: 2rem;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    background-color: #e5e7eb;
    color: #374151;
    text-decoration: none;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.btn-back:hover {
    background-color: #d1d5db;
    color: #1f2937;
    transform: translateX(-2px);
}

/* Grid Layout */
.user-detail-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    margin-bottom: 0;
}

@media (min-width: 768px) {
    .user-detail-grid {
        grid-template-columns: 280px 1fr;
        gap: 2rem;
    }
}

@media (min-width: 1024px) {
    .user-detail-grid {
        grid-template-columns: 300px 1fr;
        gap: 2.5rem;
    }
}

.profile-section {
    order: 2;
}

@media (min-width: 768px) {
    .profile-section {
        order: 1;
    }
}

.details-section {
    order: 1;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

@media (min-width: 768px) {
    .details-section {
        order: 2;
    }
}

/* Profile Card */
.profile-card {
    background: white;
    border-radius: 0.75rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border: 1px solid #f0f0f0;
    overflow: hidden;
    transition: all 0.3s ease;
}

.profile-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

.profile-card-body {
    padding: 2rem 1.5rem;
    text-align: center;
}

@media (min-width: 768px) {
    .profile-card-body {
        padding: 2.5rem 1.5rem;
    }
}

.user-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2.5rem;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.profile-name {
    margin: 0 0 1rem;
    color: #1f2937;
    font-weight: 700;
    font-size: 1.5rem;
    line-height: 1.3;
    word-break: break-word;
}

.status-container {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    justify-content: center;
    flex-wrap: wrap;
}

.profile-divider {
    border-top: 2px solid #f0f0f0;
    padding-top: 1.5rem;
    margin-top: 1.5rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.info-label {
    color: #9ca3af;
    font-size: 0.85rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    color: #1f2937;
    font-size: 1.25rem;
    font-weight: 700;
}

/* Status Badge */
.status-badge-detail {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    border: none;
    border-radius: 9999px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.status-badge-detail.active {
    background-color: #d1fae5;
    color: #065f46;
}

.status-badge-detail.active:hover {
    background-color: #a7f3d0;
    transform: scale(1.05);
}

.status-badge-detail.inactive {
    background-color: #fee2e2;
    color: #991b1b;
}

.status-badge-detail.inactive:hover {
    background-color: #fecaca;
    transform: scale(1.05);
}

/* Info Cards Grid */
.info-cards-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

@media (min-width: 768px) {
    .info-cards-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
}

@media (min-width: 1024px) {
    .info-cards-grid {
        gap: 1.75rem;
    }
}

/* Info Card */
.info-card {
    background: white;
    border-radius: 0.75rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border: 1px solid #f0f0f0;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.info-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    border-color: #e5e7eb;
}

@media (min-width: 768px) {
    .info-card {
        padding: 2rem;
    }
}

.card-header-icon {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f3f4f6;
}

.card-header-icon i {
    color: #3b82f6;
    font-size: 1.5rem;
    width: 2rem;
    text-align: center;
}

.card-header-icon h3 {
    margin: 0;
    color: #1f2937;
    font-weight: 700;
    font-size: 1.05rem;
}

@media (min-width: 768px) {
    .card-header-icon h3 {
        font-size: 1.15rem;
    }
}

/* Info Row */
.info-row {
    display: flex;
    justify-content: space-between;
    padding: 0.875rem 0;
    border-bottom: 1px solid #f3f4f6;
    gap: 1rem;
}

.info-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.info-row label {
    font-weight: 600;
    color: #6b7280;
    font-size: 0.9rem;
    flex: 0 0 auto;
    min-width: 100px;
}

.info-row span {
    color: #1f2937;
    text-align: right;
    word-break: break-word;
    font-size: 0.95rem;
    flex: 1 1 auto;
}

@media (min-width: 768px) {
    .info-row label {
        font-size: 0.95rem;
    }

    .info-row span {
        font-size: 1rem;
    }
}

/* Booking History Card */
.booking-history-card {
    background: white;
    border-radius: 0.75rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border: 1px solid #f0f0f0;
    overflow: hidden;
    transition: all 0.3s ease;
    margin-top: 1rem;
}

.booking-history-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

.card-header-main {
    padding: 1.5rem;
    border-bottom: 2px solid #f3f4f6;
    background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.card-header-main i {
    color: #3b82f6;
    font-size: 1.5rem;
    width: 2rem;
    text-align: center;
}

.card-header-main h3 {
    margin: 0;
    color: #1f2937;
    font-weight: 700;
    font-size: 1.15rem;
}

.card-content {
    padding: 0;
    overflow-x: auto;
}

/* Empty State */
.empty-state {
    padding: 3rem 1.5rem;
    text-align: center;
    color: #9ca3af;
}

.empty-state i {
    font-size: 3.5rem;
    color: #e5e7eb;
    margin-bottom: 1rem;
}

.empty-state p {
    margin: 1rem 0 0;
    font-size: 0.95rem;
    color: #6b7280;
}

/* Table Wrapper for Responsive Scrolling */
.table-wrapper {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* Admin Table */
.admin-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

.admin-table thead {
    background-color: #f9fafb;
    border-bottom: 2px solid #e5e7eb;
    position: sticky;
    top: 0;
}

.admin-table th {
    padding: 1rem;
    text-align: left;
    font-weight: 700;
    color: #374151;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.admin-table td {
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
    color: #1f2937;
    font-size: 0.95rem;
}

.admin-table tbody tr {
    transition: all 0.2s ease;
}

.admin-table tbody tr:hover {
    background-color: #f9fafb;
}

.admin-table tbody tr:last-child td {
    border-bottom: none;
}

/* Badges */
.badge {
    display: inline-block;
    padding: 0.375rem 1rem;
    border-radius: 9999px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.badge-pending {
    background-color: #fef3c7;
    color: #92400e;
}

.badge-approved {
    background-color: #dbeafe;
    color: #0c4a6e;
}

.badge-in_progress {
    background-color: #e9d5ff;
    color: #581c87;
}

.badge-completed {
    background-color: #d1fae5;
    color: #065f46;
}

.badge-cancelled {
    background-color: #fee2e2;
    color: #991b1b;
}

/* Action Link */
.action-link {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-block;
    padding: 0.5rem;
}

.action-link:hover {
    color: #1d4ed8;
    transform: scale(1.2);
}

/* Pagination Styles */
.pagination-badge {
    margin-left: auto;
    background-color: #eff6ff;
    color: #0c4a6e;
    padding: 0.375rem 0.875rem;
    border-radius: 9999px;
    font-size: 0.85rem;
    font-weight: 600;
}

.pagination-container {
    padding: 1.5rem;
    border-top: 1px solid #e5e7eb;
    background-color: #fafafa;
}

.pagination-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.pagination-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    background-color: #3b82f6;
    color: white;
    text-decoration: none;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.pagination-btn:hover {
    background-color: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.pagination-btn-disabled {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    background-color: #d1d5db;
    color: #9ca3af;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: not-allowed;
    border: none;
}

.pagination-numbers {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.pagination-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    padding: 0;
    background-color: white;
    color: #374151;
    text-decoration: none;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.pagination-number:hover {
    background-color: #f3f4f6;
    border-color: #3b82f6;
    color: #3b82f6;
}

.pagination-number.active {
    background-color: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.pagination-info {
    text-align: center;
    color: #6b7280;
    font-size: 0.9rem;
}

/* Responsive adjustments for small screens */
@media (max-width: 640px) {
    .admin-container {
        padding: 1rem;
    }

    .profile-card-body {
        padding: 1.5rem 1rem;
    }

    .info-card {
        padding: 1rem;
    }

    .card-header-main {
        padding: 1.25rem;
    }

    .info-row {
        flex-direction: column;
        padding: 0.75rem 0;
    }

    .info-row label {
        min-width: auto;
        color: #9ca3af;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .info-row span {
        text-align: left;
        font-weight: 600;
        color: #1f2937;
    }

    .admin-table th,
    .admin-table td {
        padding: 0.75rem;
        font-size: 0.85rem;
    }

    .admin-table th {
        font-size: 0.75rem;
    }

    /* Mobile table responsive display */
    .admin-table tbody tr {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.5rem;
        margin-bottom: 1rem;
        padding: 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        background: white;
    }

    .admin-table thead {
        display: none;
    }

    .admin-table td {
        border: none;
        padding: 0.5rem 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .admin-table td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #6b7280;
        font-size: 0.8rem;
        text-transform: uppercase;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .action-link {
        padding: 0.75rem 1rem;
    }
}

/* Mobile pagination adjustments */
@media (max-width: 640px) {
    .card-header-main {
        flex-direction: column;
        align-items: flex-start;
    }

    .pagination-badge {
        margin-left: 0;
        margin-top: 0.75rem;
    }

    .pagination-controls {
        gap: 0.5rem;
        justify-content: center;
    }

    .pagination-btn {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
        gap: 0.25rem;
    }

    .pagination-numbers {
        gap: 0.25rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination-number {
        width: 2rem;
        height: 2rem;
        font-size: 0.8rem;
    }

    .pagination-info {
        font-size: 0.85rem;
        margin-top: 0.75rem;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
function toggleActive() {
    const userId = <?= $user['id'] ?>;

    AdminAPI.post('/users/' + userId + '/toggle', {})
        .then(data => {
            showToast('User status updated', 'success');
            setTimeout(() => location.reload(), 1000);
        })
        .catch(error => {
            showToast('Failed to update user status', 'danger');
        });
}
</script>
<?= $this->endSection() ?>
