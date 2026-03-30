<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="/admin/users" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition font-medium">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pelanggan
        </a>
    </div>

    <!-- Header Section with Gradient -->
    <div class="mb-8 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg shadow-lg p-4 sm:p-8">
        <div class="flex flex-row items-start gap-3 sm:gap-4">
            <!-- User Avatar -->
            <div class="w-16 h-16 sm:w-24 sm:h-24 flex-shrink-0 bg-white rounded-full flex items-center justify-center text-blue-600 text-2xl sm:text-4xl shadow-lg">
                <i class="fas fa-user"></i>
            </div>
            <!-- User Info -->
            <div class="flex-1 min-w-0">
                <h1 class="text-xl sm:text-3xl font-bold mb-1 sm:mb-2 break-words">
                    <?= htmlspecialchars($user['nama_lengkap']) ?>
                </h1>
                <div class="flex flex-col gap-1 text-blue-100 text-xs sm:text-sm">
                    <div class="flex items-center gap-2 min-w-0">
                        <i class="fas fa-envelope flex-shrink-0"></i>
                        <span class="truncate"><?= htmlspecialchars($user['email']) ?></span>
                    </div>
                    <div class="flex items-center gap-2 min-w-0">
                        <i class="fas fa-phone flex-shrink-0"></i>
                        <span class="truncate"><?= htmlspecialchars($user['no_hp']) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Form Tabs/Header -->
        <div class="border-b border-gray-200 px-6 sm:px-8 py-4">
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-pen-square text-blue-600"></i>
                Edit Informasi Pengguna
            </h2>
        </div>

        <!-- Form Content -->
        <form id="userForm" class="p-6 sm:p-8">
            <?= csrf_field() ?>
            <input type="hidden" id="userId" value="<?= $user['id'] ?>">
            <input type="hidden" name="role" value="<?= htmlspecialchars($user['role']) ?>">

            <!-- Personal Information Section -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    Informasi Pribadi
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nama_lengkap" 
                            name="nama_lengkap" 
                            value="<?= old('nama_lengkap', $user['nama_lengkap']) ?>"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition placeholder-gray-400"
                            placeholder="Masukkan nama lengkap"
                            required
                        >
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="<?= old('email', $user['email']) ?>"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition placeholder-gray-400"
                            placeholder="Masukkan email"
                            required
                        >
                    </div>

                    <!-- Nomor HP -->
                    <div>
                        <label for="no_hp" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor HP <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="no_hp" 
                            name="no_hp" 
                            value="<?= old('no_hp', $user['no_hp']) ?>"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition placeholder-gray-400"
                            placeholder="Contoh: 08123456789"
                            required
                        >
                    </div>
                </div>
            </div>

            <!-- Address Section -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">
                    
                    Alamat
                </h3>
                
                <div>
                    <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                        Alamat Lengkap
                    </label>
                    <textarea 
                        id="alamat" 
                        name="alamat" 
                        rows="4"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition placeholder-gray-400 resize-none"
                        placeholder="Masukkan alamat lengkap"
                    ><?= old('alamat', $user['alamat']) ?></textarea>
                </div>
            </div>

            <!-- Password Section -->
            <div class="mb-8 bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg p-6 border-2 border-amber-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-amber-300">
                   
                    Keamanan
                </h3>
                
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Password Baru
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="w-full px-4 py-3 border-2 border-amber-200 rounded-lg focus:outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-100 transition placeholder-gray-400"
                        placeholder="Biarkan kosong jika tidak ingin mengubah"
                    >
                    <p class="mt-2 text-xs text-gray-600">
                        <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                        <strong>Tip:</strong> Password minimal 6 karakter. Kosongkan jika tidak ingin mengubah password saat ini.
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t-2 border-gray-200">
                <button 
                    type="button"
                    onclick="submitUserForm()"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-semibold flex items-center justify-center gap-2"
                >
                    <i class="fas fa-check-circle"></i>
                    <span>Simpan Perubahan</span>
                </button>
                <a 
                    href="/admin/users" 
                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold flex items-center justify-center gap-2"
                >
                    <i class="fas fa-times-circle"></i>
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
    
    // Collect data (with role from hidden field)
    const data = {
        nama_lengkap: formData.get('nama_lengkap'),
        email: formData.get('email'),
        no_hp: formData.get('no_hp'),
        role: formData.get('role'),
        alamat: formData.get('alamat') || ''
    };
    
    // Only include password if provided
    if (formData.get('password') && formData.get('password').trim() !== '') {
        data.password = formData.get('password');
    }
    
    console.log('📤 Submitting user update:', data, userId);
    
    // Get CSRF token - CodeIgniter 4 puts it in input[name="csrf_token"]
    let csrfToken = '';
    const csrfField = form.querySelector('input[name="csrf_token"]');
    
    if (csrfField) {
        csrfToken = csrfField.value;
    }
    
    console.log('🔐 CSRF Token:', csrfToken ? `found: ${csrfToken.substring(0, 20)}...` : 'not found');
    
    const headers = {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    };
    
    if (csrfToken) {
        headers['X-CSRF-TOKEN'] = csrfToken;
    }
    
    fetch(`/api/users/${userId}`, {
        method: 'PUT',
        headers: headers,
        credentials: 'include',
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log('📬 API Response Status:', response.status);
        return response.json().then(body => ({
            status: response.status,
            body: body
        })).catch(err => {
            console.error('Error parsing JSON:', err);
            return {
                status: response.status,
                body: { error: 'Failed to parse response' }
            };
        });
    })
    .then(({ status, body }) => {
        console.log('✅ API Response:', status, body);
        
        if (status === 200 || (body && body.success)) {
            // Success - redirect to users list
            if (Modal) {
                Modal.success('Pengguna berhasil diperbarui', 'Berhasil', () => {
                    console.log('🔄 Redirecting to /admin/users');
                    window.location.href = '/admin/users';
                });
            } else {
                showToast('Pengguna berhasil diperbarui', 'success');
                setTimeout(() => {
                    window.location.href = '/admin/users';
                }, 1500);
            }
        } else {
            // Better error message display
            let errorMsg = 'Gagal memperbarui pengguna';
            if (body?.message) {
                errorMsg = body.message;
            } else if (body?.error) {
                errorMsg = body.error;
            } else if (body?.errors) {
                // Handle validation errors
                errorMsg = Object.values(body.errors).flat().join(', ');
            }
            
            errorMsg = `[Error ${status}] ${errorMsg}`;
            console.error('❌ API Error:', errorMsg, body);
            
            if (Modal) {
                Modal.error(errorMsg, 'Gagal Memproses');
            } else {
                showToast(errorMsg, 'error');
            }
        }
    })
    .catch(error => {
        console.error('❌ Fetch Error:', error);
        const errorMsg = 'Terjadi kesalahan koneksi: ' + error.message;
        
        if (Modal) {
            Modal.error(errorMsg, 'Error Koneksi');
        } else {
            showToast(errorMsg, 'error');
        }
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

/* Form Input Hover Effects */
input:hover,
textarea:hover {
    border-color: #e5e7eb;
}

input:focus,
textarea:focus {
    border-color: #3b82f6;
}

/* Styling for required fields marker */
.text-red-500 {
    font-weight: bold;
}

/* Section heading styling */
h3 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding-left: 0.75rem;
    border-left: 4px solid #3b82f6;
}

h3 i {
    flex-shrink: 0;
    width: auto;
    min-width: 1.5rem;
    text-align: center;
    display: inline-block;
}

/* Button animations */
button[type="button"],
.btn-action {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

button[type="button"]:hover,
.btn-action:hover {
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

button[type="button"]:active,
.btn-action:active {
    transform: scale(0.98);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    input,
    textarea {
        font-size: 16px !important; /* Prevent zoom on iOS */
        min-height: 44px;
    }
}

/* Gradient overlay effect */
.bg-gradient-to-r {
    background-attachment: fixed;
}

/* Smooth transitions */
* {
    transition: border-color 0.2s, box-shadow 0.2s, background-color 0.2s;
}

/* Info text styling */
.text-amber-600 {
    font-weight: 500;
}
</style>
<?= $this->endSection() ?>
