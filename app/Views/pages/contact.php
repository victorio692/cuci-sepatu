<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- Contact Section -->
<section class="py-12 bg-gradient-to-br from-blue-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Hubungi Kami</h1>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-600 to-blue-400 mx-auto mb-6"></div>
                <p class="text-lg md:text-xl text-gray-700">
                    Punya pertanyaan? Hubungi kami melalui berbagai saluran komunikasi yang tersedia.
                </p>
            </div>

            <!-- Contact Cards Grid -->
            <div class="grid md:grid-cols-3 gap-6 mb-12">
                <!-- Lokasi Card -->
                <div class="group bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-3 transition-all duration-300 border border-gray-100 hover:border-blue-300 cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mb-4 shadow-lg group-hover:scale-110 transition-transform duration-300 mx-auto">
                        <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center group-hover:text-blue-600 transition-colors">Lokasi</h3>
                    <p class="text-gray-600 text-center text-sm leading-relaxed">
                        Desa Paten RT04, Sumberaguung, Jetis, Bantul
                    </p>
                </div>

                <!-- Telepon Card -->
                <div class="group bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-3 transition-all duration-300 border border-gray-100 hover:border-green-300 cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mb-4 shadow-lg group-hover:scale-110 transition-transform duration-300 mx-auto">
                        <i class="fas fa-phone text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center group-hover:text-green-600 transition-colors">Telepon</h3>
                    <p class="text-center">
                        <a href="tel:+628985709532" class="text-gray-600 hover:text-green-600 transition-colors text-sm font-semibold">
                            0898-5709-532
                        </a>
                    </p>
                </div>

                <!-- Email Card -->
                <div class="group bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-3 transition-all duration-300 border border-gray-100 hover:border-red-300 cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center mb-4 shadow-lg group-hover:scale-110 transition-transform duration-300 mx-auto">
                        <i class="fas fa-envelope text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center group-hover:text-red-600 transition-colors">Email</h3>
                    <p class="text-center">
                        <a href="mailto:syhhcleaning@gmail.com" class="text-gray-600 hover:text-red-600 transition-colors text-sm font-semibold break-all">
                            syhhcleaning@gmail.com
                        </a>
                    </p>
                </div>
            </div>

            <!-- Info Grid -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <!-- Jam Operasional -->
                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-clock text-blue-600 text-lg"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Jam Operasional</h3>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">Setiap Hari</span>
                            <span class="font-bold text-gray-900">12:00 - 00:00</span>
                        </div>
                        <p class="text-sm text-green-600 font-semibold pt-2">
                            <i class="fas fa-check-circle mr-1"></i>Buka setiap hari!
                        </p>
                    </div>
                </div>

                <!-- Media Sosial -->
                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-share-alt text-pink-600 text-lg"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Media Sosial</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="https://instagram.com/syh.cleaning" target="_blank" class="flex items-center justify-center space-x-2 bg-gradient-to-br from-purple-600 via-pink-500 to-orange-400 text-white py-3 px-4 rounded-xl font-semibold hover:from-purple-700 hover:via-pink-600 hover:to-orange-500 transform hover:scale-105 transition-all duration-300 shadow-md hover:shadow-lg">
                            <i class="fab fa-instagram text-lg"></i>
                            <span class="text-sm">Instagram</span>
                        </a>
                        <a href="https://wa.me/628985709532" target="_blank" class="flex items-center justify-center space-x-2 bg-green-600 text-white py-3 px-4 rounded-xl font-semibold hover:bg-green-700 transform hover:scale-105 transition-all duration-300 shadow-md hover:shadow-lg">
                            <i class="fab fa-whatsapp text-lg"></i>
                            <span class="text-sm">WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 rounded-2xl shadow-xl p-8 text-white text-center hover:shadow-2xl transform hover:scale-[1.02] transition-all duration-300">
                <h3 class="text-2xl font-bold mb-3">Siap untuk sepatu bersih dan rapi?</h3>
                <p class="text-blue-100 mb-6">Hubungi kami sekarang atau langsung pesan layanan kami!</p>
                <a href="/#services" class="inline-flex items-center space-x-2 bg-white text-blue-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-blue-50 transform hover:scale-105 transition-all duration-300 shadow-lg">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Booking Sekarang</span>
                </a>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
