<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-logo" style="text-align: center; margin-bottom: 2rem;">
                <img src="/assets/images/SYH.CLEANING.png" alt="SYH Cleaning" style="width: 120px; height: 120px;">
            </div>
            <h1>Sepatu Bersih, Percaya Diri Maksimal</h1>
            <p>Layanan cuci sepatu profesional dengan hasil terbaik dan harga terjangkau. Gratis delivery untuk pemesanan awal.</p>
            <div class="hero-buttons">
                <a href="#booking" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                </a>
                <a href="#services" class="btn btn-outline btn-lg" style="color: white; border-color: white;">
                    <i class="fas fa-info-circle"></i> Lihat Layanan
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services" id="services">
    <div class="container">
        <div class="section-title">
            <h2>Layanan Kami</h2>
            <p>Pilih layanan terbaik untuk kebutuhan sepatu Anda</p>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3>Fast Cleaning</h3>
                <p>Mencuci sepatu hanya bagian luarnya saja (outsole, midsole, upper).</p>
                <div class="service-price">Rp 20.000</div>
                <button class="btn btn-primary btn-sm mt-3" onclick="openBookingModal('fast-cleaning')">
                    Pesan
                </button>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-water"></i>
                </div>
                <h3>Deep Cleaning</h3>
                <p>Mencuci sepatu secara keseluruhan (outsole, midsole, insole, upper).</p>
                <div class="service-price">Rp 25.000</div>
                <button class="btn btn-primary btn-sm mt-3" onclick="openBookingModal('deep-cleaning')">
                    Pesan
                </button>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3>White Shoes</h3>
                <p>Mencuci sepatu putih berbahan canvas secara keseluruhan agar tetap putih bersih.</p>
                <div class="service-price">Rp 30.000</div>
                <button class="btn btn-primary btn-sm mt-3" onclick="openBookingModal('white-shoes')">
                    Pesan
                </button>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Suede treatment</h3>
                <p>Mencuci sepatu berbahan suede secara keseluruhan</p>
                <div class="service-price">Rp 30.000</div>
                <button class="btn btn-primary btn-sm mt-3" onclick="openBookingModal('coating')">
                    Pesan
                </button>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-palette"></i>
                </div>
                <h3>Unyelowing</h3>
                <p>Membersihkan kembali mid sol sepatu yang menguning</p>
                <div class="service-price">Rp 35.000</div>
                <button class="btn btn-primary btn-sm mt-3" onclick="openBookingModal('dyeing')">
                    Pesan
                </button>
            </div>

           >
        </div>
    </div>
</section>

<!-- Why Us Section -->
<section class="services">
    <div class="container">
        <div class="section-title">
            <h2>Mengapa Memilih Kami?</h2>
            <p>Kami berkomitmen memberikan layanan terbaik untuk kepuasan Anda</p>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3>Profesional</h3>
                <p>berpengalaman dalam penanganan berbagai jenis sepatu.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Terpercaya</h3>
                <p>Banyak pelanggan puas telah mempercayai layanan kami selama bertahun-tahun.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h3>Pengiriman Gratis</h3>
                <p>Layanan antar-jemput gratis max 5km.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-rupiah-sign"></i>
                </div>
                <h3>Harga Terjangkau</h3>
                <p>Harga kompetitif dengan kualitas terbaik tanpa mengorbankan hasil.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Cepat & Tepat Waktu</h3>
                <p>Pengerjaan yang cepat tanpa mengorbankan kualitas, selalu tepat waktu.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Layanan Pelanggan</h3>
                <p>24/7 siap membantu menjawab semua pertanyaan Anda.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section style="background: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%); padding: 4rem 0; color: white;">
    <div class="container text-center">
        <h2 style="color: white;">Siap Membuat Sepatu Anda Bersih?</h2>
        <p style="color: rgba(255, 255, 255, 0.9); margin-bottom: 2rem; font-size: 1.1rem;">
            Jangan tunggu lagi, pesan layanan cuci sepatu kami sekarang dan dapatkan diskon spesial!
        </p>
        <a href="#booking" class="btn btn-primary btn-lg">
            Pesan Sekarang
        </a>
    </div>
</section>

<!-- Booking Modal (for non-logged in users) -->
<div id="bookingModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Pesan Layanan</h2>
            <button class="modal-close" onclick="closeModal('bookingModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <p class="mb-3">Silakan login atau daftar terlebih dahulu untuk melakukan pemesanan.</p>
            <div style="display: flex; gap: 1rem;">
                <a href="/login" class="btn btn-primary btn-block">Login</a>
                <a href="/register" class="btn btn-outline btn-block">Daftar</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
function openBookingModal(service) {
    openModal('bookingModal');
}
</script>
<?= $this->endSection() ?>
