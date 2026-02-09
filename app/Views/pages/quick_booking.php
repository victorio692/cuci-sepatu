<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <a href="/" class="inline-flex items-center text-blue-600 hover:text-blue-700 mb-4">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Booking Sekarang</h1>
            <p class="text-gray-600 mt-2">Isi form dibawah untuk langsung booking layanan ini</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Section -->
            <div class="lg:col-span-2">
                <form action="/quick-booking/submit" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6">
                    <?= csrf_field() ?>
                    <input type="hidden" name="service" value="<?= htmlspecialchars($service['kode_layanan']) ?>">

                    <!-- Service Display -->
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-<?= match($service['kode_layanan']) {
                                    'fast-cleaning' => 'bolt',
                                    'deep-cleaning' => 'water',
                                    'white-shoes' => 'star',
                                    'suede-treatment' => 'shoe-prints',
                                    'unyellowing' => 'magic',
                                    default => 'concierge-bell'
                                } ?> text-white text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900"><?= htmlspecialchars($service['nama_layanan']) ?></h3>
                                <p class="text-sm text-gray-600"><?= htmlspecialchars($service['deskripsi']) ?></p>
                                <p class="text-lg font-bold text-blue-600 mt-1">Rp <?= number_format($service['harga_dasar'], 0, ',', '.') ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Kondisi Sepatu -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Kondisi Sepatu <span class="text-red-500">*</span></label>
                        <select name="shoe_condition" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih kondisi sepatu</option>
                            <option value="normal">Normal - Kotoran biasa</option>
                            <option value="kotor">Kotor - Banyak noda</option>
                            <option value="sangat-kotor">Sangat Kotor - Noda membandel</option>
                        </select>
                    </div>

                    <!-- Jumlah -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Jumlah Sepatu <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" min="1" value="1" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Jumlah pasang sepatu yang akan dicuci</p>
                    </div>

                    <!-- Tanggal -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Tanggal Masuk <span class="text-red-500">*</span></label>
                        <input type="date" name="delivery_date" min="<?= date('Y-m-d') ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Jam Booking -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Jam Booking <span class="text-red-500">*</span></label>
                        <input type="time" name="booking_time" min="12:00" max="23:59" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Waktu saat ini: <?= date('H:i') ?></p>
                    </div>

                    <!-- Opsi Pengiriman -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Opsi Pengiriman <span class="text-red-500">*</span></label>
                        <select name="delivery_option" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="pickup">Ambil di Tempat - Gratis</option>
                            <option value="home">Antar ke Rumah - Rp 5.000</option>
                        </select>
                    </div>

                    <!-- Alamat Pengiriman -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Alamat Pengiriman</label>
                        <textarea name="delivery_address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"><?= htmlspecialchars($user['alamat'] ?? '') ?></textarea>
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika ambil di tempat</p>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Catatan</label>
                        <textarea name="notes" rows="3" placeholder="Tulis catatan di sini..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <!-- Foto Sepatu -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Foto Sepatu <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                            <i class="fas fa-camera text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-600 mb-2">Upload Foto Sepatu Anda</p>
                            <p class="text-xs text-gray-500 mb-3">PNG, JPG, JPEG (Maks. 5 MB)</p>
                            <input type="file" name="shoe_photo" accept="image/*" required class="w-full">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                        <i class="fas fa-check-circle mr-2"></i> Booking Sekarang
                    </button>
                </form>
            </div>

            <!-- Summary Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-receipt text-blue-600 mr-2"></i> Ringkasan Pesanan
                    </h3>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Layanan</span>
                            <span class="font-medium"><?= htmlspecialchars($service['nama_layanan']) ?></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Harga/Sepatu</span>
                            <span class="font-medium">Rp <?= number_format($service['harga_dasar'], 0, ',', '.') ?></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Jumlah</span>
                            <span class="font-medium" id="summary-quantity">1 pasang</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Biaya Kirim</span>
                            <span class="font-medium" id="summary-delivery">Gratis</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-900 font-bold">Total</span>
                            <span class="text-2xl font-bold text-blue-600" id="summary-total">Rp <?= number_format($service['harga_dasar'], 0, ',', '.') ?></span>
                        </div>
                    </div>

                    <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                        <p class="text-xs text-blue-700">
                            <i class="fas fa-info-circle mr-1"></i>
                            Booking langsung akan diproses setelah Anda submit form ini
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const basePrice = <?= $service['harga_dasar'] ?>;
const quantityInput = document.querySelector('input[name="quantity"]');
const deliveryOption = document.querySelector('select[name="delivery_option"]');

function updateSummary() {
    const quantity = parseInt(quantityInput.value) || 1;
    const deliveryFee = deliveryOption.value === 'home' ? 5000 : 0;
    const subtotal = basePrice * quantity;
    const total = subtotal + deliveryFee;

    document.getElementById('summary-quantity').textContent = quantity + ' pasang';
    document.getElementById('summary-delivery').textContent = deliveryFee > 0 ? 'Rp 5.000' : 'Gratis';
    document.getElementById('summary-total').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

quantityInput.addEventListener('input', updateSummary);
deliveryOption.addEventListener('change', updateSummary);
</script>

<?= $this->endSection() ?>
