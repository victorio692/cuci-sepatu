<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="min-h-screen bg-gray-100 py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Back Button -->
        <a href="/my-bookings" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
            <i class="fas fa-arrow-left"></i> Kembali ke Pesanan Saya
        </a>

        <!-- Header -->
        <div class="bg-white border border-gray-300 p-6 mb-6">
            <h1 class="text-xl font-bold mb-1">
                Detail Pesanan #<?= $booking['id'] ?>
            </h1>
            <p class="text-gray-600 text-sm">
                Dibuat pada <?= date('d M Y H:i', strtotime($booking['dibuat_pada'])) ?>
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Status -->
                <div class="bg-white border border-gray-300 p-6">
                    <h3 class="font-bold mb-3">Status Pesanan</h3>
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
                        'pending' => 'bg-yellow-500',
                        'disetujui' => 'bg-blue-500',
                        'proses' => 'bg-purple-500',
                        'selesai' => 'bg-green-500',
                        'ditolak' => 'bg-red-500',
                        'batal' => 'bg-gray-500',
                        default => 'bg-gray-500'
                    };
                    ?>
                    <span class="inline-block <?= $statusColor ?> text-white px-3 py-1 text-sm font-semibold">
                        <?= $statusLabel ?>
                    </span>
                        
                    <?php if ($booking['status'] === 'selesai'): ?>
                        <div class="mt-4 p-3 bg-green-50 border-l-4 border-green-500">
                            <p class="text-green-800 text-sm">
                                <i class="fas fa-check-circle"></i> Sepatu sudah selesai dicuci! Admin akan menghubungi Anda via WhatsApp.
                            </p>
                        </div>
                    <?php endif; ?>
                        
                    <?php if ($booking['status'] === 'ditolak' && !empty($booking['alasan_penolakan'])): ?>
                        <div class="mt-4 p-3 bg-red-50 border-l-4 border-red-500">
                            <strong class="text-red-900 text-sm block mb-1">Alasan Penolakan:</strong>
                            <p class="text-red-800 text-sm"><?= nl2br(htmlspecialchars($booking['alasan_penolakan'], ENT_QUOTES, 'UTF-8')) ?></p>
                        </div>
                    <?php endif; ?>
                        
                    <?php if ($booking['status'] === 'batal' && !empty($booking['alasan_pembatalan'])): ?>
                        <div class="mt-4 p-3 bg-gray-50 border-l-4 border-gray-500">
                            <strong class="text-gray-900 text-sm block mb-1">Alasan Pembatalan:</strong>
                            <p class="text-gray-800 text-sm"><?= nl2br(htmlspecialchars($booking['alasan_pembatalan'], ENT_QUOTES, 'UTF-8')) ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Detail Layanan -->
                <div class="bg-white border border-gray-300 p-6">
                    <h3 class="font-bold mb-4">Detail Layanan</h3>
                    
                    <table class="w-full text-sm">
                        <tr class="border-b">
                            <td class="py-2 text-gray-600">Layanan</td>
                            <td class="py-2 font-semibold">
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
                            </td>
                        </tr>
                        
                        <?php if (!empty($booking['kondisi_sepatu'])): ?>
                        <tr class="border-b">
                            <td class="py-2 text-gray-600">Kondisi Sepatu</td>
                            <td class="py-2 font-semibold"><?= ucfirst(str_replace('_', ' ', $booking['kondisi_sepatu'])) ?></td>
                        </tr>
                        <?php endif; ?>
                        
                        <tr class="border-b">
                            <td class="py-2 text-gray-600">Jumlah</td>
                            <td class="py-2 font-semibold"><?= $booking['jumlah'] ?> Pasang</td>
                        </tr>
                        
                        <tr class="border-b">
                            <td class="py-2 text-gray-600">Tanggal Pengambilan</td>
                            <td class="py-2 font-semibold"><?= date('d M Y', strtotime($booking['tanggal_kirim'])) ?></td>
                        </tr>
                        
                        <?php if (!empty($booking['jam_booking'])): ?>
                        <tr class="border-b">
                            <td class="py-2 text-gray-600">Jam Booking</td>
                            <td class="py-2 font-semibold"><?= $booking['jam_booking'] ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                    
                    <?php if (!empty($booking['catatan'])): ?>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <label class="text-gray-600 block mb-2 text-sm font-semibold">Catatan:</label>
                            <p class="text-gray-800 text-sm"><?= nl2br(htmlspecialchars($booking['catatan'], ENT_QUOTES, 'UTF-8')) ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Foto Hasil Cucian (Setelah) - Dari Admin -->
                <?php if (!empty($booking['foto_hasil']) && $booking['status'] === 'selesai'): ?>
                    <div class="bg-white border border-gray-300 p-6">
                        <div class="mb-3">
                            <h3 class="font-bold text-lg flex items-center gap-2">
                                <span class="text-2xl">✨</span>
                                <span>Hasil Cucian Sepatu Anda</span>
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">Sepatu Anda sudah selesai dicuci dengan sempurna!</p>
                        </div>
                        <div class="relative">
                            <img 
                                src="<?= base_url('uploads/' . $booking['foto_hasil']) ?>" 
                                alt="Foto Hasil Cucian" 
                                class="w-full h-auto border-4 border-green-500 shadow-lg cursor-pointer hover:shadow-xl transition-shadow"
                                onclick="openImageModal(this.src)"
                            >
                            <div class="absolute top-2 right-2 bg-green-500 text-white px-3 py-1 text-xs font-bold shadow-md">
                                SELESAI ✓
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 text-center">
                            <i class="fas fa-info-circle"></i> Klik gambar untuk memperbesar
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Foto Sepatu (from cart) -->
                <?php if (!empty($booking['foto_sepatu'])): ?>
                    <div class="bg-white border border-gray-300 p-6">
                        <h3 class="font-bold mb-3">Foto Sepatu (Sebelum)</h3>
                        <img 
                            src="<?= base_url('uploads/' . $booking['foto_sepatu']) ?>" 
                            alt="Foto Sepatu" 
                            class="max-w-full h-auto border border-gray-300 cursor-pointer"
                            onclick="openImageModal(this.src)"
                        >
                    </div>
                <?php endif; ?>

                <!-- Cancel Button -->
                <?php if ($booking['status'] === 'pending'): ?>
                    <div class="bg-white border border-gray-300 p-6">
                        <h3 class="font-bold mb-3">Aksi</h3>
                        <button 
                            onclick="cancelBooking(<?= $booking['id'] ?>)" 
                            class="w-full px-4 py-2 bg-red-500 text-white font-semibold hover:bg-red-600"
                        >
                            Batalkan Pesanan
                        </button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Foto Sepatu Anda (from checkout) -->
                <?php if (!empty($photos) && count($photos) > 0): ?>
                    <div class="bg-white border border-gray-300 p-6">
                        <h3 class="font-bold mb-3">Foto Sepatu Anda</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <?php foreach ($photos as $photo): ?>
                                <div>
                                    <img 
                                        src="<?= base_url('uploads/' . $photo['photo_path']) ?>" 
                                        alt="Foto Sepatu" 
                                        class="w-full h-24 object-cover border border-gray-300 cursor-pointer hover:border-blue-500"
                                        onclick="openImageModal(this.src)"
                                    >
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Informasi Pengiriman -->
                <div class="bg-white border border-gray-300 p-6">
                    <h3 class="font-bold mb-3">Informasi Pengiriman</h3>
                    
                    <div class="space-y-3 text-sm">
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
                        
                        <div class="pb-2 border-b border-gray-200">
                            <label class="text-gray-600 block mb-1">Opsi Barang Masuk:</label>
                            <span class="font-semibold flex items-center gap-2">
                                <i class="fas <?= $itemEntryIcon ?> <?= $itemEntryColor ?>"></i>
                                <?= $itemEntry ?>
                            </span>
                        </div>
                        
                        <div class="pb-2 border-b border-gray-200">
                            <label class="text-gray-600 block mb-1">Opsi Pengiriman:</label>
                            <span class="font-semibold flex items-center gap-2">
                                <i class="fas <?= $deliveryIcon ?> <?= $deliveryColor ?>"></i>
                                <?= $deliveryOption ?>
                            </span>
                        </div>
                        
                        <?php if (!empty($booking['alamat_kirim'])): ?>
                        <div>
                            <label class="text-gray-600 block mb-1">
                                <?= $itemEntry === 'Dijemput' ? 'Alamat Penjemputan:' : 'Alamat Pengiriman:' ?>
                            </label>
                            <span class="font-semibold"><?= nl2br(htmlspecialchars($booking['alamat_kirim'], ENT_QUOTES, 'UTF-8')) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Ringkasan Harga -->
                <div class="bg-white border border-gray-300 p-6">
                    <h3 class="font-bold mb-3">Ringkasan Harga</h3>
                    
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
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-semibold">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Biaya Pengiriman</span>
                            <span class="font-semibold <?= $biayaKirim == 0 ? 'text-green-600' : '' ?>">
                                <?php if ($biayaKirim == 0): ?>
                                    FREE
                                <?php else: ?>
                                    Rp <?= number_format($biayaKirim, 0, ',', '.') ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        
                        <div class="border-t border-gray-300 pt-2 mt-2">
                            <div class="flex justify-between">
                                <span class="font-bold">Total</span>
                                <span class="font-bold text-lg">Rp <?= number_format($total, 0, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div id="cancelModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white max-w-md w-full p-6">
            <h3 class="text-lg font-bold mb-4">Batalkan Pesanan</h3>
            
            <p class="text-gray-600 mb-4 text-sm">
                Mohon berikan alasan pembatalan pesanan Anda.
            </p>
            
            <form id="cancelForm" onsubmit="submitCancelBooking(event)" class="space-y-4">
                <div>
                    <label for="alasan_pembatalan" class="block text-sm font-semibold mb-2">
                        Alasan Pembatalan <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="alasan_pembatalan" 
                        name="alasan_pembatalan" 
                        required
                        rows="4"
                        placeholder="Contoh: Salah memilih layanan, Ingin mengubah jadwal, dll."
                        class="w-full px-3 py-2 border border-gray-300 text-sm"
                    ></textarea>
                </div>
                
                <div class="flex gap-3">
                    <button 
                        type="submit"
                        class="flex-1 px-4 py-2 bg-red-500 text-white font-semibold hover:bg-red-600"
                    >
                        Batalkan Pesanan
                    </button>
                    <button 
                        type="button"
                        onclick="closeCancelModal()"
                        class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 font-semibold hover:bg-gray-400"
                    >
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-90" onclick="closeImageModal()">
    <div class="absolute top-4 right-4">
        <button class="text-white text-3xl">&times;</button>
    </div>
    <div class="flex items-center justify-center h-full p-4">
        <img id="modalImage" class="max-w-full max-h-full">
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
