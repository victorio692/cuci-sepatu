<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 text-white py-20 md:py-32 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute transform rotate-45 -top-20 -right-20 w-96 h-96 bg-white rounded-full"></div>
        <div class="absolute transform -rotate-45 -bottom-20 -left-20 w-96 h-96 bg-white rounded-full"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <!-- Logo -->
            <div class="mb-8">
                <img src="/assets/images/SYH.CLEANING.png" alt="SYH Cleaning" class="w-32 h-32 mx-auto">
            </div>
            
            <!-- Title -->
            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Sepatu Bersih, Percaya Diri Maksimal
            </h1>
            
            <!-- Subtitle -->
            <p class="text-xl md:text-2xl mb-10 text-blue-100 max-w-3xl mx-auto">
                Layanan cuci sepatu profesional dengan hasil terbaik dan harga terjangkau.
            </p>
            
            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="/login" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 rounded-xl font-semibold text-lg hover:shadow-2xl transform hover:-translate-y-1 transition duration-300">
                    <i class="fas fa-shopping-cart mr-2"></i> Pesan Sekarang
                </a>
                <a href="#services" class="inline-flex items-center px-8 py-4 border-2 border-white text-white rounded-xl font-semibold text-lg hover:bg-white hover:text-blue-600 transition duration-300">
                    <i class="fas fa-info-circle mr-2"></i> Lihat Layanan
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-20 bg-white" id="services">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Title -->
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Layanan Kami</h2>
            <p class="text-xl text-gray-600">Pilih layanan terbaik untuk kebutuhan sepatu Anda</p>
        </div>
        
        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Fast Cleaning -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 p-8 border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-bolt text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Fast Cleaning</h3>
                <p class="text-gray-600 mb-6">Mencuci sepatu hanya bagian luarnya saja (outsole, midsole, upper).</p>
                <div class="text-3xl font-bold text-blue-600 mb-6">Rp 20.000</div>
                <button onclick="openBookingModal('fast-cleaning')" class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition duration-300">
                    Pesan
                </button>
            </div>
            
            <!-- Deep Cleaning -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 p-8 border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-400 to-cyan-600 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-water text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Deep Cleaning</h3>
                <p class="text-gray-600 mb-6">Mencuci sepatu secara keseluruhan (outsole, midsole, insole, upper).</p>
                <div class="text-3xl font-bold text-blue-600 mb-6">Rp 25.000</div>
                <button onclick="openBookingModal('deep-cleaning')" class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition duration-300">
                    Pesan
                </button>
            </div>
            
            <!-- White Shoes -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 p-8 border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-star text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">White Shoes</h3>
                <p class="text-gray-600 mb-6">Mencuci sepatu putih berbahan canvas secara keseluruhan agar tetap putih bersih.</p>
                <div class="text-3xl font-bold text-blue-600 mb-6">Rp 30.000</div>
                <button onclick="openBookingModal('white-shoes')" class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition duration-300">
                    Pesan
                </button>
            </div>
            
            <!-- Suede Treatment -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 p-8 border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Suede Treatment</h3>
                <p class="text-gray-600 mb-6">Mencuci sepatu berbahan suede secara keseluruhan</p>
                <div class="text-3xl font-bold text-blue-600 mb-6">Rp 30.000</div>
                <button onclick="openBookingModal('coating')" class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition duration-300">
                    Pesan
                </button>
            </div>
            
            <!-- Unyelowing -->
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition duration-300 p-8 border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-pink-400 to-pink-600 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-palette text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Unyelowing</h3>
                <p class="text-gray-600 mb-6">Membersihkan kembali mid sol sepatu yang menguning</p>
                <div class="text-3xl font-bold text-blue-600 mb-6">Rp 35.000</div>
                <button onclick="openBookingModal('dyeing')" class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition duration-300">
                    Pesan
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Why Us Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Title -->
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Mengapa Memilih Kami?</h2>
            <p class="text-xl text-gray-600">Kami berkomitmen memberikan layanan terbaik untuk kepuasan Anda</p>
        </div>
        
        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Professional -->
            <div class="bg-white rounded-xl p-8 text-center hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check-circle text-green-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Profesional</h3>
                <p class="text-gray-600">Berpengalaman dalam penanganan berbagai jenis sepatu.</p>
            </div>
            
            <!-- Trusted -->
            <div class="bg-white rounded-xl p-8 text-center hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-red-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Terpercaya</h3>
                <p class="text-gray-600">Banyak pelanggan puas telah mempercayai layanan kami selama bertahun-tahun.</p>
            </div>
            
            <!-- Free Delivery -->
            <div class="bg-white rounded-xl p-8 text-center hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-truck text-blue-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Pengiriman Gratis</h3>
                <p class="text-gray-600">Layanan antar-jemput gratis max 5km.</p>
            </div>
            
            <!-- Affordable -->
            <div class="bg-white rounded-xl p-8 text-center hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-rupiah-sign text-yellow-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Harga Terjangkau</h3>
                <p class="text-gray-600">Harga kompetitif dengan kualitas terbaik tanpa mengorbankan hasil.</p>
            </div>
            
            <!-- Fast & On Time -->
            <div class="bg-white rounded-xl p-8 text-center hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-purple-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Cepat & Tepat Waktu</h3>
                <p class="text-gray-600">Pengerjaan yang cepat tanpa mengorbankan kualitas, selalu tepat waktu.</p>
            </div>
            
            <!-- Customer Service -->
            <div class="bg-white rounded-xl p-8 text-center hover:shadow-xl transition duration-300">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-indigo-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Layanan Pelanggan</h3>
                <p class="text-gray-600">24/7 siap membantu menjawab semua pertanyaan Anda.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-blue-500 to-blue-600 py-20 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-6">Siap Membuat Sepatu Anda Bersih?</h2>
        <p class="text-xl mb-10 text-blue-100">
            Jangan tunggu lagi, pesan layanan cuci sepatu kami sekarang dan dapatkan diskon spesial!
        </p>
        <a href="/login" class="inline-block px-10 py-4 bg-white text-blue-600 rounded-xl font-bold text-lg hover:shadow-2xl transform hover:-translate-y-1 transition duration-300">
            Pesan Sekarang
        </a>
    </div>
</section>

<!-- Booking Modal -->
<div id="bookingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-8 relative animate-fade-in">
        <button onclick="closeModal('bookingModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <i class="fas fa-times text-2xl"></i>
        </button>
        
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Pesan Layanan</h2>
        <p class="text-gray-600 mb-6">Silakan login atau daftar terlebih dahulu untuk melakukan pemesanan.</p>
        
        <div class="flex gap-4">
            <a href="/login" class="flex-1 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold text-center hover:shadow-lg transition">Login</a>
            <a href="/register" class="flex-1 py-3 border-2 border-blue-600 text-blue-600 rounded-lg font-semibold text-center hover:bg-blue-50 transition">Daftar</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
function openBookingModal(service) {
    document.getElementById('bookingModal').classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

// Close modal on outside click
document.getElementById('bookingModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal('bookingModal');
    }
});
</script>
<?= $this->endSection() ?>
