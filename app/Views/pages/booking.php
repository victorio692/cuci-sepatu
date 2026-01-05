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
                <a href="/my-services">
                    <span class="sidebar-icon"><i class="fas fa-list"></i></span>
                    Riwayat Layanan
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
            <h1><i class="fas fa-shopping-cart"></i> Pesan Layanan</h1>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <form action="/submit-booking" method="POST" id="bookingForm">
            <?= csrf_field() ?>

            <!-- Step 1: Choose Service -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>
                        <span class="badge badge-primary" style="margin-right: 0.5rem;">1</span>
                        Pilih Layanan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="services-grid">
                        <div class="service-card" style="cursor: pointer; border: 2px solid transparent; transition: all 0.3s ease;">
                            <div class="service-icon"><i class="fas fa-bolt"></i></div>
                            <h3>Fast Cleaning</h3>
                            <p>Pembersihan cepat</p>
                            <div class="service-price">Rp 15.000</div>
                            <input type="radio" name="service" value="fast-cleaning" data-price="15000" required style="display: none;">
                        </div>

                        <div class="service-card" style="cursor: pointer; border: 2px solid transparent; transition: all 0.3s ease;">
                            <div class="service-icon"><i class="fas fa-water"></i></div>
                            <h3>Deep Cleaning</h3>
                            <p>Pembersihan mendalam</p>
                            <div class="service-price">Rp 20.000</div>
                            <input type="radio" name="service" value="deep-cleaning" data-price="20000" style="display: none;">
                        </div>

                        <div class="service-card" style="cursor: pointer; border: 2px solid transparent; transition: all 0.3s ease;">
                            <div class="service-icon"><i class="fas fa-star"></i></div>
                            <h3>White Shoes</h3>
                            <p>Khusus sepatu putih</p>
                            <div class="service-price">Rp 35.000</div>
                            <input type="radio" name="service" value="white-shoes" data-price="35000" style="display: none;">
                        </div>

                        <div class="service-card" style="cursor: pointer; border: 2px solid transparent; transition: all 0.3s ease;">
                            <div class="service-icon"><i class="fas fa-shield-alt"></i></div>
                            <h3>Coating</h3>
                            <p>Perlindungan tahan lama</p>
                            <div class="service-price">Rp 25.000</div>
                            <input type="radio" name="service" value="coating" data-price="25000" style="display: none;">
                        </div>

                        <div class="service-card" style="cursor: pointer; border: 2px solid transparent; transition: all 0.3s ease;">
                            <div class="service-icon"><i class="fas fa-palette"></i></div>
                            <h3>Dyeing</h3>
                            <p>Pewarnaan ulang</p>
                            <div class="service-price">Rp 40.000</div>
                            <input type="radio" name="service" value="dyeing" data-price="40000" style="display: none;">
                        </div>

                        <div class="service-card" style="cursor: pointer; border: 2px solid transparent; transition: all 0.3s ease;">
                            <div class="service-icon"><i class="fas fa-tools"></i></div>
                            <h3>Repair</h3>
                            <p>Perbaikan sepatu</p>
                            <div class="service-price">Rp 50.000</div>
                            <input type="radio" name="service" value="repair" data-price="50000" style="display: none;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Booking Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>
                        <span class="badge badge-primary" style="margin-right: 0.5rem;">2</span>
                        Detail Pemesanan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="shoe_type">Jenis Sepatu</label>
                            <select id="shoe_type" name="shoe_type" class="form-control" required>
                                <option value="">-- Pilih Jenis Sepatu --</option>
                                <option value="sneaker">Sneaker</option>
                                <option value="canvas">Canvas</option>
                                <option value="sports">Sepatu Olahraga</option>
                                <option value="casual">Casual</option>
                                <option value="formal">Formal</option>
                                <option value="boot">Boot</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="shoe_condition">Kondisi Sepatu</label>
                            <select id="shoe_condition" name="shoe_condition" class="form-control" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="normal">Normal (sedikit kotor)</option>
                                <option value="dirty">Kotor</option>
                                <option value="very_dirty">Sangat Kotor</option>
                                <option value="damaged">Ada yang Rusak</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="quantity">Jumlah Sepatu</label>
                            <input 
                                type="number" 
                                id="quantity" 
                                name="quantity" 
                                class="form-control" 
                                value="1" 
                                min="1"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="delivery_date">Tanggal Pengambilan</label>
                            <input 
                                type="date" 
                                id="delivery_date" 
                                name="delivery_date" 
                                class="form-control"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Catatan Khusus (Opsional)</label>
                        <textarea 
                            id="notes" 
                            name="notes" 
                            class="form-control" 
                            rows="3" 
                            placeholder="Contoh: Warna tertentu, alergi bahan, dll"
                        ></textarea>
                    </div>
                </div>
            </div>

            <!-- Step 3: Delivery Option -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>
                        <span class="badge badge-primary" style="margin-right: 0.5rem;">3</span>
                        Opsi Pengiriman
                    </h3>
                </div>
                <div class="card-body">
                    <div class="form-check" style="border: 1px solid #e5e7eb; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                        <input 
                            type="radio" 
                            id="delivery_pickup" 
                            name="delivery_option" 
                            value="pickup"
                            checked
                        >
                        <label for="delivery_pickup" style="margin-bottom: 0;">
                            <strong>Ambil Sendiri</strong>
                            <p style="margin: 0.5rem 0 0 1.5rem; color: #6b7280; font-size: 0.9rem;">Gratis</p>
                        </label>
                    </div>

                    <div class="form-check" style="border: 1px solid #e5e7eb; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                        <input 
                            type="radio" 
                            id="delivery_home" 
                            name="delivery_option" 
                            value="home"
                        >
                        <label for="delivery_home" style="margin-bottom: 0;">
                            <strong>Antar-Jemput</strong>
                            <p style="margin: 0.5rem 0 0 1.5rem; color: #6b7280; font-size: 0.9rem;">Biaya: Rp 5.000</p>
                        </label>
                    </div>

                    <div id="addressField" style="display: none; margin-top: 1rem;">
                        <label for="delivery_address">Alamat Pengiriman</label>
                        <textarea 
                            id="delivery_address" 
                            name="delivery_address" 
                            class="form-control" 
                            rows="3" 
                            placeholder="Masukkan alamat lengkap"
                        ></textarea>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Ringkasan Pesanan</h3>
                </div>
                <div class="card-body">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 0.75rem 0;">Layanan</td>
                            <td style="padding: 0.75rem 0; text-align: right;" id="summaryService">-</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 0.75rem 0;">Harga Satuan</td>
                            <td style="padding: 0.75rem 0; text-align: right;" id="summaryPrice">-</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 0.75rem 0;">Jumlah</td>
                            <td style="padding: 0.75rem 0; text-align: right;" id="summaryQuantity">1</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 0.75rem 0;">Biaya Pengiriman</td>
                            <td style="padding: 0.75rem 0; text-align: right;" id="summaryDelivery">Rp 0</td>
                        </tr>
                        <tr style="font-size: 1.1rem; font-weight: 700;">
                            <td style="padding: 1rem 0;">Total</td>
                            <td style="padding: 1rem 0; text-align: right; color: #7c3aed;" id="summaryTotal">Rp 0</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 1rem;">
                <a href="/dashboard" class="btn btn-outline" style="flex: 1;">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary btn-lg" style="flex: 1;">
                    <i class="fas fa-check"></i> Lanjutkan ke Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
// Service selection
const serviceCards = document.querySelectorAll('.service-card');
const serviceInputs = document.querySelectorAll('input[name="service"]');

serviceCards.forEach((card, index) => {
    card.addEventListener('click', () => {
        serviceInputs[index].checked = true;
        updateSummary();
        
        serviceCards.forEach(c => {
            c.style.borderColor = 'transparent';
            c.style.backgroundColor = 'white';
        });
        
        card.style.borderColor = '#7c3aed';
        card.style.backgroundColor = '#f3e8ff';
    });
});

serviceInputs.forEach((input, index) => {
    input.addEventListener('change', () => {
        serviceCards[index].click();
    });
});

// Delivery option
document.getElementById('delivery_home').addEventListener('change', () => {
    document.getElementById('addressField').style.display = 'block';
    updateSummary();
});

document.getElementById('delivery_pickup').addEventListener('change', () => {
    document.getElementById('addressField').style.display = 'none';
    updateSummary();
});

// Quantity update
document.getElementById('quantity').addEventListener('change', updateSummary);

// Update summary
function updateSummary() {
    const selectedService = document.querySelector('input[name="service"]:checked');
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    const deliveryOption = document.querySelector('input[name="delivery_option"]:checked').value;
    
    if (selectedService) {
        const serviceLabel = selectedService.value.replace('-', ' ').toUpperCase();
        const price = parseInt(selectedService.dataset.price);
        const deliveryFee = deliveryOption === 'home' ? 5000 : 0;
        const subtotal = price * quantity;
        const total = subtotal + deliveryFee;
        
        document.getElementById('summaryService').textContent = serviceLabel;
        document.getElementById('summaryPrice').textContent = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('summaryQuantity').textContent = quantity;
        document.getElementById('summaryDelivery').textContent = 'Rp ' + deliveryFee.toLocaleString('id-ID');
        document.getElementById('summaryTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
}

// Set minimum date
const today = new Date();
const minDate = new Date(today);
minDate.setDate(minDate.getDate() + 1);
document.getElementById('delivery_date').min = minDate.toISOString().split('T')[0];

// Form submission
document.getElementById('bookingForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const selectedService = document.querySelector('input[name="service"]:checked');
    if (!selectedService) {
        showToast('Pilih layanan terlebih dahulu', 'warning');
        return;
    }
    
    const formData = new FormData(this);
    try {
        const response = await API.post('/submit-booking', Object.fromEntries(formData));
        showToast('Pesanan berhasil dibuat', 'success');
        setTimeout(() => {
            window.location.href = '/payment/' + response.booking_id;
        }, 1500);
    } catch (error) {
        showToast(error.message || 'Gagal membuat pesanan', 'danger');
    }
});
</script>
<?= $this->endSection() ?>
