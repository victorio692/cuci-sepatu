<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="mb-6 md:mb-8">
    <h1 class="text-xl md:text-3xl font-bold text-gray-800 mb-1 md:mb-2">
        <i class="fas fa-file-chart-line"></i>Akun
    </h1>
    <p class="text-xs md:text-base text-gray-600">kelola informasi akun Anda</p>
</div>

    <!-- Card: Edit Profil (Display Mode) -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-user" style="color: #5d00ff; font-size: 1.25rem;"></i>
                <h3 style="margin: 0; color: #1f2937; font-weight: 600; font-size: 1.1rem;">Detail akun</h3>
            </div>
            <button type="button" onclick="openEditModal()" class="btn btn-primary" style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                <i class="fas fa-pencil-alt"></i> Edit
            </button>
        </div>

        <div class="profile-display-grid">
            <!-- Nama Lengkap -->
            <div>
                <p style="margin: 0 0 0.5rem; color: #6b7280; font-weight: 600; font-size: 0.85rem;">NAMA LENGKAP</p>
                <p id="displayNamaLengkap" style="margin: 0; color: #1f2937; font-weight: 500; font-size: 1rem;">-</p>
            </div>

            <!-- Email -->
            <div>
                <p style="margin: 0 0 0.5rem; color: #6b7280; font-weight: 600; font-size: 0.85rem;">EMAIL</p>
                <p id="displayEmail" style="margin: 0; color: #1f2937; font-weight: 500; font-size: 1rem;">-</p>
            </div>

            <!-- No. HP -->
            <div>
                <p style="margin: 0 0 0.5rem; color: #6b7280; font-weight: 600; font-size: 0.85rem;">NO. HP</p>
                <p id="displayNoHp" style="margin: 0; color: #1f2937; font-weight: 500; font-size: 1rem;">-</p>
            </div>

            <!-- Alamat -->
            <div>
                <p style="margin: 0 0 0.5rem; color: #6b7280; font-weight: 600; font-size: 0.85rem;">ALAMAT</p>
                <p id="displayAlamat" style="margin: 0; color: #1f2937; font-weight: 500; font-size: 1rem; line-height: 1.5;">-</p>
            </div>

            <!-- Role -->
            <div>
                <p style="margin: 0 0 0.5rem; color: #6b7280; font-weight: 600; font-size: 0.85rem;">ROLE</p>
                <p id="displayRole" style="margin: 0; color: #1f2937; font-weight: 500; font-size: 1rem; text-transform: capitalize;">-</p>
            </div>

            <!-- Terdaftar Sejak -->
            <div>
                <p style="margin: 0 0 0.5rem; color: #6b7280; font-weight: 600; font-size: 0.85rem;">TERDAFTAR SEJAK</p>
                <p id="displayCreatedAt" style="margin: 0; color: #1f2937; font-weight: 500; font-size: 1rem;">-</p>
            </div>
        </div>
    </div>

    <!-- Modal: Edit Profil -->
    <div id="editModal" class="modal hidden">
        <div class="modal-overlay" onclick="closeEditModal()"></div>
        <div class="modal-container">
            <div class="modal-header">
                <h3><i class="fas fa-pencil-alt"></i> Edit Personal Information</h3>
                <button type="button" onclick="closeEditModal()" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="profileForm" class="modal-body">
                <!-- Nama Lengkap -->
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" id="modal_nama_lengkap" name="nama_lengkap" class="form-control" required>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="modal_email" name="email" class="form-control" required>
                </div>

                <!-- No. HP -->
                <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" id="modal_no_hp" name="no_hp" class="form-control" required>
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea id="modal_alamat" name="alamat" rows="3" class="form-control"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" onclick="closeEditModal()" class="btn btn-secondary">Batal</button>
                    <button type="button" onclick="submitProfileForm()" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Card: Ubah Password -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.25rem;">
            <i class="fas fa-lock" style="color: #5d00ff; font-size: 1.25rem;"></i>
            <h3 style="margin: 0; color: #1f2937; font-weight: 600; font-size: 1.1rem;">Ubah Kata Sandi</h3>
        </div>
        <form id="passwordForm" class="password-form">
            <div class="password-grid">
                <div class="form-group">
                    <label>Kata Sandi Saat Ini</label>
                    <input type="password" id="current_password" name="current_password" class="form-control form-control-sm" placeholder="Kata sandi saat ini" required>
                    <small class="text-xs text-gray-500">Diperlukan untuk keamanan</small>
                </div>

                <div class="form-group">
                    <label>Kata Sandi Baru</label>
                    <input type="password" id="new_password" name="new_password" class="form-control form-control-sm" placeholder="Min 6 karakter" required>
                </div>

                <div class="form-group">
                    <label>Konfirmasi Kata Sandi</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-sm" placeholder="Ulang kata sandi" required>
                </div>
            </div>

            <button type="button" onclick="submitPasswordForm()" class="btn btn-primary btn-sm" style="margin-top: 1rem; margin-left: auto; margin-right: auto; display: block; width: fit-content;">
                <i class="fas fa-key"></i> Ubah Kata Sandi
            </button>
        </form>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
<style>
/* Profile Display Grid */
.profile-display-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    row-gap: 1.5rem;
}

@media (max-width: 640px) {
    .profile-display-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}

/* Modal Styles */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 50;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.modal.hidden {
    display: none;
}

.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    cursor: pointer;
}

.modal-container {
    position: relative;
    background: white;
    border-radius: 0.75rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.modal-header h3 {
    margin: 0;
    color: #1f2937;
    font-weight: 600;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.modal-header h3 i {
    color: #5d00ff;
}

.modal-close {
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    font-size: 1.5rem;
    transition: color 0.2s;
    padding: 0;
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-close:hover {
    color: #1f2937;
}

.modal-body {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.modal-footer {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    border-top: 1px solid #e5e7eb;
    justify-content: flex-end;
}

.btn-secondary {
    background: #e5e7eb;
    color: #1f2937;
}

.btn-secondary:hover {
    background: #d1d5db;
    box-shadow: none;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
}

.form-control {
    padding: 0.75rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    width: 100%;
    font-size: 0.875rem;
    font-family: inherit;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #5d00ff;
    box-shadow: 0 0 0 3px rgba(93, 0, 255, 0.1);
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.375rem;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.btn-primary {
    background: #5d00ff;
    color: white;
}

.btn-primary:hover {
    background: #4c00cc;
    box-shadow: 0 4px 6px rgba(93, 0, 255, 0.3);
}

/* Password Form Compact */
.password-form {
    display: flex;
    flex-direction: column;
}

.password-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
    margin-bottom: 0;
}

.password-grid .form-group {
    margin-bottom: 0;
}

.password-grid .form-group label {
    margin-bottom: 0.25rem;
    font-size: 0.8125rem;
}

.form-control-sm {
    padding: 0.5rem 0.625rem;
    font-size: 0.8125rem;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.8125rem;
}

.text-xs {
    font-size: 0.75rem;
}

.text-gray-500 {
    color: #6b7280;
}

.mt-1 {
    margin-top: 0.25rem;
}

.space-y-6 > * + * {
    margin-top: 1.5rem;
}

/* Password Form Compact */
.password-form {
    display: flex;
    flex-direction: column;
}

.password-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1rem;
    margin-bottom: 0;
}

.password-grid .form-group {
    margin-bottom: 0;
}

.password-grid .form-group label {
    margin-bottom: 0.25rem;
    font-size: 0.8125rem;
}

.form-control-sm {
    padding: 0.5rem 0.625rem;
    font-size: 0.8125rem;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.8125rem;
}

/* Responsive untuk mobile */
@media (max-width: 768px) {
    .modal-container {
        max-width: calc(100% - 2rem);
    }

    .password-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
const userId = '<?= session()->get("user_id") ?>';

// Load profile data on page load
document.addEventListener('DOMContentLoaded', async function() {
    try {
        console.log('🚀 Loading admin profile from API...');
        
        const response = await fetch(`/api/users/profile`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'include'
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const result = await response.json();
        console.log('✅ Profile loaded:', result);
        
        const user = result.data;
        
        if (user) {
            // Display mode
            document.getElementById('displayNamaLengkap').textContent = user.nama_lengkap || '-';
            document.getElementById('displayEmail').textContent = user.email || '-';
            document.getElementById('displayNoHp').textContent = user.no_hp || '-';
            document.getElementById('displayAlamat').textContent = user.alamat || '-';
            document.getElementById('displayRole').textContent = user.role ? user.role.charAt(0).toUpperCase() + user.role.slice(1) : '-';
            
            if (user.created_at) {
                const date = new Date(user.created_at);
                document.getElementById('displayCreatedAt').textContent = date.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
            }
            
            // Modal form fields
            document.getElementById('modal_nama_lengkap').value = user.nama_lengkap || '';
            document.getElementById('modal_email').value = user.email || '';
            document.getElementById('modal_no_hp').value = user.no_hp || '';
            document.getElementById('modal_alamat').value = user.alamat || '';
        }
    } catch (error) {
        console.error('❌ Error loading profile:', error);
        showToast('Gagal memuat profil: ' + error.message, 'error');
    }
});

// Modal functions
function openEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when pressing Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditModal();
    }
});

// Submit profile form
function submitProfileForm() {
    const form = document.getElementById('profileForm');
    
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    const data = {
        nama_lengkap: document.getElementById('modal_nama_lengkap').value,
        email: document.getElementById('modal_email').value,
        no_hp: document.getElementById('modal_no_hp').value,
        alamat: document.getElementById('modal_alamat').value
    };
    
    console.log('📤 Submitting profile update:', data);
    
    fetch(`/api/users/profile`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'include',
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        console.log('✅ Profile updated:', result);
        
        if (result.success || result.code === 200) {
            showToast('Profil berhasil diperbarui', 'success');
            closeEditModal();
            
            // Update display
            document.getElementById('displayNamaLengkap').textContent = data.nama_lengkap;
            document.getElementById('displayEmail').textContent = data.email;
            document.getElementById('displayNoHp').textContent = data.no_hp;
            document.getElementById('displayAlamat').textContent = data.alamat;
        } else {
            showToast(result.message || 'Gagal memperbarui profil', 'error');
        }
    })
    .catch(error => {
        console.error('❌ Error:', error);
        showToast('Terjadi kesalahan koneksi: ' + error.message, 'error');
    });
}

// Submit password form
function submitPasswordForm() {
    const form = document.getElementById('passwordForm');
    const currentPassword = document.getElementById('current_password').value;
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    if (!currentPassword) {
        showToast('Kata sandi saat ini harus diisi', 'error');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        showToast('Password tidak cocok', 'error');
        return;
    }
    
    if (newPassword.length < 6) {
        showToast('Password minimal 6 karakter', 'error');
        return;
    }
    
    const data = {
        current_password: currentPassword,
        password: newPassword
    };
    
    console.log('📤 Submitting password change...');
    
    fetch(`/api/users/change-password`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'include',
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        console.log('✅ Password updated:', result);
        
        if (result.success || result.code === 200) {
            showToast('Password berhasil diubah', 'success');
            document.getElementById('passwordForm').reset();
        } else {
            showToast(result.message || 'Gagal mengubah password', 'error');
        }
    })
    .catch(error => {
        console.error('❌ Error:', error);
        showToast('Terjadi kesalahan koneksi: ' + error.message, 'error');
    });
}

// Show toast notification
function showToast(message, type) {
    const bgColors = {
        'success': 'bg-green-500',
        'error': 'bg-red-500'
    };
    
    const icons = {
        'success': 'fa-check-circle',
        'error': 'fa-exclamation-circle'
    };
    
    const toast = document.createElement('div');
    toast.className = `fixed top-20 right-4 ${bgColors[type]} text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 z-50 animate-slide-in`;
    toast.innerHTML = `
        <i class="fas ${icons[type]} text-xl"></i>
        <span class="font-medium">${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>

<style>
@keyframes slide-in {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}
.animate-slide-in {
    animation: slide-in 0.3s ease;
}
</style>
<?= $this->endSection() ?>
