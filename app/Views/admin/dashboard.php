<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Admin</h1>
    <p class="text-gray-600">Kelola semua booking dan layanan SYH Cleaning</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Booking Card -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Booking</p>
                <h3 class="text-3xl font-bold mt-2"><?= $total_bookings ?? 0 ?></h3>
                <p class="text-blue-100 text-xs mt-1">Total semua pesanan</p>
            </div>
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-shopping-bag text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Dalam Proses Card -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Dalam Proses</p>
                <h3 class="text-3xl font-bold mt-2"><?= $proses_bookings ?? 0 ?></h3>
                <p class="text-blue-100 text-xs mt-1">Sedang dikerjakan</p>
            </div>
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-spinner text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Selesai Card -->
    <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Selesai</p>
                <h3 class="text-3xl font-bold mt-2"><?= $completed_bookings ?? 0 ?></h3>
                <p class="text-green-100 text-xs mt-1">Siap diambil</p>
            </div>
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Pendapatan Card -->
    <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium">Total Pendapatan</p>
                <h3 class="text-2xl font-bold mt-2">Rp <?= number_format($total_revenue ?? 0, 0, ',', '.') ?></h3>
                <p class="text-purple-100 text-xs mt-1">Dari pesanan selesai</p>
            </div>
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Data Booking Table -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <!-- Card Header -->
    <div class="px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h3 class="text-xl font-bold text-gray-800">Data Booking</h3>
            <p class="text-sm text-gray-600 mt-1">Kelola semua pesanan customer</p>
        </div>
        <div class="relative">
            <input 
                type="text" 
                id="searchBooking" 
                placeholder="Cari booking..." 
                onkeyup="searchTable()"
                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            >
            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <?php if (!empty($recent_bookings)): ?>
            <table class="w-full" id="bookingTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($recent_bookings as $booking): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-800">BK<?= str_pad($booking['id'], 3, '0', STR_PAD_LEFT) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold mr-3">
                                        <?= strtoupper(substr($booking['customer_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800"><?= $booking['customer_name'] ?></div>
                                        <div class="text-xs text-gray-500"><?= date('d M Y', strtotime($booking['dibuat_pada'])) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $booking['no_hp'] ?? '') ?>" target="_blank" class="text-green-600 hover:text-green-700 flex items-center space-x-1">
                                    <i class="fab fa-whatsapp"></i>
                                    <span class="text-sm"><?= $booking['no_hp'] ?? '-' ?></span>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-700"><?= ucfirst(str_replace('-', ' ', $booking['layanan'])) ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-700"><?= $booking['jumlah'] ?? 1 ?> Pasang</span>
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
                                    <a href="<?= base_url('admin/bookings/' . $booking['id']) ?>" 
                                       class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button onclick="deleteBooking(<?= $booking['id'] ?>)" 
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="p-12 text-center text-gray-500">
                <i class="fas fa-inbox text-5xl mb-4 text-gray-300"></i>
                <p class="text-lg">Belum ada booking</p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Pagination -->
    <?php if (!empty($recent_bookings)): ?>
        <div class="px-6 py-4 border-t border-gray-200">
            <?= $pager->links('default', 'custom_pagination') ?>
        </div>
    <?php endif; ?>
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
    const newStatus = selectElement.value;
    const originalStatus = selectElement.getAttribute('data-original-status');
    
    if (!originalStatus) {
        selectElement.setAttribute('data-original-status', newStatus);
    }
    
    if (newStatus === 'selesai') {
        const confirmMsg = 'Status "Selesai" memerlukan foto hasil cucian.\n\nAnda akan diarahkan ke halaman detail booking untuk mengupload foto hasil cucian.\n\nLanjutkan?';
        if (confirm(confirmMsg)) {
            window.location.href = '<?= base_url() ?>/admin/bookings/' + bookingId;
        } else {
            selectElement.value = originalStatus;
        }
        return;
    }
    
    if (newStatus === 'ditolak') {
        const confirmMsg = 'Status "Ditolak" memerlukan alasan penolakan.\n\nAnda akan diarahkan ke halaman detail booking untuk mengisi alasan.\n\nLanjutkan?';
        if (confirm(confirmMsg)) {
            window.location.href = '<?= base_url() ?>/admin/bookings/' + bookingId;
        } else {
            selectElement.value = originalStatus;
        }
        return;
    }
    
    fetch('<?= base_url() ?>/admin/bookings/' + bookingId + '/status', {
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
                showToast('Gagal menghapus booking', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan', 'error');
        });
    }
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
    toast.className = `fixed top-20 right-4 ${bgColors[type]} text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 z-50 animate-slide-in-right`;
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
</script>

<style>
@keyframes slide-in-right {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
.animate-slide-in-right {
    animation: slide-in-right 0.3s ease;
}
</style>
<?= $this->endSection() ?>
