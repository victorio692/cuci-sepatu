<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- About Section -->
<section style="padding: 4rem 0;">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto;">
            <h1>Tentang SYH Cleaning</h1>
            <p style="margin-bottom: 2rem; font-size: 1.1rem; line-height: 1.8;">
                SYH Cleaning adalah layanan cuci sepatu profesional yang berdedikasi memberikan 
                hasil terbaik dengan harga terjangkau. Kami memahami bahwa sepatu adalah bagian penting dari penampilan Anda, 
                dan kami berkomitmen untuk menjaganya tetap bersih dan rapi.
            </p>

            <div class="services-grid">     
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <h3>Sejak 2025</h3>
                    <p>Kami telah melayani ratusan pelanggan, dan berbagai sepatu dengan hasil memuaskan.</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3>Kualitas Terjamin</h3>
                    <p>Menggunakan bahan dan teknik terbaik untuk hasil maksimal.kalau customer tidak puas kami jamin uang kembali.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
