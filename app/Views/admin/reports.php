<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">
        <i class="fas fa-file-chart-line"></i> Laporan
    </h1>
    <p class="text-gray-600">Statistik dan laporan bisnis SYH Cleaning</p>
</div>

<!-- Filter Date Range -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <form method="GET" action="<?= base_url('admin/reports') ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
            <input 
                type="date" 
                name="start_date" 
                value="<?= $start_date ?>" 
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" 
                required
            >
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
            <input 
                type="date" 
                name="end_date" 
                value="<?= $end_date ?>" 
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" 
                required
            >
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full px-6 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-medium flex items-center justify-center space-x-2">
                <i class="fas fa-filter"></i>
                <span>Filter</span>
            </button>
        </div>
        <div class="flex items-end">
            <a href="<?= base_url('admin/reports/print?start_date=' . $start_date . '&end_date=' . $end_date) ?>" 
               target="_blank" 
               class="w-full px-6 py-2.5 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition font-medium flex items-center justify-center space-x-2">
                <i class="fas fa-print"></i>
                <span>Cetak</span>
            </a>
        </div>
    </form>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Booking Card -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Booking</p>
                <h3 class="text-3xl font-bold mt-2"><?= $total_bookings ?></h3>
                <p class="text-blue-100 text-xs mt-1">Periode ini</p>
            </div>
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-shopping-bag text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Selesai Card -->
    <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Selesai</p>
                <h3 class="text-3xl font-bold mt-2"><?= $completed_bookings ?></h3>
                <p class="text-green-100 text-xs mt-1">Booking selesai</p>
            </div>
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Pending Card -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Pending</p>
                <h3 class="text-3xl font-bold mt-2"><?= $pending_bookings ?></h3>
                <p class="text-blue-100 text-xs mt-1">Menunggu proses</p>
            </div>
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-clock text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Pendapatan Card -->
    <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium">Total Pendapatan</p>
                <h3 class="text-2xl font-bold mt-2">Rp <?= number_format($total_revenue, 0, ',', '.') ?></h3>
                <p class="text-purple-100 text-xs mt-1">Dari booking selesai</p>
            </div>
            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Service Statistics -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <!-- Card Header -->
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-xl font-bold text-gray-800">Statistik Layanan</h3>
        <p class="text-sm text-gray-600 mt-1">Performa setiap layanan dalam periode yang dipilih</p>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <?php if (!empty($service_stats)): ?>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pendapatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rata-rata/Order</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($service_stats as $stat): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold mr-3">
                                        <i class="fas fa-shoe-prints"></i>
                                    </div>
                                    <span class="font-medium text-gray-800"><?= ucfirst(str_replace('-', ' ', $stat['service'])) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    <?= $stat['count'] ?> order
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-800">Rp <?= number_format($stat['revenue'], 0, ',', '.') ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-gray-700">Rp <?= number_format($stat['revenue'] / $stat['count'], 0, ',', '.') ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Total Summary -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex justify-between items-center">
                    <span class="text-gray-700 font-medium">Total</span>
                    <div class="flex space-x-8">
                        <span class="text-gray-700">
                            <span class="font-medium">Orders:</span> 
                            <span class="font-bold text-blue-600"><?= array_sum(array_column($service_stats, 'count')) ?></span>
                        </span>
                        <span class="text-gray-700">
                            <span class="font-medium">Pendapatan:</span> 
                            <span class="font-bold text-green-600">Rp <?= number_format(array_sum(array_column($service_stats, 'revenue')), 0, ',', '.') ?></span>
                        </span>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="p-12 text-center text-gray-500">
                <i class="fas fa-inbox text-5xl mb-4 text-gray-300"></i>
                <p class="text-lg">Belum ada data untuk periode ini</p>
                <p class="text-sm mt-2">Silakan pilih periode lain atau tunggu hingga ada booking</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
