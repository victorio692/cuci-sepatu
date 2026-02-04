<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- Main Content Without Sidebar -->
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="/" class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-blue-400 hover:text-blue-600 transition-all duration-300 font-medium shadow-sm hover:shadow-md transform hover:-translate-x-1">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
        
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-calendar-check text-blue-600 mr-3"></i>
                Pesanan Saya
            </h1>
            <p class="text-gray-600 mt-2">Kelola dan lacak semua pesanan cuci sepatu Anda</p>
        </div>

        <?php if (!empty($bookings)): ?>
            <!-- Bookings Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-blue-50 to-blue-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    No Pesanan
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Layanan
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($bookings as $booking): ?>
                                    <?php
                                    // Status badge class
                                    $statusClass = match($booking['status']) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'disetujui' => 'bg-blue-100 text-blue-800',
                                        'proses' => 'bg-purple-100 text-purple-800',
                                        'selesai' => 'bg-green-100 text-green-800',
                                        'ditolak' => 'bg-red-100 text-red-800',
                                        'batal' => 'bg-gray-100 text-gray-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                    
                                    // Status label
                                    $statusLabel = match($booking['status']) {
                                        'pending' => 'Menunggu',
                                        'disetujui' => 'Disetujui',
                                        'proses' => 'Diproses',
                                        'selesai' => 'Selesai',
                                        'ditolak' => 'Ditolak',
                                        'batal' => 'Dibatalkan',
                                        default => $booking['status']
                                    };
                                    
                                    // Service name mapping
                                    $serviceName = match($booking['layanan']) {
                                        'fast-cleaning' => 'Fast Cleaning',
                                        'deep-cleaning' => 'Deep Cleaning',
                                        'white-shoes' => 'White Shoes',
                                        'suede-treatment' => 'Suede Treatment',
                                        'unyellowing' => 'Unyellowing',
                                        default => $booking['layanan']
                                    };
                                    
                                    // Format date
                                    $tanggal = date('d M Y', strtotime($booking['dibuat_pada']));
                                    ?>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="font-bold text-gray-900">#<?= $booking['id'] ?></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-gray-900"><?= $serviceName ?></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-gray-600"><?= $tanggal ?></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                                <?php if ($booking['status'] === 'selesai'): ?>
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                <?php endif; ?>
                                                <?= $statusLabel ?>
                                            </span>
                                            <?php if ($booking['status'] === 'selesai' && !empty($booking['foto_hasil'])): ?>
                                                <div class="mt-1">
                                                    <span class="text-xs text-green-600 font-medium">
                                                        <i class="fas fa-camera"></i> Foto tersedia
                                                    </span>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="font-semibold text-gray-900">Rp <?= number_format($booking['total'], 0, ',', '.') ?></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="/booking-detail/<?= $booking['id'] ?>" 
                                               class="inline-block px-4 py-2 <?= $booking['status'] === 'selesai' ? 'bg-green-500 hover:bg-green-600' : 'bg-blue-500 hover:bg-blue-600' ?> text-white text-sm font-medium rounded-lg transition-colors duration-200"
                                               style="<?= $booking['status'] === 'selesai' ? 'background-color: #10b981;' : 'background-color: #3b82f6;' ?> color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; display: inline-block;">
                                                <?php if ($booking['status'] === 'selesai' && !empty($booking['foto_hasil'])): ?>
                                                    <i class="fas fa-image mr-1"></i> Detail & Foto
                                                <?php else: ?>
                                                    <i class="fas fa-eye mr-1"></i> Lihat
                                                <?php endif; ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <div class="mb-6">
                        <i class="fas fa-inbox text-8xl text-gray-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-3">Belum Ada Pesanan</h3>
                    <p class="text-gray-500 mb-6 max-w-md mx-auto">
                        Anda belum memiliki pesanan apapun. Mulai pesan layanan cuci sepatu sekarang!
                    </p>
                    <a href="/make-booking" 
                       class="inline-block px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition">
                        <i class="fas fa-plus mr-2"></i>
                        Pesan Sekarang
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Logout confirmation
function confirmLogout(e) {
    e.preventDefault();
    if (confirm('Apakah Anda yakin ingin logout?')) {
        window.location.href = '/logout';
    }
}
</script>

<?= $this->endSection() ?>
