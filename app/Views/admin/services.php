<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <div class="admin-header">
        <h1>Layanan</h1>
        <p>Kelola layanan dan harganya</p>
    </div>

    <!-- Services Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
        <?php foreach ($services as $service): ?>
            <div class="admin-card service-card">
                <div class="card-body">
                    <h3 style="margin: 0 0 0.5rem 0; color: #1f2937;">
                        <i class="fas fa-<?= $service['icon'] ?>"></i> 
                        <?= $service['name'] ?>
                    </h3>
                    
                    <p style="color: #6b7280; margin: 0.5rem 0; font-size: 0.95rem;">
                        <?= $service['description'] ?>
                    </p>

                    <div style="margin: 1.5rem 0; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <span style="color: #6b7280;">Harga:</span>
                            <strong style="font-size: 1.5rem; color: #7c3aed;">
                                Rp <?= number_format($service['price'], 0, ',', '.') ?>
                            </strong>
                        </div>

                        <button 
                            class="btn btn-sm btn-primary"
                            onclick="openEditPrice('<?= $service['id'] ?>', '<?= $service['name'] ?>', <?= $service['price'] ?>)"
                            style="width: 100%;"
                        >
                            <i class="fas fa-edit"></i> Ubah Harga
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Edit Price Modal -->
<div id="priceModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Ubah Harga - <span id="serviceName"></span></h2>
            <button class="close-btn" onclick="closePriceModal()">&times;</button>
        </div>

        <div class="modal-body">
            <form id="priceForm">
                <input type="hidden" id="serviceId" name="service_id">
                
                <div class="form-group">
                    <label for="newPrice">Harga Baru (Rp)</label>
                    <input 
                        type="number" 
                        id="newPrice" 
                        name="price" 
                        class="form-control"
                        placeholder="Masukkan harga baru"
                        min="0"
                        step="1000"
                        required
                    >
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="closePriceModal()" style="flex: 1;">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
<style>
.service-card {
    transition: all 0.3s ease;
}

.service-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal.show {
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    padding: 0;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.modal-header h2 {
    margin: 0;
    color: #1f2937;
    font-size: 1.25rem;
}

.close-btn {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #6b7280;
}

.close-btn:hover {
    color: #1f2937;
}

.modal-body {
    padding: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: #374151;
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #7c3aed;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
}

.btn {
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 0.375rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.btn-primary {
    background-color: #7c3aed;
    color: white;
}

.btn-primary:hover {
    background-color: #6d28d9;
}

.btn-secondary {
    background-color: #e5e7eb;
    color: #374151;
}

.btn-secondary:hover {
    background-color: #d1d5db;
}

.btn-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
function openEditPrice(serviceId, serviceName, currentPrice) {
    document.getElementById('serviceId').value = serviceId;
    document.getElementById('serviceName').textContent = serviceName;
    document.getElementById('newPrice').value = currentPrice;
    document.getElementById('priceModal').classList.add('show');
}

function closePriceModal() {
    document.getElementById('priceModal').classList.remove('show');
    document.getElementById('priceForm').reset();
}

document.getElementById('priceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const serviceId = document.getElementById('serviceId').value;
    const price = document.getElementById('newPrice').value;

    AdminAPI.post('/services/price', { service: serviceId, price: price })
        .then(data => {
            showToast('Harga berhasil diperbarui', 'success');
            closePriceModal();
            setTimeout(() => location.reload(), 1000);
        })
        .catch(error => {
            showToast('Gagal memperbarui harga', 'danger');
        });
});

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    const modal = document.getElementById('priceModal');
    if (event.target === modal) {
        closePriceModal();
    }
});
</script>
<?= $this->endSection() ?>
