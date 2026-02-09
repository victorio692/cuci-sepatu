<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="admin-container">
    <div style="margin-bottom: 2rem;">
        <a href="/admin/bookings" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Pesanan
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Main Details -->
        <div>
            <!-- Order Header -->
            <div class="admin-card" style="margin-bottom: 1.5rem;">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items: start; gap: 1rem;">
                        <div>
                            <h1 style="margin: 0 0 0.5rem 0; color: #1f2937;">
                                Pesanan #<?= $booking['id'] ?>
                            </h1>
                            <p style="margin: 0; color: #6b7280;">
                                <?= date('d M Y H:i', strtotime($booking['created_at'])) ?>
                            </p>
                            <?php
                            $statusLabels = [
                                'pending' => 'Menunggu Persetujuan',
                                'disetujui' => 'Disetujui',
                                'proses' => 'Sedang Diproses',
                                'selesai' => 'Selesai',
                                'ditolak' => 'Ditolak'
                            ];
                            $statusColors = [
                                'pending' => '#f59e0b',
                                'disetujui' => '#3b82f6',
                                'proses' => '#8b5cf6',
                                'selesai' => '#10b981',
                                'ditolak' => '#ef4444'
                            ];
                            ?>
                            <div style="margin-top: 1rem;">
                                <span style="background: <?= $statusColors[$booking['status']] ?? '#6b7280' ?>; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; display: inline-block;">
                                    <?= $statusLabels[$booking['status']] ?? ucfirst($booking['status']) ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                            <?php if ($booking['status'] === 'pending'): ?>
                                <button onclick="approveBooking()" class="btn" style="background: #10b981; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 600; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);">
                                    <i class="fas fa-check"></i> Setujui
                                </button>
                                <button onclick="showRejectModal()" class="btn" style="background: #ef4444; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 600; box-shadow: 0 4px 6px rgba(239, 68, 68, 0.3);">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            <?php elseif ($booking['status'] === 'disetujui'): ?>
                                <button onclick="changeStatus('proses')" class="btn" style="background: #8b5cf6; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 600; box-shadow: 0 4px 6px rgba(139, 92, 246, 0.3);">
                                    <i class="fas fa-cog"></i> Mulai Proses
                                </button>
                            <?php elseif ($booking['status'] === 'proses'): ?>
                                <button onclick="showCompleteModal()" class="btn" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 1rem 2rem; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 700; font-size: 1.1rem; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.4); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 30px rgba(16, 185, 129, 0.5)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(16, 185, 129, 0.4)'">
                                    <i class="fas fa-check-circle"></i> Upload Foto & Tandai Selesai
                                </button>
                            <?php elseif ($booking['status'] === 'selesai'): ?>
                                <button onclick="sendWhatsApp()" class="btn" style="background: #25D366; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 600; box-shadow: 0 4px 6px rgba(37, 211, 102, 0.3);">
                                    <i class="fab fa-whatsapp"></i> Kabari via WhatsApp
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Alasan Penolakan (jika ditolak) -->
                    <?php if ($booking['status'] === 'ditolak' && !empty($booking['alasan_penolakan'])): ?>
                        <div style="margin-top: 1.5rem; padding: 1rem; background: #fee2e2; border-left: 4px solid #ef4444; border-radius: 0.375rem;">
                            <div style="display: flex; align-items: start; gap: 0.75rem;">
                                <i class="fas fa-exclamation-circle" style="color: #ef4444; margin-top: 0.25rem;"></i>
                                <div>
                                    <strong style="color: #991b1b;">Alasan Penolakan:</strong>
                                    <p style="margin: 0.5rem 0 0; color: #7f1d1d;"><?= nl2br(htmlspecialchars($booking['alasan_penolakan'], ENT_QUOTES, 'UTF-8')) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="admin-card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 style="margin: 0; color: #1f2937;">
                        <i class="fas fa-user"></i> Informasi Pelanggan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <label>Nama:</label>
                        <span><?= $booking['full_name'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Email:</label>
                        <span><?= $booking['email'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Telepon:</label>
                        <span><?= $booking['phone'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Alamat:</label>
                        <span><?= $booking['address'] ?></span>
                    </div>
                    <div class="info-row">
                        <label>Kota:</label>
                        <span><?= $booking['city'] ?>, <?= $booking['province'] ?> <?= $booking['zip_code'] ?></span>
                    </div>
                </div>
            </div>

            <!-- Service & Items -->
            <div class="admin-card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 style="margin: 0; color: #1f2937;">
                        <i class="fas fa-shopping-bag"></i> Detail Pesanan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <label>Layanan:</label>
                        <span><?= ucfirst(str_replace('-', ' ', $booking['service'])) ?></span>
                    </div>
                    <div class="info-row">
                        <label>Kondisi Sepatu:</label>
                        <span><?= ucfirst(str_replace('_', ' ', $booking['shoe_condition'])) ?></span>
                    </div>
                    <div class="info-row">
                        <label>Jumlah:</label>
                        <span><?= $booking['quantity'] ?> pasang</span>
                    </div>
                </div>
            </div>

            <!-- Foto Sepatu dari Customer -->
            <?php if (!empty($photos) && count($photos) > 0): ?>
                <div class="admin-card" style="margin-bottom: 1.5rem;">
                    <div class="card-header">
                        <h3 style="margin: 0; color: #1f2937;">
                            <i class="fas fa-camera"></i> Foto Sepatu dari Customer (<?= count($photos) ?>)
                        </h3>
                    </div>
                    <div class="card-body">
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                            <?php foreach ($photos as $photo): ?>
                                <div style="position: relative; border-radius: 0.5rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); cursor: pointer;" onclick="openPhotoModal('<?= base_url('uploads/' . $photo['photo_path']) ?>')">
                                    <img 
                                        src="<?= base_url('uploads/' . $photo['photo_path']) ?>" 
                                        alt="Foto Sepatu" 
                                        style="width: 100%; height: 200px; object-fit: cover;"
                                        onerror="this.src='<?= base_url('assets/images/no-image.png') ?>'"
                                    >
                                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); padding: 0.5rem; color: white; font-size: 0.75rem;">
                                        <i class="fas fa-search-plus"></i> Klik untuk memperbesar
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Foto Sepatu Lama -->
            <?php if (!empty($booking['foto_sepatu'])): ?>
                <div class="admin-card" style="margin-bottom: 1.5rem;">
                    <div class="card-header">
                        <h3 style="margin: 0; color: #1f2937;">
                            <i class="fas fa-camera"></i> Foto Kondisi Sepatu
                        </h3>
                    </div>
                    <div class="card-body">
                        <div style="text-align: center;">
                            <img 
                                src="<?= base_url('uploads/' . $booking['foto_sepatu']) ?>" 
                                alt="Foto Sepatu" 
                                style="max-width: 100%; height: auto; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); cursor: pointer;"
                                onclick="openPhotoModal(this.src)"
                            >
                            <p style="margin: 1rem 0 0; color: #6b7280; font-size: 0.9rem;">
                                <i class="fas fa-info-circle"></i> Klik gambar untuk memperbesar
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Foto Hasil Cucian (Setelah) -->
            <?php if (!empty($booking['foto_hasil']) && $booking['status'] === 'selesai'): ?>
                <div class="admin-card" style="margin-bottom: 1.5rem; border: 2px solid #10b981;">
                    <div class="card-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <h3 style="margin: 0; color: white;">
                            <i class="fas fa-check-circle"></i> Foto Hasil Cucian (Dikirim ke Customer)
                        </h3>
                    </div>
                    <div class="card-body">
                        <div style="text-align: center;">
                            <img 
                                src="<?= base_url('uploads/' . $booking['foto_hasil']) ?>" 
                                alt="Foto Hasil Cucian" 
                                style="max-width: 100%; height: auto; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3); cursor: pointer;"
                                onclick="openPhotoModal(this.src)"
                            >
                            <p style="margin: 1rem 0 0; color: #059669; font-size: 0.9rem; font-weight: 600;">
                                <i class="fas fa-check-double"></i> Foto ini sudah dikirim ke customer
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Delivery Info -->
            <div class="admin-card">
                <div class="card-header">
                    <h3 style="margin: 0; color: #1f2937;">
                        <i class="fas fa-truck"></i> Pengiriman
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <label>Tipe Pengiriman:</label>
                        <span><?= ucfirst(str_replace('-', ' ', $booking['delivery_option'])) ?></span>
                    </div>
                    <div class="info-row">
                        <label>Tanggal Pengiriman:</label>
                        <span><?= date('d M Y', strtotime($booking['delivery_date'])) ?></span>
                    </div>
                    <div class="info-row">
                        <label>Alamat Pengiriman:</label>
                        <span><?= $booking['delivery_address'] ?></span>
                    </div>
                    <?php if (!empty($booking['notes'])): ?>
                        <div class="info-row">
                            <label>Catatan:</label>
                            <span><?= $booking['notes'] ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar Summary -->
        <div>
            <!-- Price Summary -->
            <div class="admin-card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none; border-radius: 1rem; overflow: hidden;">
                <div style="padding: 1.5rem;">
                    <h3 style="margin: 0 0 1.5rem 0; color: white; font-size: 1.25rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-receipt"></i> Ringkasan Booking
                    </h3>
                    <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                            <span style="color: rgba(255, 255, 255, 0.9);">Layanan:</span>
                            <span style="color: white; font-weight: 600;">
                                <?php
                                $serviceName = match($booking['service']) {
                                    'fast-cleaning' => 'Fast Cleaning',
                                    'deep-cleaning' => 'Deep Cleaning',
                                    'white-shoes' => 'White Shoes',
                                    'suede-treatment' => 'Suede Treatment',
                                    'unyellowing' => 'Unyellowing',
                                    default => $booking['service']
                                };
                                echo $serviceName;
                                ?>
                            </span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.75rem;">
                            <span style="color: rgba(255, 255, 255, 0.9);">Harga/Sepatu</span>
                            <span style="color: white; font-weight: 600;">Rp <?= number_format($booking['subtotal'] / $booking['quantity'], 0, ',', '.') ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: rgba(255, 255, 255, 0.9);">Jumlah</span>
                            <span style="color: white; font-weight: 600;"><?= $booking['quantity'] ?> pasang</span>
                        </div>
                    </div>
                    <div style="background: white; padding: 1rem; border-radius: 0.5rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="color: #374151;">Subtotal:</span>
                            <span style="color: #374151; font-weight: 600;">Rp <?= number_format($booking['subtotal'], 0, ',', '.') ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding-bottom: 0.75rem; border-bottom: 1px solid #e5e7eb;">
                            <span style="color: #374151;">Biaya Pengiriman:</span>
                            <span style="color: #374151; font-weight: 600;">Rp <?= number_format($booking['delivery_fee'], 0, ',', '.') ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-top: 0.75rem;">
                            <span style="color: #374151; font-weight: 700; font-size: 1.1rem;">Total</span>
                            <span style="color: #3b82f6; font-size: 1.5rem; font-weight: 700;">Rp <?= number_format($booking['total'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                    <div style="margin-top: 1rem; padding: 0.75rem; background: rgba(59, 130, 246, 0.2); border-radius: 0.5rem; border-left: 4px solid rgba(255, 255, 255, 0.5);">
                        <p style="margin: 0; color: white; font-size: 0.875rem; display: flex; align-items: start; gap: 0.5rem;">
                            <i class="fas fa-info-circle" style="margin-top: 0.125rem;"></i>
                            <span>Anda dapat booking untuk hari ini atau hari lainnya. Untuk konfirmasi lebih lanjut hubungi kami.</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="admin-card">
                <div class="card-header">
                    <h3 style="margin: 0; color: #1f2937;">
                        <i class="fas fa-clock"></i> Timeline
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline-item">
                        <div class="timeline-status completed">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <strong>Dibuat</strong>
                            <p style="margin: 0.25rem 0 0; color: #6b7280; font-size: 0.9rem;">
                                <?= date('d M Y H:i', strtotime($booking['created_at'])) ?>
                            </p>
                        </div>
                    </div>

                    <?php
                    $statuses = ['pending' => 'Pending', 'approved' => 'Disetujui', 'in_progress' => 'Sedang Diproses', 'completed' => 'Selesai'];
                    $status_order = ['pending', 'approved', 'in_progress', 'completed'];
                    $current_status = $booking['status'];
                    ?>

                    <?php foreach ($status_order as $status): ?>
                        <?php if ($status !== 'pending'): ?>
                            <div class="timeline-item">
                                <div class="timeline-status <?= (array_search($current_status, $status_order) >= array_search($status, $status_order)) ? 'completed' : 'pending' ?>">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div>
                                    <strong><?= $statuses[$status] ?></strong>
                                    <p style="margin: 0.25rem 0 0; color: #6b7280; font-size: 0.9rem;">
                                        <?= (array_search($current_status, $status_order) >= array_search($status, $status_order)) ? 'Selesai' : 'Menunggu' ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Photo Modal -->
<div id="photoModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.9);" onclick="closePhotoModal()">
    <span style="position: absolute; top: 20px; right: 40px; color: white; font-size: 40px; font-weight: bold; cursor: pointer;">&times;</span>
    <img id="modalPhoto" style="margin: auto; display: block; max-width: 90%; max-height: 90%; margin-top: 50px;">
</div>

<!-- Reject Modal -->
<div id="rejectModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5);">
    <div style="background: white; max-width: 500px; margin: 100px auto; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
        <h3 style="margin: 0 0 1rem 0; color: #1f2937;">
            <i class="fas fa-times-circle" style="color: #ef4444;"></i> Tolak Pesanan
        </h3>
        <p style="color: #6b7280; margin-bottom: 1.5rem;">Berikan alasan kenapa pesanan ini ditolak:</p>
        
        <textarea 
            id="rejectReason" 
            rows="4" 
            style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; font-family: inherit;"
            placeholder="Contoh: Stok bahan habis, jadwal penuh, dll..."
        ></textarea>
        
        <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
            <button onclick="confirmReject()" class="btn" style="flex: 1; background: #ef4444; color: white; padding: 0.75rem;">
                <i class="fas fa-times"></i> Tolak Pesanan
            </button>
            <button onclick="closeRejectModal()" class="btn" style="flex: 1; background: #6b7280; color: white; padding: 0.75rem;">
                <i class="fas fa-ban"></i> Batal
            </button>
        </div>
    </div>
</div>

<!-- Complete Modal with Photo Upload -->
<div id="completeModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7); backdrop-filter: blur(4px); overflow-y: auto; padding: 20px 0;">
    <div style="background: white; max-width: 600px; margin: 20px auto; padding: 0; border-radius: 1rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow: hidden;">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 1.5rem; text-align: center;">
            <div style="width: 60px; height: 60px; background: white; border-radius: 50%; margin: 0 auto 0.75rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);">
                <i class="fas fa-camera" style="font-size: 1.75rem; color: #10b981;"></i>
            </div>
            <h3 style="margin: 0; color: white; font-size: 1.5rem; font-weight: 700;">
                Upload Foto Hasil Cucian
            </h3>
            <p style="margin: 0.5rem 0 0; color: rgba(255, 255, 255, 0.9); font-size: 0.95rem;">
                Pesanan #<?= $booking['id'] ?> - <?= $booking['full_name'] ?>
            </p>
        </div>

        <!-- Body -->
        <div style="padding: 1.5rem;">
            <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 0.875rem; border-radius: 0.5rem; margin-bottom: 1.25rem;">
                <div style="display: flex; align-items: start; gap: 0.75rem;">
                    <i class="fas fa-exclamation-triangle" style="color: #f59e0b; font-size: 1.1rem; margin-top: 0.25rem;"></i>
                    <div>
                        <strong style="color: #92400e; display: block; margin-bottom: 0.25rem; font-size: 0.95rem;">Penting!</strong>
                        <p style="margin: 0; color: #78350f; font-size: 0.875rem; line-height: 1.5;">
                            Upload foto hasil cucian sepatu yang sudah selesai dikerjakan. Foto ini akan dikirim ke customer sebagai bukti pekerjaan selesai.
                        </p>
                    </div>
                </div>
            </div>
            
            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.75rem; font-size: 1rem;">
                    <i class="fas fa-image"></i> Pilih Foto Hasil Cucian <span style="color: #ef4444;">*</span>
                </label>
                <input 
                    type="file" 
                    id="fotoHasil" 
                    accept="image/jpeg,image/jpg,image/png"
                    style="width: 100%; padding: 0.875rem; border: 2px dashed #d1d5db; border-radius: 0.5rem; cursor: pointer; font-size: 0.95rem;"
                    onchange="this.style.borderColor='#10b981'"
                >
                <div style="display: flex; gap: 1rem; margin-top: 0.625rem;">
                    <small style="color: #6b7280; display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem;">
                        <i class="fas fa-check-circle" style="color: #10b981;"></i> Format: JPG, JPEG, PNG
                    </small>
                    <small style="color: #6b7280; display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem;">
                        <i class="fas fa-check-circle" style="color: #10b981;"></i> Maksimal: 5MB
                    </small>
                </div>
            </div>

            <!-- Preview -->
            <div id="previewContainer" style="display: none; margin-bottom: 1.25rem;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.625rem; font-size: 0.95rem;">
                    <i class="fas fa-eye"></i> Preview Foto:
                </label>
                <div style="text-align: center; padding: 0.75rem; background: #f9fafb; border-radius: 0.5rem; border: 2px solid #10b981;">
                    <img id="previewImage" style="max-width: 100%; max-height: 250px; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div style="background: #f9fafb; padding: 1.25rem 1.5rem; display: flex; gap: 1rem; border-top: 1px solid #e5e7eb;">
            <button onclick="confirmComplete()" class="btn" style="flex: 1; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 0.875rem; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 700; font-size: 1rem; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3); transition: all 0.2s;">
                <i class="fas fa-check-circle"></i> Upload & Tandai Selesai
            </button>
            <button onclick="closeCompleteModal()" class="btn" style="flex: 1; background: #e5e7eb; color: #374151; padding: 0.875rem; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 600; font-size: 1rem; transition: all 0.2s;">
                <i class="fas fa-times"></i> Batal
            </button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('extra_css') ?>
<style>
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background-color: #e5e7eb;
    color: #374151;
    text-decoration: none;
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background-color: #d1d5db;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.info-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f3f4f6;
}

.info-row:last-child {
    border-bottom: none;
}

.info-row label {
    font-weight: 600;
    color: #6b7280;
}

.info-row span {
    color: #1f2937;
    text-align: right;
}

.status-select-detail {
    padding: 0.75rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
    background-color: white;
}

.status-select-detail:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    color: #374151;
}

.timeline-item {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    position: relative;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 12px;
    top: 40px;
    width: 2px;
    height: calc(100% + 0.5rem);
    background-color: #e5e7eb;
}

.timeline-status {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 0.75rem;
}

.timeline-status.completed {
    background-color: #d1fae5;
    color: #065f46;
}

.timeline-status.pending {
    background-color: #fee2e2;
    color: #991b1b;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('extra_js') ?>
<script>
const bookingId = <?= $booking['id'] ?>;

function approveBooking() {
    if (!confirm('Apakah Anda yakin ingin menyetujui pesanan ini?')) return;
    
    changeStatus('disetujui');
}

function showRejectModal() {
    document.getElementById('rejectModal').style.display = 'block';
}

function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
    document.getElementById('rejectReason').value = '';
}

function showCompleteModal() {
    document.getElementById('completeModal').style.display = 'block';
}

function closeCompleteModal() {
    document.getElementById('completeModal').style.display = 'none';
    document.getElementById('fotoHasil').value = '';
    document.getElementById('previewContainer').style.display = 'none';
}

// Preview foto sebelum upload
document.addEventListener('DOMContentLoaded', function() {
    const fotoInput = document.getElementById('fotoHasil');
    if (fotoInput) {
        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImage').src = e.target.result;
                    document.getElementById('previewContainer').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    }
});

function confirmComplete() {
    const fotoInput = document.getElementById('fotoHasil');
    const file = fotoInput.files[0];
    
    if (!file) {
        alert('Foto hasil cucian wajib diupload!');
        return;
    }

    // Validate file type
    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!validTypes.includes(file.type)) {
        alert('Format foto harus JPG, JPEG, atau PNG!');
        return;
    }

    // Validate file size (max 5MB)
    if (file.size > 5 * 1024 * 1024) {
        alert('Ukuran foto maksimal 5MB!');
        return;
    }

    const formData = new FormData();
    formData.append('status', 'selesai');
    formData.append('foto_hasil', file);

    // Show loading indicator
    const submitBtn = event.target;
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload...';
    }

    // Use POST for file upload (PUT doesn't support multipart/form-data properly)
    fetch('<?= base_url() ?>/admin/bookings/' + bookingId + '/status', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Close modal
            closeCompleteModal();
            
            // Show success message
            alert('✅ Pesanan berhasil ditandai selesai!\n\n📸 Foto hasil cucian telah diupload\n🔔 Customer telah menerima notifikasi\n📦 Sepatu siap diambil/diantar');
            
            // Reload page to show updated status
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            alert('❌ Error: ' + (data.message || 'Gagal mengubah status'));
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> Upload & Tandai Selesai';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan saat upload foto.\n\nCek console untuk detail atau coba lagi.');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check-circle"></i> Upload & Tandai Selesai';
        }
    });
}

function confirmReject() {
    const reason = document.getElementById('rejectReason').value.trim();
    
    if (!reason) {
        alert('Alasan penolakan harus diisi!');
        return;
    }
    
    fetch('<?= base_url() ?>/admin/bookings/' + bookingId + '/status', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
            status: 'ditolak',
            alasan_penolakan: reason
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Pesanan berhasil ditolak');
            location.reload();
        } else {
            alert(data.message || 'Gagal menolak pesanan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

function changeStatus(newStatus) {
    fetch('<?= base_url() ?>/admin/bookings/' + bookingId + '/status', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Status berhasil diubah');
            
            // If completed, show WhatsApp option
            if (data.show_whatsapp) {
                if (confirm('Status berhasil diubah menjadi Selesai. Apakah Anda ingin langsung mengirim notifikasi WhatsApp ke customer?')) {
                    sendWhatsApp();
                } else {
                    location.reload();
                }
            } else {
                location.reload();
            }
        } else {
            alert(data.message || 'Gagal mengubah status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

function sendWhatsApp() {
    fetch('<?= base_url() ?>/notifications/sendWhatsApp/' + bookingId)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.open(data.whatsapp_link, '_blank');
        } else {
            alert(data.message || 'Gagal membuat link WhatsApp');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
}

function openPhotoModal(src) {
    const modal = document.getElementById('photoModal');
    const modalImg = document.getElementById('modalPhoto');
    modal.style.display = 'block';
    modalImg.src = src;
}

function closePhotoModal() {
    document.getElementById('photoModal').style.display = 'none';
}

// Close modal when ESC key is pressed
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closePhotoModal();
        closeRejectModal();
    }
});
</script>
<?= $this->endSection() ?>
