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
                <a href="#" onclick="confirmLogout(event)" style="color: #ef4444;">
                    <span class="sidebar-icon"><i class="fas fa-sign-out-alt"></i></span>
                    Logout
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div style="margin-bottom: 2rem;">
            <a href="/dashboard" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <h1 style="margin-bottom: 2rem;">Buat Booking Baru</h1>

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

        <div style="display: grid; grid-template-columns: 1fr 400px; gap: 2rem;">
            <!-- Left Column: Form -->
            <div>
                <form action="/submit-booking" method="POST" id="bookingForm" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- Service Selection -->
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 2rem;">
                        <!-- Fast Cleaning -->
                        <label class="service-radio-card">
                            <input type="radio" name="service" value="fast-cleaning" data-price="15000" required>
                            <div class="service-radio-content">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <div>
                                        <h3 style="margin: 0 0 0.25rem 0; font-size: 1.1rem;">Fast Cleaning</h3>
                                        <p style="margin: 0; color: #6b7280; font-size: 0.85rem;">Layanan cuci cepat yang praktis</p>
                                    </div>
                                    <i class="fas fa-star" style="color: #fbbf24; font-size: 1.25rem;"></i>
                                </div>
                                <div style="margin-top: 0.75rem;">
                                    <span style="color: #3b82f6; font-weight: 600;">Rp 15,000</span>
                                    <span style="color: #9ca3af; font-size: 0.85rem;">/pasang</span>
                                </div>
                                <div style="margin-top: 0.5rem; color: #9ca3af; font-size: 0.8rem;">1 hari</div>
                            </div>
                        </label>

                        <!-- Deep Cleaning -->
                        <label class="service-radio-card">
                            <input type="radio" name="service" value="deep-cleaning" data-price="20000">
                            <div class="service-radio-content">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <div>
                                        <h3 style="margin: 0 0 0.25rem 0; font-size: 1.1rem;">Deep Cleaning</h3>
                                        <p style="margin: 0; color: #6b7280; font-size: 0.85rem;">Layanan cuci full yang lebih detail</p>
                                    </div>
                                    <i class="fas fa-star" style="color: #fbbf24; font-size: 1.25rem;"></i>
                                </div>
                                <div style="margin-top: 0.75rem;">
                                    <span style="color: #3b82f6; font-weight: 600;">Rp 20,000</span>
                                    <span style="color: #9ca3af; font-size: 0.85rem;">/pasang</span>
                                </div>
                                <div style="margin-top: 0.5rem; color: #9ca3af; font-size: 0.8rem;">1 hari</div>
                            </div>
                        </label>

                        <!-- Suede Treatment -->
                        <label class="service-radio-card">
                            <input type="radio" name="service" value="suede-treatment" data-price="30000">
                            <div class="service-radio-content">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <div>
                                        <h3 style="margin: 0 0 0.25rem 0; font-size: 1.1rem;">Suede Treatment</h3>
                                        <p style="margin: 0; color: #6b7280; font-size: 0.85rem;">Layanan Khusus untuk sepatu Bahan Suede</p>
                                    </div>
                                    <i class="fas fa-star" style="color: #fbbf24; font-size: 1.25rem;"></i>
                                </div>
                                <div style="margin-top: 0.75rem;">
                                    <span style="color: #3b82f6; font-weight: 600;">Rp 30,000</span>
                                    <span style="color: #9ca3af; font-size: 0.85rem;">/pasang</span>
                                </div>
                                <div style="margin-top: 0.5rem; color: #9ca3af; font-size: 0.8rem;">1 hari</div>
                            </div>
                        </label>

                        <!-- White Shoes -->
                        <label class="service-radio-card">
                            <input type="radio" name="service" value="white-shoes" data-price="35000">
                            <div class="service-radio-content">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <div>
                                        <h3 style="margin: 0 0 0.25rem 0; font-size: 1.1rem;">White Shoes</h3>
                                        <p style="margin: 0; color: #6b7280; font-size: 0.85rem;">Layanan khusus untuk sepatu white midsole</p>
                                    </div>
                                    <i class="fas fa-star" style="color: #fbbf24; font-size: 1.25rem;"></i>
                                </div>
                                <div style="margin-top: 0.75rem;">
                                    <span style="color: #3b82f6; font-weight: 600;">Rp 35,000</span>
                                    <span style="color: #9ca3af; font-size: 0.85rem;">/pasang</span>
                                </div>
                                <div style="margin-top: 0.5rem; color: #9ca3af; font-size: 0.8rem;">1 hari</div>
                            </div>
                        </label>

                        <!-- Unyellowing -->
                        <label class="service-radio-card">
                            <input type="radio" name="service" value="unyellowing" data-price="30000">
                            <div class="service-radio-content">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <div>
                                        <h3 style="margin: 0 0 0.25rem 0; font-size: 1.1rem;">Unyellowing</h3>
                                        <p style="margin: 0; color: #6b7280; font-size: 0.85rem;">Layanan penyegaran/kuningan midsole</p>
                                    </div>
                                    <i class="fas fa-star" style="color: #fbbf24; font-size: 1.25rem;"></i>
                                </div>
                                <div style="margin-top: 0.75rem;">
                                    <span style="color: #3b82f6; font-weight: 600;">Rp 30,000</span>
                                    <span style="color: #9ca3af; font-size: 0.85rem;">/pasang</span>
                                </div>
                                <div style="margin-top: 0.5rem; color: #9ca3af; font-size: 0.8rem;">1 hari</div>
                            </div>
                        </label>
                    </div>

                    <!-- Hidden fields for shoe details -->
                    <input type="hidden" name="shoe_type" value="sneaker">
                    <input type="hidden" name="shoe_condition" value="normal">
                    <input type="hidden" name="delivery_option" value="pickup">
                    <input type="hidden" name="delivery_address" value="">

                    <!-- Jumlah Sepatu -->
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Jumlah Sepatu</label>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <button type="button" id="btnMinus" class="btn-quantity">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input 
                                type="number" 
                                id="quantity" 
                                name="quantity" 
                                value="1" 
                                min="1"
                                readonly
                                style="width: 80px; text-align: center; border: 1px solid #e5e7eb; padding: 0.5rem; border-radius: 0.375rem; font-size: 1.1rem; font-weight: 600;"
                                required
                            >
                            <button type="button" id="btnPlus" class="btn-quantity">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tanggal Masuk -->
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="delivery_date" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tanggal masuk</label>
                        <input 
                            type="date" 
                            id="delivery_date" 
                            name="delivery_date" 
                            class="form-control"
                            required
                        >
                    </div>

                    <!-- Jam Booking -->
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="booking_time" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Jam Booking</label>
                        <input 
                            type="time" 
                            id="booking_time" 
                            name="booking_time" 
                            class="form-control"
                            required
                        >
                        <small style="color: #6b7280; font-size: 0.85rem; margin-top: 0.25rem; display: block;">
                            Waktu saat ini: <span id="currentTime"></span>
                        </small>
                    </div>

                    <!-- Catatan -->
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="notes" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Catatan</label>
                        <textarea 
                            id="notes" 
                            name="notes" 
                            class="form-control" 
                            rows="4" 
                            placeholder="Tulis catatan di sini..."
                        ></textarea>
                    </div>

                    <!-- Foto Sepatu -->
                    <div class="form-group" style="margin-bottom: 2rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">
                            Foto Sepatu <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="file" id="shoe_photo" name="shoe_photo" accept="image/png,image/jpeg,image/jpg" required style="display: none;">
                        
                        <div id="uploadArea" style="border: 2px dashed #e5e7eb; border-radius: 0.5rem; padding: 2rem; text-align: center; background: #f9fafb; transition: all 0.3s ease;">
                            <div style="margin-bottom: 1rem;">
                                <i class="fas fa-image" style="font-size: 3rem; color: #3b82f6;"></i>
                            </div>
                            <p style="margin: 0 0 0.5rem 0; font-weight: 500; color: #374151;">Upload Foto Sepatu Anda</p>
                            <p style="margin: 0 0 1rem 0; color: #6b7280; font-size: 0.85rem;">PNG, JPG, JPEG (Maks. 5 MB)</p>
                            
                            <button type="button" onclick="document.getElementById('shoe_photo').click()" class="btn-upload">
                                <i class="fas fa-camera"></i> Pilih Foto
                            </button>
                            
                            <p style="margin: 1rem 0 0 0; color: #9ca3af; font-size: 0.8rem;">
                                <i class="fas fa-hand-pointer"></i> atau seret file kesini
                            </p>
                            <p style="margin: 0.5rem 0 0 0; color: #ef4444; font-size: 0.85rem;">
                                <i class="fas fa-exclamation-circle"></i> Wajib upload foto sepatu
                            </p>
                        </div>
                        
                        <div id="imagePreview" style="display: none; margin-top: 1rem;">
                            <div style="position: relative; display: inline-block;">
                                <img id="previewImg" src="" style="max-width: 100%; max-height: 300px; border-radius: 0.5rem; border: 2px solid #3b82f6; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                                <div style="position: absolute; top: -10px; right: -10px;">
                                    <button type="button" onclick="removeImage()" class="btn-remove-photo">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div style="margin-top: 1rem; text-align: center;">
                                <button type="button" onclick="document.getElementById('shoe_photo').click()" class="btn btn-outline btn-sm">
                                    <i class="fas fa-sync-alt"></i> Ganti Foto
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                        <i class="fas fa-check-circle"></i> Buat Booking
                    </button>
                </form>
            </div>

            <!-- Right Column: Summary -->
            <div>
                <div class="card" style="position: sticky; top: 2rem;">
                    <div class="card-header">
                        <h3 style="margin: 0;"><i class="fas fa-clipboard-list"></i> Ringkasan Booking</h3>
                    </div>
                    <div class="card-body">
                        <div style="margin-bottom: 1rem;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                                <span style="color: #6b7280;">Layanan</span>
                                <span id="summaryService" style="font-weight: 600;">-</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                                <span style="color: #6b7280;">Harga/Sepatu</span>
                                <span id="summaryPrice" style="font-weight: 600;">Rp 0</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                                <span style="color: #6b7280;">Jumlah</span>
                                <span id="summaryQuantity" style="font-weight: 600;">1 pasang</span>
                            </div>
                            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 1rem 0;">
                            <div style="display: flex; justify-content: space-between; font-size: 1.1rem;">
                                <span style="font-weight: 600;">Total</span>
                                <span id="summaryTotal" style="font-weight: 700; color: #3b82f6;">Rp 0</span>
                            </div>
                        </div>

                        <div style="background: #eff6ff; border: 1px solid #3b82f6; border-radius: 0.5rem; padding: 1rem; margin-top: 1.5rem;">
                            <div style="display: flex; gap: 0.5rem;">
                                <i class="fas fa-info-circle" style="color: #3b82f6; margin-top: 0.25rem;"></i>
                                <p style="margin: 0; color: #1e40af; font-size: 0.85rem;">
                                    Anda dapat booking untuk hari ini atau hari lainnya. Untuk konfirmasi lebih lanjut hubungi kami.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
<style>
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background-color: #e5e7eb;
    color: #374151;
    text-decoration: none;
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background-color: #d1d5db;
}

.service-radio-card {
    position: relative;
    display: block;
    cursor: pointer;
    border: 2px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 1.25rem;
    transition: all 0.3s ease;
    background: white;
}

.service-radio-card:hover {
    border-color: #3b82f6;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.service-radio-card input[type="radio"] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.service-radio-card input[type="radio"]:checked + .service-radio-content {
    background: #eff6ff;
}

.service-radio-card input[type="radio"]:checked ~ .service-radio-content::before {
    content: '\f058';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    color: #3b82f6;
    font-size: 1.25rem;
}

.service-radio-card input[type="radio"]:checked {
    border-color: #3b82f6;
}

.service-radio-card:has(input:checked) {
    border-color: #3b82f6;
    background: #eff6ff;
}

.service-radio-content {
    position: relative;
    transition: all 0.3s ease;
    border-radius: 0.5rem;
    padding: 0.5rem;
}

.btn-quantity {
    width: 40px;
    height: 40px;
    border: 2px solid #e5e7eb;
    background: white;
    border-radius: 0.375rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #374151;
}

.btn-quantity:hover {
    border-color: #3b82f6;
    color: #3b82f6;
    background: #eff6ff;
}

.btn-quantity:active {
    transform: scale(0.95);
}

.btn-outline {
    background: white;
    border: 1px solid #d1d5db;
    color: #374151;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.btn-outline:hover {
    background: #f9fafb;
    border-color: #9ca3af;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.8125rem;
}

.btn-upload {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-upload:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px -1px rgba(59, 130, 246, 0.4);
}

.btn-upload:active {
    transform: translateY(0);
}

.btn-remove-photo {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #ef4444;
    color: white;
    border: 2px solid white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.btn-remove-photo:hover {
    background: #dc2626;
    transform: scale(1.1);
}

#uploadArea {
    cursor: default;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
// Quantity buttons
document.getElementById('btnMinus').addEventListener('click', () => {
    const input = document.getElementById('quantity');
    const value = parseInt(input.value);
    if (value > 1) {
        input.value = value - 1;
        updateSummary();
    }
});

document.getElementById('btnPlus').addEventListener('click', () => {
    const input = document.getElementById('quantity');
    const value = parseInt(input.value);
    input.value = value + 1;
    updateSummary();
});

// Service selection
const serviceRadios = document.querySelectorAll('input[name="service"]');
serviceRadios.forEach(radio => {
    radio.addEventListener('change', updateSummary);
});

// Update summary
function updateSummary() {
    const selectedService = document.querySelector('input[name="service"]:checked');
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    
    if (selectedService) {
        const price = parseInt(selectedService.dataset.price);
        const total = price * quantity;
        
        // Get service name
        const serviceCard = selectedService.closest('.service-radio-card');
        const serviceName = serviceCard.querySelector('h3').textContent;
        
        document.getElementById('summaryService').textContent = serviceName;
        document.getElementById('summaryPrice').textContent = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('summaryQuantity').textContent = quantity + ' pasang';
        document.getElementById('summaryTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
}

// Set minimum date (today)
const today = new Date();
document.getElementById('delivery_date').min = today.toISOString().split('T')[0];

// Update current time every second
function updateCurrentTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    document.getElementById('currentTime').textContent = `${hours}:${minutes}:${seconds}`;
}

updateCurrentTime();
setInterval(updateCurrentTime, 1000);

// Set default time to current time
const now = new Date();
const currentHours = String(now.getHours()).padStart(2, '0');
const currentMinutes = String(now.getMinutes()).padStart(2, '0');
document.getElementById('booking_time').value = `${currentHours}:${currentMinutes}`;

// Form submission
document.getElementById('bookingForm').addEventListener('submit', (e) => {
    const selectedService = document.querySelector('input[name="service"]:checked');
    if (!selectedService) {
        e.preventDefault();
        alert('Pilih layanan terlebih dahulu');
        return;
    }
    
    const shoePhoto = document.getElementById('shoe_photo');
    if (!shoePhoto.files || shoePhoto.files.length === 0) {
        e.preventDefault();
        alert('Wajib upload foto sepatu terlebih dahulu');
        return;
    }
});

// File upload handling
const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('shoe_photo');
const imagePreview = document.getElementById('imagePreview');
const previewImg = document.getElementById('previewImg');

fileInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Check file size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file maksimal 5 MB');
            fileInput.value = '';
            return;
        }
        
        // Check file type
        if (!file.type.match('image/(png|jpeg|jpg)')) {
            alert('Format file harus PNG, JPG, atau JPEG');
            fileInput.value = '';
            return;
        }
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(event) {
            previewImg.src = event.target.result;
            uploadArea.style.display = 'none';
            imagePreview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

// Remove image
function removeImage() {
    fileInput.value = '';
    uploadArea.style.display = 'block';
    imagePreview.style.display = 'none';
    previewImg.src = '';
}

// Drag and drop
uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '#3b82f6';
    uploadArea.style.background = '#eff6ff';
});

uploadArea.addEventListener('dragleave', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '#e5e7eb';
    uploadArea.style.background = '#f9fafb';
});

uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = '#e5e7eb';
    uploadArea.style.background = '#f9fafb';
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        fileInput.dispatchEvent(new Event('change'));
    }
});

// Initialize
updateSummary();
</script>
<?= $this->endSection() ?>
