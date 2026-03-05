<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="/admin/users" class="inline-flex items-center text-blue-600 hover:text-blue-700 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Pengguna
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            <i class="fas fa-user-edit mr-2"></i>
            Edit Pengguna
        </h2>

        <form id="userForm" class="space-y-6">
            <input type="hidden" id="userId" value="<?= $user['id'] ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div>
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nama_lengkap" 
                        name="nama_lengkap" 
                        value="<?= old('nama_lengkap', $user['nama_lengkap']) ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="John Doe"
                        required
                    >
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="<?= old('email', $user['email']) ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="john@example.com"
                        required
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nomor HP -->
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor HP <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="no_hp" 
                        name="no_hp" 
                        value="<?= old('no_hp', $user['no_hp']) ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="08123456789"
                        required
                    >
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="role" 
                        name="role" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        required
                    >
                        <option value="pelanggan" <?= old('role', $user['role']) == 'pelanggan' ? 'selected' : '' ?>>Pelanggan</option>
                        <option value="admin" <?= old('role', $user['role']) == 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>
            </div>

            <!-- Alamat -->
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                    Alamat
                </label>
                <textarea 
                    id="alamat" 
                    name="alamat" 
                    rows="3"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="Masukkan alamat lengkap"
                ><?= old('alamat', $user['alamat']) ?></textarea>
            </div>

            <!-- Password (Optional) -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password Baru (Kosongkan jika tidak ingin mengubah)
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    placeholder="Minimal 6 karakter"
                >
                <p class="mt-1 text-sm text-gray-500">
                    <i class="fas fa-info-circle"></i> Kosongkan jika tidak ingin mengubah password
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex items-center space-x-4 pt-4 border-t border-gray-200">
                <button 
                    type="button"
                    onclick="submitUserForm()"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center space-x-2"
                >
                    <i class="fas fa-save"></i>
                    <span>Simpan Perubahan</span>
                </button>
                <a 
                    href="/admin/users" 
                    class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition flex items-center space-x-2"
                >
                    <i class="fas fa-times"></i>
                    <span>Batal</span>
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>

// Submit user form via API
function submitUserForm() {
    const form = document.getElementById('userForm');
    const userId = document.getElementById('userId').value;
    const formData = new FormData(form);
    
    // Validate form
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    // Collect data
    const data = {
        nama_lengkap: formData.get('nama_lengkap'),
        email: formData.get('email'),
        no_hp: formData.get('no_hp'),
        role: formData.get('role'),
        alamat: formData.get('alamat')
    };
    
    // Only include password if provided
    if (formData.get('password')) {
        data.password = formData.get('password');
    }
    
    console.log('📤 Submitting user update:', data);
    
    fetch(`/api/users/${userId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'include',
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log('📬 API Response Status:', response.status);
        return response.json().then(body => ({
            status: response.status,
            body: body
        }));
    })
    .then(({ status, body }) => {
        console.log('✅ API Response:', status, body);
        
        if (status === 200 || (body && body.success)) {
            showToast('Pengguna berhasil diperbarui', 'success');
            setTimeout(() => {
                window.location.href = '/admin/users';
            }, 1500);
        } else {
            const errorMsg = body.message || body.error || 'Gagal memperbarui pengguna';
            showToast(errorMsg, 'error');
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

// Handle Enter key to submit
document.getElementById('userForm').addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
        e.preventDefault();
        submitUserForm();
    }
});
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
