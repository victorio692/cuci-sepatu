<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- About Section -->
<section style="padding: 4rem 0;">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto;">
            <h1>Tentang SYH Cleaning</h1>
            <p style="margin-bottom: 2rem; font-size: 1.1rem; line-height: 1.8;">
                SYH Cleaning adalah perusahaan layanan cuci sepatu profesional yang berdedikasi memberikan 
                hasil terbaik dengan harga terjangkau. Kami memahami bahwa sepatu adalah bagian penting dari penampilan Anda, 
                dan kami berkomitmen untuk menjaganya tetap bersih dan rapi.
            </p>

            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <h3>Sejak 2020</h3>
                    <p>Kami telah melayani ribuan pelanggan puas selama 5 tahun lebih.</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Tim Profesional</h3>
                    <p>Tim berpengalaman dengan pelatihan khusus dalam penanganan sepatu.</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3>Kualitas Terjamin</h3>
                    <p>Menggunakan bahan dan teknik terbaik untuk hasil maksimal.</p>
                </div>
            </div>

            <div style="background-color: #f3e8ff; padding: 2rem; border-radius: 0.75rem; margin-top: 2rem;">
                <h2 style="color: #6d28d9;">Visi & Misi</h2>
                <div style="display: grid; gap: 2rem; margin-top: 1rem;">
                    <div>
                        <h4 style="color: #7c3aed;">Visi</h4>
                        <p>Menjadi perusahaan cuci sepatu terkemuka dan terpercaya di bansel dengan standar kualitas yang baik.</p>
                    </div>
                    <div>
                        <h4 style="color: #7c3aed;">Misi</h4>
                        <ul style="list-style: none; padding: 0;">
                            <li style="margin-bottom: 0.5rem;"><i class="fas fa-check"></i> Memberikan layanan cuci sepatu berkualitas tinggi</li>
                            <li style="margin-bottom: 0.5rem;"><i class="fas fa-check"></i> Menggunakan bahan ramah lingkungan</li>
                            <li style="margin-bottom: 0.5rem;"><i class="fas fa-check"></i> Memberikan harga yang kompetitif dan terjangkau</li>
                            <li><i class="fas fa-check"></i> Memberikan pelayanan pelanggan terbaik</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
