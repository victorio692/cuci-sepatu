<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- Promo Banner Slider -->
<section class="bg-gray-50 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative rounded-xl overflow-hidden shadow-lg">
            <!-- Slider Container -->
            <div class="slider-container relative">
                <!-- Slides -->
                <div class="slides">
                    <!-- Slide 1 - Diskon Jumat 5K -->
                    <div class="slide active">
                        <div class="promo-banner banner-jumat">
                            <div class="banner-content">
                                <!-- Left Side - Icon Circle -->
                                <div class="banner-icon-circle">
                                    <div class="shoe-icon-wrapper">
                                        <i class="fas fa-shoe-prints"></i>
                                        <div class="bubbles">
                                            <span class="bubble"></span>
                                            <span class="bubble"></span>
                                            <span class="bubble"></span>
                                            <span class="bubble"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Center - Main Text -->
                                <div class="banner-main">
                                    <div class="discount-text">DISKON</div>
                                    <div class="discount-amount">5K</div>
                                </div>
                                
                                <!-- Divider -->
                                <div class="banner-divider"></div>
                                
                                <!-- Right - Description -->
                                <div class="banner-desc">
                                    <div class="desc-text">SEMUA</div>
                                    <div class="desc-text">LAYANAN</div>
                                    <div class="desc-text">SETIAP JUMAT</div>
                                </div>
                                
                                <!-- CTA Button -->
                                <div class="banner-cta">
                                    <a href="#services" class="cta-button">Booking Sekarang</a>
                                </div>
                                
                                <!-- Decorative Elements -->
                                <div class="deco-shoes">
                                    <i class="fas fa-shoe-prints deco-shoe" style="top: 10%; left: 75%; transform: rotate(-25deg);"></i>
                                    <i class="fas fa-shoe-prints deco-shoe" style="top: 60%; right: 15%; transform: rotate(15deg);"></i>
                                    <i class="fas fa-shoe-prints deco-shoe" style="bottom: 20%; left: 80%; transform: rotate(-40deg);"></i>
                                </div>
                                
                                <!-- Brand Text -->
                                <div class="brand-text">SYHCLEANING</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 2 - Gratis Ongkir -->
                    <div class="slide">
                        <div class="promo-banner banner-ongkir">
                            <div class="banner-content">
                                <!-- Left Side - Icon Circle -->
                                <div class="banner-icon-circle">
                                    <div class="shoe-icon-wrapper">
                                        <i class="fas fa-shoe-prints"></i>
                                        <div class="bubbles">
                                            <span class="bubble"></span>
                                            <span class="bubble"></span>
                                            <span class="bubble"></span>
                                            <span class="bubble"></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Center - Main Text -->
                                <div class="banner-main banner-main-ongkir">
                                    <div class="gratis-text">GRATIS</div>
                                    <div class="ongkir-text">ONGKIR</div>
                                    <!-- CTA Button inside red box -->
                                    <div class="banner-cta banner-cta-ongkir">
                                        <a href="#services" class="cta-button cta-button-red">Booking Sekarang</a>
                                    </div>
                                </div>
                                
                                <!-- Divider -->
                                <div class="banner-divider"></div>
                                
                                <!-- Right - Description -->
                                <div class="banner-desc">
                                    <div class="desc-text">SETIAP 2</div>
                                    <div class="desc-text">PASANG</div>
                                    <div class="desc-text">SEPATU</div>
                                </div>
                                
                                <!-- Decorative Elements -->
                                <div class="deco-shoes">
                                    <i class="fas fa-shoe-prints deco-shoe" style="top: 10%; left: 75%; transform: rotate(-25deg);"></i>
                                    <i class="fas fa-shoe-prints deco-shoe" style="top: 60%; right: 15%; transform: rotate(15deg);"></i>
                                    <i class="fas fa-shoe-prints deco-shoe" style="bottom: 20%; left: 80%; transform: rotate(-40deg);"></i>
                                </div>
                                
                                <!-- Brand Text -->
                                <div class="brand-text">SYHCLEANING</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <button onclick="changeSlide(-1)" class="slider-arrow left">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button onclick="changeSlide(1)" class="slider-arrow right">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <!-- Pagination Dots -->
                <div class="slider-pagination">
                    <span class="dot active" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Promo Banner Base Styles */
.promo-banner {
    position: relative;
    width: 100%;
    min-height: 250px;
    overflow: hidden;
    display: flex;
    align-items: center;
    padding: 20px;
}

.banner-jumat {
    background: #ffffff;
}

.banner-ongkir {
    background: #2563eb;
}

.banner-content {
    position: relative;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

/* Left Circle Icon */
.banner-icon-circle {
    position: relative;
    width: 140px;
    height: 140px;
    background: #2563eb;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    flex-shrink: 0;
}

.shoe-icon-wrapper {
    position: relative;
    z-index: 2;
}

.shoe-icon-wrapper i {
    font-size: 50px;
    color: white;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
}

/* Bubbles Animation */
.bubbles {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
}

.bubble {
    position: absolute;
    background: rgba(255, 255, 255, 0.4);
    border-radius: 50%;
    animation: float 3s infinite ease-in-out;
}

.bubble:nth-child(1) {
    width: 10px;
    height: 10px;
    top: 20%;
    left: 15%;
    animation-delay: 0s;
}

.bubble:nth-child(2) {
    width: 15px;
    height: 15px;
    top: 50%;
    left: 70%;
    animation-delay: 0.5s;
}

.bubble:nth-child(3) {
    width: 8px;
    height: 8px;
    top: 70%;
    left: 30%;
    animation-delay: 1s;
}

.bubble:nth-child(4) {
    width: 12px;
    height: 12px;
    top: 35%;
    left: 80%;
    animation-delay: 1.5s;
}

@keyframes float {
    0%, 100% { transform: translateY(0) scale(1); opacity: 0.6; }
    50% { transform: translateY(-10px) scale(1.1); opacity: 1; }
}

/* Promo Badge */
.promo-badge {
    position: absolute;
    top: 5px;
    left: 210px;
    background: #fbbf24;
    color: #1e3a8a;
    font-weight: 900;
    font-size: 11px;
    padding: 6px 14px;
    border-radius: 20px;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    z-index: 10;
}

/* Main Text Area */
.banner-main {
    flex: 0 0 auto;
    text-align: center;
    padding: 10px;
}

.discount-text {
    font-size: 42px;
    font-weight: 900;
    color: #2563eb;
    letter-spacing: 3px;
    line-height: 1;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.discount-amount {
    font-size: 120px;
    font-weight: 900;
    color: #2563eb;
    letter-spacing: -5px;
    line-height: 0.9;
    text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.15);
}

.banner-main-ongkir {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    margin-left: -80px;
}

.gratis-text, .ongkir-text {
    font-size: 56px;
    font-weight: 900;
    color: #fff;
    letter-spacing: 3px;
    line-height: 0.9;
    text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.5);
}

.banner-cta-ongkir {
    position: static;
    transform: none;
    margin-top: 5px;
}

/* Divider */
.banner-divider {
    width: 4px;
    height: 120px;
    background: white;
    border-radius: 2px;
    opacity: 0.8;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    flex-shrink: 0;
}

.banner-ongkir .banner-divider {
    background: rgba(255, 255, 255, 0.6);
}

/* Description Text */
.banner-desc {
    flex: 0 0 auto;
    text-align: left;
}

.banner-jumat .banner-desc {
    margin-right: 80px;
}

.banner-ongkir .banner-desc {
    margin-right: 80px;
}

.desc-text {
    font-size: 32px;
    font-weight: 900;
    color: white;
    line-height: 1.1;
    letter-spacing: 1px;
    text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
}

.banner-jumat .desc-text {
    color: #2563eb;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

/* CTA Button */
.banner-cta {
    position: absolute;
    bottom: 35px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 5;
}

.cta-button {
    display: inline-block;
    background: #fbbf24;
    color: #1e3a8a;
    font-weight: 900;
    font-size: 9px;
    padding: 6px 20px;
    border-radius: 15px;
    text-decoration: none;
    letter-spacing: 0.3px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
    text-transform: uppercase;
}

.cta-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.35);
}

.cta-button-red {
    background: #fbbf24;
    color: #dc2626;
}

/* Decorative Shoes */
.deco-shoes {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    pointer-events: none;
}

.deco-shoe {
    position: absolute;
    font-size: 40px;
    opacity: 0.15;
}

.banner-jumat .deco-shoe {
    color: #2563eb;
}

.banner-ongkir .deco-shoe {
    color: #fff;
}

/* Brand Text */
.brand-text {
    position: absolute;
    top: 20px;
    right: 30px;
    font-size: 28px;
    font-weight: 900;
    letter-spacing: 1px;
    opacity: 0.3;
}

.banner-jumat .brand-text {
    color: #2563eb;
}

.banner-ongkir .brand-text {
    color: #fff;
}

.brand-note {
    position: absolute;
    bottom: 20px;
    right: 30px;
    font-size: 12px;
    font-weight: 600;
    opacity: 0.6;
}

.banner-jumat .brand-note {
    color: #2563eb;
}

.banner-ongkir .brand-note {
    color: #fff;
}

/* Slider Base Styles */
.slider-container {
    position: relative;
    width: 100%;
}

.slides {
    position: relative;
    width: 100%;
}

.slide {
    display: none;
    width: 100%;
}

.slide.active {
    display: block;
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 12px 16px;
    cursor: pointer;
    border-radius: 50%;
    font-size: 18px;
    z-index: 10;
    transition: background 0.3s;
}

.slider-arrow:hover {
    background: rgba(0, 0, 0, 0.8);
}

.slider-arrow.left {
    left: 10px;
}

.slider-arrow.right {
    right: 10px;
}

.slider-pagination {
    position: absolute;
    bottom: 15px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
    z-index: 10;
}

.dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    cursor: pointer;
    transition: background 0.3s;
    border: 2px solid white;
}

.dot.active {
    background: white;
}

.dot:hover {
    background: rgba(255, 255, 255, 0.8);
}

/* Responsive Design */
@media (max-width: 768px) {
    .promo-banner {
        min-height: 180px;
        padding: 10px;
    }
    
    .banner-content {
        gap: 8px;
        justify-content: center;
    }
    
    .banner-icon-circle {
        width: 80px;
        height: 80px;
    }
    
    .shoe-icon-wrapper i {
        font-size: 28px;
    }
    
    .bubble:nth-child(1) {
        width: 6px;
        height: 6px;
    }
    
    .bubble:nth-child(2) {
        width: 8px;
        height: 8px;
    }
    
    .bubble:nth-child(3) {
        width: 5px;
        height: 5px;
    }
    
    .bubble:nth-child(4) {
        width: 7px;
        height: 7px;
    }
    
    .promo-badge {
        font-size: 7px;
        padding: 3px 8px;
        left: 95px;
        top: 3px;
    }
    
    .banner-main {
        padding: 5px;
    }
    
    .discount-text {
        font-size: 22px;
        letter-spacing: 1px;
    }
    
    .discount-amount {
        font-size: 55px;
        letter-spacing: -3px;
    }
    
    .gratis-text, .ongkir-text {
        font-size: 26px;
        letter-spacing: 1px;
    }
    
    .banner-main-ongkir {
        padding: 12px 20px;
        border-radius: 10px;
    }
    
    .banner-divider {
        width: 3px;
        height: 60px;
    }
    
    .banner-desc {
        padding: 0 5px;
    }
    
    .desc-text {
        font-size: 16px;
        letter-spacing: 0.5px;
    }
    
    .cta-button {
        font-size: 7px;
        padding: 5px 12px;
        border-radius: 10px;
    }
    
    .banner-cta {
        bottom: 20px;
        left: 50%;
    }
    
    .brand-text {
        font-size: 14px;
        right: 10px;
        top: 12px;
    }
    
    .brand-note {
        font-size: 8px;
        bottom: 12px;
        right: 10px;
    }
    
    .deco-shoe {
        font-size: 20px;
    }
    
    .slider-arrow {
        padding: 8px 10px;
        font-size: 14px;
    }
    
    .slider-arrow.left {
        left: 5px;
    }
    
    .slider-arrow.right {
        right: 5px;
    }
    
    .slider-pagination {
        bottom: 10px;
        gap: 6px;
    }
    
    .dot {
        width: 8px;
        height: 8px;
        border: 1px solid white;
    }
}

/* Extra Small Mobile (Portrait) */
@media (max-width: 480px) {
    .promo-banner {
        min-height: 150px;
        padding: 8px;
    }
    
    .banner-content {
        gap: 5px;
    }
    
    .banner-icon-circle {
        width: 65px;
        height: 65px;
    }
    
    .shoe-icon-wrapper i {
        font-size: 22px;
    }
    
    .promo-badge {
        font-size: 6px;
        padding: 2px 6px;
        left: 75px;
        top: 2px;
    }
    
    .discount-text {
        font-size: 18px;
        letter-spacing: 0.5px;
    }
    
    .discount-amount {
        font-size: 42px;
        letter-spacing: -2px;
    }
    
    .gratis-text, .ongkir-text {
        font-size: 20px;
        letter-spacing: 0.5px;
    }
    
    .banner-main-ongkir {
        padding: 8px 15px;
        border-radius: 8px;
    }
    
    .banner-divider {
        width: 2px;
        height: 45px;
    }
    
    .desc-text {
        font-size: 12px;
        letter-spacing: 0.3px;
    }
    
    .cta-button {
        font-size: 6px;
        padding: 4px 10px;
        border-radius: 8px;
    }
    
    .banner-cta {
        bottom: 15px;
        left: 50%;
    }
    
    .brand-text {
        font-size: 11px;
        right: 8px;
        top: 8px;
    }
    
    .brand-note {
        font-size: 6px;
        bottom: 8px;
        right: 8px;
    }
    
    .deco-shoe {
        font-size: 15px;
    }
    
    .slider-arrow {
        padding: 6px 8px;
        font-size: 12px;
    }
    
    .slider-arrow.left {
        left: 3px;
    }
    
    .slider-arrow.right {
        right: 3px;
    }
    
    .slider-pagination {
        bottom: 8px;
        gap: 5px;
    }
    
    .dot {
        width: 7px;
        height: 7px;
    }
}

/* Tablet */
@media (min-width: 769px) and (max-width: 1024px) {
    .promo-banner {
        min-height: 220px;
        padding: 18px;
    }
    
    .banner-icon-circle {
        width: 120px;
        height: 120px;
    }
    
    .shoe-icon-wrapper i {
        font-size: 42px;
    }
    
    .promo-badge {
        font-size: 10px;
        padding: 5px 12px;
        left: 145px;
    }
    
    .discount-text {
        font-size: 38px;
    }
    
    .discount-amount {
        font-size: 100px;
    }
    
    .gratis-text, .ongkir-text {
        font-size: 44px;
    }
    
    .banner-main-ongkir {
        padding: 18px 32px;
    }
    
    .banner-divider {
        height: 100px;
    }
    
    .desc-text {
        font-size: 28px;
    }
    
    .cta-button {
        font-size: 9px;
        padding: 7px 18px;
    }
    
    .banner-cta {
        bottom: 30px;
    }
    
    .brand-text {
        font-size: 24px;
    }
    
    .brand-note {
        font-size: 11px;
    }
    
    .deco-shoe {
        font-size: 35px;
    }
}
</style>

<script>
let slideIndex = 1;
let autoSlideTimer;

// Show initial slide
showSlide(slideIndex);

// Auto slide every 5 seconds
startAutoSlide();

function startAutoSlide() {
    autoSlideTimer = setInterval(() => {
        changeSlide(1);
    }, 5000);
}

function stopAutoSlide() {
    clearInterval(autoSlideTimer);
}

function changeSlide(n) {
    stopAutoSlide();
    showSlide(slideIndex += n);
    startAutoSlide();
}

function currentSlide(n) {
    stopAutoSlide();
    showSlide(slideIndex = n);
    startAutoSlide();
}

function showSlide(n) {
    let slides = document.getElementsByClassName("slide");
    let dots = document.getElementsByClassName("dot");
    
    if (n > slides.length) { slideIndex = 1 }
    if (n < 1) { slideIndex = slides.length }
    
    // Hide all slides
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove('active');
    }
    
    // Remove active from all dots
    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove('active');
    }
    
    // Show current slide and dot
    slides[slideIndex - 1].classList.add('active');
    dots[slideIndex - 1].classList.add('active');
}
</script>

<!-- Services Section - Shopee Style -->
<section class="py-6 bg-white" id="services">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Title -->
        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-900 mb-1">Layanan Kami</h2>
            <p class="text-sm text-gray-600">Pilihan Terbaik Untuk Perawatan Sepatu Anda</p>
        </div>
        
        <!-- Services Grid - Compact Shopee Style -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            <?php 
            // Icon mapping for different services
            $iconMap = [
                'fast-cleaning' => 'fa-bolt',
                'deep-cleaning' => 'fa-water',
                'white-shoes' => 'fa-star',
                'suede-treatment' => 'fa-shoe-prints',
                'unyellowing' => 'fa-magic',
            ];
            
            // Popular service (could be from DB in future)
            $popularServices = ['suede-treatment'];
            
            // Special border for white shoes
            $specialBorder = ['white-shoes'];
            
            // Loop through services from database
            foreach ($services ?? [] as $index => $service): 
                $serviceCode = $service['kode_layanan'];
                $serviceName = $service['nama_layanan'];
                $serviceDesc = $service['deskripsi'];
                $servicePrice = $service['harga_dasar'];
                $serviceDuration = $service['durasi_hari'];
                
                // Get icon or use default
                $icon = $iconMap[$serviceCode] ?? 'fa-shoe-prints';
                
                // Check if popular
                $isPopular = in_array($serviceCode, $popularServices);
                
                // Check if special border
                $borderClass = in_array($serviceCode, $specialBorder) ? 'border-blue-300' : 'border-gray-200';
                
                // Format price
                $priceFormatted = number_format($servicePrice / 1000, 0) . 'K';
                
                // Duration text
                $durationText = $serviceDuration == 1 ? '1 hari' : "1-{$serviceDuration} hari";
            ?>
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden border <?= $borderClass ?>">
                <div class="relative">
                    <div class="bg-blue-600 h-24 flex items-center justify-center">
                        <i class="fas <?= $icon ?> text-white text-3xl"></i>
                    </div>
                    <?php if ($isPopular): ?>
                    <div class="absolute top-1 left-1 bg-blue-600 text-white text-xs font-bold px-2 py-0.5 rounded">
                        POPULER
                    </div>
                    <?php endif; ?>
                </div>
                <div class="p-3">
                    <h3 class="text-sm font-bold text-gray-900 mb-1 truncate" title="<?= htmlspecialchars($serviceName) ?>"><?= htmlspecialchars($serviceName) ?></h3>
                    <p class="text-xs text-gray-500 mb-2 h-8 line-clamp-2" title="<?= htmlspecialchars($serviceDesc) ?>"><?= htmlspecialchars($serviceDesc) ?></p>
                    <div class="flex items-baseline space-x-1 mb-2">
                        <span class="text-base font-bold text-blue-600">Rp <?= $priceFormatted ?></span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                        <span>⏱️ <?= $durationText ?></span>
                    </div>
                    <div class="grid grid-cols-2 gap-1">
                        <button onclick="addToCartQuick('<?= $serviceCode ?>', '<?= htmlspecialchars($serviceName) ?>', <?= $servicePrice ?>)" class="block py-1.5 bg-blue-600 text-white text-center rounded text-xs font-semibold hover:bg-blue-700 transition" title="Tambah ke Keranjang">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                        <a href="/make-booking?service=<?= $serviceCode ?>" class="block py-1.5 bg-blue-600 text-white text-center rounded text-xs font-semibold hover:bg-blue-700 transition">
                            Booking
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php if (empty($services)): ?>
            <div class="col-span-full text-center py-12">
                <i class="fas fa-info-circle text-gray-400 text-4xl mb-3"></i>
                <p class="text-gray-500">Belum ada layanan tersedia.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Location Section -->
<section class="py-8 bg-gradient-to-br from-blue-50 to-white" id="lokasi">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Title -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                <i class="fas fa-map-marker-alt text-blue-600"></i>
                Lokasi Kami
            </h2>
            <p class="text-gray-600">Kunjungi toko kami atau gunakan layanan antar-jemput gratis</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            <!-- Map Container -->
            <div class="rounded-xl overflow-hidden shadow-lg order-2 md:order-1">
                <div class="w-full h-[400px] md:h-full md:min-h-[500px]">
                    <!-- Google Maps Street View - Jl. Didusun Ngentak, Bantul -->
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!4v1770261867506!6m8!1m7!1sz-AsQMYNh_MnEgWfJqMY2w!2m2!1d-7.908172796276689!2d110.3695127888999!3f260.2971299763088!4f-10.893995609548384!5f0.7820865974627469"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full h-full">
                    </iframe>
                </div>
            </div>

            <!-- Location Info -->
            <div class="space-y-3 md:space-y-4 order-1 md:order-2">
                <!-- Address Card -->
                <div class="bg-white p-4 md:p-6 rounded-xl shadow-lg hover:shadow-xl transition">
                    <div class="flex items-start space-x-3 md:space-x-4">
                        <div class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-blue-600 text-xl md:text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 mb-2 md:mb-3 text-base md:text-lg">Alamat</h3>
                            <p class="text-gray-700 text-xs md:text-sm leading-relaxed">
                                Jl. Paten RT04, Kelurahan Sumberagung<br>
                                Kecamatan Jetis, Kabupaten Bantul, Kota Yogyakarta<br>
                                Kode Pos 55781
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Hours Card -->
                <div class="bg-white p-4 md:p-6 rounded-xl shadow-lg hover:shadow-xl transition">
                    <div class="flex items-start space-x-3 md:space-x-4">
                        <div class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-clock text-blue-600 text-xl md:text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 mb-2 md:mb-3 text-base md:text-lg">Jam Operasional</h3>
                            <div class="text-xs md:text-sm text-gray-700 space-y-1">
                                <p>Setiap Hari: <span class="font-semibold">12:00 - 00:00</span></p>
                                <p class="text-green-600 font-semibold mt-2">Buka setiap hari!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="bg-white p-4 md:p-6 rounded-xl shadow-lg hover:shadow-xl transition">
                    <div class="flex items-start space-x-3 md:space-x-4">
                        <div class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-blue-600 text-xl md:text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 mb-2 md:mb-3 text-base md:text-lg">Hubungi Kami</h3>
                            <div class="space-y-1 md:space-y-2 mb-3 md:mb-4">
                                <div class="flex items-center space-x-2 text-xs md:text-sm text-gray-700">
                                    <i class="fab fa-whatsapp text-green-600"></i>
                                    <span>WhatsApp: 0898-5709-532</span>
                                </div>
                                <div class="flex items-center space-x-2 text-xs md:text-sm text-gray-700">
                                    <i class="fab fa-instagram text-pink-600"></i>
                                    <span>Instagram: @syh.cleaning</span>
                                </div>
                            </div>
                            <a href="https://wa.me/628985709532?text=Halo%20SYH%20Cleaning,%20saya%20ingin%20bertanya" target="_blank" class="inline-flex items-center justify-center space-x-2 bg-green-600 text-white py-2 md:py-2.5 px-4 rounded-lg text-sm md:text-base font-semibold hover:bg-green-700 transition shadow-md hover:shadow-lg w-full">
                                <i class="fab fa-whatsapp text-lg"></i>
                                <span>Chat WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Area Info -->
        <div class="mt-4 md:mt-6 bg-gradient-to-r from-blue-600 to-blue-500 rounded-xl shadow-lg p-4 md:p-6 text-white">
            <div class="flex flex-col md:flex-row items-center justify-between gap-3 md:gap-4">
                <div class="flex items-center space-x-3 md:space-x-4 w-full md:w-auto">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-truck text-xl md:text-2xl"></i>
                    </div>
                    <div class="flex-1 md:flex-initial">
                        <h3 class="font-bold text-base md:text-lg">Layanan Antar-Jemput GRATIS</h3>
                        <p class="text-blue-100 text-xs md:text-sm">Untuk radius 5 km dari lokasi toko kami</p>
                    </div>
                </div>
                <a href="/#services" class="bg-white text-blue-600 px-6 py-2.5 md:py-3 rounded-lg font-bold hover:bg-blue-50 transition shadow-md text-sm md:text-base w-full md:w-auto text-center">
                    Booking Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Banner - Compact -->
<section class="py-4 bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div>
                    <div class="font-semibold text-xs text-gray-900">Profesional</div>
                    <div class="text-xs text-gray-500">Berpengalaman</div>
                </div>
            </div>
            
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-truck text-blue-600"></i>
                </div>
                <div>
                    <div class="font-semibold text-xs text-gray-900">Gratis Antar</div>
                    <div class="text-xs text-gray-500">Radius 5km</div>
                </div>
            </div>
            
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-tags text-yellow-600"></i>
                </div>
                <div>
                    <div class="font-semibold text-xs text-gray-900">Harga Murah</div>
                    <div class="text-xs text-gray-500">Terjangkau</div>
                </div>
            </div>
            
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-clock text-purple-600"></i>
                </div>
                <div>
                    <div class="font-semibold text-xs text-gray-900">Cepat</div>
                    <div class="text-xs text-gray-500">1-3 hari</div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Quick add to cart function
function addToCartQuick(serviceCode, serviceName, price) {
    // Check if user is logged in
    <?php if (!session()->get('user_id')): ?>
        alert('Silakan login terlebih dahulu untuk menambahkan ke keranjang');
        window.location.href = '/login';
        return;
    <?php endif; ?>
    
    // Create simple cart item
    const cartItem = {
        service_code: serviceCode,
        service_name: serviceName,
        price: price,
        quantity: 1,
        timestamp: Date.now()
    };
    
    // Get cart key for current user
    const getCartKey = () => {
        <?php if (session()->get('user_id')): ?>
            return 'cart_user_<?= session()->get('user_id') ?>';
        <?php else: ?>
            return 'cart_guest';
        <?php endif; ?>
    };
    
    // Get existing cart from localStorage
    let cart = JSON.parse(localStorage.getItem(getCartKey()) || '[]');
    
    // Check if item already exists
    const existingIndex = cart.findIndex(item => item.service_code === serviceCode);
    if (existingIndex > -1) {
        cart[existingIndex].quantity += 1;
    } else {
        cart.push(cartItem);
    }
    
    // Save to localStorage
    localStorage.setItem(getCartKey(), JSON.stringify(cart));
    
    // Calculate total items for notification
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    
    // Update cart badge with animation
    if (typeof updateCartBadge === 'function') {
        updateCartBadge(true); // Pass true to enable animation
    }
    
    // Show enhanced notification
    showCartNotification(serviceName, totalItems);
}

// Show enhanced cart notification
function showCartNotification(serviceName, totalItems) {
    // Remove existing notification if any
    const existingNotif = document.querySelector('.cart-notification-popup');
    if (existingNotif) existingNotif.remove();
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'cart-notification-popup fixed bottom-4 right-4 bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-4 rounded-xl shadow-2xl z-[9999] max-w-sm animate-slide-up';
    notification.innerHTML = `
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0 w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center animate-bounce-once">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
            <div class="flex-1">
                <div class="font-bold text-lg mb-1">✓ Berhasil Ditambahkan!</div>
                <div class="text-sm opacity-90 mb-2">${serviceName}</div>
                <div class="flex items-center justify-between">
                    <span class="text-xs bg-white bg-opacity-20 px-3 py-1 rounded-full">
                        <i class="fas fa-shopping-cart mr-1"></i>
                        ${totalItems} item di keranjang
                    </span>
                    <a href="/cart" class="text-xs font-semibold underline hover:no-underline">
                        Lihat Keranjang →
                    </a>
                </div>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-white opacity-70 hover:opacity-100 transition-opacity">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="notification-progress"></div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 4 seconds with progress bar
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

// Initialize cart badge on page load
document.addEventListener('DOMContentLoaded', function() {
    if (typeof updateCartBadge === 'function') {
        updateCartBadge();
    }
});
</script>

<style>
/* Slide up animation */
@keyframes slide-up {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.animate-slide-up {
    animation: slide-up 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    transition: all 0.3s ease;
}

/* Cart badge bounce animation */
@keyframes cartBounce {
    0%, 100% { transform: scale(1); }
    25% { transform: scale(1.3) rotate(-5deg); }
    50% { transform: scale(0.9) rotate(5deg); }
    75% { transform: scale(1.2) rotate(-3deg); }
}

/* Bounce once animation */
@keyframes bounce-once {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

.animate-bounce-once {
    animation: bounce-once 0.6s ease;
}

/* Notification progress bar */
.notification-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: rgba(255, 255, 255, 0.3);
    width: 100%;
    border-radius: 0 0 12px 12px;
    animation: progressBar 4s linear;
}

@keyframes progressBar {
    from { width: 100%; }
    to { width: 0%; }
}

/* Responsive notification */
@media (max-width: 640px) {
    .cart-notification-popup {
        bottom: 1rem;
        right: 1rem;
        left: 1rem;
        max-width: none;
    }
}
</style>

<?= $this->endSection() ?>