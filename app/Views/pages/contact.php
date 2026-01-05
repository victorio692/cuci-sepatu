<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<section style="padding: 4rem 0;">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto;">
            <h1>Hubungi Kami</h1>
            <p style="margin-bottom: 3rem; font-size: 1.1rem;">
                Punya pertanyaan? Hubungi kami melalui berbagai saluran komunikasi yang tersedia.
            </p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                <div class="card">
                    <div class="card-body">
                        <div style="font-size: 2rem; color: #7c3aed; margin-bottom: 1rem;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3>Lokasi</h3>
                        <p style="margin: 0;">Jl. Example No. 123<br>Jakarta, Indonesia</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div style="font-size: 2rem; color: #7c3aed; margin-bottom: 1rem;">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h3>Telepon</h3>
                        <p style="margin: 0;">
                            <a href="tel:+6281234567890">+62 812-3456-7890</a>
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div style="font-size: 2rem; color: #7c3aed; margin-bottom: 1rem;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3>Email</h3>
                        <p style="margin: 0;">
                            <a href="mailto:info@syhcleaning.com">info@syhcleaning.com</a>
                        </p>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <h3>Jam Operasional</h3>
                    <table style="width: 100%;">
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 0.5rem 0;">Senin - Jumat</td>
                            <td style="padding: 0.5rem 0; text-align: right;"><strong>08:00 - 18:00</strong></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 0.5rem 0;">Sabtu</td>
                            <td style="padding: 0.5rem 0; text-align: right;"><strong>08:00 - 16:00</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem 0;">Minggu</td>
                            <td style="padding: 0.5rem 0; text-align: right;"><strong>Tutup</strong></td>
                        </tr>
                    </table>
                </div>

                <div>
                    <h3>Media Sosial</h3>
                    <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                        <a href="#" class="btn btn-primary" style="flex: 1; text-align: center;">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                        <a href="#" class="btn btn-primary" style="flex: 1; text-align: center;">
                            <i class="fab fa-instagram"></i> Instagram
                        </a>
                    </div>
                    <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                        <a href="#" class="btn btn-primary" style="flex: 1; text-align: center;">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="#" class="btn btn-primary" style="flex: 1; text-align: center;">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Kirim Pesan</h3>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('contact_success')): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <span><?= session()->getFlashdata('contact_success') ?></span>
                        </div>
                    <?php endif; ?>

                    <form action="/kontak" method="POST">
                        <?= csrf_field() ?>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    class="form-control"
                                    required
                                    value="<?= old('name') ?>"
                                >
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    class="form-control"
                                    required
                                    value="<?= old('email') ?>"
                                >
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">Nomor Telepon</label>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    class="form-control"
                                    value="<?= old('phone') ?>"
                                >
                            </div>

                            <div class="form-group">
                                <label for="subject">Subjek</label>
                                <input 
                                    type="text" 
                                    id="subject" 
                                    name="subject" 
                                    class="form-control"
                                    required
                                    value="<?= old('subject') ?>"
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message">Pesan</label>
                            <textarea 
                                id="message" 
                                name="message" 
                                class="form-control" 
                                rows="5"
                                required
                            ><?= old('message') ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane"></i> Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
