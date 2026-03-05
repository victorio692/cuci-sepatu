<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Back Button -->
        <a href="/my-bookings" class="text-purple-600 hover:text-purple-800 mb-6 inline-flex items-center gap-2 font-medium transition-colors duration-300">
            <i class="fas fa-arrow-left"></i> Kembali ke Pesanan Saya
        </a>

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-md p-8 mb-8">
            <h1 class="text-3xl font-semibold mb-2 text-gray-900">
                Detail Pesanan #<?= $booking['id'] ?>
            </h1>
            <p class="text-gray-500 text-sm">
                Dibuat pada <?= date('d M Y H:i', strtotime($booking['created_at'])) ?>
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Status -->
                <div class="bg-white rounded-2xl shadow-md p-8 hover:shadow-lg transition-shadow duration-300">
                    <h3 class="font-semibold text-lg mb-4 text-gray-900">Status Pesanan</h3>
                    <?php
                    $statusLabel = match($booking['status']) {
                        'pending' => 'Menunggu Persetujuan',
                        'disetujui' => 'Disetujui Admin',
                        'proses' => 'Sedang Diproses',
                        'selesai' => 'Selesai',
                        'ditolak' => 'Ditolak Admin',
                        'batal' => 'Dibatalkan',
                        default => $booking['status']
                    };
                    
                    $statusColor = match($booking['status']) {
                        'pending' => 'bg-amber-500',
                        'disetujui' => 'bg-blue-500',
                        'proses' => 'bg-purple-600',
                        'selesai' => 'bg-emerald-500',
                        'ditolak' => 'bg-red-500',
                        'batal' => 'bg-gray-500',
                        default => 'bg-gray-500'
                    };
                    ?>
                    <span class="inline-block <?= $statusColor ?> text-white px-4 py-2 text-sm font-medium rounded-full shadow-md">
                        <?= $statusLabel ?>
                    </span>
                        
                    <?php if ($booking['status'] === 'selesai'): ?>
                        <div class="mt-5 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-lg">
                            <p class="text-emerald-800 text-sm flex items-center gap-2">
                                <i class="fas fa-check-circle text-emerald-600"></i> Sepatu sudah selesai dicuci! Admin akan menghubungi Anda via WhatsApp.
                            </p>
                        </div>
                    <?php endif; ?>
                        
                    <?php if ($booking['status'] === 'ditolak' && !empty($booking['alasan_penolakan'])): ?>
                        <div class="mt-5 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
                            <strong class="text-red-900 text-sm block mb-2">Alasan Penolakan:</strong>
                            <p class="text-red-800 text-sm"><?= nl2br(htmlspecialchars($booking['alasan_penolakan'], ENT_QUOTES, 'UTF-8')) ?></p>
                        </div>
                    <?php endif; ?>
                        
                    <?php if ($booking['status'] === 'batal' && !empty($booking['alasan_pembatalan'])): ?>
                        <div class="mt-5 p-4 bg-gray-50 border-l-4 border-gray-400 rounded-lg">
                            <strong class="text-gray-900 text-sm block mb-2">Alasan Pembatalan:</strong>
                            <p class="text-gray-800 text-sm"><?= nl2br(htmlspecialchars($booking['alasan_pembatalan'], ENT_QUOTES, 'UTF-8')) ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Detail Layanan -->
                <div class="bg-white rounded-2xl shadow-md p-8 hover:shadow-lg transition-shadow duration-300">
                    <h3 class="font-semibold text-lg mb-5 text-gray-900">Detail Layanan</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between py-3 border-b border-gray-200">
                            <span class="text-gray-600 text-sm">Layanan</span>
                            <span class="font-medium text-gray-900">
                                <?php
                                $serviceName = match($booking['layanan']) {
                                    'fast-cleaning' => 'Fast Cleaning',
                                    'deep-cleaning' => 'Deep Cleaning',
                                    'white-shoes' => 'White Shoes',
                                    'suede-treatment' => 'Suede Treatment',
                                    'unyellowing' => 'Unyellowing',
                                    'repair' => 'Repair',
                                    'coating' => 'Coating',
                                    'dyeing' => 'Dyeing',
                                    default => $booking['layanan']
                                };
                                echo $serviceName;
                                ?>
                            </span>
                        </div>
                        
                        <?php if (!empty($booking['kondisi_sepatu'])): ?>
                        <div class="flex justify-between py-3 border-b border-gray-200">
                            <span class="text-gray-600 text-sm">Kondisi Sepatu</span>
                            <span class="font-medium text-gray-900"><?= ucfirst(str_replace('_', ' ', $booking['kondisi_sepatu'])) ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="flex justify-between py-3 border-b border-gray-200">
                            <span class="text-gray-600 text-sm">Jumlah</span>
                            <span class="font-medium text-gray-900"><?= $booking['jumlah'] ?> Pasang</span>
                        </div>
                        
                        <div class="flex justify-between py-3 border-b border-gray-200">
                            <span class="text-gray-600 text-sm">Tanggal Pengambilan</span>
                            <span class="font-medium text-gray-900"><?= date('d M Y', strtotime($booking['tanggal_kirim'])) ?></span>
                        </div>
                        
                        <?php if (!empty($booking['jam_booking'])): ?>
                        <div class="flex justify-between py-3 border-b border-gray-200">
                            <span class="text-gray-600 text-sm">Jam Booking</span>
                            <span class="font-medium text-gray-900"><?= $booking['jam_booking'] ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (!empty($booking['catatan'])): ?>
                        <div class="mt-6 pt-5 border-t border-gray-200">
                            <label class="text-gray-600 block mb-3 text-sm font-medium">Catatan:</label>
                            <p class="text-gray-800 text-sm leading-relaxed"><?= nl2br(htmlspecialchars($booking['catatan'], ENT_QUOTES, 'UTF-8')) ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Foto Hasil Cucian (Setelah) - Dari Admin -->
                <?php if (!empty($booking['foto_hasil']) && $booking['status'] === 'selesai'): ?>
                    <div class="bg-white rounded-2xl shadow-md p-8 hover:shadow-lg transition-shadow duration-300">
                        <div class="mb-5">
                            <h3 class="font-semibold text-lg flex items-center gap-3 text-gray-900">
                                <span class="text-2xl">✨</span>
                                <span>Hasil Cucian Sepatu Anda</span>
                            </h3>
                            <p class="text-sm text-gray-500 mt-2">Sepatu Anda sudah selesai dicuci dengan sempurna!</p>
                        </div>
                        <div class="relative rounded-xl overflow-hidden">
                            <img 
                                src="<?= base_url('uploads/' . $booking['foto_hasil']) ?>" 
                                alt="Foto Hasil Cucian" 
                                class="w-full h-auto border-2 border-emerald-200 shadow-lg cursor-pointer hover:shadow-xl transition-shadow duration-300"
                                onclick="openImageModal(this.src)"
                            >
                            <div class="absolute top-3 right-3 bg-emerald-500 text-white px-3 py-1 text-xs font-medium shadow-lg rounded-full flex items-center gap-1">
                                <i class="fas fa-check"></i> SELESAI
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-3 text-center">
                            <i class="fas fa-info-circle"></i> Klik gambar untuk memperbesar
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Foto Sepatu (from cart) -->
                <?php if (!empty($booking['foto_sepatu'])): ?>
                    <div class="bg-white rounded-2xl shadow-md p-8 hover:shadow-lg transition-shadow duration-300">
                        <h3 class="font-semibold text-lg mb-4 text-gray-900">Foto Sepatu (Sebelum)</h3>
                        <div class="rounded-xl overflow-hidden">
                            <img 
                                src="<?= base_url('uploads/' . $booking['foto_sepatu']) ?>" 
                                alt="Foto Sepatu" 
                                class="w-full h-auto border border-gray-200 cursor-pointer hover:shadow-lg transition-shadow duration-300"
                                onclick="openImageModal(this.src)"
                            >
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Cancel Button -->
                <?php if ($booking['status'] === 'pending'): ?>
                    <div class="bg-white rounded-2xl shadow-md p-8 hover:shadow-lg transition-shadow duration-300">
                        <h3 class="font-semibold text-lg mb-4 text-gray-900">Aksi</h3>
                        <button 
                            onclick="cancelBooking(<?= $booking['id'] ?>)" 
                            class="w-full px-4 py-3 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 transition-all duration-300 shadow-md hover:shadow-lg"
                        >
                            <i class="fas fa-times-circle mr-2"></i> Batalkan Pesanan
                        </button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Foto Sepatu Anda (from checkout) -->
                <?php if (!empty($photos) && count($photos) > 0): ?>
                    <div class="bg-white rounded-2xl shadow-md p-8 hover:shadow-lg transition-shadow duration-300">
                        <h3 class="font-semibold text-lg mb-4 text-gray-900">Foto Sepatu Anda</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <?php foreach ($photos as $photo): ?>
                                <div class="rounded-lg overflow-hidden">
                                    <img 
                                        src="<?= base_url('uploads/' . $photo['photo_path']) ?>" 
                                        alt="Foto Sepatu" 
                                        class="w-full h-24 object-cover border border-gray-200 cursor-pointer hover:border-purple-500 hover:shadow-md transition-all duration-300"
                                        onclick="openImageModal(this.src)"
                                    >
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Informasi Pengiriman -->
                <div class="bg-white rounded-2xl shadow-md p-8 hover:shadow-lg transition-shadow duration-300">
                    <h3 class="font-semibold text-lg mb-5 text-gray-900">Informasi Pengiriman</h3>
                    
                    <div class="space-y-4 text-sm">
                        <?php
                        // Parse delivery_method to determine both options
                        $deliveryMethodCode = $booking['delivery_method'] ?? $booking['opsi_kirim'] ?? 'langsung';
                        
                        // Determine item entry option (Opsi Barang Masuk)
                        $itemEntry = 'Antar Sendiri';
                        $itemEntryIcon = 'fa-user';
                        $itemEntryColor = 'text-blue-600';
                        
                        if (stripos($deliveryMethodCode, 'jemput') !== false) {
                            $itemEntry = 'Dijemput';
                            $itemEntryIcon = 'fa-truck';
                            $itemEntryColor = 'text-green-600';
                        }
                        
                        // Determine delivery option (Opsi Pengiriman)
                        $deliveryOption = 'Ambil di Tempat';
                        $deliveryIcon = 'fa-box';
                        $deliveryColor = 'text-purple-600';
                        
                        if (stripos($deliveryMethodCode, 'antar') !== false || $deliveryMethodCode === 'home') {
                            $deliveryOption = 'Diantar ke Rumah';
                            $deliveryIcon = 'fa-home';
                            $deliveryColor = 'text-orange-600';
                        }
                        ?>
                        
                        <div class="pb-3 border-b border-gray-200">
                            <label class="text-gray-600 block mb-2 text-xs font-medium">Opsi Barang Masuk:</label>
                            <span class="font-medium text-gray-900 flex items-center gap-2">
                                <i class="fas <?= $itemEntryIcon ?> <?= $itemEntryColor ?>"></i>
                                <?= $itemEntry ?>
                            </span>
                        </div>
                        
                        <div class="pb-3 border-b border-gray-200">
                            <label class="text-gray-600 block mb-2 text-xs font-medium">Opsi Pengiriman:</label>
                            <span class="font-medium text-gray-900 flex items-center gap-2">
                                <i class="fas <?= $deliveryIcon ?> <?= $deliveryColor ?>"></i>
                                <?= $deliveryOption ?>
                            </span>
                        </div>
                        
                        <?php if (!empty($booking['alamat_kirim'])): ?>
                        <div>
                            <label class="text-gray-600 block mb-2 text-xs font-medium">
                                <?= $itemEntry === 'Dijemput' ? 'Alamat Penjemputan:' : 'Alamat Pengiriman:' ?>
                            </label>
                            <span class="font-medium text-gray-900"><?= nl2br(htmlspecialchars($booking['alamat_kirim'], ENT_QUOTES, 'UTF-8')) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Ringkasan Harga -->
                <div class="bg-gradient-to-br from-purple-50 to-white rounded-2xl shadow-md p-8 hover:shadow-lg transition-shadow duration-300 border border-purple-100">
                    <h3 class="font-semibold text-lg mb-5 text-gray-900">Ringkasan Harga</h3>
                    
                    <?php
                    // Handle old bookings that don't have subtotal and biaya_kirim
                    $subtotal = $booking['subtotal'] ?? 0;
                    $biayaKirim = $booking['biaya_kirim'] ?? 0;
                    $total = $booking['total'] ?? 0;
                    
                    // If subtotal is 0 or empty, calculate from total
                    if ($subtotal == 0 && $total > 0) {
                        // Assume no delivery fee for old bookings
                        $subtotal = $total;
                        $biayaKirim = 0;
                    }
                    ?>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium text-gray-900">Rp <?= number_format($subtotal, 0, '', '.') ?></span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600">Biaya Pengiriman</span>
                            <span class="font-medium <?= $biayaKirim == 0 ? 'text-emerald-600' : 'text-gray-900' ?>">
                                <?php if ($biayaKirim == 0): ?>
                                    <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full font-medium">FREE</span>
                                <?php else: ?>
                                    Rp <?= number_format($biayaKirim, 0, '', '.') ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        
                        <div class="border-t-2 border-gray-200 pt-3 mt-3">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-900">Total</span>
                                <span class="font-bold text-xl text-purple-600">Rp <?= number_format($total, 0, '', '.') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div id="cancelModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white max-w-md w-full p-8 rounded-2xl shadow-xl">
        <h3 class="text-xl font-semibold mb-3 text-gray-900">Batalkan Pesanan</h3>
        
        <p class="text-gray-600 mb-5 text-sm leading-relaxed">
            Mohon berikan alasan pembatalan pesanan Anda.
        </p>
        
        <form id="cancelForm" onsubmit="submitCancelBooking(event)" class="space-y-4">
            <div>
                <label for="alasan_pembatalan" class="block text-sm font-medium mb-2 text-gray-900">
                    Alasan Pembatalan <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="alasan_pembatalan" 
                    name="alasan_pembatalan" 
                    required
                    rows="4"
                    placeholder="Contoh: Salah memilih layanan, Ingin mengubah jadwal, dll."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-300"
                ></textarea>
            </div>
            
            <div class="flex gap-3 pt-4">
                <button 
                    type="submit"
                    class="flex-1 px-4 py-2 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 transition-all duration-300 shadow-md hover:shadow-lg"
                >
                    Batalkan Pesanan
                </button>
                <button 
                    type="button"
                    onclick="closeCancelModal()"
                    class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-all duration-300"
                >
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-95 flex items-center justify-center p-4" onclick="closeImageModal()">
    <button class="absolute top-4 right-4 text-white text-4xl font-light hover:text-gray-300 transition-colors duration-200" onclick="closeImageModal()">
        &times;
    </button>
    <div class="flex items-center justify-center">
        <img id="modalImage" class="max-w-full max-h-full rounded-lg">
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

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});
</script>
<?= $this->endSection() ?>
