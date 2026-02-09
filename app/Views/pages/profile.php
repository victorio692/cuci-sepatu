<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- User Profile - Shopee Style -->
<div class="min-h-screen bg-gray-50 pt-20 pb-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Profile Section - Clickable -->
        <a href="/profile/detail" class="block bg-blue-600 rounded-2xl shadow-lg p-6 mb-6 hover:shadow-2xl transition-all duration-300 transform hover:scale-[1.01] cursor-pointer">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <?php if (!empty($user['foto_profil'])): ?>
                        <img src="<?= base_url('uploads/' . $user['foto_profil']) ?>" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover border-4 border-white shadow-lg">
                    <?php else: ?>
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-full flex items-center justify-center text-blue-600 text-2xl sm:text-3xl font-bold border-4 border-white shadow-lg">
                            <?= strtoupper(substr($user['full_name'] ?? $user['nama_lengkap'] ?? 'U', 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    <div class="absolute bottom-0 right-0 w-4 h-4 sm:w-5 sm:h-5 bg-green-400 border-2 border-white rounded-full"></div>
                </div>
                <div class="flex-1">
                    <h2 class="text-white font-bold text-lg sm:text-xl"><?= $user['full_name'] ?? $user['nama_lengkap'] ?? 'User' ?></h2>
                    <p class="text-blue-100 text-sm"><?= $user['email'] ?></p>
                </div>
                <i class="fas fa-chevron-right text-white text-xl"></i>
            </div>
        </a>

        <!-- Pesanan Saya Section -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-shopping-bag text-blue-600"></i>
                    Pesanan Saya
                </h3>
                <a href="/my-bookings" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center gap-1">
                    Lihat Riwayat Pesanan
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- Order Status Cards - Grid Layout -->
            <div class="grid grid-cols-3 sm:flex sm:justify-center gap-4 sm:gap-6">
                <!-- Menunggu Konfirmasi -->
                <a href="/my-bookings?status=pending" class="flex flex-col items-center justify-center">
                    <div class="relative mb-2">
                        <?php if ($statusCounts['pending'] > 0): ?>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full min-w-[20px] text-center"><?= $statusCounts['pending'] ?></span>
                        <?php endif; ?>
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-blue-100 rounded-full flex items-center justify-center hover:bg-blue-200 transition-colors">
                            <i class="fas fa-clock text-blue-600 text-xl sm:text-2xl"></i>
                        </div>
                    </div>
                    <span class="text-xs text-gray-700 text-center leading-tight">Menunggu Konfirmasi</span>
                </a>

                <!-- Dikonfirmasi -->
                <a href="/my-bookings?status=disetujui" class="flex flex-col items-center justify-center">
                    <div class="relative mb-2">
                        <?php if ($statusCounts['disetujui'] > 0): ?>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full min-w-[20px] text-center"><?= $statusCounts['disetujui'] ?></span>
                        <?php endif; ?>
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-blue-100 rounded-full flex items-center justify-center hover:bg-blue-200 transition-colors">
                            <i class="fas fa-check-circle text-blue-500 text-xl sm:text-2xl"></i>
                        </div>
                    </div>
                    <span class="text-xs text-gray-700 text-center leading-tight">Dikonfirmasi</span>
                </a>

                <!-- Proses -->
                <a href="/my-bookings?status=proses" class="flex flex-col items-center justify-center">
                    <div class="relative mb-2">
                        <?php if ($statusCounts['proses'] > 0): ?>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full min-w-[20px] text-center"><?= $statusCounts['proses'] ?></span>
                        <?php endif; ?>
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-purple-100 rounded-full flex items-center justify-center hover:bg-purple-200 transition-colors">
                            <i class="fas fa-sync-alt text-purple-500 text-xl sm:text-2xl"></i>
                        </div>
                    </div>
                    <span class="text-xs text-gray-700 text-center leading-tight">Proses</span>
                </a>

                <!-- Selesai -->
                <a href="/my-bookings?status=selesai" class="flex flex-col items-center justify-center">
                    <div class="relative mb-2">
                        <?php if ($statusCounts['selesai'] > 0): ?>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full min-w-[20px] text-center"><?= $statusCounts['selesai'] ?></span>
                        <?php endif; ?>
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-green-100 rounded-full flex items-center justify-center hover:bg-green-200 transition-colors">
                            <i class="fas fa-check-double text-green-500 text-xl sm:text-2xl"></i>
                        </div>
                    </div>
                    <span class="text-xs text-gray-700 text-center leading-tight">Selesai</span>
                </a>

                <!-- Dibatalkan -->
                <a href="/my-bookings?status=batal" class="flex flex-col items-center justify-center">
                    <div class="relative mb-2">
                        <?php if ($statusCounts['batal'] > 0): ?>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full min-w-[20px] text-center"><?= $statusCounts['batal'] ?></span>
                        <?php endif; ?>
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
                            <i class="fas fa-times-circle text-gray-500 text-xl sm:text-2xl"></i>
                        </div>
                    </div>
                    <span class="text-xs text-gray-700 text-center leading-tight">Dibatalkan</span>
                </a>

                <!-- Ditolak -->
                <a href="/my-bookings?status=ditolak" class="flex flex-col items-center justify-center">
                    <div class="relative mb-2">
                        <?php if (isset($statusCounts['ditolak']) && $statusCounts['ditolak'] > 0): ?>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full min-w-[20px] text-center"><?= $statusCounts['ditolak'] ?></span>
                        <?php endif; ?>
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-red-100 rounded-full flex items-center justify-center hover:bg-red-200 transition-colors">
                            <i class="fas fa-ban text-red-500 text-xl sm:text-2xl"></i>
                        </div>
                    </div>
                    <span class="text-xs text-gray-700 text-center leading-tight">Ditolak</span>
                </a>
            </div>
        </div>

        <!-- Bantuan & Info Section -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2 mb-4">
                <i class="fas fa-info-circle text-blue-600"></i>
                Bantuan & Informasi
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- FAQ -->
                <a href="/faq" class="bg-white border-2 border-gray-200 rounded-xl p-4 hover:border-blue-500 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-question-circle text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">FAQ</h4>
                            <p class="text-xs text-gray-500">Pertanyaan Umum</p>
                        </div>
                    </div>
                </a>

                <!-- Hubungi Kami -->
                <a href="/kontak" class="bg-white border-2 border-gray-200 rounded-xl p-4 hover:border-green-500 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone-alt text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">Hubungi Kami</h4>
                            <p class="text-xs text-gray-500">Bantuan Customer</p>
                        </div>
                    </div>
                </a>

                <!-- Tentang -->
                <a href="/tentang" class="bg-white border-2 border-gray-200 rounded-xl p-4 hover:border-purple-500 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-info-circle text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">Tentang</h4>
                            <p class="text-xs text-gray-500">Informasi Kami</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
