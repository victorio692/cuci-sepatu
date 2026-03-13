<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-2xl md:text-2xl font-bold text-gray-800 mb-2">Pelanggan</h1>
        <p class="text-sm md:text-base text-gray-600">Kelola pelanggan dan akses mereka</p>
    </div>
   <a href="/admin/users/create" class="w-full md:w-auto px-3 md:px-4 py-1.5 md:py-2 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs md:text-sm rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-medium flex items-center justify-center md:justify-start space-x-2">
    <i class="fas fa-plus text-xs md:text-sm"></i>
    <span>Tambah Pelanggan</span>
</a>
</div>

<!-- Filter & Search -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Pelanggan</label>
            <div class="relative">
                <input 
                    type="text" 
                    id="searchInput"
                    placeholder="Cari nama, email, nomor telepon..." 
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                >
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <div class="flex items-end">
            <button type="button" onclick="applyUserSearch()" class="w-full px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-medium flex items-center justify-center space-x-2">
                <i class="fas fa-search"></i>
                <span>Cari</span>
            </button>
        </div>
    </div>
</div>

<!-- Users Table -->
<div id="usersContainer" class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="w-full flex justify-center py-12">
        <div class="animate-spin">
            <i class="fas fa-spinner text-blue-500 text-4xl"></i>
        </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
// Pagination state for users page
let currentUserPage = 1;
let currentUserSearch = '';

// Load users from API
async function loadUsers(search = '', page = 1) {
    const container = document.getElementById('usersContainer');
    currentUserPage = page;
    currentUserSearch = search;
    
    try {
        console.log('🚀 Loading users from API...', { search, page });
        let url = '/api/users';
        const params = new URLSearchParams();
        
        if (search) params.append('search', encodeURIComponent(search));
        if (page > 1) params.append('page', page);
        
        if (params.toString()) {
            url += '?' + params.toString();
        }
        
        const response = await fetch(url, {
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
        console.log('✅ Users loaded:', result);

        // Handle API response structure
        const users = result.data?.users || result.data || [];
        const pagination = result.data?.pagination || {};
        const total = pagination.total || users.length;
        
        console.log('📊 Extracted users:', users);
        console.log('📊 Pagination:', pagination);

        if (users && users.length > 0) {
            renderUsersTable(users, total, pagination);
        } else {
            renderEmptyState();
        }
    } catch (error) {
        console.error('❌ Error loading users:', error);
        container.innerHTML = `
            <div class="p-12 text-center bg-red-50">
                <i class="fas fa-exclamation-circle text-red-500 text-6xl mb-4"></i>
                <h3 class="text-xl font-bold text-red-700 mb-2">Gagal Memuat Data Pengguna</h3>
                <p class="text-red-600 mb-4">${error.message}</p>
                <button onclick="loadUsers()" 
                        class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition">
                    <i class="fas fa-redo mr-2"></i>Coba Lagi
                </button>
            </div>
        `;
    }
}

// Apply search filter for users
function applyUserSearch() {
    const searchInput = document.getElementById('searchInput');
    const search = searchInput?.value || '';
    loadUsers(search, 1);  // Reset to page 1 when searching
}

// Render users table
function renderUsersTable(users, total, pagination = {}) {
    const container = document.getElementById('usersContainer');
    
    const tableHTML = `
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    ${users.map(user => {
                        const name = user.full_name || user.nama_lengkap || user.nama || '-';
                        const phone = user.phone || user.no_hp || user.telepon || '-';
                        const email = user.email || '-';
                        const createdAt = new Date(user.created_at || user.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' });
                        const isActive = user.is_active !== false && user.is_active !== 0; // default true if not explicitly false
                        
                        return `
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-3 py-3 whitespace-nowrap">
                                <span class="font-semibold text-xs text-gray-800">#${user.id}</span>
                            </td>
                            <td class="px-3 py-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-xs mr-2">
                                        ${name.charAt(0).toUpperCase()}
                                    </div>
                                    <span class="font-medium text-sm text-gray-800">${name}</span>
                                </div>
                            </td>
                            <td class="px-3 py-3">
                                <span class="text-xs text-gray-700">${email}</span>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap">
                                <a href="https://wa.me/${phone.replace(/[^0-9]/g, '')}" target="_blank" class="text-green-600 hover:text-green-700 flex items-center space-x-0.5">
                                    <i class="fab fa-whatsapp text-sm"></i>
                                    <span class="text-xs">${phone}</span>
                                </a>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap">
                                <span class="text-xs text-gray-700">${createdAt}</span>
                            </td>
                            <td class="px-3 py-3">
                                <button 
                                    class="inline-flex items-center space-x-1 px-2 py-1 rounded text-xs font-medium transition cursor-pointer
                                        ${isActive ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200'}"
                                    onclick="toggleUserActive(this, ${user.id})"
                                    title="Click to toggle"
                                >
                                    <i class="fas fa-${isActive ? 'check-circle' : 'ban'}" style="font-size: 0.7rem;"></i>
                                    <span>${isActive ? 'Active' : 'Inactive'}</span>
                                </button>
                            </td>
                            <td class="px-2 py-3 whitespace-nowrap">
                                <div class="flex items-center space-x-0.5">
                                    <a href="/admin/users/${user.id}" 
                                       class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-xs" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="/admin/users/edit/${user.id}" 
                                       class="inline-flex items-center justify-center w-8 h-8 bg-yellow-50 text-yellow-600 rounded hover:bg-yellow-100 transition text-xs" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/admin/users/delete/${user.id}" 
                                       onclick="return confirm('Yakin ingin menghapus user ini?')"
                                       class="inline-flex items-center justify-center w-8 h-8 bg-red-50 text-red-600 rounded hover:bg-red-100 transition text-xs" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `}).join('')}
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 text-center text-gray-600">
                Total: <span class="font-semibold">${total || users.length}</span> pengguna
            </div>
        </div>
    `;
    
    // Add pagination if available
    let paginationHTML = '';
    // Check if pagination exists and there are multiple pages
    const hasPagination = pagination && (pagination.last_page > 1 || pagination.total > users.length);
    
    if (hasPagination) {
        const currentPage = pagination.current_page || 1;
        const lastPage = pagination.last_page || Math.ceil((pagination.total || 0) / 10);
        const totalItems = pagination.total || 0;
        
        paginationHTML = `
            <div class="px-4 md:px-6 py-5 border-t-2 border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-700 font-semibold">
                        <i class="fas fa-list mr-2 text-blue-600"></i>
                        Total: <span class="text-gray-900 font-bold text-lg">${totalItems}</span> pengguna | 
                        Halaman <span class="text-blue-600 font-bold">${currentPage}</span> dari <span class="text-blue-600 font-bold">${lastPage}</span>
                    </div>
                    
                    <div class="flex items-center gap-2 flex-wrap justify-center sm:justify-end">
                        ${currentPage > 1 ? `<button onclick="paginateUsers(${currentPage - 1})" class="px-3 py-2 text-sm bg-white border-2 border-blue-400 text-blue-600 rounded-lg hover:bg-blue-50 transition font-semibold shadow-sm"><i class="fas fa-chevron-left mr-1"></i></button>` : `<button disabled class="px-3 py-2 text-sm bg-gray-100 border-2 border-gray-300 text-gray-400 rounded-lg cursor-not-allowed font-semibold"><i class="fas fa-chevron-left mr-1"></i></button>`}
                        <div class="flex gap-1">
                            ${generateUserPageNumbers(currentPage, lastPage)}
                        </div>
                        ${currentPage < lastPage ? `<button onclick="paginateUsers(${currentPage + 1})" class="px-3 py-2 text-sm bg-white border-2 border-blue-400 text-blue-600 rounded-lg hover:bg-blue-50 transition font-semibold shadow-sm"><i class="fas fa-chevron-right ml-1"></i></button>` : `<button disabled class="px-3 py-2 text-sm bg-gray-100 border-2 border-gray-300 text-gray-400 rounded-lg cursor-not-allowed font-semibold"><i class="fas fa-chevron-right ml-1"></i></button>`}
                    </div>
                </div>
            </div>
        `;
    }
    
    container.innerHTML = tableHTML + paginationHTML;
}

// Helper function for pagination navigation
function paginateUsers(page) {
    loadUsers(currentUserSearch, page);
}

// Generate page numbers for user pagination
function generateUserPageNumbers(currentPage, totalPages) {
    let html = '';
    
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);
    
    // Show first page if not visible
    if (startPage > 1) {
        html += `<button onclick="paginateUsers(1)" class="px-3 py-2 text-sm bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">1</button>`;
        if (startPage > 2) {
            html += `<span class="px-2 py-2 text-gray-400 font-bold">...</span>`;
        }
    }
    
    // Show page numbers
    for (let i = startPage; i <= endPage; i++) {
        if (i === currentPage) {
            html += `<button class="px-4 py-2 text-sm bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-bold shadow-md">${i}</button>`;
        } else {
            html += `<button onclick="paginateUsers(${i})" class="px-3 py-2 text-sm bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">${i}</button>`;
        }
    }
    
    // Show last page if not visible
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            html += `<span class="px-2 py-2 text-gray-400 font-bold">...</span>`;
        }
        html += `<button onclick="paginateUsers(${totalPages})" class="px-3 py-2 text-sm bg-white border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">${totalPages}</button>`;
    }
    
    return html;
}

// Render empty state
function renderEmptyState() {
    const container = document.getElementById('usersContainer');
    container.innerHTML = `
        <div class="p-12 text-center text-gray-500">
            <i class="fas fa-users text-5xl mb-4 text-gray-300"></i>
            <p class="text-lg">Tidak ada pengguna</p>
            <p class="text-sm mt-2">Pengguna akan muncul di sini setelah registrasi</p>
        </div>
    `;
}

// Toggle user active status
function toggleUserActive(element, userId) {
    fetch(`/admin/users/${userId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'include'
    })
    .then(response => response.json())
    .then(data => {
        const isNowActive = data.is_active;
        
        // Update button appearance
        element.className = 'inline-flex items-center space-x-1 px-3 py-1.5 rounded-lg text-sm font-medium transition cursor-pointer ' + 
            (isNowActive ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200');
        
        element.innerHTML = `
            <i class="fas fa-${isNowActive ? 'check-circle' : 'ban'}"></i>
            <span>${isNowActive ? 'Active' : 'Inactive'}</span>
        `;
        
        showToast('Status pengguna berhasil diupdate', 'success');
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Gagal update status pengguna: ' + error.message, 'error');
    });
}

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

// Load users on page load
document.addEventListener('DOMContentLoaded', () => loadUsers(''));

// Add Enter key to search input
document.getElementById('searchInput')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        applyUserSearch();
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