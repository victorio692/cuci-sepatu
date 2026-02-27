<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- Main Content -->
<div class="min-h-screen bg-gray-50 pt-24 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        <i class="fas fa-calendar-check text-blue-600 mr-3"></i>
                        Pesanan Saya
                    </h1>
                    <p class="text-gray-600 mt-2">Kelola dan lacak semua pesanan cuci sepatu Anda</p>
                </div>
                <div>
                    <a href="/profile" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
                        <i class="fas fa-arrow-left"></i>
                        <span class="hidden sm:inline">Kembali ke Profil</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Status Tabs Navigation - DIPERBAIKI -->
        <div class="bg-white rounded-xl shadow-lg mb-6 overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="flex overflow-x-auto py-2 px-4" aria-label="Tabs">
                    <?php 
                    $currentStatus = $_GET['status'] ?? 'all';
                    $tabs = [
                        'all' => ['label' => 'Semua', 'icon' => 'fa-list', 'count' => count($allBookings ?? $bookings)],
                        'pending' => ['label' => 'Menunggu', 'icon' => 'fa-clock', 'count' => $statusCounts['pending'] ?? 0],
                        'disetujui' => ['label' => 'Dikonfirmasi', 'icon' => 'fa-check-circle', 'count' => $statusCounts['disetujui'] ?? 0],
                        'proses' => ['label' => 'Proses', 'icon' => 'fa-sync-alt', 'count' => $statusCounts['proses'] ?? 0],
                        'selesai' => ['label' => 'Selesai', 'icon' => 'fa-check-double', 'count' => $statusCounts['selesai'] ?? 0],
                        'batal' => ['label' => 'Dibatalkan', 'icon' => 'fa-times-circle', 'count' => $statusCounts['batal'] ?? 0],
                        'ditolak' => ['label' => 'Ditolak', 'icon' => 'fa-ban', 'count' => $statusCounts['ditolak'] ?? 0],
                    ];
                    ?>
                    
                    <?php foreach ($tabs as $status => $tab): ?>
                        <a href="/my-bookings<?= $status !== 'all' ? '?status=' . $status : '' ?>" 
                           class="<?= $currentStatus === $status 
                                ? 'bg-blue-50 text-blue-600 font-semibold border-blue-200' 
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 border-transparent' 
                            ?> whitespace-nowrap py-2.5 px-4 border-2 rounded-lg font-medium text-sm flex items-center gap-2 transition-all mr-2">
                            <i class="fas <?= $tab['icon'] ?>"></i>
                            <span><?= $tab['label'] ?></span>
                            <span class="<?= $currentStatus === $status 
                                ? 'bg-blue-100 text-blue-600' 
                                : 'bg-gray-100 text-gray-600' 
                            ?> ml-1 py-0.5 px-2 rounded-full text-xs font-semibold">
                                <?= $tab['count'] ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </div>
        </div>

        <?php if (!empty($bookings)): ?>
            <!-- Bookings Table - DIBUNGKUS CARD -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-blue-100">
                    <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-list text-blue-600"></i>
                        Daftar Pesanan
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No Pesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Layanan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
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
                                        <span class="font-medium text-gray-900">#<?= $booking['id'] ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-gray-800"><?= $serviceName ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-gray-600"><?= $tanggal ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <!-- Status Badge dengan Icon dan Teks Sejajar - DIPERBAIKI -->
                                        <div class="flex items-center gap-1">
                                            <span class="px-3 py-1 inline-flex items-center justify-center text-xs font-semibold rounded-full <?= $statusClass ?>">
                                                <?php if ($booking['status'] === 'selesai'): ?>
                                                    <i class="fas fa-check-circle mr-1 text-[10px] leading-none"></i>
                                                <?php endif; ?>
                                                <?php if ($booking['status'] === 'disetujui'): ?>
                                                    <i class="fas fa-check-circle mr-1 text-[10px] leading-none"></i>
                                                <?php endif; ?>
                                                <?php if ($booking['status'] === 'proses'): ?>
                                                    <i class="fas fa-sync-alt mr-1 text-[10px] leading-none"></i>
                                                <?php endif; ?>
                                                <?php if ($booking['status'] === 'pending'): ?>
                                                    <i class="fas fa-clock mr-1 text-[10px] leading-none"></i>
                                                <?php endif; ?>
                                                <?php if ($booking['status'] === 'ditolak' || $booking['status'] === 'batal'): ?>
                                                    <i class="fas fa-times-circle mr-1 text-[10px] leading-none"></i>
                                                <?php endif; ?>
                                                <span class="leading-none"><?= $statusLabel ?></span>
                                            </span>
                                        </div>
                                        
                                        <!-- Info Foto Tersedia (untuk status selesai) -->
                                        <?php if ($booking['status'] === 'selesai' && !empty($booking['foto_hasil'])): ?>
                                            <div class="mt-1">
                                                <span class="text-xs text-green-600 font-medium flex items-center gap-1">
                                                    <i class="fas fa-camera text-[10px] leading-none"></i> 
                                                    <span class="leading-none">Foto tersedia</span>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-semibold text-gray-900">Rp <?= number_format($booking['total'], 0, ',', '.') ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="/booking-detail/<?= $booking['id'] ?>" 
                                           class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-all hover:shadow-md">
                                            <i class="fas fa-eye mr-1"></i> 
                                            <?= ($booking['status'] === 'selesai' && !empty($booking['foto_hasil'])) ? 'Detail & Foto' : 'Lihat' ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Footer tabel dengan pagination -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 text-sm text-gray-600">
                    <div class="flex justify-between items-center">
                        <span>Menampilkan <?= count($bookings) ?> pesanan</span>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 border border-gray-300 rounded-md bg-white hover:bg-gray-50 disabled:opacity-50" disabled>Prev</button>
                            <button class="px-3 py-1 border border-gray-300 rounded-md bg-white hover:bg-gray-50">Next</button>
                        </div>
                    </div>
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
                    Booking Sekarang
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>