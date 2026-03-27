<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- Promo Banner Slider -->
<section class="bg-gray-50 py-6 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative rounded-lg md:rounded-xl overflow-hidden shadow-sm md:shadow-lg">
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
                                    <a href="#services" class="cta-button">Pesan Sekarang</a>
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
                                        <a href="#services" class="cta-button cta-button-red">Pesan Sekarang</a>
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
    font-weight: 700;
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
    font-weight: 700;
    color: #2563eb;
    letter-spacing: 3px;
    line-height: 1;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.discount-amount {
    font-size: 120px;
    font-weight: 700;
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
    font-weight: 700;
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
    font-weight: 700;
    color: white;
    line-height: 1.1;
    letter-spacing: 1px;
    text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
    margin: 0;
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
    font-weight: 700;
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
    font-weight: 700;
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

/* Responsive Design - Tablet */
@media (max-width: 768px) {
    .promo-banner {
        min-height: 200px;
        padding: 12px 8px 16px 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .banner-content {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 4px;
        width: 100%;
        flex-wrap: nowrap;
        justify-content: space-between;
        padding: 0 40px;
    }
    
    .banner-icon-circle {
        width: 80px;
        height: 80px;
        flex-shrink: 0;
    }
    
    .shoe-icon-wrapper i {
        font-size: 32px;
    }
    
    .bubbles {
        display: none !important;
    }
    
    .bubble:nth-child(1) {
        width: 4px;
        height: 4px;
    }
    
    .bubble:nth-child(2) {
        width: 6px;
        height: 6px;
    }
    
    .bubble:nth-child(3) {
        width: 4px;
        height: 4px;
    }
    
    .bubble:nth-child(4) {
        width: 5px;
        height: 5px;
    }
    
    .promo-badge {
        display: none !important;
    }
    
    .banner-main {
        padding: 0;
        flex: 0 0 auto;
    }
    
    .discount-text {
        font-size: 16px;
        letter-spacing: 0.5px;
        line-height: 0.8;
        margin: 0;
    }
    
    .discount-amount {
        font-size: 48px;
        letter-spacing: -2px;
        line-height: 0.8;
        margin: 0;
    }
    
    .gratis-text, .ongkir-text {
        font-size: 24px;
        letter-spacing: 0.3px;
        line-height: 0.85;
        margin: 0;
        white-space: nowrap;
    }
    
    .banner-main-ongkir {
        padding: 4px 8px;
        border-radius: 8px;
        gap: 2px;
        margin-left: 0;
    }
    
    .banner-divider {
        width: 2px;
        height: 60px;
        flex-shrink: 0;
        margin: 0 2px;
    }
    
    .banner-desc {
        padding: 0;
        flex: 0 0 auto;
        min-width: 0;
        margin-left: 0;
        text-align: right;
    }
    
    .banner-jumat .banner-desc {
        margin-right: 0 !important;
    }
    
    .banner-ongkir .banner-desc {
        margin-right: 0 !important;
    }
    
    .desc-text {
        font-size: 14px;
        letter-spacing: 0.2px;
        line-height: 1.1;
        margin: 0;
        word-break: break-word;
        word-wrap: break-word;
        white-space: normal;
    }
    
    .cta-button {
        font-size: 7px;
        padding: 4px 10px;
        border-radius: 8px;
        white-space: nowrap;
    }
    
    .banner-cta {
        position: absolute;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .brand-text {
        display: none !important;
    }
    
    .brand-note {
        display: none !important;
    }
    
    .deco-shoes {
        display: none !important;
    }
    
    .deco-shoe {
        display: none !important;
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
        bottom: 6px;
        gap: 5px;
    }
    
    .dot {
        width: 6px;
        height: 6px;
        border: 1px solid white;
    }
}

/* Extra Small Mobile (Portrait) */
@media (max-width: 480px) {
    .promo-banner {
        min-height: 130px;
        padding: 8px 4px 12px 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .banner-content {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 2px;
        width: 100%;
        flex-wrap: nowrap;
        justify-content: space-between;
        padding: 0 70px;
    }
    
    .banner-icon-circle {
        width: 70px;
        height: 70px;
        flex-shrink: 0;
    }
    
    .shoe-icon-wrapper i {
        font-size: 28px;
    }
    
    .bubbles {
        display: none !important;
    }
    
    .promo-badge {
        display: none !important;
    }
    
    .banner-main {
        padding: 0;
        flex: 0 0 auto;
    }
    
    .discount-text {
        font-size: 14px;
        letter-spacing: 0.3px;
        line-height: 0.95;
        margin: 0;
    }
    
    .discount-amount {
        font-size: 32px;
        letter-spacing: -1px;
        line-height: 1;
        margin: 0;
    }
    
    .gratis-text, .ongkir-text {
        font-size: 20px;
        letter-spacing: 0.2px;
        line-height: 1.1;
        margin: 0;
        white-space: nowrap;
    }
    
    .banner-main-ongkir {
        padding: 1px 3px;
        border-radius: 4px;
        gap: 0;
        margin-left: 0;
    }
    
    .banner-divider {
        width: 1px;
        height: 35px;
        flex-shrink: 0;
        margin: 0 1px;
    }
    
    .banner-desc {
        padding: 0;
        flex: 0 0 auto;
        min-width: 0;
        overflow: hidden;
        margin-left: 0;
        text-align: right;
    }
    
    .banner-jumat .banner-desc {
        margin-right: 0 !important;
    }
    
    .banner-ongkir .banner-desc {
        margin-right: 0 !important;
    }
    
    .desc-text {
        font-size: 13px;
        letter-spacing: 0.1px;
        line-height: 1.3;
        margin: 0;
        word-break: break-word;
        word-wrap: break-word;
        white-space: normal;
    }
    
    .cta-button {
        font-size: 7px;
        padding: 4px 10px;
        border-radius: 6px;
        white-space: nowrap;
    }
    
    .banner-cta {
        position: absolute;
        bottom: -16px;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .brand-text {
        display: none !important;
    }
    
    .brand-note {
        display: none !important;
    }
    
    .deco-shoes {
        display: none !important;
    }
    
    .deco-shoe {
        display: none !important;
    }
    
    .slider-arrow {
        padding: 5px 6px;
        font-size: 10px;
    }
    
    .slider-arrow.left {
        left: 2px;
    }
    
    .slider-arrow.right {
        right: 2px;
    }
    
    .slider-pagination {
        bottom: 4px;
        gap: 4px;
    }
    
    .dot {
        width: 5px;
        height: 5px;
        border: none;
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
        
        <!-- Services Grid - 4 Columns for Main Services -->
        <div id="servicesGrid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            <!-- Loading State -->
            <div class="col-span-full text-center py-12">
                <i class="fas fa-spinner fa-spin text-blue-600 text-4xl mb-3"></i>
                <p class="text-gray-500">Memuat layanan...</p>
            </div>
        </div>

        <!-- More Services Grid (Initially Hidden) -->
        <div id="moreServicesExpandedGrid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mt-3 hidden"></div>

        <!-- More Services Button -->
        <div id="moreServicesButtonContainer" class="text-center mt-6"></div>
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
                            <a href="https://wa.me/628985709532?text=Halo%20SYH%20Cleaning,%20saya%20ingin%20bertanya" target="_blank" class="inline-flex items-center justify-center space-x-2 bg-green-600 text-white py-2 md:py-2.5 px-4 rounded-lg text-sm md:text-base font-semibold transition shadow-md hover:shadow-lg w-full whatsapp-button">
                                <i class="fab fa-whatsapp text-lg"></i>
                                <span>Chat WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Keunggulan Kami Section -->
<section class="py-4 md:py-8 bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <h2 class="text-lg md:text-2xl font-bold text-gray-900 mb-3 md:mb-6 text-center">Keunggulan Kami</h2>
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4">
            <div class="group bg-gradient-to-br from-gray-50 to-white p-3 md:p-5 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 cursor-pointer flex flex-col sm:flex-row sm:items-center gap-2 md:gap-4">
                <div class="w-12 md:w-14 h-12 md:h-14 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform mx-auto sm:mx-0">
                    <i class="fas fa-check-circle text-green-600 text-xl md:text-2xl"></i>
                </div>
                <div class="flex-1 flex flex-col items-center sm:items-start">
                    <div class="font-semibold text-sm md:text-sm text-gray-900">Profesional</div>
                    <div class="text-xs md:text-xs text-gray-600">Berpengalaman</div>
                </div>
            </div>
            
            <div class="group bg-gradient-to-br from-gray-50 to-white p-3 md:p-5 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 cursor-pointer flex flex-col sm:flex-row sm:items-center gap-2 md:gap-4">
                <div class="w-12 md:w-14 h-12 md:h-14 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform mx-auto sm:mx-0">
                    <i class="fas fa-truck text-blue-600 text-xl md:text-2xl"></i>
                </div>
                <div class="flex-1 flex flex-col items-center sm:items-start">
                    <div class="font-semibold text-sm md:text-sm text-gray-900">Gratis Antar</div>
                    <div class="text-xs md:text-xs text-gray-600">Radius 5km</div>
                </div>
            </div>
            
            <div class="group bg-gradient-to-br from-gray-50 to-white p-3 md:p-5 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 cursor-pointer flex flex-col sm:flex-row sm:items-center gap-2 md:gap-4">
                <div class="w-12 md:w-14 h-12 md:h-14 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform mx-auto sm:mx-0">
                    <i class="fas fa-tags text-yellow-600 text-xl md:text-2xl"></i>
                </div>
                <div class="flex-1 flex flex-col items-center sm:items-start">
                    <div class="font-semibold text-sm md:text-sm text-gray-900">Harga Murah</div>
                    <div class="text-xs md:text-xs text-gray-600">Terjangkau</div>
                </div>
            </div>
            
            <div class="group bg-gradient-to-br from-gray-50 to-white p-3 md:p-5 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 cursor-pointer flex flex-col sm:flex-row sm:items-center gap-2 md:gap-4">
                <div class="w-12 md:w-14 h-12 md:h-14 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform mx-auto sm:mx-0">
                    <i class="fas fa-clock text-purple-600 text-xl md:text-2xl"></i>
                </div>
                <div class="flex-1 flex flex-col items-center sm:items-start">
                    <div class="font-semibold text-sm md:text-sm text-gray-900">Cepat</div>
                    <div class="text-xs md:text-xs text-gray-600">1-3 hari</div>
                </div>
            </div>
        </div>
    </div>
</section>

        <!-- Service Area Info -->
        <div class="mt-4 md:mt-6 bg-gradient-to-r from-blue-600 to-blue-500 rounded-xl shadow-lg p-4 md:p-6 text-white">
            <div class="flex flex-col md:flex-row items-center justify-between gap-3 md:gap-4">
                <div class="flex items-center space-x-3 md:space-x-4 w-full md:w-auto">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-truck text-xl md:text-2xl"></i>
                    </div>
                    <div class="flex-1 md:flex-initial">
                        <h3 class="font-bold text-base md:text-lg text-white"> Layanan Antar-Jemput GRATIS</h3>
                        <p class="text-blue-100 text-xs md:text-sm">Untuk radius 5 km dari lokasi toko kami</p>
                    </div>
                </div>
                <a href="/#services" class="bg-white text-blue-600 px-6 py-2.5 md:py-3 rounded-lg font-bold hover:bg-blue-50 transition shadow-md text-sm md:text-base w-full md:w-auto text-center">
                    Pesan Sekarang
                </a>
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
    
    // Load services from API
    loadServices();
});

// Load services from API
async function loadServices() {
    const servicesGrid = document.getElementById('servicesGrid');
    const moreServicesButtonContainer = document.getElementById('moreServicesButtonContainer');
    const moreServicesExpandedGrid = document.getElementById('moreServicesExpandedGrid');
    
    try {
        console.log('🚀 Loading services from API...');
        const response = await fetch('/api/services', {
            credentials: 'include'
        });
        const services = await response.json();
        
        console.log('✅ Services loaded:', services);
        
        if (services && services.length > 0) {
            // Icon mapping
            const iconMap = {
                'fast-cleaning': 'fa-bolt',
                'deep-cleaning': 'fa-water',
                'white-shoes': 'fa-star',
                'suede-treatment': 'fa-shoe-prints',
                'unyellowing': 'fa-magic',
            };
            
            const popularServices = ['suede-treatment'];
            const specialBorder = ['white-shoes'];
            
            // Function to render service card
            const renderServiceCard = (service) => {
                const icon = iconMap[service.kode_layanan] || 'fa-shoe-prints';
                const isPopular = popularServices.includes(service.kode_layanan);
                const borderClass = specialBorder.includes(service.kode_layanan) ? 'border-blue-300' : 'border-gray-200';
                // Convert to number to ensure proper formatting
                const price = Number(service.harga_dasar) || 0;
                const priceFormatted = price.toLocaleString('id-ID', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
                const durationDays = Number(service.durasi_hari) || 1;
                const durationText = durationDays == 1 ? '1 hari' : `1-${durationDays} hari`;
                
                // Use icon_path from database if available, otherwise fallback to icon
                const hasImage = service.icon_path && service.icon_path.trim() !== '';
                const headerStyle = hasImage 
                    ? `background-image: url('${service.icon_path}'); background-size: cover; background-position: center;`
                    : 'background-color: #2563eb;';
                const headerContent = hasImage
                    ? '' // If image exists, don't show icon
                    : `<i class="fas ${icon} text-white text-3xl"></i>`;
                
                return `
                    <div class="bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden border ${borderClass} flex flex-col h-full">
                        <div class="relative h-28 sm:h-32 md:h-36 flex items-center justify-center flex-shrink-0" style="${headerStyle}">
                            ${headerContent}
                            ${hasImage ? '<div class="absolute inset-0 bg-black/20 flex items-center justify-center"></div>' : ''}
                        </div>
                        <div class="p-3 sm:p-4 flex flex-col flex-grow">
                            <h3 class="text-xs sm:text-sm font-bold text-gray-900 mb-1 line-clamp-2" title="${service.nama_layanan}">${service.nama_layanan}</h3>
                            <p class="text-xs text-gray-600 mb-3 h-8 line-clamp-2 flex-grow" title="${service.deskripsi}">${service.deskripsi}</p>
                            <div class="flex items-baseline space-x-1 mb-2">
                                <span class="text-sm sm:text-base font-bold text-blue-600">Rp ${priceFormatted}</span>
                            </div>
                            <div class="flex items-center gap-1 text-xs text-gray-500 mb-3">
                                <i class="fas fa-clock text-xs"></i>
                                <span>${durationText}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-auto">
                                <button onclick="addToCartQuick('${service.kode_layanan}', '${service.nama_layanan}', ${price})" class="py-2 bg-blue-600 text-white rounded text-xs sm:text-sm font-semibold hover:bg-blue-700 transition flex items-center justify-center gap-1 min-h-[2.5rem]" title="Tambah ke Keranjang">
                                    <i class="fas fa-shopping-cart text-xs"></i>
                                    <span class="hidden sm:inline"></span>
                                </button>
                                <a href="/make-booking?service=${service.kode_layanan}" class="py-2 px-2 bg-blue-600 text-white rounded text-xs sm:text-sm font-semibold flex items-center justify-center gap-1 min-h-[2.5rem] no-underline" style="color: white !important; overflow: visible !important; text-decoration: none !important;">
                                    <span style="color: white !important; display: inline !important;">Pesan</span>
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            };
            
            // Split services: first 4 for main grid, rest for expanded grid
            const mainServices = services.slice(0, 4);
            const moreServices = services.slice(4);
            
            // Render main services (first 4)
            servicesGrid.innerHTML = mainServices.map(renderServiceCard).join('');
            
            // Render more services button and expanded grid if there are more services
            if (moreServices.length > 0) {
                // Render more services in expanded grid (hidden by default)
                moreServicesExpandedGrid.innerHTML = moreServices.map(renderServiceCard).join('');
                
                moreServicesButtonContainer.innerHTML = `
                    <button onclick="toggleMoreServices()" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition flex items-center justify-center space-x-2 mx-auto">
                        <i class="fas fa-chevron-down" id="moreServicesToggleIcon"></i>
                        <span id="moreServicesToggleText">Layanan Lainnya</span>
                    </button>
                `;
            } else {
                moreServicesButtonContainer.innerHTML = '';
                moreServicesExpandedGrid.classList.add('hidden');
            }
            
            console.log(' Services rendered successfully!');
        } else {
            servicesGrid.innerHTML = `
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-info-circle text-gray-400 text-4xl mb-3"></i>
                    <p class="text-gray-500">Belum ada layanan tersedia.</p>
                </div>
            `;
            moreServicesButtonContainer.innerHTML = '';
            moreServicesExpandedGrid.classList.add('hidden');
        }
    } catch (error) {
        console.error(' Error loading services:', error);
        servicesGrid.innerHTML = `
            <div class="col-span-full text-center py-12">
                <i class="fas fa-exclamation-triangle text-red-400 text-4xl mb-3"></i>
                <p class="text-red-500">Gagal memuat layanan. Silakan refresh halaman.</p>
            </div>
        `;
        moreServicesButtonContainer.innerHTML = '';
        moreServicesExpandedGrid.classList.add('hidden');
    }
}

// Toggle more services visibility
function toggleMoreServices() {
    const moreServicesExpandedGrid = document.getElementById('moreServicesExpandedGrid');
    const toggleIcon = document.getElementById('moreServicesToggleIcon');
    const toggleText = document.getElementById('moreServicesToggleText');
    
    if (moreServicesExpandedGrid.classList.contains('hidden')) {
        // Show more services
        moreServicesExpandedGrid.classList.remove('hidden');
        toggleIcon.classList.add('rotate-180');
        toggleIcon.style.transition = 'transform 0.3s ease';
        toggleText.textContent = 'Sembunyikan Layanan';
    } else {
        // Hide more services
        moreServicesExpandedGrid.classList.add('hidden');
        toggleIcon.classList.remove('rotate-180');
        toggleText.textContent = 'Layanan Lainnya';
        
        // Scroll to services section
        document.getElementById('services').scrollIntoView({ behavior: 'smooth' });
    }
}
</script>

<style>
/* Toggle icon rotation */
#moreServicesToggleIcon {
    transition: transform 0.3s ease;
}

#moreServicesToggleIcon.rotate-180 {
    transform: rotate(180deg);
}

/* More services expanded grid animation */
#moreServicesExpandedGrid:not(.hidden) {
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

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

/* WhatsApp Button Hover Effect - Harmonis */
.whatsapp-button {
    background-color: #16a34a !important;
    color: white !important;
    position: relative;
    overflow: hidden;
}

.whatsapp-button:hover {
    background-color: #15803d !important;
    color: white !important;
    transform: translateY(-2px);
    box-shadow: 0 12px 20px rgba(22, 163, 74, 0.4) !important;
}

.whatsapp-button:active {
    transform: translateY(0);
}

/* Ensure icon and text stay white on hover */
.whatsapp-button:hover i,
.whatsapp-button:hover span {
    color: white !important;
    text-decoration: none !important;
}

.whatsapp-button i {
    color: white !important;
}

.whatsapp-button span {
    color: white !important;
}

/* Ensure Pesan button text always visible */
#servicesGrid a[href*="make-booking"],
#moreServicesExpandedGrid a[href*="make-booking"] {
    color: white !important;
}

#servicesGrid a[href*="make-booking"] span,
#moreServicesExpandedGrid a[href*="make-booking"] span {
    color: white !important;
}

#servicesGrid a[href*="make-booking"]:hover,
#moreServicesExpandedGrid a[href*="make-booking"]:hover {
    color: white !important;
    background: #1d4ed8 !important;
}

/* Button raised effect */
.grid button,
.grid a[href*="make-booking"] {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15) !important;
    transition: all 0.2s ease !important;
}

.grid button:hover,
.grid button:active,
.grid a[href*="make-booking"]:hover,
.grid a[href*="make-booking"]:active {
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.25) !important;
    transform: translateY(-2px);
}
</style>

<?= $this->endSection() ?>