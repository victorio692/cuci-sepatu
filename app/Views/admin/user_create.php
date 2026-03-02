<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center space-x-4 mb-4">
        <a href="/admin/users" class="text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah Pengguna</h1>
            <p class="text-gray-600">Buat akun pengguna baru di sistem</p>
        </div>
    </div>
</div>

<!-- Form -->
<div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl">
    <form id="userForm" class="space-y-6">
        <!-- Nama Lengkap -->
        <div>
            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                id="nama_lengkap" 
                name="nama_lengkap" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="Nama lengkap pengguna"
                required
            >
            <p class="mt-1 text-sm text-gray-500">Minimal 3 karakter</p>
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
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="email@contoh.com"
                required
            >
        </div>

        <!-- Nomor HP -->
        <div>
            <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                Nomor HP <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                id="no_hp" 
                name="no_hp" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="08123456789"
                required
            >
            <p class="mt-1 text-sm text-gray-500">Minimal 10 digit</p>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                Password <span class="text-red-500">*</span>
            </label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="••••••••"
                required
            >
            <p class="mt-1 text-sm text-gray-500">Minimal 6 karakter</p>
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
                <option value="">-- Pilih Role --</option>
                <option value="pelanggan">Pelanggan</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <!-- Alamat -->
        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                Alamat (Opsional)
            </label>
            <textarea 
                id="alamat" 
                name="alamat" 
                rows="3"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="Masukkan alamat lengkap..."
            ></textarea>
        </div>

        <!-- Buttons -->
        <div class="flex items-center space-x-4 pt-6 border-t border-gray-200">
            <button 
                type="button" 
                onclick="submitUserForm()"
                class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-medium flex items-center space-x-2"
            >
                <i class="fas fa-save"></i>
                <span>Simpan Pengguna</span>
            </button>
            <a 
                href="/admin/users" 
                class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition font-medium flex items-center space-x-2"
            >
                <i class="fas fa-times"></i>
                <span>Batal</span>
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
// Submit user form
function submitUserForm() {
    const form = document.getElementById('userForm');
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
        password: formData.get('password'),
        role: formData.get('role'),
        alamat: formData.get('alamat')
    };
    
    console.log('📤 Submitting user form:', data);
    
    fetch('/api/users', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'include',
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log('📬 API Response Status:', response.status);
        return response.json().then(data => ({
            status: response.status,
            body: data
        }));
    })
    .then(({ status, body }) => {
        console.log('✅ API Response:', status, body);
        
        if (status === 201 || (body && body.success)) {
            showToast('Pengguna berhasil ditambahkan', 'success');
            setTimeout(() => {
                window.location.href = '/admin/users';
            }, 1500);
        } else {
            const errorMsg = body.message || body.error || 'Gagal menambahkan pengguna';
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
