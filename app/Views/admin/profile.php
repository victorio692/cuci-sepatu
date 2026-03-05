<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <div class="dashboard-header" style="margin-bottom: 2rem;">
        <h1><i class="fas fa-user-circle"></i> Akun Admin</h1>
        <p style="margin: 0.5rem 0 0; color: #6b7280;">Kelola informasi akun Anda</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <!-- Card: Informasi Profil -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                <i class="fas fa-user" style="color: #5d00ff; font-size: 1.25rem;"></i>
                <h3 style="margin: 0; color: #1f2937; font-weight: 600; font-size: 1.1rem;">Informasi Akun</h3>
            </div>
            <form id="profileForm" class="space-y-6">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" id="no_hp" name="no_hp" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3" class="form-control"></textarea>
                </div>

                <button type="button" onclick="submitProfileForm()" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>

        <!-- Card: Ubah Password -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                <i class="fas fa-lock" style="color: #5d00ff; font-size: 1.25rem;"></i>
                <h3 style="margin: 0; color: #1f2937; font-weight: 600; font-size: 1.1rem;">Ubah Kata Sandi</h3>
            </div>
            <form id="passwordForm" class="space-y-6">
                <div class="form-group">
                    <label>Kata Sandi Baru</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                    <p class="text-xs text-gray-500 mt-1">Minimal 6 karakter</p>
                </div>

                <div class="form-group">
                    <label>Konfirmasi Kata Sandi Baru</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                </div>

                <button type="button" onclick="submitPasswordForm()" class="btn btn-primary">
                    <i class="fas fa-key"></i> Ubah Kata Sandi
                </button>
            </form>
        </div>
    </div>

    <!-- Card: Informasi Akun -->
    <div class="bg-white rounded-lg shadow-md p-6" style="margin-top: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
            <i class="fas fa-info-circle" style="color: #5d00ff; font-size: 1.25rem;"></i>
            <h3 style="margin: 0; color: #1f2937; font-weight: 600; font-size: 1.1rem;">Informasi Akun</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
            <div>
                <label style="font-weight: 600; color: #6b7280; display: block; margin-bottom: 0.5rem; font-size: 0.875rem;">Role:</label>
                <span id="roleDisplay" style="display: inline-block; background: #5d00ff; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 500;">
                    -
                </span>
            </div>
            <div>
                <label style="font-weight: 600; color: #6b7280; display: block; margin-bottom: 0.5rem; font-size: 0.875rem;">Terdaftar Sejak:</label>
                <span id="createdAtDisplay" style="color: #1f2937; font-weight: 500;">-</span>
            </div>
            <div>
                <label style="font-weight: 600; color: #6b7280; display: block; margin-bottom: 0.5rem; font-size: 0.875rem;">Status:</label>
                <span style="color: #10b981; font-weight: 600;">
                    <i class="fas fa-check-circle"></i> Aktif
                </span>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
<style>
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #374151;
    font-size: 0.95rem;
}

.form-control {
    padding: 0.75rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    width: 100%;
    font-size: 1rem;
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
}

.btn-primary {
    background: #5d00ff;
    color: white;
}

.btn-primary:hover {
    background: #4c00cc;
    box-shadow: 0 4px 6px rgba(93, 0, 255, 0.3);
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #10b981;
}

.alert-danger {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #ef4444;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f3f4f6;
    align-items: center;
}

.info-row:last-child {
    border-bottom: none;
}

.info-row label {
    font-weight: 600;
    color: #6b7280;
    font-size: 0.95rem;
}

.info-row span {
    color: #1f2937;
    text-align: right;
    font-weight: 500;
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
            document.getElementById('nama_lengkap').value = user.nama_lengkap || '';
            document.getElementById('email').value = user.email || '';
            document.getElementById('no_hp').value = user.no_hp || '';
            document.getElementById('alamat').value = user.alamat || '';
            document.getElementById('roleDisplay').textContent = user.role ? user.role.charAt(0).toUpperCase() + user.role.slice(1) : '-';
            
            if (user.created_at) {
                const date = new Date(user.created_at);
                document.getElementById('createdAtDisplay').textContent = date.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
            }
        }
    } catch (error) {
        console.error('❌ Error loading profile:', error);
        showToast('Gagal memuat profil: ' + error.message, 'error');
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
        nama_lengkap: document.getElementById('nama_lengkap').value,
        email: document.getElementById('email').value,
        no_hp: document.getElementById('no_hp').value,
        alamat: document.getElementById('alamat').value
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
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (!form.checkValidity()) {
        form.reportValidity();
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
        password: newPassword
    };
    
    console.log('📤 Submitting password change...');
    
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
