<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Pengguna</h1>
        <p class="text-gray-600">Kelola pengguna dan akses mereka</p>
    </div>
    <a href="/admin/users/create" class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-medium flex items-center space-x-2">
        <i class="fas fa-plus"></i>
        <span>Tambah User</span>
    </a>
</div>

<!-- Filter & Search -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <form action="/admin/users" method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Pengguna</label>
            <div class="relative">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari nama, email, nomor telepon..." 
                    value="<?= $search ?>"
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                >
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <div class="flex items-end">
            <button type="submit" class="w-full px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-medium flex items-center justify-center space-x-2">
                <i class="fas fa-search"></i>
                <span>Cari</span>
            </button>
        </div>
    </form>
</div>

<!-- Users Table -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <?php if (!empty($users)): ?>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-800">#<?= $user['id'] ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white font-bold mr-3">
                                        <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                                    </div>
                                    <span class="font-medium text-gray-800"><?= $user['full_name'] ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-700"><?= $user['email'] ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $user['phone'] ?? '') ?>" target="_blank" class="text-green-600 hover:text-green-700 flex items-center space-x-1">
                                    <i class="fab fa-whatsapp"></i>
                                    <span class="text-sm"><?= $user['phone'] ?></span>
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-700"><?= date('d M Y', strtotime($user['created_at'])) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <button 
                                    class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-lg text-sm font-medium transition cursor-pointer
                                        <?= $user['is_active'] ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' ?>"
                                    onclick="toggleUserActive(this, <?= $user['id'] ?>)"
                                    title="Click to toggle"
                                >
                                    <i class="fas fa-<?= $user['is_active'] ? 'check-circle' : 'ban' ?>"></i>
                                    <span><?= $user['is_active'] ? 'Active' : 'Inactive' ?></span>
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <a href="/admin/users/<?= $user['id'] ?>" 
                                       class="inline-flex items-center space-x-1 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm">
                                        <i class="fas fa-eye"></i>
                                        <span>Lihat</span>
                                    </a>
                                    <a href="/admin/users/edit/<?= $user['id'] ?>" 
                                       class="inline-flex items-center space-x-1 px-3 py-1.5 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition text-sm">
                                        <i class="fas fa-edit"></i>
                                        <span>Edit</span>
                                    </a>
                                    <a href="/admin/users/delete/<?= $user['id'] ?>" 
                                       onclick="return confirm('Yakin ingin menghapus user ini?')"
                                       class="inline-flex items-center space-x-1 px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm">
                                        <i class="fas fa-trash"></i>
                                        <span>Hapus</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Total Count -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 text-center text-gray-600">
                Total: <span class="font-semibold"><?= $pager['total'] ?></span> pengguna
                <?php if ($pager['total'] > 0): ?>
                    | Menampilkan <?= (($pager['currentPage'] - 1) * $pager['perPage']) + 1 ?> - <?= min($pager['currentPage'] * $pager['perPage'], $pager['total']) ?>
                <?php endif; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($pager['totalPages'] > 1): ?>
            <div class="px-6 py-4 border-t border-gray-200 bg-white">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Halaman <?= $pager['currentPage'] ?> dari <?= $pager['totalPages'] ?>
                    </div>
                    <div class="flex space-x-1">
                        <!-- Previous Button -->
                        <?php if ($pager['currentPage'] > 1): ?>
                            <a href="?page=<?= $pager['currentPage'] - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
                               class="px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        <?php else: ?>
                            <span class="px-3 py-2 bg-gray-100 border border-gray-200 text-gray-400 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        <?php endif; ?>
                        
                        <!-- Page Numbers -->
                        <?php 
                        $startPage = max(1, $pager['currentPage'] - 2);
                        $endPage = min($pager['totalPages'], $pager['currentPage'] + 2);
                        
                        if ($startPage > 1): ?>
                            <a href="?page=1<?= $search ? '&search=' . urlencode($search) : '' ?>" 
                               class="px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                1
                            </a>
                            <?php if ($startPage > 2): ?>
                                <span class="px-3 py-2 text-gray-400">...</span>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <?php if ($i == $pager['currentPage']): ?>
                                <span class="px-3 py-2 bg-blue-600 text-white rounded-lg font-semibold">
                                    <?= $i ?>
                                </span>
                            <?php else: ?>
                                <a href="?page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
                                   class="px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                    <?= $i ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        
                        <?php if ($endPage < $pager['totalPages']): ?>
                            <?php if ($endPage < $pager['totalPages'] - 1): ?>
                                <span class="px-3 py-2 text-gray-400">...</span>
                            <?php endif; ?>
                            <a href="?page=<?= $pager['totalPages'] ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
                               class="px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                <?= $pager['totalPages'] ?>
                            </a>
                        <?php endif; ?>
                        
                        <!-- Next Button -->
                        <?php if ($pager['currentPage'] < $pager['totalPages']): ?>
                            <a href="?page=<?= $pager['currentPage'] + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
                               class="px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php else: ?>
                            <span class="px-3 py-2 bg-gray-100 border border-gray-200 text-gray-400 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="p-12 text-center text-gray-500">
                <i class="fas fa-users text-5xl mb-4 text-gray-300"></i>
                <p class="text-lg">Tidak ada pengguna</p>
                <p class="text-sm mt-2">Pengguna akan muncul di sini setelah registrasi</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
function toggleUserActive(element, userId) {
    fetch('/admin/users/' + userId + '/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
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
        showToast('Gagal update status pengguna', 'error');
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
