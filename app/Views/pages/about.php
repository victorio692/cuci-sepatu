<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- About Section -->
<section class="py-12 bg-gradient-to-br from-blue-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Tentang SYH Cleaning</h1>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-600 to-blue-400 mx-auto mb-6"></div>
                <p class="text-lg md:text-xl text-gray-700 leading-relaxed">
                    SYH Cleaning adalah layanan cuci sepatu profesional yang berdedikasi memberikan 
                    hasil terbaik dengan harga terjangkau. Kami memahami bahwa sepatu adalah bagian penting dari penampilan Anda, 
                    dan kami berkomitmen untuk menjaganya tetap bersih dan rapi.
                </p>
            </div>

            <!-- Info Cards Grid -->
            <div class="grid md:grid-cols-2 gap-6 mb-12">
                <!-- Sejak 2025 Card -->
                <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-3 transition-all duration-300 border border-gray-100 hover:border-blue-300 cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-history text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">Sejak 2025</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Kami telah melayani ratusan pelanggan, dan berbagai sepatu dengan hasil memuaskan.
                    </p>
                </div>

                <!-- Kualitas Terjamin Card -->
                <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-3 transition-all duration-300 border border-gray-100 hover:border-blue-300 cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-award text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">Kualitas Terjamin</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Menggunakan bahan dan teknik terbaik untuk hasil maksimal. Kalau customer tidak puas kami jamin uang kembali.
                    </p>
                </div>
            </div>

            <!-- Why Choose Us Section -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 rounded-2xl shadow-xl p-8 md:p-10 text-white hover:shadow-2xl transform hover:scale-[1.02] transition-all duration-300">
                <h2 class="text-3xl font-bold mb-6 text-center">Kenapa Memilih SYH Cleaning?</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center group cursor-pointer">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-white/30 group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-star text-2xl"></i>
                        </div>
                        <h4 class="font-bold mb-2">Profesional</h4>
                        <p class="text-blue-100 text-sm">Tim berpengalaman & terlatih</p>
                    </div>
                    <div class="text-center group cursor-pointer">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-white/30 group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-truck text-2xl"></i>
                        </div>
                        <h4 class="font-bold mb-2">Gratis Antar-Jemput</h4>
                        <p class="text-blue-100 text-sm">Radius 5 km dari toko</p>
                    </div>
                    <div class="text-center group cursor-pointer">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-white/30 group-hover:scale-110 transition-all duration-300">
                            <i class="fas fa-tags text-2xl"></i>
                        </div>
                        <h4 class="font-bold mb-2">Harga Terjangkau</h4>
                        <p class="text-blue-100 text-sm">Mulai dari Rp 20.000</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="text-center mt-12">
                <a href="/#services" class="inline-flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white px-8 py-4 rounded-xl font-bold text-lg hover:from-blue-700 hover:to-blue-600 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Booking Sekarang</span>
                </a>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
