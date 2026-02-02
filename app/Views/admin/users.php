<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <div class="admin-header">
        <h1>Pengguna</h1>
        <p>Kelola pengguna dan akses mereka</p>
    </div>

    <!-- Filter & Search -->
    <div class="admin-card" style="margin-bottom: 2rem;">
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; align-items: end;">
                <form action="/admin/users" method="GET" style="display: contents;">
                    <div>
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Cari nama, email, nomor telepon..." 
                            value="<?= $search ?>"
                            class="form-control"
                        >
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="admin-card">
        <div class="card-body" style="padding: 0;">
            <?php if (!empty($users)): ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Bergabung</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><strong>#<?= $user['id'] ?></strong></td>
                                <td>
                                    <div>
                                        <strong><?= $user['full_name'] ?></strong>
                                    </div>
                                </td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['phone'] ?></td>
                                <td><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                                <td>
                                    <button 
                                        class="status-badge <?= $user['is_active'] ? 'active' : 'inactive' ?>"
                                        onclick="toggleUserActive(this, <?= $user['id'] ?>)"
                                        title="Click to toggle"
                                    >
                                        <i class="fas fa-<?= $user['is_active'] ? 'check-circle' : 'ban' ?>"></i>
                                        <?= $user['is_active'] ? 'Active' : 'Inactive' ?>
                                    </button>
                                </td>
                                <td>
                                    <a href="/admin/users/<?= $user['id'] ?>" class="btn-link">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Total Users -->
                <div style="padding: 1.5rem; border-top: 1px solid #e5e7eb; text-align: center; color: #6b7280;">
                    Total: <?= count($users) ?> pengguna
                </div>
            <?php else: ?>
                <div style="padding: 2rem; text-align: center; color: #6b7280;">
                    <i class="fas fa-users" style="font-size: 3rem; color: #d1d5db;"></i>
                    <p style="margin-top: 1rem;">Tidak ada pengguna</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
<style>
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.status-badge.active {
    background-color: #d1fae5;
    color: #065f46;
}

.status-badge.active:hover {
    background-color: #a7f3d0;
}

.status-badge.inactive {
    background-color: #fee2e2;
    color: #991b1b;
}

.status-badge.inactive:hover {
    background-color: #fecaca;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
function toggleUserActive(element, userId) {
    AdminAPI.post('/users/' + userId + '/toggle', {})
        .then(data => {
            // Toggle the status
            const badge = element;
            const isNowActive = data.is_active;
            
            if (isNowActive) {
                badge.classList.remove('inactive');
                badge.classList.add('active');
                badge.innerHTML = '<i class="fas fa-check-circle"></i> Active';
            } else {
                badge.classList.remove('active');
                badge.classList.add('inactive');
                badge.innerHTML = '<i class="fas fa-ban"></i> Inactive';
            }
            
            showToast('User status updated', 'success');
        })
        .catch(error => {
            showToast('Failed to update user status', 'danger');
        });
}
</script>
<?= $this->endSection() ?>
