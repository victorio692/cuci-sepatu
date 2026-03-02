<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- Main Content Without Sidebar -->
<div class="min-h-screen bg-gray-50 py-6 sm:py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-4 sm:mb-6">
            <a href="/" class="inline-flex items-center gap-2 px-3 py-2 sm:px-4 sm:py-2 bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 hover:border-blue-400 hover:text-blue-600 transition-all duration-300 font-medium shadow-sm hover:shadow-md transform hover:-translate-x-1 text-sm sm:text-base">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4 sm:mb-6">Buat Booking Baru</h1>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                    <span class="text-green-800"><?= session()->getFlashdata('success') ?></span>
                </div>
            </div>
        <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        <span class="text-red-800"><?= session()->getFlashdata('error') ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mt-0.5"></i>
                        <div>
                            <h4 class="font-semibold text-red-800 mb-2">Validasi gagal:</h4>
                            <ul class="text-red-800 text-sm space-y-1">
                                <?php foreach (session()->getFlashdata('errors') as $field => $error): ?>
                                    <li>• <?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
                <!-- Left Column: Form -->
                <div class="lg:col-span-2">
                    <form action="/submit-booking" method="POST" id="bookingForm" enctype="multipart/form-data" class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
                        <?= csrf_field() ?>

                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">Pilih Layanan</h2>

                        <!-- Service Selection -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 mb-6 sm:mb-8">
                        <?php 
                        $serviceIcons = [
    'fast-cleaning'     => 'fa-bolt',
    'deep-cleaning'     => 'fa-droplets',
    'white-shoes'       => 'fa-star',
    'suede-treatment'   => 'fa-wand-magic-sparkles',
    'unyellowing'       => 'fa-sun'
];
                        
                        // Get service from URL parameter
                        $selectedService = $_GET['service'] ?? '';
                        
                        foreach ($services as $index => $service): 
                            $icon = $serviceIcons[$service['kode_layanan']] ?? 'fa-shoe-prints';
                            // Check if this service should be selected
                            $isSelected = ($selectedService === $service['kode_layanan']) || ($index === 0 && empty($selectedService));
                        ?>
                        <!-- <?= htmlspecialchars($service['nama_layanan']) ?> -->
                        <label class="relative block cursor-pointer border-2 border-gray-200 rounded-lg sm:rounded-xl p-3 sm:p-4 md:p-5 transition hover:border-blue-500 hover:shadow-lg bg-white group">
                            <input type="radio" name="service" value="<?= $service['kode_layanan'] ?>" data-price="<?= intval($service['harga_dasar']) ?>" <?= $isSelected ? 'checked' : '' ?> <?= $index === 0 ? 'required' : '' ?> class="absolute opacity-0">
                            <div class="flex justify-between items-start mb-2 sm:mb-3">
                                <div>
                                    <h3 class="text-base sm:text-lg font-bold text-gray-900"><?= htmlspecialchars($service['nama_layanan']) ?></h3>
                                    <p class="text-xs sm:text-sm text-gray-600 mt-1"><?= htmlspecialchars($service['deskripsi']) ?></p>
                                </div>
                                <span style="font-size: 1.5rem;">
                                    <?php 
                                    $emojiMap = [
                                        'fast-cleaning' => '',
                                        'deep-cleaning' => '',
                                        'white-shoes' => '',
                                        'suede-treatment' => '',
                                        'unyellowing' => ''
                                    ];
                                    echo $emojiMap[$service['kode_layanan']] ?? '';
                                    ?>
                                </span>
                            </div>
                            <div class="mt-2 sm:mt-3">
                                <span class="text-blue-600 font-semibold text-base sm:text-lg">Rp <?= number_format($service['harga_dasar'], 0, ',', '.') ?></span>
                                <span class="text-gray-400 text-xs sm:text-sm">/pasang</span>
                            </div>
                            <div class="text-gray-400 text-xs mt-1 sm:mt-2"><?= $service['durasi_hari'] ?> hari pengerjaan</div>
                        </label>
                        <?php endforeach; ?>
                        </div>

                    <!-- Hidden fields for shoe details -->
                    <input type="hidden" name="shoe_type" value="sneaker">
                    <input type="hidden" name="shoe_condition" value="normal">

                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6 mt-6 sm:mt-8">Detail Pesanan</h2>

                    <!-- Jumlah Sepatu -->
                <div class="mb-6">
    <span class="block text-gray-700 font-medium mb-2" 
          style="transition: none; animation: none; transform: none;">
        Jumlah Sepatu
    </span>
                        <div class="flex items-center gap-4">
                            <button type="button" id="btnMinus" class="ripple w-10 h-10 border-2 border-gray-300 bg-white rounded-lg hover:border-blue-500 hover:bg-blue-50 hover:text-blue-600 transition flex items-center justify-center">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input 
                                type="number" 
                                id="quantity" 
                                name="quantity" 
                                value="1" 
                                min="1"
                                readonly
                                class="w-20 text-center border border-gray-300 rounded-lg py-2 text-lg font-semibold focus:outline-none focus:border-blue-500"
                                required
                            >
                            <button type="button" id="btnPlus" class="ripple w-10 h-10 border-2 border-gray-300 bg-white rounded-lg hover:border-blue-500 hover:bg-blue-50 hover:text-blue-600 transition flex items-center justify-center">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Opsi Barang Masuk -->
                    <div class="mb-6">
                        <span class="block text-gray-700 font-medium mb-3">
                            <i class="fas fa-box text-purple-500 mr-1"></i> Opsi Barang Masuk <span class="text-red-500">*</span>
                        </span>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Diantar ke Tempat -->
                            <label class="item-entry-option relative block cursor-pointer border-2 border-gray-300 rounded-lg p-4 transition hover:border-blue-500 hover:shadow-md bg-white">
                                <input type="radio" name="item_entry_option" value="dropoff" checked required class="absolute opacity-0">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-user-check text-purple-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Diantar ke Tempat</h4>
                                        <p class="text-sm text-gray-600">Saya antar barang ke SYH.CLEANING</p>
                                    </div>
                                </div>
                            </label>

                            <!-- Dijemput -->
                            <label class="item-entry-option relative block cursor-pointer border-2 border-gray-300 rounded-lg p-4 transition hover:border-blue-500 hover:shadow-md bg-white">
                                <input type="radio" name="item_entry_option" value="pickup" required class="absolute opacity-0">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-truck text-indigo-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Dijemput</h4>
                                        <p class="text-sm text-gray-600">Tim kami jemput barang Anda</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Jam Antar/Jemput (di dalam Opsi Barang Masuk) -->
                        <div class="mt-4">
                            <span id="bookingTimeLabel" for="booking_time" class="block text-gray-700 font-medium mb-2">
                                <i class="fas fa-clock text-blue-500 mr-1"></i>
                                <span id="timeLabelText">Jam Antar</span> <span class="text-red-500">*</span>
                            </span>
                            <input 
                                type="text" 
                                id="booking_time" 
                                name="booking_time" 
                                placeholder="HH:MM (contoh: 14:30)"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                pattern="([01][0-9]|2[0-3]):[0-5][0-9]"
                                required
                            >
                            <small class="text-gray-500 text-sm mt-1 block">
                                <i class="fas fa-info-circle mr-1"></i>
                                Waktu saat ini: <span id="currentTime"></span> | <span id="suggestedTime" class="text-blue-600 font-medium cursor-pointer" onclick="useCurrentTime()">Gunakan waktu saat ini</span>
                            </small>
                        </div>
                    </div>

                    <!-- Alamat Penjemputan (conditional) -->
                    <div id="pickupAddressSection" class="mb-6 hidden">
                        <span for="pickup_address" class="block text-gray-700 font-medium mb-2">
                            <i class="fas fa-map-marker-alt text-indigo-500 mr-1"></i> Alamat Penjemputan <span class="text-red-500">*</span>
                        </span>
                        <textarea 
                            id="pickup_address" 
                            name="pickup_address" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                            rows="3" 
                            placeholder="Masukkan alamat lengkap untuk penjemputan..."
                        ></textarea>
                        <small class="text-gray-500 text-sm mt-1 block">
                            <i class="fas fa-info-circle"></i> Pastikan alamat lengkap dan jelas agar barang dapat dijemput dengan tepat
                        </small>
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mt-3">
                            <div class="flex gap-2">
                                <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5 text-sm"></i>
                                <p class="text-amber-800 text-sm">
                                    <span class="font-semibold">Biaya penjemputan: Rp 5.000</span> diterapkan untuk 1 sepatu. Gratis untuk 2 sepatu atau lebih.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Opsi Pengiriman -->
                    <div class="mb-6">
                        <span class="block text-gray-700 font-medium mb-3">
                            <i class="fas fa-shipping-fast text-blue-500 mr-1"></i> Opsi Pengiriman <span class="text-red-500">*</span>
                        </span>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Ambil di Tempat -->
                            <label class="delivery-option relative block cursor-pointer border-2 border-gray-300 rounded-lg p-4 transition hover:border-blue-500 hover:shadow-md bg-white">
                                <input type="radio" name="delivery_option" value="pickup" checked required class="absolute opacity-0">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-store text-blue-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Ambil di Tempat</h4>
                                        <p class="text-sm text-gray-600">Ambil sendiri di SYH.CLEANING</p>
                                    </div>
                                </div>
                            </label>

                            <!-- Diantar ke Rumah -->
                            <label class="delivery-option relative block cursor-pointer border-2 border-gray-300 rounded-lg p-4 transition hover:border-blue-500 hover:shadow-md bg-white">
                                <input type="radio" name="delivery_option" value="delivery" required class="absolute opacity-0">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-home text-green-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Diantar ke Rumah</h4>
                                        <p class="text-sm text-gray-600">Kami antar ke alamat Anda</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Alamat Pengiriman (conditional) -->
                    <div id="deliveryAddressSection" class="mb-6 hidden">
                        <span for="delivery_address" class="block text-gray-700 font-medium mb-2">
                            <i class="fas fa-map-marker-alt text-green-500 mr-1"></i> Alamat Pengiriman <span class="text-red-500">*</span>
                        </span>
                        <textarea 
                            id="delivery_address" 
                            name="delivery_address" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                            rows="3" 
                            placeholder="Masukkan alamat lengkap untuk pengiriman..."
                        ></textarea>
                        <small class="text-gray-500 text-sm mt-1 block">
                            <i class="fas fa-info-circle"></i> Pastikan alamat lengkap dan jelas agar sepatu dapat diantar dengan tepat
                        </small>
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mt-3">
                            <div class="flex gap-2">
                                <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5 text-sm"></i>
                                <p class="text-amber-800 text-sm">
                                    <span class="font-semibold">Biaya pengiriman: Rp 5.000</span> diterapkan untuk 1 sepatu. Gratis untuk 2 sepatu atau lebih.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Masuk -->
                    <div class="mb-6">
                        <span for="delivery_date" class="block text-gray-700 font-medium mb-2">Tanggal masuk</span>
                        <input 
                            type="date" 
                            id="delivery_date" 
                            name="delivery_date" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            min="<?= date('Y-m-d') ?>"
                            value="<?= date('Y-m-d') ?>"
                            required
                        >
                    </div>

                    <!-- Estimasi Selesai -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-4 sm:p-5 mb-6">
                        <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-calendar-check text-green-600"></i>
                            Estimasi Barang Selesai & Siap Diambil
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="estimated_finish_date" class="block text-gray-700 text-sm font-medium mb-2">
                                    Tanggal Selesai
                                </label>
                                <input 
                                    type="date" 
                                    id="estimated_finish_date" 
                                    name="estimated_finish_date" 
                                    class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white"
                                    readonly
                                >
                            </div>
                            
                            <div>
                                <label for="estimated_finish_time" class="block text-gray-700 text-sm font-medium mb-2">
                                    Jam Siap Diambil
                                </label>
                                <input 
                                    type="text" 
                                    id="estimated_finish_time" 
                                    name="estimated_finish_time" 
                                    placeholder="HH:MM"
                                    class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white"
                                    readonly
                                >
                            </div>
                        </div>
                        
                        <p class="text-xs text-gray-600 mt-3">
                            <i class="fas fa-info-circle text-green-600 mr-1"></i>
                            Estimasi ini dihitung otomatis berdasarkan layanan yang dipilih. Waktu sebenarnya bisa berbeda.
                        </p>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-6">
                        <span for="notes" class="block text-gray-700 font-medium mb-2">Catatan</span>
                        <textarea 
                            id="notes" 
                            name="notes" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                            rows="4" 
                            placeholder="Tulis catatan di sini..."
                        ></textarea>
                    </div>

                    <!-- Foto Sepatu -->
                    <div class="mb-6 sm:mb-8">
                        <span class="block text-gray-700 font-medium mb-2 text-sm sm:text-base">
                            Foto Sepatu <span class="text-red-500">*</span>
                        </label>
                        <input type="file" id="shoe_photo" name="shoe_photo" accept="image/png,image/jpeg,image/jpg" required class="hidden">
                        
                        <div id="uploadArea" class="border-2 border-dashed border-gray-300 rounded-lg p-6 sm:p-8 text-center bg-gray-50 transition hover:border-blue-500 hover:bg-blue-50">
                            <div class="mb-3 sm:mb-4">
                                <i class="fas fa-image text-4xl sm:text-5xl md:text-6xl text-blue-500"></i>
                            </div>
                            <p class="text-gray-800 font-medium mb-1 text-sm sm:text-base">Upload Foto Sepatu Anda</p>
                            <p class="text-gray-600 text-xs sm:text-sm mb-3 sm:mb-4">PNG, JPG, JPEG (Maks. 5 MB)</p>
                            
                            <button type="button" onclick="document.getElementById('shoe_photo').click()" class="ripple inline-flex items-center gap-2 px-4 py-2 sm:px-6 sm:py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:shadow-lg transition text-sm sm:text-base">
                                <i class="fas fa-camera"></i> Pilih Foto
                            </button>
                            
                            <p class="text-gray-400 text-xs mt-3 sm:mt-4">
                                <i class="fas fa-hand-pointer"></i> atau seret file kesini
                            </p>
                            <p class="text-red-500 text-xs sm:text-sm mt-2">
                                <i class="fas fa-exclamation-circle"></i> Wajib upload foto sepatu
                            </p>
                        </div>
                        
                        <div id="imagePreview" class="hidden mt-4">
                            <div class="relative inline-block">
                                <img id="previewImg" src="" class="max-w-full max-h-80 rounded-lg border-2 border-blue-500 shadow-lg">
                                <div class="absolute -top-2 -right-2">
                                    <button type="button" onclick="removeImage()" class="ripple w-8 h-8 bg-red-500 text-white rounded-full hover:bg-red-600 flex items-center justify-center border-2 border-white shadow-md transition hover:scale-110">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <button type="button" onclick="document.getElementById('shoe_photo').click()" class="ripple inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                                    <i class="fas fa-sync-alt"></i> Ganti Foto
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="ripple w-full px-6 py-3 sm:px-8 sm:py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-bold text-base sm:text-lg hover:shadow-xl transform hover:-translate-y-0.5 transition hover:from-blue-600 hover:to-blue-700">
                        <i class="fas fa-check-circle mr-2"></i> Booking Sekarang
                    </button>
                </form>
            </div>

            <!-- Right Column: Summary -->
            <div>
                <div class="bg-white rounded-xl shadow-lg lg:sticky lg:top-8 overflow-hidden transition-all duration-300 hover:shadow-2xl">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-t-xl p-4 sm:p-5 md:p-6">
                        <h3 class="text-lg sm:text-xl font-bold flex items-center gap-2">
                            <i class="fas fa-clipboard-list"></i> Ringkasan Booking
                        </h3>
                    </div>
                    <div class="p-4 sm:p-5 md:p-6">
                        <div class="space-y-2.5 sm:space-y-3 mb-4">
                            <div class="flex justify-between items-center text-sm sm:text-base">
                                <span class="text-gray-600">Layanan</span>
                                <span id="summaryService" class="font-semibold text-gray-900">-</span>
                            </div>
                            <div class="flex justify-between items-center text-sm sm:text-base">
                                <span class="text-gray-600">Harga/Sepatu</span>
                                <span id="summaryPrice" class="font-semibold text-gray-900">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center text-sm sm:text-base">
                                <span class="text-gray-600">Jumlah</span>
                                <span id="summaryQuantity" class="font-semibold text-gray-900">1 pasang</span>
                            </div>
                        </div>
                        
                        <div class="space-y-2.5 sm:space-y-3 mb-4 pb-4 border-b border-gray-300">
                            <div class="flex justify-between items-center text-sm sm:text-base">
                                <span class="text-gray-600">Subtotal</span>
                                <span id="summarySubtotal" class="font-semibold text-gray-900">Rp 0</span>
                            </div>
                            <div id="additionalFeeSection" class="flex justify-between items-center text-sm sm:text-base hidden">
                                <span class="text-gray-600">Biaya Tambahan</span>
                                <span id="summaryAdditionalFee" class="font-semibold text-orange-600">Rp 0</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center mb-4 sm:mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 p-3 sm:p-4 rounded-lg border border-blue-200 transition-all duration-300 hover:shadow-md">
                            <span class="font-bold text-gray-900 text-lg sm:text-xl">Total</span>
                            <span id="summaryTotal" class="font-bold text-blue-600 text-xl sm:text-2xl">Rp 0</span>
                        </div>

                        <div id="feeInfoSection" class="bg-orange-50 border border-orange-200 rounded-lg p-3 sm:p-4 hidden">
                            <div class="flex gap-2 sm:gap-3">
                                <i class="fas fa-info-circle text-orange-500 mt-0.5 text-sm sm:text-base"></i>
                                <p class="text-orange-900 text-xs sm:text-sm">
                                    <span id="feeInfoText"></span>
                                </p>
                            </div>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 sm:p-4">
                            <div class="flex gap-2 sm:gap-3">
                                <i class="fas fa-info-circle text-blue-500 mt-0.5 text-sm sm:text-base"></i>
                                <p class="text-blue-900 text-xs sm:text-sm">
                                    Anda dapat booking untuk hari ini atau hari lainnya. Untuk konfirmasi lebih lanjut hubungi kami.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<style>
/* Button Animation Styles */
button, a.inline-flex {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

button:active, a.inline-flex:active {
    transform: scale(0.95);
}

button:hover:not(:disabled), a.inline-flex:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

/* Gradient Button Glow Effect */
button.bg-gradient-to-r:hover,
button[type="submit"]:hover {
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.6), 0 10px 25px rgba(0, 0, 0, 0.15);
}

/* Red Button Glow */
.bg-red-500:hover {
    box-shadow: 0 0 15px rgba(239, 68, 68, 0.6), 0 5px 15px rgba(0, 0, 0, 0.15);
}

/* Service and Delivery Cards Animation */
label {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

label:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
}

label:active {
    transform: scale(0.98);
}

/* Ripple Effect */
@keyframes ripple {
    0% {
        transform: scale(0);
        opacity: 1;
    }
    100% {
        transform: scale(4);
        opacity: 0;
    }
}

.ripple {
    position: relative;
    overflow: hidden;
}

.ripple::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    background: rgba(255, 255, 255, 0.5);
    border-radius: 50%;
    transform: scale(0);
    pointer-events: none;
}

.ripple:active::after {
    animation: ripple 0.6s ease-out;
}

/* Pulse Animation for Selected Items */
@keyframes pulse {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.5);
    }
    50% {
        box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
    }
}

/* Sidebar Menu Animation */
aside ul li a {
    transition: all 0.3s ease;
    position: relative;
}

aside ul li a:hover {
    transform: translateX(5px);
}

aside ul li a:active {
    transform: scale(0.97);
}

/* Total Section Highlight */
#summaryTotal {
    transition: all 0.3s ease;
}

#summaryTotal:hover {
    transform: scale(1.05);
}

/* Smooth transitions for all elements */
* {
    -webkit-tap-highlight-color: transparent;
}

/* Smooth Scroll */
html {
    scroll-behavior: smooth;
}

/* Loading State for Buttons */
button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

button.loading {
    position: relative;
    color: transparent;
}

button.loading::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-left: -8px;
    margin-top: -8px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spinner 0.6s linear infinite;
}

@keyframes spinner {
    to {
        transform: rotate(360deg);
    }
}

/* Shake Animation for Errors */
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

.shake {
    animation: shake 0.5s ease-in-out;
}

/* Fade In Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 0.5s ease-out;
}

/* Selected service card styling */
label:has(input[type="radio"]:checked) {
    border-color: #3b82f6 !important;
    background-color: #eff6ff !important;
    animation: pulse 2s infinite;
}

label:has(input[type="radio"]:checked)::after {
    content: '\f058';
    font-family: 'Font Awesome 5 Free';
    font-weight: 700;
    position: absolute;
    top: 1rem;
    right: 1rem;
    color: #3b82f6;
    font-size: 1.5rem;
}

/* Delivery option styling */
.delivery-option:has(input[type="radio"]:checked) {
    border-color: #3b82f6 !important;
    background-color: #eff6ff !important;
}

.delivery-option:has(input[type="radio"]:checked)::after {
    content: '\f058';
    font-family: 'Font Awesome 5 Free';
    font-weight: 700;
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    color: #3b82f6;
    font-size: 1.25rem;
}

/* Item entry option styling */
.item-entry-option:has(input[type="radio"]:checked) {
    border-color: #3b82f6 !important;
    background-color: #eff6ff !important;
}

.item-entry-option:has(input[type="radio"]:checked)::after {
    content: '\f058';
    font-family: 'Font Awesome 5 Free';
    font-weight: 700;
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    color: #3b82f6;
    font-size: 1.25rem;
}
</style>

<script>
// Quantity buttons
document.getElementById('btnMinus').addEventListener('click', () => {
    const input = document.getElementById('quantity');
    const value = parseInt(input.value);
    if (value > 1) {
        input.value = value - 1;
        updateSummary();
    }
});

document.getElementById('btnPlus').addEventListener('click', () => {
    const input = document.getElementById('quantity');
    const value = parseInt(input.value);
    input.value = value + 1;
    updateSummary();
});

// Quantity input change
document.getElementById('quantity').addEventListener('change', updateSummary);
document.getElementById('quantity').addEventListener('input', updateSummary);

// Service selection
const serviceRadios = document.querySelectorAll('input[name="service"]');
serviceRadios.forEach(radio => {
    radio.addEventListener('change', updateSummary);
});

// Delivery option handling
const deliveryOptions = document.querySelectorAll('input[name="delivery_option"]');
const deliveryAddressSection = document.getElementById('deliveryAddressSection');
const deliveryAddressInput = document.getElementById('delivery_address');

deliveryOptions.forEach(option => {
    option.addEventListener('change', function() {
        if (this.value === 'delivery') {
            deliveryAddressSection.classList.remove('hidden');
            deliveryAddressInput.required = true;
        } else {
            deliveryAddressSection.classList.add('hidden');
            deliveryAddressInput.required = false;
            deliveryAddressInput.value = '';
        }
        updateSummary();
    });
});

// Item entry option handling
const itemEntryOptions = document.querySelectorAll('input[name="item_entry_option"]');
const pickupAddressSection = document.getElementById('pickupAddressSection');
const pickupAddressInput = document.getElementById('pickup_address');

itemEntryOptions.forEach(option => {
    option.addEventListener('change', function() {
        if (this.value === 'pickup') {
            pickupAddressSection.classList.remove('hidden');
            pickupAddressInput.required = true;
        } else {
            pickupAddressSection.classList.add('hidden');
            pickupAddressInput.required = false;
            pickupAddressInput.value = '';
        }
        updateSummary();
    });
});

// Update summary with animation
function updateSummary() {
    const selectedService = document.querySelector('input[name="service"]:checked');
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    const itemEntryOption = document.querySelector('input[name="item_entry_option"]:checked')?.value;
    const deliveryOption = document.querySelector('input[name="delivery_option"]:checked')?.value;
    
    const summaryTotal = document.getElementById('summaryTotal');
    const summaryService = document.getElementById('summaryService');
    const summaryPrice = document.getElementById('summaryPrice');
    const summaryQuantity = document.getElementById('summaryQuantity');
    const summarySubtotal = document.getElementById('summarySubtotal');
    const summaryAdditionalFee = document.getElementById('summaryAdditionalFee');
    const additionalFeeSection = document.getElementById('additionalFeeSection');
    const feeInfoSection = document.getElementById('feeInfoSection');
    const feeInfoText = document.getElementById('feeInfoText');
    
    if (selectedService) {
        const price = parseInt(selectedService.dataset.price);
        const subtotal = price * quantity;
        
        // Calculate additional fees
        let additionalFee = 0;
        let feeReasons = [];
        
        // Single shoe pickup fee
        if (itemEntryOption === 'pickup' && quantity === 1) {
            additionalFee += 5000;
            feeReasons.push('Penjemputan 1 sepatu');
        }
        
        // Delivery fee (only for 1 shoe, free for 2+)
        if (deliveryOption === 'delivery' && quantity === 1) {
            additionalFee += 5000;
            feeReasons.push('Pengiriman ke rumah');
        }
        
        const total = subtotal + additionalFee;
        
        // Get service name
        const serviceLabel = selectedService.closest('label');
        const serviceName = serviceLabel.querySelector('h3').textContent;
        
        // Add fade animation
        [summaryTotal, summaryService, summaryPrice, summaryQuantity, summarySubtotal, summaryAdditionalFee].forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(10px)';
        });
        
        setTimeout(() => {
            summaryService.textContent = serviceName;
            summaryPrice.textContent = 'Rp ' + price.toLocaleString('id-ID');
            summaryQuantity.textContent = quantity + ' pasang';
            summarySubtotal.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            summaryTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
            
            // Show or hide additional fee section
            if (additionalFee > 0) {
                summaryAdditionalFee.textContent = 'Rp ' + additionalFee.toLocaleString('id-ID');
                additionalFeeSection.classList.remove('hidden');
                
                // Update fee info
                feeInfoText.textContent = 'Biaya tambahan: ' + feeReasons.join(' + ');
                feeInfoSection.classList.remove('hidden');
            } else {
                additionalFeeSection.classList.add('hidden');
                feeInfoSection.classList.add('hidden');
            }
            
            [summaryTotal, summaryService, summaryPrice, summaryQuantity, summarySubtotal, summaryAdditionalFee].forEach((el, index) => {
                setTimeout(() => {
                    el.style.transition = 'all 0.3s ease-out';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 30);
            });
        }, 150);
    } else {
        // Jika belum ada layanan dipilih
        summaryService.textContent = '-';
        summaryPrice.textContent = 'Rp 0';
        summaryQuantity.textContent = quantity + ' pasang';
        summarySubtotal.textContent = 'Rp 0';
        summaryTotal.textContent = 'Rp 0';
        additionalFeeSection.classList.add('hidden');
        feeInfoSection.classList.add('hidden');
    }
}

// Set minimum date (today) - Execute immediately
const today = new Date();
document.getElementById('delivery_date').min = today.toISOString().split('T')[0];

// Update current time display every second
function updateCurrentTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    document.getElementById('currentTime').textContent = `${hours}:${minutes}:${seconds}`;
}

// Function to use current time
function useCurrentTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    document.getElementById('booking_time').value = `${hours}:${minutes}`;
}

// Initialize everything when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Initialize booking time with current time
    useCurrentTime();
    
    // Update current time display
    updateCurrentTime();
    setInterval(updateCurrentTime, 1000);
    
    // Auto-select service from URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const serviceParam = urlParams.get('service');
    
    if (serviceParam) {
        const serviceRadio = document.querySelector(`input[name="service"][value="${serviceParam}"]`);
        if (serviceRadio) {
            serviceRadio.checked = true;
            updateSummary();
            setTimeout(() => {
                serviceRadio.closest('label').scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 100);
        }
    } else {
        const checkedService = document.querySelector('input[name="service"]:checked');
        if (checkedService) {
            updateSummary();
        } else {
            updateSummary();
        }
    }

    // Update label jam booking berdasarkan opsi barang masuk
    const timeLabelText = document.getElementById('timeLabelText');
    const itemEntryOptions = document.querySelectorAll('input[name="item_entry_option"]');
    
    itemEntryOptions.forEach(option => {
        option.addEventListener('change', function() {
            if (this.value === 'pickup') {
                timeLabelText.textContent = 'Jam Jemput';
            } else {
                timeLabelText.textContent = 'Jam Antar';
            }
        });
    });
    
    // Set initial label
    const selectedItemEntry2 = document.querySelector('input[name="item_entry_option"]:checked');
    if (selectedItemEntry2) {
        timeLabelText.textContent = selectedItemEntry2.value === 'pickup' ? 'Jam Jemput' : 'Jam Antar';
    }
    
    // Calculate estimated finish date/time
    function calculateEstimatedFinish() {
        const deliveryDate = document.getElementById('delivery_date').value;
        if (!deliveryDate) return;
        
        // Get selected service to determine duration
        const selectedService = document.querySelector('input[name="service"]:checked');
        let serviceDays = 3; // Default 3 hari
        
        if (selectedService) {
            // Ambil durasi dari data-duration jika ada, atau gunakan default
            const serviceCode = selectedService.value;
            // Mapping durasi layanan (bisa disesuaikan)
            const durations = {
                'fast-cleaning': 1,
                'deep-cleaning': 3,
                'white-shoes': 2,
                'suede-treatment': 3,
                'unyellowing': 4
            };
            serviceDays = durations[serviceCode] || 3;
        }
        
        const startDate = new Date(deliveryDate);
        const finishDate = new Date(startDate);
        finishDate.setDate(finishDate.getDate() + serviceDays);
        
        // Format tanggal
        const year = finishDate.getFullYear();
        const month = String(finishDate.getMonth() + 1).padStart(2, '0');
        const day = String(finishDate.getDate()).padStart(2, '0');
        
        document.getElementById('estimated_finish_date').value = `${year}-${month}-${day}`;
        document.getElementById('estimated_finish_time').value = '17:00'; // Default jam 5 sore
    }
    
    // Update estimasi saat tanggal atau layanan berubah
    document.getElementById('delivery_date').addEventListener('change', calculateEstimatedFinish);
    
    // Update estimasi saat layanan dipilih
    const serviceRadios = document.querySelectorAll('input[name="service"]');
    serviceRadios.forEach(radio => {
        radio.addEventListener('change', calculateEstimatedFinish);
    });
    
    // Hitung estimasi saat load
    calculateEstimatedFinish();

    // Initialize item entry option state
    const selectedItemEntry = document.querySelector('input[name="item_entry_option"]:checked');
    if (selectedItemEntry && selectedItemEntry.value === 'pickup') {
        pickupAddressSection.classList.remove('hidden');
        pickupAddressInput.required = true;
    }
});

// Form submission
document.getElementById('bookingForm').addEventListener('submit', (e) => {
    console.log('🚀 Form submit event triggered!');
    
    // Fallback: ensure booking_time has value if empty
    const bookingTimeInput = document.getElementById('booking_time');
    if (!bookingTimeInput.value) {
        console.log('⏰ Auto-fill booking time');
        useCurrentTime();
    }
    
    const selectedService = document.querySelector('input[name="service"]:checked');
    console.log('🔍 Checking service:', selectedService);
    if (!selectedService) {
        console.log('❌ VALIDASI GAGAL: Layanan belum dipilih');
        e.preventDefault();
        alert('Pilih layanan terlebih dahulu');
        const serviceSection = document.querySelector('[name="service"]').closest('.grid');
        serviceSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
        serviceSection.classList.add('shake');
        setTimeout(() => serviceSection.classList.remove('shake'), 500);
        return;
    }
    
    // Check delivery date
    const deliveryDate = document.getElementById('delivery_date').value.trim();
    console.log('📅 Checking delivery date:', deliveryDate);
    if (!deliveryDate) {
        console.log('❌ VALIDASI GAGAL: Tanggal belum dipilih');
        e.preventDefault();
        alert('Tanggal masuk wajib dipilih');
        const dateInput = document.getElementById('delivery_date');
        dateInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        dateInput.focus();
        dateInput.classList.add('shake');
        setTimeout(() => dateInput.classList.remove('shake'), 500);
        return;
    }
    
    // Check booking time
    const bookingTime = document.getElementById('booking_time').value.trim();
    console.log('⏰ Checking booking time:', bookingTime);
    if (!bookingTime) {
        console.log('❌ VALIDASI GAGAL: Jam booking kosong');
        e.preventDefault();
        alert('Jam booking wajib diisi');
        const timeInput = document.getElementById('booking_time');
        timeInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        timeInput.focus();
        timeInput.classList.add('shake');
        setTimeout(() => timeInput.classList.remove('shake'), 500);
        return;
    }
    
    const shoePhoto = document.getElementById('shoe_photo');
    console.log('📸 Checking shoe photo:', shoePhoto.files.length, 'files');
    if (!shoePhoto.files || shoePhoto.files.length === 0) {
        console.log('❌ VALIDASI GAGAL: Foto belum diupload');
        e.preventDefault();
        alert('Wajib upload foto sepatu terlebih dahulu');
        const photoSection = document.getElementById('uploadArea');
        photoSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
        photoSection.classList.add('shake');
        setTimeout(() => photoSection.classList.remove('shake'), 500);
        return;
    }
    
    // Check delivery address if delivery option is selected
    const deliveryOption = document.querySelector('input[name="delivery_option"]:checked');
    console.log('🚚 Delivery option:', deliveryOption?.value);
    if (deliveryOption && deliveryOption.value === 'delivery') {
        const deliveryAddress = document.getElementById('delivery_address').value.trim();
        console.log('📍 Delivery address:', deliveryAddress);
        if (!deliveryAddress) {
            console.log('❌ VALIDASI GAGAL: Alamat pengiriman kosong');
            e.preventDefault();
            alert('Alamat pengiriman wajib diisi jika memilih opsi Diantar ke Rumah');
            const addressInput = document.getElementById('delivery_address');
            addressInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            addressInput.focus();
            addressInput.classList.add('shake');
            setTimeout(() => addressInput.classList.remove('shake'), 500);
            return;
        }
    }

    // Check pickup address if item entry option is pickup
    const itemEntryOption = document.querySelector('input[name="item_entry_option"]:checked');
    console.log('📦 Item entry option:', itemEntryOption?.value);
    if (itemEntryOption && itemEntryOption.value === 'pickup') {
        const pickupAddress = document.getElementById('pickup_address').value.trim();
        console.log('📍 Pickup address:', pickupAddress);
        if (!pickupAddress) {
            console.log('❌ VALIDASI GAGAL: Alamat penjemputan kosong');
            e.preventDefault();
            alert('Alamat penjemputan wajib diisi jika memilih opsi Dijemput');
            const addressInput = document.getElementById('pickup_address');
            addressInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            addressInput.focus();
            addressInput.classList.add('shake');
            setTimeout(() => addressInput.classList.remove('shake'), 500);
            return;
        }
    }
    
    // Add loading state to submit button
    const submitBtn = e.target.querySelector('button[type="submit"]');
    submitBtn.classList.add('loading');
    submitBtn.disabled = true;
    
    // Debug log - pastikan form akan submit
    console.log('✅✅✅ SEMUA VALIDASI LOLOS - Form akan disubmit! ✅✅✅');
    console.log('📤 Form action:', e.target.action);
    console.log('📤 Form method:', e.target.method);
    console.log('📤 Form data:', {
        service: selectedService?.value,
        quantity: document.getElementById('quantity')?.value,
        delivery_date: deliveryDate,
        booking_time: bookingTime,
        has_photo: shoePhoto.files.length > 0,
        item_entry_option: itemEntryOption?.value,
        delivery_option: deliveryOption?.value
    });
    console.log('🔄 Submitting... Cek Network tab untuk request "submit-booking"');
    
    // Form akan submit secara normal karena tidak ada preventDefault() di sini
});

// File upload handling
const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('shoe_photo');
const imagePreview = document.getElementById('imagePreview');
const previewImg = document.getElementById('previewImg');

fileInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Check file size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file maksimal 5 MB');
            fileInput.value = '';
            uploadArea.classList.add('shake');
            setTimeout(() => uploadArea.classList.remove('shake'), 500);
            return;
        }
        
        // Check file type
        if (!file.type.match('image/(png|jpeg|jpg)')) {
            alert('Format file harus PNG, JPG, atau JPEG');
            fileInput.value = '';
            uploadArea.classList.add('shake');
            setTimeout(() => uploadArea.classList.remove('shake'), 500);
            return;
        }
        
        // Show preview with animation
        const reader = new FileReader();
        reader.onload = function(event) {
            previewImg.src = event.target.result;
            uploadArea.style.display = 'none';
            imagePreview.classList.remove('hidden');
            imagePreview.classList.add('fade-in');
            imagePreview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

// Remove image
function removeImage() {
    fileInput.value = '';
    uploadArea.style.display = 'block';
    imagePreview.style.display = 'none';
    previewImg.src = '';
}

// Drag and drop
uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '#3b82f6';
    uploadArea.style.background = '#eff6ff';
});

uploadArea.addEventListener('dragleave', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '#e5e7eb';
    uploadArea.style.background = '#f9fafb';
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '#e5e7eb';
    uploadArea.style.background = '#f9fafb';
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        fileInput.dispatchEvent(new Event('change'));
    }
});

// Logout confirmation and API call
async function confirmLogout(e) {
    e.preventDefault();
    if (confirm('Apakah Anda yakin ingin logout?')) {
        try {
            console.log('🚀 Logging out via API...');
            const response = await fetch('/api/auth/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'include'
            });
            
            console.log('📊 Logout Response Status:', response.status);
            const result = await response.json();
            console.log('✅ Logout API Response:', result);
            
            window.location.href = '/';
        } catch (error) {
            console.error('❌ Logout error:', error);
            // Still redirect even if error
            window.location.href = '/';
        }
    }
}
</script>
<?= $this->endSection() ?>
