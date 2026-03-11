<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <div class="mb-6">
        <a href="/admin/bookings" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Pesanan
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-8">
        <!-- Kolom Kiri -->
        <div>
            <!-- Order Header -->
            <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start gap-3 md:gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-1">
                            Pesanan #<?= $booking['id'] ?>
                        </h1>
                        <p class="text-gray-600 text-sm md:text-base">
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
                            'disetujui' => '#10b981',
                            'proses' => '#8b5cf6',
                            'selesai' => '#10b981',
                            'ditolak' => '#ef4444'
                        ];
                        ?>
                        <div class="mt-2 md:mt-3">
                            <span class="inline-block px-3 md:px-4 py-1 md:py-2 rounded-lg font-semibold text-white text-sm md:text-base" style="background: <?= $statusColors[$booking['status']] ?? '#6b7280' ?>;">
                                <?= $statusLabels[$booking['status']] ?? ucfirst($booking['status']) ?>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col gap-2 w-full md:w-auto">
                        <?php if ($booking['status'] === 'pending'): ?>
                            <button onclick="approveBooking()" class="w-full px-3 md:px-4 py-2 md:py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg font-semibold transition transform hover:-translate-y-0.5 text-sm md:text-base whitespace-nowrap">
                                <i class="fas fa-check"></i> Setujui
                            </button>
                            <button onclick="showRejectModal()" class="w-full px-3 md:px-4 py-2 md:py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold transition transform hover:-translate-y-0.5 text-sm md:text-base whitespace-nowrap">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        <?php elseif ($booking['status'] === 'disetujui'): ?>
                            <button onclick="changeStatus('proses')" class="w-full px-3 md:px-4 py-2 md:py-2.5 bg-violet-500 hover:bg-violet-600 text-white rounded-lg font-semibold transition transform hover:-translate-y-0.5 text-sm md:text-base whitespace-nowrap">
                                <i class="fas fa-cog"></i> Mulai Proses
                            </button>
                        <?php elseif ($booking['status'] === 'proses'): ?>
                            <button onclick="showCompleteModal()" class="w-full px-3 md:px-4 py-2 md:py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white rounded-lg font-bold transition transform hover:-translate-y-0.5 text-sm md:text-base">
                                <i class="fas fa-check-circle"></i> Unggah Foto
                            </button>
                        <?php elseif ($booking['status'] === 'selesai'): ?>
                            <button onclick="sendWhatsApp()" class="w-full px-3 md:px-4 py-2 md:py-2.5 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold transition transform hover:-translate-y-0.5 text-sm md:text-base whitespace-nowrap">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Alasan Penolakan (jika ditolak) -->
                <?php if ($booking['status'] === 'ditolak' && !empty($booking['alasan_penolakan'])): ?>
                    <div class="mt-4 md:mt-6 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                            <div>
                                <strong class="text-red-900">Alasan Penolakan:</strong>
                                <p class="mt-1 text-red-800 text-sm md:text-base"><?= nl2br(htmlspecialchars($booking['alasan_penolakan'], ENT_QUOTES, 'UTF-8')) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="p-4 md:p-6 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user text-blue-500 text-lg md:text-xl"></i>
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800">Informasi Pelanggan</h3>
                    </div>
                </div>
                <div class="p-4 md:p-6 space-y-3 md:space-y-4">
                    <div class="flex flex-col md:flex-row justify-between py-2">
                        <label class="font-semibold text-gray-700 text-sm md:text-base">Nama:</label>
                        <span class="text-gray-600 text-sm md:text-base"><?= $booking['full_name'] ?></span>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between py-2">
                        <label class="font-semibold text-gray-700 text-sm md:text-base">Email:</label>
                        <span class="text-gray-600 text-sm md:text-base"><?= $booking['email'] ?></span>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between py-2">
                        <label class="font-semibold text-gray-700 text-sm md:text-base">Telepon:</label>
                        <span class="text-gray-600 text-sm md:text-base"><?= $booking['no_hp'] ?></span>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between py-2">
                        <label class="font-semibold text-gray-700 text-sm md:text-base">Alamat:</label>
                        <span class="text-gray-600 text-sm md:text-base"><?= $booking['address'] ?></span>
                    </div>
                </div>
            </div>

            <!-- Detail Pesanan -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 md:p-6 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-shopping-bag text-blue-500 text-lg md:text-xl"></i>
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800">Detail Pesanan</h3>
                    </div>
                </div>
                <div class="p-4 md:p-6 space-y-3 md:space-y-4">
                    <div class="flex flex-col md:flex-row justify-between py-2">
                        <label class="font-semibold text-gray-700 text-sm md:text-base">Layanan:</label>
                        <span class="text-gray-600 text-sm md:text-base"><?= ucfirst(str_replace('-', ' ', $booking['service'])) ?></span>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between py-2">
                        <label class="font-semibold text-gray-700 text-sm md:text-base">Kondisi Sepatu:</label>
                        <span class="text-gray-600 text-sm md:text-base"><?= ucfirst(str_replace('_', ' ', $booking['shoe_condition'])) ?></span>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between py-2">
                        <label class="font-semibold text-gray-700 text-sm md:text-base">Jumlah:</label>
                        <span class="text-gray-600 text-sm md:text-base"><?= $booking['quantity'] ?> pasang</span>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between py-2">
                        <label class="font-semibold text-gray-700 text-sm md:text-base">Pengiriman:</label>
                        <span class="text-gray-600 text-sm md:text-base"><?= ucfirst(str_replace('-', ' ', $booking['delivery_option'])) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan -->
        <div>
            <!-- Price Summary -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-4 md:p-6 mb-6 text-white">
                <h3 class="text-xl md:text-2xl font-bold mb-4 flex items-center gap-2">
                    <i class="fas fa-receipt"></i> Ringkasan Pesanan
                </h3>
                <div class="bg-white bg-opacity-10 p-3 md:p-4 rounded mb-4 space-y-2 md:space-y-3">
                    <div class="flex justify-between text-sm md:text-base">
                        <span class="opacity-90">Layanan:</span>
                        <span class="font-semibold">
                            <?= !empty($booking['service_name']) ? $booking['service_name'] : ucfirst(str_replace('-', ' ', $booking['service'])) ?>
                        </span>
                    </div>
                    <div class="flex justify-between text-sm md:text-base">
                        <span class="opacity-90">Harga/Sepatu:</span>
                        <span class="font-semibold">Rp <?= number_format(!empty($booking['service_price']) ? intval($booking['service_price']) : intval($booking['subtotal'] / $booking['quantity']), 0, '', '.') ?></span>
                    </div>
                    <div class="flex justify-between text-sm md:text-base">
                        <span class="opacity-90">Jumlah:</span>
                        <span class="font-semibold"><?= $booking['quantity'] ?> pasang</span>
                    </div>
                </div>
                <div class="bg-white text-gray-700 p-3 md:p-4 rounded space-y-2">
                    <div class="flex justify-between text-sm md:text-base">
                        <span>Subtotal:</span>
                        <span class="font-semibold">Rp <?= number_format(intval($booking['subtotal']), 0, '', '.') ?></span>
                    </div>
                    <div class="flex justify-between text-sm md:text-base pb-2 border-b border-gray-300">
                        <span>Biaya Pengiriman:</span>
                        <span class="font-semibold">Rp <?= number_format(intval($booking['delivery_fee']), 0, '', '.') ?></span>
                    </div>
                    <div class="flex justify-between pt-2 md:pt-3">
                        <span class="font-bold text-base md:text-lg">Total</span>
                        <span class="text-blue-600 text-lg md:text-2xl font-bold">Rp <?= number_format(intval($booking['total']), 0, '', '.') ?></span>
                    </div>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 md:p-6 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-clock text-blue-500 text-lg md:text-xl"></i>
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800">Timeline Status</h3>
                    </div>
                </div>
                <div class="p-4 md:p-6">
                    <div class="py-2 md:py-3">
                        <div class="flex items-center gap-3">
                            <div class="relative flex-shrink-0">
                                <div class="w-8 h-8 md:w-10 md:h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-bold text-sm md:text-base">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                            <div>
                                <strong class="text-gray-800 text-sm md:text-base">Dibuat</strong>
                                <p class="mt-1 text-gray-600 text-xs md:text-sm">
                                    <?= date('d M Y H:i', strtotime($booking['created_at'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <?php
                    // Map status timeline berdasarkan status sebenarnya
                    $statuses = [
                        'pending' => 'Menunggu Persetujuan',
                        'disetujui' => 'Disetujui',
                        'proses' => 'Sedang Diproses',
                        'selesai' => 'Selesai'
                    ];
                    
                    $status_order = ['pending', 'disetujui', 'proses', 'selesai'];
                    $current_status = $booking['status'];
                    
                    // Jika ditolak, tampilkan status berbeda
                    $is_rejected = ($current_status === 'ditolak');
                    ?>

                    <?php if ($is_rejected): ?>
                        <!-- Timeline untuk pesanan yang ditolak -->
                        <div class="py-2 md:py-3">
                            <div class="flex items-center gap-3">
                                <div class="relative flex-shrink-0">
                                    <div class="w-8 h-8 md:w-10 md:h-10 bg-red-100 text-red-700 rounded-full flex items-center justify-center font-bold text-sm md:text-base">
                                        <i class="fas fa-times"></i>
                                    </div>
                                </div>
                                <div>
                                    <strong class="text-red-600 text-base md:text-lg">Pesanan Ditolak</strong>
                                    <p class="mt-1 text-red-700 text-sm">
                                        Pesanan tidak dapat diproses
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Timeline normal untuk pesanan yang diproses -->
                        <?php foreach ($status_order as $status): ?>
                            <?php if ($status !== 'pending'): ?>
                                <?php
                                $current_index = array_search($current_status, $status_order);
                                $status_index = array_search($status, $status_order);
                                $is_completed = ($current_index !== false && $status_index !== false && $current_index >= $status_index);
                                $is_current = ($current_status === $status);
                                ?>
                                <div class="py-2 md:py-3" <?= $is_current ? 'style="opacity: 1; background: rgba(59, 130, 246, 0.05); padding: 1rem; border-radius: 0.5rem;"' : '' ?>>
                                    <div class="flex items-center gap-3">
                                        <div class="relative flex-shrink-0">
                                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center font-bold text-sm md:text-base transition" 
                                                style="background: <?= $is_completed ? '#dcfce7' : '#f0f9ff' ?>; color: <?= $is_completed ? '#15803d' : '#0369a1' ?>;">
                                                <i class="fas <?= $is_completed ? 'fa-check' : 'fa-circle' ?>"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <strong style="color: <?= $is_current ? '#3b82f6' : '#1f2937' ?>; font-size: 0.95rem; md:text-base;">
                                                <?= $statuses[$status] ?>
                                                <?= $is_current ? '<span style="font-size: 0.75rem; color: #3b82f6; font-weight: normal; display: inline-block; margin-left: 0.5rem;">(Saat ini)</span>' : '' ?>
                                            </strong>
                                            <p style="margin: 0.5rem 0 0; color: #6b7280; font-size: 0.875rem;">
                                                <?= $is_completed ? 'Selesai' : 'Menunggu' ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Foto & Detail Lainnya -->
    <div class="mt-8 md:mt-10">
            <?php if (!empty($photos) && count($photos) > 0): ?>
                <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-6">
                    <div class="flex items-center gap-2 mb-4 md:mb-6">
                        <i class="fas fa-camera text-blue-500 text-lg md:text-xl"></i>
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800">Foto Sepatu dari Customer (<?= count($photos) ?>)</h3>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
                        <?php foreach ($photos as $photo): ?>
                            <div class="relative rounded-lg overflow-hidden shadow-md cursor-pointer hover:shadow-lg transition group" onclick="openPhotoModal('<?= base_url('uploads/' . $photo['photo_path']) ?>')">
                                <img 
                                    src="<?= base_url('uploads/' . $photo['photo_path']) ?>" 
                                    alt="Foto Sepatu" 
                                    class="w-full h-40 md:h-48 object-cover"
                                    onerror="this.src='<?= base_url('assets/images/no-image.png') ?>'"
                                >
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black via-black to-transparent opacity-0 group-hover:opacity-100 transition p-2 text-white text-xs md:text-sm flex items-center justify-center h-full">
                                    <i class="fas fa-search-plus mr-1"></i> <span class="hidden sm:inline">Klik untuk memperbesar</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Foto Sepatu Lama -->
            <?php if (!empty($booking['foto_sepatu'])): ?>
                <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-6">
                    <div class="flex items-center gap-2 mb-4 md:mb-6">
                        <i class="fas fa-camera text-blue-500 text-lg md:text-xl"></i>
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800">Foto Kondisi Sepatu</h3>
                    </div>
                    <div class="text-center">
                        <img 
                            src="<?= base_url('uploads/' . $booking['foto_sepatu']) ?>" 
                            alt="Foto Sepatu" 
                            class="max-w-full h-auto rounded-lg shadow-md hover:shadow-lg transition cursor-pointer"
                            onclick="openPhotoModal(this.src)"
                        >
                        <p class="mt-3 text-gray-600 text-sm">
                            <i class="fas fa-info-circle"></i> Klik gambar untuk memperbesar
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Foto Hasil Cucian (Setelah) -->
            <?php if (!empty($booking['foto_hasil']) && $booking['status'] === 'selesai'): ?>
                <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-6 border-2 border-emerald-500">
                    <div class="flex items-center gap-2 mb-4 md:mb-6 pb-3 md:pb-4 border-b-2 border-emerald-500">
                        <i class="fas fa-check-circle text-emerald-500 text-lg md:text-xl"></i>
                        <h3 class="text-lg md:text-xl font-semibold text-emerald-600">Foto Hasil Cucian (Dikirim ke Customer)</h3>
                    </div>
                    <div class="text-center">
                        <img 
                            src="<?= base_url('uploads/' . $booking['foto_hasil']) ?>" 
                            alt="Foto Hasil Cucian" 
                            class="max-w-full h-auto rounded-lg shadow-md hover:shadow-lg transition cursor-pointer"
                            onclick="openPhotoModal(this.src)"
                        >
                        <p class="mt-3 text-teal-600 text-sm font-semibold">
                            <i class="fas fa-check-double"></i> Foto ini sudah dikirim ke customer
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Delivery Info -->
            <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
                <div class="flex items-center gap-2 mb-4 md:mb-6">
                    <i class="fas fa-truck text-blue-500 text-lg md:text-xl"></i>
                    <h3 class="text-lg md:text-xl font-semibold text-gray-800">Pengiriman</h3>
                </div>
                <div class="space-y-0 divide-y divide-gray-200">
                    <div class="flex flex-col md:flex-row justify-between py-3 md:py-4 gap-2">
                        <label class="font-semibold text-gray-600 text-sm md:text-base">Tipe Pengiriman:</label>
                        <span class="text-gray-800 text-sm md:text-base font-medium"><?= ucfirst(str_replace('-', ' ', $booking['delivery_option'])) ?></span>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between py-3 md:py-4 gap-2">
                        <label class="font-semibold text-gray-600 text-sm md:text-base">Tanggal Pengiriman:</label>
                        <span class="text-gray-800 text-sm md:text-base font-medium"><?= date('d M Y', strtotime($booking['delivery_date'])) ?></span>
                    </div>
                    <div class="flex flex-col md:flex-row justify-between py-3 md:py-4 gap-2">
                        <label class="font-semibold text-gray-600 text-sm md:text-base">Alamat Pengiriman:</label>
                        <span class="text-gray-800 text-sm md:text-base font-medium text-right md:text-right"><?= $booking['delivery_address'] ?></span>
                    </div>
                    <?php if (!empty($booking['notes'])): ?>
                        <div class="flex flex-col md:flex-row justify-between py-3 md:py-4 gap-2">
                            <label class="font-semibold text-gray-600 text-sm md:text-base">Catatan:</label>
                            <span class="text-gray-800 text-sm md:text-base font-medium text-right md:text-right"><?= $booking['notes'] ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

       

<!-- Photo Modal -->
<div id="photoModal" class="hidden fixed z-50 inset-0 bg-black bg-opacity-90 flex items-center justify-center overflow-auto" onclick="if(event.target.id === 'photoModal') closePhotoModal()">
    <button onclick="closePhotoModal()" class="absolute top-4 right-6 text-white text-4xl font-bold hover:opacity-80 transition">&times;</button>
    <img id="modalPhoto" class="max-w-full max-h-screen m-auto">
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed z-50 inset-0 bg-black bg-opacity-50 flex items-center justify-center" onclick="if(event.target.id === 'rejectModal') closeRejectModal()">
    <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-md mx-4">
        <h3 class="text-xl font-bold text-gray-800 mb-2">
            <i class="fas fa-times-circle text-red-500"></i> Tolak Pesanan
        </h3>
        <p class="text-gray-600 mb-4">Berikan alasan kenapa pesanan ini ditolak:</p>
        
        <textarea 
            id="rejectReason" 
            rows="4" 
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition font-inherit"
            placeholder="Contoh: Stok bahan habis, jadwal penuh, dll..."
        ></textarea>
        
        <div class="flex gap-3 mt-6">
            <button onclick="confirmReject()" class="flex-1 px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold transition flex items-center justify-center gap-2">
                <i class="fas fa-times"></i> Tolak Pesanan
            </button>
            <button onclick="closeRejectModal()" class="flex-1 px-4 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-semibold transition flex items-center justify-center gap-2">
                <i class="fas fa-ban"></i> Batal
            </button>
        </div>
    </div>
</div>

<!-- Complete Modal with Photo Upload -->
<div id="completeModal" class="hidden fixed z-50 inset-0 bg-black bg-opacity-70 flex items-center justify-center overflow-y-auto p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-6 md:p-8 text-center">
            <div class="w-16 h-16 bg-white rounded-full mx-auto mb-3 flex items-center justify-center shadow-lg">
                <i class="fas fa-camera text-emerald-500 text-2xl"></i>
            </div>
            <h3 class="text-2xl md:text-3xl font-bold text-white mb-2">
                Unggah Foto Hasil Cucian
            </h3>
            <p class="text-emerald-50 text-sm md:text-base">
                Pesanan #<?= $booking['id'] ?> - <?= $booking['full_name'] ?>
            </p>
        </div>

        <!-- Body -->
        <div class="p-6 md:p-8">
            <div class="bg-amber-50 border-l-4 border-amber-500 p-4 md:p-5 rounded mb-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-triangle text-amber-600 mt-1 text-lg"></i>
                    <div>
                        <strong class="text-amber-900 block text-base mb-1">Penting!</strong>
                        <p class="text-amber-800 text-sm md:text-base leading-relaxed m-0">
                            Unggah foto hasil cucian sepatu yang sudah selesai diproses. Foto ini akan dikirim ke customer sebagai bukti pekerjaan selesai.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block font-semibold text-gray-800 mb-3 text-base md:text-lg">
                    <i class="fas fa-image"></i> Pilih Foto Hasil Cucian <span class="text-red-500">*</span>
                </label>
                <input 
                    type="file" 
                    id="fotoHasil" 
                    accept="image/jpeg,image/jpg,image/png"
                    class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-emerald-500 focus:outline-none focus:border-emerald-500 transition text-sm md:text-base"
                >
                <div class="flex flex-col md:flex-row gap-3 md:gap-4 mt-3">
                    <small class="text-gray-600 flex items-center gap-2 text-xs md:text-sm">
                        <i class="fas fa-check-circle text-emerald-500"></i> Format: JPG, JPEG, PNG
                    </small>
                    <small class="text-gray-600 flex items-center gap-2 text-xs md:text-sm">
                        <i class="fas fa-check-circle text-emerald-500"></i> Maksimal: 5MB
                    </small>
                </div>
            </div>

            <!-- Preview -->
            <div id="previewContainer" class="hidden mb-6">
                <label class="block font-semibold text-gray-800 mb-3 text-base">
                    <i class="fas fa-eye"></i> Preview Foto:
                </label>
                <div class="p-4 text-center bg-gray-50 rounded-lg border-2 border-emerald-500">
                    <img id="previewImage" class="max-w-full max-h-60 rounded-lg shadow-md mx-auto">
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 p-6 md:p-8 flex flex-col md:flex-row gap-3 border-t border-gray-200">
            <button onclick="confirmComplete()" class="flex-1 px-4 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white rounded-lg font-bold transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-sm md:text-base">
                <i class="fas fa-check-circle"></i> Unggah & Tandai Selesai
            </button>
            <button onclick="closeCompleteModal()" class="flex-1 px-4 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold transition flex items-center justify-center gap-2 text-sm md:text-base">
                <i class="fas fa-times"></i> Batal
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
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectReason').value = '';
}

function showCompleteModal() {
    document.getElementById('completeModal').classList.remove('hidden');
}

function closeCompleteModal() {
    document.getElementById('completeModal').classList.add('hidden');
    document.getElementById('fotoHasil').value = '';
    document.getElementById('previewContainer').classList.add('hidden');
}

// Preview foto sebelum upload
document.addEventListener('DOMContentLoaded', function() {
    const fotoInput = document.getElementById('fotoHasil');
    if (fotoInput) {
        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImage').src = e.target.result;
                    document.getElementById('previewContainer').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    }
});

function confirmComplete() {
    const fotoInput = document.getElementById('fotoHasil');
    const file = fotoInput.files[0];
    
    if (!file) {
        alert('Foto hasil cucian wajib diupload!');
        return;
    }

    // Validate file type
    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!validTypes.includes(file.type)) {
        alert('Format foto harus JPG, JPEG, atau PNG!');
        return;
    }

    // Validate file size (max 5MB)
    if (file.size > 5 * 1024 * 1024) {
        alert('Ukuran foto maksimal 5MB!');
        return;
    }

    const formData = new FormData();
    formData.append('status', 'selesai');
    formData.append('foto_hasil', file);

    // Show loading indicator
    const submitBtn = event.target;
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload...';
    }

    // Use POST for file upload (PUT doesn't support multipart/form-data properly)
    fetch('<?= base_url() ?>/admin/bookings/' + bookingId + '/status', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Close modal
            closeCompleteModal();
            
            // Show success message
            alert('Pesanan berhasil ditandai selesai!\n\nFoto hasil cucian telah diupload\nCustomer telah menerima notifikasi\nSepatu siap diambil/diantar');
            
            // Reload page to show updated status
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            alert('Error: ' + (data.message || 'Gagal mengubah status'));
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> Unggah & Tandai Selesai';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat unggah foto.\n\nCek console untuk detail atau coba lagi.');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> Unggah & Tandai Selesai';
        }
    });
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
    modal.classList.remove('hidden');
    modalImg.src = src;
}

function closePhotoModal() {
    document.getElementById('photoModal').classList.add('hidden');
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
