<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- FAQ Page -->
<div class="min-h-screen bg-gray-50 pt-20 pb-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-3">
                <i class="fas fa-question-circle text-blue-600"></i>
                Pertanyaan yang Sering Diajukan
            </h1>
            <p class="text-gray-600">Temukan jawaban untuk pertanyaan umum tentang layanan kami</p>
        </div>

        <!-- FAQ Sections -->
        <div class="space-y-4">
            
            <!-- Tentang Layanan -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors" onclick="toggleFAQ('faq1')">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-spray-can text-blue-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Apa saja layanan yang tersedia?</h3>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" id="icon-faq1"></i>
                </button>
                <div id="faq1" class="hidden px-6 pb-4 text-gray-600">
                    <p class="pl-13">Kami menyediakan berbagai layanan cleaning sepatu termasuk:</p>
                    <ul class="pl-13 mt-2 space-y-1">
                        <li>• <strong>Fast Cleaning</strong> - Pembersihan cepat untuk sepatu kotor ringan</li>
                        <li>• <strong>Deep Cleaning</strong> - Pembersihan menyeluruh untuk sepatu yang sangat kotor</li>
                        <li>• <strong>White Shoes</strong> - Perawatan khusus untuk sepatu putih</li>
                        <li>• <strong>Suede Treatment</strong> - Perawatan khusus untuk material suede</li>
                        <li>• <strong>Unyelowing</strong> - Menghilangkan warna kuning pada midsole</li>
                    </ul>
                </div>
            </div>

            <!-- Waktu Pengerjaan -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors" onclick="toggleFAQ('faq2')">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-green-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Berapa lama waktu pengerjaan?</h3>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" id="icon-faq2"></i>
                </button>
                <div id="faq2" class="hidden px-6 pb-4 text-gray-600">
                    <p class="pl-13">Waktu pengerjaan bervariasi tergantung jenis layanan:</p>
                    <ul class="pl-13 mt-2 space-y-1">
                        <li>• <strong>Fast Cleaning:</strong> 1-2 hari kerja</li>
                        <li>• <strong>Deep Cleaning:</strong> 1-2 hari kerja</li>
                        <li>• <strong>White Shoes:</strong> 1-2 hari kerja</li>
                        <li>• <strong>Suede Treatment:</strong> 1-2 hari kerja</li>
                        <li>• <strong>Unyelowing:</strong> 3-3 hari kerja</li>
                    </ul>
                    <p class="pl-13 mt-2 text-sm italic">*Waktu dapat berubah tergantung kondisi sepatu dan antrian pesanan</p>
                </div>
            </div>

            <!-- Cara Booking -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors" onclick="toggleFAQ('faq3')">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-check text-purple-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Bagaimana cara melakukan booking?</h3>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" id="icon-faq3"></i>
                </button>
                <div id="faq3" class="hidden px-6 pb-4 text-gray-600">
                    <p class="pl-13">Anda dapat melakukan booking dengan mudah:</p>
                    <ol class="pl-13 mt-2 space-y-2">
                        <li>1. Pilih menu <strong>Layanan</strong> dan pilih jenis layanan yang diinginkan</li>
                        <li>2. Klik tombol <strong>Booking Sekarang</strong></li>
                        <li>3. Isi form booking dengan detail lengkap</li>
                        <li>4. Pilih tanggal pengambilan yang tersedia</li>
                        <li>5. Submit booking dan tunggu konfirmasi dari kami</li>
                    </ol>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors" onclick="toggleFAQ('faq4')">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-credit-card text-blue-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Metode pembayaran apa saja yang tersedia?</h3>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" id="icon-faq4"></i>
                </button>
                <div id="faq4" class="hidden px-6 pb-4 text-gray-600">
                    <p class="pl-13">Kami menerima berbagai metode pembayaran:</p>
                    <ul class="pl-13 mt-2 space-y-1">
                        <li>• Transfer Bank (BCA, Mandiri, BNI, BRI)</li>
                        <li>• E-Wallet (GoPay, OVO, Dana, ShopeePay)</li>
                        <li>• QRIS</li>
                        <li>• Cash saat pengambilan (untuk area tertentu)</li>
                    </ul>
                    <p class="pl-13 mt-2 text-sm italic">*Pembayaran dapat dilakukan saat admin ngabarin kalau sepatunya sudah jadi dan akan di wa oleh admin</p>
                </div>
            </div>

            <!-- Area Layanan -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors" onclick="toggleFAQ('faq5')">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-red-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Apakah ada layanan antar jemput?</h3>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" id="icon-faq5"></i>
                </button>
                <div id="faq5" class="hidden px-6 pb-4 text-gray-600">
                    <p class="pl-13">Ya, kami menyediakan layanan antar jemput untuk area:</p>
                    <ul class="pl-13 mt-2 space-y-1">
                        <li>• Sumberagung</li>
                        <li>• Jetis</li>
                        <li>• Bantul dan sekitarnya</li>
                    </ul>
                    <p class="pl-13 mt-2">Untuk area lain, silakan hubungi kami untuk informasi lebih lanjut.</p>
                </div>
            </div>

            <!-- Garansi -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors" onclick="toggleFAQ('faq6')">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-shield-alt text-teal-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Apakah ada garansi untuk layanan?</h3>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" id="icon-faq6"></i>
                </button>
                <div id="faq6" class="hidden px-6 pb-4 text-gray-600">
                    <p class="pl-13">Ya, kami memberikan garansi untuk setiap layanan:</p>
                    <ul class="pl-13 mt-2 space-y-1">
                        <li>• Garansi cuci ulang jika hasil kurang memuaskan</li>
                        <li>• Jaminan kualitas material dan warna tidak rusak</li>
                        <li>• Kompensasi jika terjadi kerusakan akibat kesalahan proses</li>
                    </ul>
                    <p class="pl-13 mt-2 text-sm italic">*Syarat dan ketentuan berlaku</p>
                </div>
            </div>

            <!-- Pembatalan -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors" onclick="toggleFAQ('faq7')">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-times-circle text-yellow-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Bagaimana jika ingin membatalkan booking?</h3>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" id="icon-faq7"></i>
                </button>
                <div id="faq7" class="hidden px-6 pb-4 text-gray-600">
                    <p class="pl-13">Pembatalan booking dapat dilakukan dengan ketentuan:</p>
                    <ul class="pl-13 mt-2 space-y-1">
                        <li>• Pembatalan gratis jika dilakukan sebelum booking dikonfirmasi</li>
                        <li>• Pembatalan setelah dikonfirmasi akan dikenakan biaya admin 10%</li>
                        <li>• Tidak dapat dibatalkan jika sepatu sudah dalam proses pengerjaan</li>
                    </ul>
                    <p class="pl-13 mt-2">Untuk membatalkan, hubungi customer service atau batalkan melalui halaman <strong>Pesanan Saya</strong>.</p>
                </div>
            </div>

            <!-- Kontak -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <button class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors" onclick="toggleFAQ('faq8')">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-phone text-indigo-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Bagaimana cara menghubungi customer service?</h3>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform" id="icon-faq8"></i>
                </button>
                <div id="faq8" class="hidden px-6 pb-4 text-gray-600">
                    <p class="pl-13">Anda dapat menghubungi kami melalui:</p>
                    <ul class="pl-13 mt-2 space-y-1">
                        <li>• <strong>WhatsApp:</strong> 08985709532</li>
                        <li>• <strong>Email:</strong> syhhcleaning@gmail.com</li>
                        <li>• <strong>Instagram:</strong> @syhcleaning</li>
                    </ul>
                    <p class="pl-13 mt-2">Atau kunjungi halaman <a href="/kontak" class="text-blue-600 hover:underline">Hubungi Kami</a> untuk mengirim pesan langsung.</p>
                </div>
            </div>

        </div>

        <!-- CTA Section -->
        <div class="mt-8 bg-blue-600 rounded-2xl p-6 text-center text-white">
            <h3 class="text-xl font-bold mb-2">Masih Ada Pertanyaan?</h3>
            <p class="mb-4">Jangan ragu untuk menghubungi kami. Tim kami siap membantu Anda!</p>
            <a href="/kontak" class="inline-block bg-white text-blue-600 font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-phone-alt mr-2"></i>
                Hubungi Kami
            </a>
        </div>

    </div>
</div>

<script>
function toggleFAQ(id) {
    const content = document.getElementById(id);
    const icon = document.getElementById('icon-' + id);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>

<?= $this->endSection() ?>
