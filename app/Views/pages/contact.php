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
                        <div style="font-size: 2rem; color: #3b82f6; margin-bottom: 1rem;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3>Lokasi</h3>
                        <p style="margin: 0;">Desa Paten RT04, Sumberaguung, Jetis, Bantul</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div style="font-size: 2rem; color: #3b82f6; margin-bottom: 1rem;">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h3>Telepon</h3>
                        <p style="margin: 0;">
                            <a href="tel:+6281234567890">08985709532</a>
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div style="font-size: 2rem; color: #3b82f6; margin-bottom: 1rem;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3>Email</h3>
                        <p style="margin: 0;">
                            <a href="mailto:info@syhcleaning.com">syhcleaning@gmail.com</a>
                        </p>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <h3>Jam Operasional</h3>
                    <table style="width: 100%;">
                        <tr>
                            <td style="padding: 0.5rem 0;">Setiap Hari</td>
                            <td style="padding: 0.5rem 0; text-align: right;"><strong>08:00 - 20:00</strong></td>
                        </tr>
                    </table>
                </div>

                <div>
                    <h3>Media Sosial</h3>
                    <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                        <a href="https://www.instagram.com/syh.cleaning" target="_blank" class="btn btn-primary" style="flex: 1; text-align: center;">
                            <i class="fab fa-instagram"></i> Instagram
                        </a>
                        <a href="https://wa.me/628985709532" target="_blank" class="btn btn-primary" style="flex: 1; text-align: center;">
                            <i class="fab fa-whatsapp"></i> WhatsApp
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
