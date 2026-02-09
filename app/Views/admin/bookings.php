<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Pesanan</h1>
    <p class="text-gray-600">Kelola semua pesanan pelanggan</p>
</div>

<!-- Filter & Search -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <form action="/admin/bookings" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Pesanan</label>
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari nama, email, layanan..." 
                        value="<?= $search ?>"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    >
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">Semua Status</option>
                    <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>Menunggu</option>
                    <option value="disetujui" <?= $status === 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
                    <option value="proses" <?= $status === 'proses' ? 'selected' : '' ?>>Sedang Dikerjakan</option>
                    <option value="selesai" <?= $status === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    <option value="batal" <?= $status === 'batal' ? 'selected' : '' ?>>Ditolak</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-medium flex items-center justify-center space-x-2">
                    <i class="fas fa-search"></i>
                    <span>Cari & Filter</span>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Bookings Table -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <?php if (!empty($bookings)): ?>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($bookings as $booking): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-800">#<?= $booking['id'] ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold mr-3">
                                        <?= strtoupper(substr($booking['full_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800"><?= $booking['full_name'] ?></div>
                                        <div class="text-xs text-gray-500"><?= $booking['email'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-700"><?= ucfirst(str_replace('-', ' ', $booking['service'])) ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-700"><?= date('d M Y', strtotime($booking['created_at'])) ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-800">Rp <?= number_format($booking['total'], 0, ',', '.') ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <select 
                                    class="px-3 py-1.5 rounded-lg text-sm font-medium border-0 focus:ring-2 focus:ring-blue-500 transition cursor-pointer
                                        <?php 
                                        switch($booking['status']) {
                                            case 'pending': echo 'bg-yellow-100 text-yellow-800'; break;
                                            case 'disetujui': echo 'bg-blue-100 text-blue-800'; break;
                                            case 'proses': echo 'bg-purple-100 text-purple-800'; break;
                                            case 'selesai': echo 'bg-green-100 text-green-800'; break;
                                            case 'ditolak': echo 'bg-red-100 text-red-800'; break;
                                            case 'batal': echo 'bg-gray-100 text-gray-800'; break;
                                        }
                                        ?>" 
                                    data-booking-id="<?= $booking['id'] ?>"
                                    data-original-status="<?= $booking['status'] ?>"
                                    onchange="updateBookingStatus(this)"
                                    <?= in_array($booking['status'], ['selesai', 'ditolak']) ? 'disabled' : '' ?>
                                >
                                    <option value="pending" <?= $booking['status'] === 'pending' ? 'selected' : '' ?>>Menunggu</option>
                                    <option value="disetujui" <?= $booking['status'] === 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
                                    <option value="proses" <?= $booking['status'] === 'proses' ? 'selected' : '' ?>>Sedang Dikerjakan</option>
                                    <option value="selesai" <?= $booking['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                    <option value="ditolak" <?= $booking['status'] === 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <a href="/admin/bookings/<?= $booking['id'] ?>" 
                                       class="inline-flex items-center space-x-1 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm">
                                        <i class="fas fa-eye"></i>
                                        <span>Lihat</span>
                                    </a>
                                    <a href="/admin/bookings/<?= $booking['id'] ?>" 
                                       onclick="event.preventDefault(); if(confirm('Yakin ingin menghapus pesanan ini?')) { deleteBooking(<?= $booking['id'] ?>); }"
                                       class="inline-flex items-center space-x-1 px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm">
                                        <i class="fas fa-trash"></i>
                                        <span>Hapus</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Total Count -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 text-center text-gray-600">
                Total: <span class="font-semibold"><?= $pager['total'] ?></span> pesanan
                <?php if ($pager['total'] > 0): ?>
                    | Menampilkan <?= (($pager['currentPage'] - 1) * $pager['perPage']) + 1 ?> - <?= min($pager['currentPage'] * $pager['perPage'], $pager['total']) ?>
                <?php endif; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($pager['totalPages'] > 1): ?>
            <div class="px-6 py-4 border-t border-gray-200 bg-white">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Halaman <?= $pager['currentPage'] ?> dari <?= $pager['totalPages'] ?>
                    </div>
                    <div class="flex space-x-1">
                        <!-- Previous Button -->
                        <?php if ($pager['currentPage'] > 1): ?>
                            <a href="?page=<?= $pager['currentPage'] - 1 ?><?= $status ? '&status=' . $status : '' ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
                               class="px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        <?php else: ?>
                            <span class="px-3 py-2 bg-gray-100 border border-gray-200 text-gray-400 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        <?php endif; ?>
                        
                        <!-- Page Numbers -->
                        <?php 
                        $startPage = max(1, $pager['currentPage'] - 2);
                        $endPage = min($pager['totalPages'], $pager['currentPage'] + 2);
                        
                        if ($startPage > 1): ?>
                            <a href="?page=1<?= $status ? '&status=' . $status : '' ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
                               class="px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                1
                            </a>
                            <?php if ($startPage > 2): ?>
                                <span class="px-3 py-2 text-gray-400">...</span>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <?php if ($i == $pager['currentPage']): ?>
                                <span class="px-3 py-2 bg-blue-600 text-white rounded-lg font-semibold">
                                    <?= $i ?>
                                </span>
                            <?php else: ?>
                                <a href="?page=<?= $i ?><?= $status ? '&status=' . $status : '' ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
                                   class="px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                    <?= $i ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        
                        <?php if ($endPage < $pager['totalPages']): ?>
                            <?php if ($endPage < $pager['totalPages'] - 1): ?>
                                <span class="px-3 py-2 text-gray-400">...</span>
                            <?php endif; ?>
                            <a href="?page=<?= $pager['totalPages'] ?><?= $status ? '&status=' . $status : '' ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
                               class="px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                <?= $pager['totalPages'] ?>
                            </a>
                        <?php endif; ?>
                        
                        <!-- Next Button -->
                        <?php if ($pager['currentPage'] < $pager['totalPages']): ?>
                            <a href="?page=<?= $pager['currentPage'] + 1 ?><?= $status ? '&status=' . $status : '' ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
                               class="px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php else: ?>
                            <span class="px-3 py-2 bg-gray-100 border border-gray-200 text-gray-400 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="p-12 text-center text-gray-500">
                <i class="fas fa-inbox text-5xl mb-4 text-gray-300"></i>
                <p class="text-lg">Tidak ada pesanan</p>
                <p class="text-sm mt-2">Pesanan akan muncul di sini setelah customer melakukan booking</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
function updateBookingStatus(selectElement) {
    const bookingId = selectElement.getAttribute('data-booking-id');
    const newStatus = selectElement.value;
    const originalStatus = selectElement.getAttribute('data-original-status');
    
    if (!originalStatus) {
        selectElement.setAttribute('data-original-status', newStatus);
    }
    
    if (newStatus === 'selesai') {
        const confirmMsg = 'Status "Selesai" memerlukan foto hasil cucian.\n\nAnda akan diarahkan ke halaman detail booking untuk mengupload foto hasil cucian.\n\nLanjutkan?';
        if (confirm(confirmMsg)) {
            window.location.href = '/admin/bookings/' + bookingId;
        } else {
            selectElement.value = originalStatus;
        }
        return;
    }
    
    if (newStatus === 'ditolak' || newStatus === 'batal') {
        const confirmMsg = 'Status "Ditolak" memerlukan alasan penolakan.\n\nAnda akan diarahkan ke halaman detail booking untuk mengisi alasan.\n\nLanjutkan?';
        if (confirm(confirmMsg)) {
            window.location.href = '/admin/bookings/' + bookingId;
        } else {
            selectElement.value = originalStatus;
        }
        return;
    }
    
    fetch('/admin/bookings/' + bookingId + '/status', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Status berhasil diupdate', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(data.message || 'Gagal update status', 'error');
            selectElement.value = originalStatus;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan koneksi', 'error');
        selectElement.value = originalStatus;
    });
}

function showToast(message, type) {
    const bgColors = {
        'success': 'bg-green-500',
        'error': 'bg-red-500',
        'info': 'bg-blue-500'
    };
    
    const icons = {
        'success': 'fa-check-circle',
        'error': 'fa-exclamation-circle',
        'info': 'fa-info-circle'
    };
    
    const toast = document.createElement('div');
    toast.className = `fixed top-20 right-4 ${bgColors[type]} text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 z-50 animate-slide-in`;
    toast.innerHTML = `
        <i class="fas ${icons[type]} text-xl"></i>
        <span class="font-medium">${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Delete booking function
function deleteBooking(id) {
    fetch(`/admin/bookings/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Pesanan berhasil dihapus', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(data.message || 'Gagal menghapus pesanan', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan', 'error');
    });
}
</script>

<style>
@keyframes slide-in {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
.animate-slide-in {
    animation: slide-in 0.3s ease;
}
</style>
<?= $this->endSection() ?>
