<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
            <!-- Header -->
            <div class="mb-6">
                <a href="/my-bookings" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold mb-6 bg-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <i class="fas fa-arrow-left"></i> Kembali ke Pesanan Saya
                </a>
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-2xl p-8 text-white">
                    <h1 class="text-4xl font-bold flex items-center gap-3">
                        <i class="fas fa-receipt"></i>
                        Detail Pesanan #<?= $booking['id'] ?>
                    </h1>
                    <p class="mt-3 text-blue-100 flex items-center gap-2">
                        <i class="fas fa-clock"></i>
                        Dibuat pada <?= date('d M Y H:i', strtotime($booking['dibuat_pada'])) ?>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-blue-500">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-info-circle text-blue-600"></i>
                            Status Pesanan
                        </h3>
                        <?php
                        // Status label
                        $statusLabel = match($booking['status']) {
                            'pending' => 'Menunggu Persetujuan',
                            'disetujui' => 'Disetujui Admin',
                            'proses' => 'Sedang Diproses',
                            'selesai' => 'Selesai',
                            'ditolak' => 'Ditolak Admin',
                            'batal' => 'Dibatalkan',
                            default => $booking['status']
                        };
                        
                        // Status gradient
                        $statusGradient = match($booking['status']) {
                            'pending' => 'bg-gradient-to-r from-yellow-500 to-orange-500',
                            'disetujui' => 'bg-gradient-to-r from-blue-500 to-cyan-500',
                            'proses' => 'bg-gradient-to-r from-purple-500 to-pink-500',
                            'selesai' => 'bg-gradient-to-r from-green-500 to-emerald-500',
                            'ditolak' => 'bg-gradient-to-r from-red-500 to-rose-500',
                            'batal' => 'bg-gradient-to-r from-gray-500 to-slate-500',
                            default => 'bg-gradient-to-r from-gray-500 to-gray-600'
                        };
                        
                        $statusIcon = match($booking['status']) {
                            'pending' => 'fa-clock',
                            'disetujui' => 'fa-check-circle',
                            'proses' => 'fa-spinner',
                            'selesai' => 'fa-check-double',
                            'ditolak' => 'fa-times-circle',
                            'batal' => 'fa-ban',
                            default => 'fa-info-circle'
                        };
                        ?>
                        <div class="inline-flex items-center gap-3 <?= $statusGradient ?> text-white px-8 py-4 rounded-xl font-bold text-xl shadow-lg">
                            <i class="fas <?= $statusIcon ?>"></i>
                            <?= $statusLabel ?>
                        </div>
                        
                        <!-- Notifikasi Selesai -->
                        <?php if ($booking['status'] === 'selesai'): ?>
                            <div class="mt-6 p-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-xl shadow-md">
                                <div class="flex gap-4">
                                    <i class="fas fa-check-circle text-green-500 text-3xl mt-1"></i>
                                    <div>
                                        <strong class="text-green-900 text-lg block mb-3 font-bold">Sepatu Sudah Selesai! 🎉</strong>
                                        <p class="text-green-800 leading-relaxed">Sepatunya sudah jadi, Nanti bakal di WA admin untuk pengambilan atau pengiriman.</p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Alasan Penolakan (jika ditolak) -->
                        <?php if ($booking['status'] === 'ditolak' && !empty($booking['alasan_penolakan'])): ?>
                            <div class="mt-6 p-6 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 rounded-xl shadow-md">
                                <div class="flex gap-4">
                                    <i class="fas fa-exclamation-triangle text-red-500 text-3xl mt-1"></i>
                                    <div>
                                        <strong class="text-red-900 text-lg block mb-3 font-bold">Alasan Penolakan:</strong>
                                        <p class="text-red-800 leading-relaxed"><?= nl2br(htmlspecialchars($booking['alasan_penolakan'], ENT_QUOTES, 'UTF-8')) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Alasan Pembatalan (jika dibatalkan customer) -->
                        <?php if ($booking['status'] === 'batal' && !empty($booking['alasan_pembatalan'])): ?>
                            <div class="mt-6 p-6 bg-gradient-to-r from-gray-50 to-slate-50 border-l-4 border-gray-500 rounded-xl shadow-md">
                                <div class="flex gap-4">
                                    <i class="fas fa-info-circle text-gray-500 text-3xl mt-1"></i>
                                    <div>
                                        <strong class="text-gray-900 text-lg block mb-3 font-bold">Alasan Pembatalan:</strong>
                                        <p class="text-gray-800 leading-relaxed"><?= nl2br(htmlspecialchars($booking['alasan_pembatalan'], ENT_QUOTES, 'UTF-8')) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Layanan Info -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-blue-500">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-shopping-bag text-blue-600"></i> 
                            Detail Layanan
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 shadow-md">
                                <label class="font-bold text-blue-700 text-sm mb-2 flex items-center gap-2">
                                    <i class="fas fa-concierge-bell"></i>
                                    Layanan:
                                </label>
                                <span class="text-gray-900 font-semibold text-lg">
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
                            
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 shadow-md">
                                <label class="font-bold text-blue-700 text-sm mb-2 flex items-center gap-2">
                                    <i class="fas fa-shoe-prints"></i>
                                    Kondisi Sepatu:
                                </label>
                                <span class="text-gray-900 font-semibold text-lg"><?= ucfirst(str_replace('_', ' ', $booking['kondisi_sepatu'])) ?></span>
                            </div>
                            
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-4 shadow-md">
                                <label class="font-bold text-green-700 text-sm mb-2 flex items-center gap-2">
                                    <i class="fas fa-layer-group"></i>
                                    Jumlah:
                                </label>
                                <span class="text-gray-900 font-semibold text-lg"><?= $booking['jumlah'] ?> Pasang</span>
                            </div>
                            
                            <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-xl p-4 shadow-md">
                                <label class="font-bold text-orange-700 text-sm mb-2 flex items-center gap-2">
                                    <i class="fas fa-calendar-day"></i>
                                    Tanggal Pengambilan:
                                </label>
                                <span class="text-gray-900 font-semibold text-lg"><?= date('d M Y', strtotime($booking['tanggal_kirim'])) ?></span>
                            </div>
                            
                            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 shadow-md">
                                <label class="font-bold text-blue-700 text-sm mb-2 flex items-center gap-2">
                                    <i class="fas fa-clock"></i>
                                    Jam Booking:
                                </label>
                                <span class="text-gray-900 font-semibold text-lg"><?= $booking['jam_booking'] ?></span>
                            </div>
                        </div>
                        
                        <?php if (!empty($booking['catatan'])): ?>
                            <div class="mt-6 pt-6 border-t-2 border-gray-200">
                                <label class="font-bold text-gray-700 mb-3 flex items-center gap-2 text-lg">
                                    <i class="fas fa-sticky-note text-yellow-500"></i>
                                    Catatan:
                                </label>
                                <p class="text-gray-700 bg-yellow-50 p-4 rounded-xl border-l-4 border-yellow-400 leading-relaxed"><?= nl2br(htmlspecialchars($booking['catatan'], ENT_QUOTES, 'UTF-8')) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                    <!-- Foto Sepatu -->
                    <?php if (!empty($booking['foto_sepatu'])): ?>
                        <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-cyan-500">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                                <i class="fas fa-camera text-cyan-600"></i> 
                                Foto Sepatu (Sebelum)
                            </h3>
                            <div class="text-center">
                                <div class="relative inline-block group">
                                    <img 
                                        src="<?= base_url('uploads/' . $booking['foto_sepatu']) ?>" 
                                        alt="Foto Sepatu" 
                                        class="max-w-full h-auto rounded-2xl shadow-lg cursor-pointer hover:shadow-2xl transition-all duration-300 group-hover:scale-105"
                                        onclick="openImageModal(this.src)"
                                    >
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-2xl transition-all duration-300 flex items-center justify-center">
                                        <i class="fas fa-search-plus text-white text-4xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                                    </div>
                                </div>
                                <p class="mt-4 text-gray-600 font-medium flex items-center justify-center gap-2">
                                    <i class="fas fa-info-circle text-blue-500"></i> 
                                    Klik gambar untuk memperbesar
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Foto Hasil Cucian -->
                    <?php if ($booking['status'] === 'selesai' && !empty($booking['foto_hasil'])): ?>
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl shadow-2xl p-8 border-4 border-green-500">
                            <h3 class="text-2xl font-bold text-green-700 mb-6 flex items-center gap-3">
                                <i class="fas fa-sparkles"></i> 
                                Foto Hasil Cucian ✨
                            </h3>
                            <div class="text-center">
                                <div class="relative inline-block group">
                                    <img 
                                        src="<?= base_url('uploads/' . $booking['foto_hasil']) ?>" 
                                        alt="Foto Hasil Cucian" 
                                        class="max-w-full h-auto rounded-2xl shadow-xl cursor-pointer hover:shadow-2xl transition-all duration-300 group-hover:scale-105 border-4 border-white"
                                        onclick="openImageModal(this.src)"
                                    >
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-2xl transition-all duration-300 flex items-center justify-center">
                                        <i class="fas fa-search-plus text-white text-4xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                                    </div>
                                </div>
                                <div class="mt-6 bg-white rounded-xl p-4 shadow-lg">
                                    <p class="text-green-600 font-bold text-lg flex items-center justify-center gap-2">
                                        <i class="fas fa-check-circle"></i> 
                                        Sepatu Anda sudah selesai dicuci!
                                    </p>
                                    <p class="mt-2 text-gray-600 flex items-center justify-center gap-2">
                                        <i class="fas fa-info-circle text-blue-500"></i> 
                                        Klik gambar untuk memperbesar
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Delivery Info -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-blue-500">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-truck text-blue-600"></i> 
                            Informasi Pengiriman
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-5 shadow-md">
                                <label class="font-bold text-blue-700 mb-2 flex items-center gap-2 text-lg">
                                    <i class="fas fa-shipping-fast"></i>
                                    Opsi Pengiriman:
                                </label>
                                <span class="text-gray-900 font-semibold text-lg flex items-center gap-2 mt-2">
                                    <?php if ($booking['opsi_kirim'] === 'pickup'): ?>
                                        <i class="fas fa-store text-blue-600"></i> Ambil di Tempat
                                    <?php else: ?>
                                        <i class="fas fa-home text-green-600"></i> Diantar ke Rumah
                                    <?php endif; ?>
                                </span>
                            </div>
                            
                            <?php if ($booking['opsi_kirim'] === 'home'): ?>
                                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-5 shadow-md">
                                    <label class="font-bold text-green-700 mb-3 flex items-center gap-2 text-lg">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Alamat Pengiriman:
                                    </label>
                                    <span class="text-gray-800 leading-relaxed block mt-2"><?= nl2br(htmlspecialchars($booking['alamat_kirim'], ENT_QUOTES, 'UTF-8')) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Summary -->
                <div class="space-y-6">
                    <!-- Price Summary -->
                    <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-green-500 sticky top-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-receipt text-green-600"></i> 
                            Ringkasan Harga
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center pb-4 border-b-2 border-gray-100">
                                <span class="text-gray-700 font-medium flex items-center gap-2">
                                    <i class="fas fa-tag text-blue-500"></i>
                                    Subtotal:
                                </span>
                                <span class="text-gray-900 font-bold text-lg">Rp <?= number_format($booking['subtotal'], 0, ',', '.') ?></span>
                            </div>
                            <div class="flex justify-between items-center pb-4 border-b-2 border-gray-100">
                                <span class="text-gray-700 font-medium flex items-center gap-2">
                                    <i class="fas fa-shipping-fast text-blue-500"></i>
                                    Biaya Pengiriman:
                                </span>
                                <span class="text-gray-900 font-bold text-lg">Rp <?= number_format($booking['biaya_kirim'], 0, ',', '.') ?></span>
                            </div>
                            <div class="flex justify-between items-center pt-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 shadow-md">
                                <span class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-calculator text-green-600"></i>
                                    Total:
                                </span>
                                <span class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                    Rp <?= number_format($booking['total'], 0, ',', '.') ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <?php if ($booking['status'] === 'pending'): ?>
                        <div class="bg-white rounded-2xl shadow-xl p-8 border-t-4 border-red-500">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                                <i class="fas fa-cog text-red-600"></i>
                                Aksi
                            </h3>
                            <button 
                                onclick="cancelBooking(<?= $booking['id'] ?>)" 
                                class="w-full px-6 py-4 bg-gradient-to-r from-red-500 to-rose-500 text-white rounded-xl font-bold text-lg hover:from-red-600 hover:to-rose-600 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-3"
                            >
                                <i class="fas fa-times-circle text-xl"></i> 
                                Batalkan Pesanan
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Booking Modal -->
<div id="cancelModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8" onclick="event.stopPropagation()">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Batalkan Pesanan</h3>
            </div>
            
            <p class="text-gray-600 mb-6">
                Mohon berikan alasan pembatalan pesanan Anda. Informasi ini akan membantu kami meningkatkan layanan.
            </p>
            
            <form id="cancelForm" onsubmit="submitCancelBooking(event)">
                <div class="mb-6">
                    <label for="alasan_pembatalan" class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Pembatalan <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="alasan_pembatalan" 
                        name="alasan_pembatalan" 
                        rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                        placeholder="Contoh: Berubah pikiran, menemukan layanan lebih murah, dll."
                        required
                        minlength="10"
                    ></textarea>
                    <p class="mt-1 text-sm text-gray-500">
                        <i class="fas fa-info-circle"></i> Minimal 10 karakter
                    </p>
                </div>
                
                <div class="flex gap-3">
                    <button 
                        type="submit" 
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-red-500 to-rose-500 text-white rounded-lg font-bold hover:from-red-600 hover:to-rose-600 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2"
                    >
                        <i class="fas fa-check"></i>
                        Ya, Batalkan
                    </button>
                    <button 
                        type="button" 
                        onclick="closeCancelModal()"
                        class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300 transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        <i class="fas fa-times"></i>
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-95 backdrop-blur-sm" onclick="closeImageModal()">
    <div class="absolute top-8 right-12">
        <button class="text-white text-5xl font-bold hover:text-gray-300 transition-all duration-200 hover:scale-110 flex items-center gap-3">
            <span>&times;</span>
        </button>
    </div>
    <div class="flex items-center justify-center h-full p-8">
        <img id="modalImage" class="max-w-[90%] max-h-[90%] rounded-2xl shadow-2xl">
    </div>
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white text-center">
        <p class="text-lg font-medium bg-black bg-opacity-50 px-6 py-3 rounded-full backdrop-blur-sm">
            <i class="fas fa-info-circle"></i> Klik di mana saja untuk menutup
        </p>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
let bookingIdToCancel = null;

function cancelBooking(id) {
    bookingIdToCancel = id;
    const modal = document.getElementById('cancelModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCancelModal() {
    const modal = document.getElementById('cancelModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('alasan_pembatalan').value = '';
    bookingIdToCancel = null;
}

function submitCancelBooking(event) {
    event.preventDefault();
    const alasan = document.getElementById('alasan_pembatalan').value.trim();
    
    if (alasan.length < 10) {
        alert('Alasan pembatalan minimal 10 karakter');
        return;
    }
    
    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/booking/cancel/' + bookingIdToCancel;
    
    const alasanInput = document.createElement('input');
    alasanInput.type = 'hidden';
    alasanInput.name = 'alasan_pembatalan';
    alasanInput.value = alasan;
    form.appendChild(alasanInput);
    
    document.body.appendChild(form);
    form.submit();
}

function openImageModal(src) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    modal.classList.remove('hidden');
    modalImg.src = src;
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when ESC key is pressed
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});
</script>
<?= $this->endSection() ?>
