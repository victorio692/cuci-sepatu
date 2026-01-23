<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="/dashboard">
                    <span class="sidebar-icon"><i class="fas fa-home"></i></span>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/my-bookings">
                    <span class="sidebar-icon"><i class="fas fa-calendar-check"></i></span>
                    Pesanan Saya
                </a>
            </li>
            <li>
                <a href="/make-booking" class="active">
                    <span class="sidebar-icon"><i class="fas fa-plus-circle"></i></span>
                    Pesan Baru
                </a>
            </li>
            <li>
                <a href="/profile">
                    <span class="sidebar-icon"><i class="fas fa-user-circle"></i></span>
                    Profil
                </a>
            </li>
            <li>
                <a href="/logout">
                    <span class="sidebar-icon"><i class="fas fa-sign-out-alt"></i></span>
                    Logout
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <h1><i class="fas fa-credit-card"></i> Pilih Metode Pembayaran</h1>
        </div>

        <!-- Booking Summary -->
        <div class="card mb-4">
            <div class="card-header">
                <h3><span class="badge badge-info" style="margin-right: 0.5rem;">📦</span>Ringkasan Pesanan</h3>
            </div>
            <div class="card-body">
                <div class="summary-row">
                    <span>ID Pesanan</span>
                    <strong>#<?= htmlspecialchars($booking->id) ?></strong>
                </div>
                <div class="summary-row">
                    <span>Layanan</span>
                    <strong><?= ucfirst(str_replace('-', ' ', $booking->service)) ?></strong>
                </div>
                <div class="summary-row">
                    <span>Jumlah</span>
                    <strong><?= htmlspecialchars($booking->quantity) ?> pasang</strong>
                </div>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <strong>Rp <?= number_format($booking->subtotal, 0, ',', '.') ?></strong>
                </div>
                <div class="summary-row">
                    <span>Biaya Pengiriman</span>
                    <strong>Rp <?= number_format($booking->delivery_fee, 0, ',', '.') ?></strong>
                </div>
                <hr style="margin: 1rem 0;">
                <div class="summary-row" style="font-size: 1.1rem; font-weight: bold; color: #7c3aed;">
                    <span>Total Pembayaran</span>
                    <strong>Rp <?= number_format($booking->total, 0, ',', '.') ?></strong>
                </div>
            </div>
        </div>

        <!-- Payment Methods Selection -->
        <div class="card mb-4">
            <div class="card-header">
                <h3><span class="badge badge-primary" style="margin-right: 0.5rem;">1</span>Pilih Metode Pembayaran</h3>
            </div>
            <div class="card-body">
                <form action="/payment/process/<?= $booking->id ?>" method="POST" id="paymentForm">
                    <?= csrf_field() ?>

                    <div class="payment-methods-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                        <!-- Bank Transfer -->
                        <label class="payment-method-card" style="cursor: pointer; border: 2px solid #ddd; border-radius: 8px; padding: 1.5rem; transition: all 0.3s;">
                            <input type="radio" name="payment_method" value="bank_transfer" style="display: none;">
                            <div style="text-align: center;">
                                <div style="font-size: 2.5rem; margin-bottom: 0.5rem; color: #7c3aed;">
                                    <i class="fas fa-university"></i>
                                </div>
                                <h3 style="margin: 0.5rem 0; font-size: 1.1rem;">Transfer Bank</h3>
                                <p style="margin: 0.25rem 0; color: #666; font-size: 0.9rem;">Transfer langsung ke rekening BCA kami</p>
                                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #eee;">
                                    <small style="color: #999;">Biaya: Gratis</small>
                                </div>
                            </div>
                        </label>

                        <!-- E-Wallet -->
                        <label class="payment-method-card" style="cursor: pointer; border: 2px solid #ddd; border-radius: 8px; padding: 1.5rem; transition: all 0.3s;">
                            <input type="radio" name="payment_method" value="e_wallet" style="display: none;">
                            <div style="text-align: center;">
                                <div style="font-size: 2.5rem; margin-bottom: 0.5rem; color: #7c3aed;">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <h3 style="margin: 0.5rem 0; font-size: 1.1rem;">E-Wallet</h3>
                                <p style="margin: 0.25rem 0; color: #666; font-size: 0.9rem;">Hubungi via WhatsApp</p>
                                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #eee;">
                                    <small style="color: #999;">Biaya: Gratis</small>
                                </div>
                            </div>
                        </label>

                        <!-- Cash at Location -->
                        <label class="payment-method-card" style="cursor: pointer; border: 2px solid #ddd; border-radius: 8px; padding: 1.5rem; transition: all 0.3s;">
                            <input type="radio" name="payment_method" value="cash" style="display: none;">
                            <div style="text-align: center;">
                                <div style="font-size: 2.5rem; margin-bottom: 0.5rem; color: #7c3aed;">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <h3 style="margin: 0.5rem 0; font-size: 1.1rem;">Bayar di Tempat</h3>
                                <p style="margin: 0.25rem 0; color: #666; font-size: 0.9rem;">Bayar saat pengambilan barang</p>
                                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #eee;">
                                    <small style="color: #999;">Biaya: Gratis</small>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Action Buttons -->
                    <div style="margin-top: 2rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                        <a href="/customer/booking/<?= $booking->id ?>" class="btn btn-secondary" style="flex: 1; min-width: 150px;">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary" style="flex: 1; min-width: 150px;">
                            <i class="fas fa-arrow-right"></i> Lanjut Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.payment-method-card {
    display: block;
    position: relative;
}

.payment-method-card input[type="radio"]:checked + div {
    border-color: #7c3aed !important;
    background-color: #f3e8ff !important;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
}

.payment-method-card input[type="radio"]:checked + div::before {
    content: '✓';
    position: absolute;
    top: 10px;
    right: 10px;
    width: 24px;
    height: 24px;
    background: #7c3aed;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.payment-method-card div {
    position: relative;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    align-items: center;
}

.summary-row + .summary-row {
    border-top: 1px solid #eee;
}
</style>

<script>
document.querySelectorAll('.payment-method-card').forEach(card => {
    card.addEventListener('click', function() {
        document.querySelectorAll('.payment-method-card input').forEach(input => {
            input.checked = false;
        });
        this.querySelector('input[type="radio"]').checked = true;
    });
});

document.getElementById('paymentForm').addEventListener('submit', function(e) {
    const selected = document.querySelector('input[name="payment_method"]:checked');
    if (!selected) {
        e.preventDefault();
        alert('Pilih metode pembayaran terlebih dahulu');
        return false;
    }
});
</script>

<?= $this->endSection() ?>
                                    <h3><?= htmlspecialchars($method['name']) ?></h3>
                                    <p><?= htmlspecialchars($method['description']) ?></p>
                                    <?php if ($method['fee'] > 0): ?>
                                        <small class="method-fee">Biaya: Rp <?= number_format($method['fee'], 0, ',', '.') ?></small>
                                    <?php else: ?>
                                        <small class="method-fee free">Gratis</small>
                                    <?php endif; ?>
                                </div>
                                <div class="method-checkmark">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>

                <!-- Summary -->
                <div class="payment-summary">
                    <div class="summary-card">
                        <h3>Ringkasan Pesanan</h3>
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <strong>Rp <?= number_format($booking->subtotal, 0, ',', '.') ?></strong>
                        </div>
                        <div class="summary-row">
                            <span>Biaya Pengiriman</span>
                            <strong>Rp <?= number_format($booking->delivery_fee, 0, ',', '.') ?></strong>
                        </div>
                        <div class="summary-row total">
                            <span>Total Pembayaran</span>
                            <strong>Rp <?= number_format($booking->total, 0, ',', '.') ?></strong>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="payment-actions">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-credit-card"></i> Lanjut Pembayaran
                    </button>
                    <a href="/customer/booking/<?= $booking->id ?>" class="btn btn-outline btn-lg">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </section>
    </main>
</div>

<?= $this->endSection() ?>
