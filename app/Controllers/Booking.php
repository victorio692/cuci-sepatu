<?php

namespace App\Controllers;

use Config\Database;

class Booking extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Tampolkan form booking
    public function makeBooking()
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if (!$user) {
            return redirect()->to('/login')->with('error', 'User tidak ditemukan');
        }

        // Cek jika admin, redirect ke admin dashboard
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin')->with('error', 'Admin tidak bisa membuat booking dari sini');
        }

        // Ambil data layanan dari database
        $services = $this->db->table('services')
            ->where('aktif', 1)
            ->orderBy("FIELD(kode_layanan, 'fast-cleaning', 'deep-cleaning', 'white-shoes', 'suede-treatment', 'unyellowing')", '', false)
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Pesan Layanan - SYH Cleaning',
            'services' => $services,
        ];

        return view('pages/booking', $data);
    }

    // Quick booking (langsung checkout tanpa cart)
    public function quickBooking()
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if (!$user) {
            return redirect()->to('/login')->with('error', 'User tidak ditemukan');
        }

        // Cek jika admin, redirect ke admin dashboard
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin')->with('error', 'Admin tidak bisa membuat booking dari sini');
        }

        // aAmbil layanan berdasarkan kode layanan dari query parameter
        $serviceCode = $this->request->getGet('service');
        if (!$serviceCode) {
            return redirect()->to('/')->with('error', 'Layanan tidak ditemukan');
        }

        // Ambil detail layanan
        $service = $this->db->table('services')
            ->where('kode_layanan', $serviceCode)
            ->where('aktif', 1)
            ->get()
            ->getRowArray();

        if (!$service) {
            return redirect()->to('/')->with('error', 'Layanan tidak ditemukan');
        }

        $data = [
            'title' => 'Booking Langsung - SYH Cleaning',
            'service' => $service,
            'user' => $user,
        ];

        return view('pages/quick_booking', $data);
    }

    // Proses quick booking
    public function submitQuickBooking()
    {
        $user_id = session()->get('user_id');
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();

        // Cek jika admin, redirect ke admin dashboard
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin')->with('error', 'Admin tidak bisa membuat booking dari sini');
        }

        // Validasi upload foto sepatu
        $validationRule = [
            'shoe_photo' => [
                'label' => 'Foto Sepatu',
                'rules' => 'uploaded[shoe_photo]'
                    . '|is_image[shoe_photo]'
                    . '|mime_in[shoe_photo,image/jpg,image/jpeg,image/png]'
                    . '|max_size[shoe_photo,5120]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Foto sepatu wajib diupload (format PNG/JPG/JPEG, maksimal 5MB)');
        }

        // Handle upload foto sepatu
        $file = $this->request->getFile('shoe_photo');
        $fileName = null;
        
        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $file->move($uploadPath, $fileName);
        }

        $serviceCode = $this->request->getPost('service');
        $shoe_condition = $this->request->getPost('shoe_condition');
        $quantity = $this->request->getPost('quantity');
        $delivery_date = $this->request->getPost('delivery_date');
        $booking_time = $this->request->getPost('booking_time');
        $delivery_option = $this->request->getPost('delivery_option');
        $delivery_address = $this->request->getPost('delivery_address') ?? $user['alamat'];
        $notes = $this->request->getPost('notes');

        // Ambil detail layanan (nama dan harga)
        $serviceDetails = $this->db->table('services')->where('kode_layanan', $serviceCode)->get()->getRowArray();
        if (!$serviceDetails) {
            return redirect()->back()
                ->with('error', 'Layanan tidak ditemukan');
        }
        
        $serviceName = $serviceDetails['nama_layanan'];
        $servicePrice = $serviceDetails['harga_dasar'];
        
        // Hitung biaya berdasarkan opsi pengiriman dan jumlah sepatu
        $delivery_fee = 0;
        
        // Tambah biaya untuk pengiriman rumah jika hanya 1 sepatu (gratis untuk 2 atau lebih)
        if ($delivery_option === 'home' && $quantity == 1) {
            $delivery_fee = 5000;
        }
        
        // Tambah biaya pickup untuk 1 sepatu (gratis untuk 2 atau lebih)
        if ($delivery_option === 'pickup' && $quantity == 1) {
            $delivery_fee += 5000;
        }
        
        $subtotal = $servicePrice * $quantity;
        $fridayDiscount = $this->getFridayDiscount($delivery_date);
        $total = max(0, $subtotal + $delivery_fee - $fridayDiscount);

        // Simpan booking langsung
        $booking_data = [
            'id_user' => $user_id,
            'layanan' => $serviceName,
            'kondisi_sepatu' => $shoe_condition,
            'jumlah' => $quantity,
            'tanggal_kirim' => $delivery_date,
            'jam_booking' => $booking_time,
            'foto_sepatu' => $fileName,
            'opsi_kirim' => $delivery_option,
            'alamat_kirim' => $delivery_address,
            'catatan' => $notes,
            'subtotal' => $subtotal,
            'biaya_kirim' => $delivery_fee,
            'total' => $total,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('bookings')->insert($booking_data);
        $booking_id = $this->db->insertID();

        // Buat notifikasi untuk semua admin
        $admins = $this->db->table('users')->where('role', 'admin')->get()->getResultArray();
        
        foreach ($admins as $admin) {
            $this->db->table('notifications')->insert([
                'id_user' => $admin['id'],
                'booking_id' => $booking_id,
                'judul' => 'Pesanan Baru!',
                'pesan' => "Ada pesanan baru dari pelanggan dengan ID #{$booking_id}. Layanan: {$serviceName}, Jumlah: {$quantity} pasang sepatu.",
                'tipe' => 'new_booking',
                'dibaca' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->to('/my-bookings')->with('success', 'Pesanan berhasil dibuat! Pesanan Anda akan segera diproses.');
    }

    // Submit Booking
    public function submitBooking()
    {
        try {
            $user_id = session()->get('user_id');
            if (!$user_id) {
                return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
            }

            $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
            if (!$user) {
                return redirect()->to('/login')->with('error', 'User tidak ditemukan');
            }

            // Cek jika admin, redirect ke admin dashboard
            if ($user['role'] === 'admin') {
                return redirect()->to('/admin')->with('error', 'Admin tidak bisa membuat pesanan dari sini');
            }

            // Ambil data dari form
            $service = $this->request->getPost('service');
            $quantity = intval($this->request->getPost('quantity')) ?? 1;
            $delivery_date = $this->request->getPost('delivery_date');
            $booking_time = $this->request->getPost('booking_time');
            $item_entry_option = $this->request->getPost('item_entry_option');
            $pickup_address = $this->request->getPost('pickup_address');
            $delivery_option = $this->request->getPost('delivery_option');
            $delivery_address = $this->request->getPost('delivery_address');

            // Validasi semua field wajib diisi
            $validationRule = [
                'service' => 'required',
                'quantity' => 'required|numeric|greater_than[0]',
                'delivery_date' => 'required|valid_date[Y-m-d]',
                'booking_time' => 'required|regex_match[/^([01][0-9]|2[0-3]):[0-5][0-9]$/]',
                'item_entry_option' => 'required|in_list[dropoff,pickup]',
                'delivery_option' => 'required|in_list[pickup,delivery]',
                'shoe_photo' => [
                    'label' => 'Foto Sepatu',
                    'rules' => 'uploaded[shoe_photo]'
                        . '|is_image[shoe_photo]'
                        . '|mime_in[shoe_photo,image/jpg,image/jpeg,image/png]'
                        . '|max_size[shoe_photo,5120]', // 5MB in KB
                ],
            ];

            // Pesan error untuk validasi
            $errors = [
                'service' => 'Pilih layanan terlebih dahulu',
                'quantity' => 'Jumlah sepatu harus lebih dari 0',
                'delivery_date' => 'Tanggal masuk tidak valid',
                'booking_time' => 'Jam booking harus format HH:MM',
                'item_entry_option' => 'Pilih opsi barang masuk',
                'delivery_option' => 'Pilih opsi pengiriman',
                'shoe_photo' => [
                    'uploaded' => 'Foto sepatu wajib diupload',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'Format foto harus PNG, JPG, atau JPEG',
                    'max_size' => 'Ukuran foto maksimal 5 MB',
                ],
            ];

            // Validasi alamat pickup jika opsi barang masuk adalah pickup
            if ($item_entry_option === 'pickup') {
                $validationRule['pickup_address'] = 'required|min_length[10]';
                $errors['pickup_address'] = 'Alamat penjemputan minimal 10 karakter';
            }

            // Validasi alamat pengiriman jika opsi pengiriman adalah delivery
            if ($delivery_option === 'delivery') {
                $validationRule['delivery_address'] = 'required|min_length[10]';
                $errors['delivery_address'] = 'Alamat pengiriman minimal 10 karakter';
            }

            if (!$this->validate($validationRule, $errors)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }

            // Validasi tanggal pengiriman harus diisi hari ini atau ke depan
            if (strtotime($delivery_date) < strtotime(date('Y-m-d'))) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Tanggal pengiriman harus hari ini atau hari berikutnya');
            }

            // Handle upload file
            $file = $this->request->getFile('shoe_photo');
            $fileName = null;
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Buat nama yang unik
                $fileName = $file->getRandomName();
                // Pindahkan ke folder public/uploads
                $uploadPath = FCPATH . 'uploads';
                
                // Buat folder jika belum ada 
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                if ($file->move($uploadPath, $fileName) === false) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Gagal unggah foto sepatu. Coba lagi.');
                }
            }

            $shoe_condition = $this->request->getPost('shoe_condition');
            $notes = $this->request->getPost('notes');
            
            // Tentukan alamat pengiriman berdasarkan opsi pengiriman 
            if (!$delivery_address) {
                $delivery_address = $user['alamat'] ?? '';
            }

            // Ambil harga layanan 
            $servicePrice = $this->getServicePrice($service);
            if ($servicePrice === 0) {
                return redirect()->back()
                    ->with('error', 'Layanan tidak ditemukan');
            }
            
            // Ambil nama layanan 
            $serviceDetails = $this->db->table('services')->where('kode_layanan', $service)->get()->getRowArray();
            $serviceName = $serviceDetails['nama_layanan'] ?? $service;
            
            // Hitung biaya berdasarkan opsi pengiriman dan jumlah sepatu
            $delivery_fee = 0;
            
            // Tambah biaya untuk pengiriman rumah jika hanya 1 sepatu (gratis untuk 2 atau lebih)
            if ($delivery_option === 'delivery' && $quantity == 1) {
                $delivery_fee += 5000;
            }
            
            // Tambah biaya untuk penjemputan jika hanya 1 sepatu (gratis untuk 2 atau lebih)
            if ($item_entry_option === 'pickup' && $quantity == 1) {
                $delivery_fee += 5000;
            }
            
            $subtotal = $servicePrice * $quantity;
            $fridayDiscount = $this->getFridayDiscount($delivery_date);
            $total = max(0, $subtotal + $delivery_fee - $fridayDiscount);

            // Simpan booking 
            $booking_data = [
                'id_user' => $user_id,
                'layanan' => $serviceName,
                'kondisi_sepatu' => $shoe_condition,
                'jumlah' => $quantity,
                'tanggal_kirim' => $delivery_date,
                'jam_booking' => $booking_time,
                'foto_sepatu' => $fileName,
                'opsi_kirim' => $delivery_option,
                'opsi_barang_masuk' => $item_entry_option,
                'alamat_kirim' => $delivery_address,
                'alamat_penjemputan' => $pickup_address,
                'catatan' => $notes,
                'subtotal' => $subtotal,
                'biaya_kirim' => $delivery_fee,
                'total' => $total,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if (!$this->db->table('bookings')->insert($booking_data)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal menyimpan booking: ' . $this->db->error()['message']);
            }

            $booking_id = $this->db->insertID();

            // Buat notifikasi untuk semua admin
            $admins = $this->db->table('users')->where('role', 'admin')->get()->getResultArray();
            
            foreach ($admins as $admin) {
                $this->db->table('notifications')->insert([
                    'id_user' => $admin['id'],
                    'booking_id' => $booking_id,
                    'judul' => 'Pesanan Baru!',
                    'pesan' => "Ada Pesanan baru dari pelanggan dengan ID #{$booking_id}. Layanan: {$serviceName}, Jumlah: {$quantity} pasang sepatu.",
                    'tipe' => 'new_booking',
                    'dibaca' => 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }

            return redirect()->to('/my-bookings')->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            log_message('error', 'Booking Error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Detail booking
        public function detail($bookingId)
    {
        $user_id = session()->get('user_id');
        
        // Cek jika admin, redirect ke admin dashboard
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin/bookings/detail/' . $bookingId)->with('info', 'Gunakan dashboard admin untuk melihat detail booking.');
        }
        
        $booking = $this->db->table('bookings')
            ->where('id', $bookingId)
            ->where('id_user', $user_id)
            ->get()
            ->getRowArray();

        if (!$booking) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Ambil foto yang di upload
        $photos = $this->db->table('booking_photos')
            ->where('booking_id', $bookingId)
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Detail Pesanan - SYH Cleaning',
            'booking' => $booking,
            'photos' => $photos,
        ];

        return view('pages/booking_detail', $data);
    }

    // Batalkan booking
    public function cancelBooking($bookingId)
    {
        $user_id = session()->get('user_id');
        
        // Cek jika admin, redirect ke admin dashboard
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if ($user && $user['role'] === 'admin') {
            return redirect()->to('/admin')->with('error', 'Admin tidak bisa membatalkan booking melalui halaman ini');
        }
        
        $booking = $this->db->table('bookings')
            ->where('id', $bookingId)
            ->where('id_user', $user_id)
            ->get()
            ->getRowArray();

        if (!$booking) {
            return redirect()->to('/my-bookings')->with('error', 'Pesanan tidak ditemukan');
        }

        // Hanya boleh dibatalkan jika status masih pending
        if ($booking['status'] !== 'pending') {
            return redirect()->back()->with('error', 'Pesanan tidak bisa dibatalkan pada status ini');
        }

        // Ambil alasan pembatalan dari form
        $alasan_pembatalan = $this->request->getPost('alasan_pembatalan');
        
        // Validasi alasan pembatalan
        if (empty($alasan_pembatalan) || strlen(trim($alasan_pembatalan)) < 10) {
            return redirect()->back()->with('error', 'Alasan pembatalan minimal 10 karakter');
        }

        // Update booking dengan status batal dan alasan pembatalan
        $this->db->table('bookings')->update([
            'status' => 'batal',
            'alasan_pembatalan' => trim($alasan_pembatalan),
            'updated_at' => date('Y-m-d H:i:s')
        ], ['id' => $bookingId]);

        return redirect()->to('/my-bookings')->with('success', 'Pesanan berhasil dibatalkan');
    }

    // Ambil harga layanan
    private function getServicePrice($service)
    {
        // Ambil harga dari database berdasarkan kode layanan
        $serviceData = $this->db->table('services')
            ->where('kode_layanan', $service)
            ->where('aktif', 1)
            ->get()
            ->getRowArray();

        if ($serviceData) {
            return intval($serviceData['harga_dasar']);
        }

        // Fallback jika service tidak ditemukan
        return 0;
    }

    private function getFridayDiscount(?string $date): int
    {
        if (empty($date)) {
            return 0;
        }

        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return 0;
        }

        return ((int) date('N', $timestamp) === 5) ? 5000 : 0;
    }

    // Checkout dari cart
    public function checkout()
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if (!$user) {
            return redirect()->to('/login')->with('error', 'User tidak ditemukan');
        }

        // Cek jika admin
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin')->with('error', 'Admin tidak bisa membuat booking');
        }

        $data = [
            'title' => 'Checkout - SYH Cleaning',
            'user' => $user,
        ];

        return view('pages/checkout', $data);
    }

    // Proses checkout dari cart
    public function submitCheckout()
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek jika admin, redirect ke admin dashboard
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if ($user && $user['role'] === 'admin') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Admin tidak bisa membuat booking'
            ]);
        }

        // Ambil data dari form
        $items = json_decode($this->request->getPost('items'), true);
        $pickupDate = $this->request->getPost('pickup_date');
        $address = $this->request->getPost('address') ?? '';
        $notes = $this->request->getPost('notes') ?? '';
        $deliveryMethod = $this->request->getPost('delivery_method');

        // Handle upload foto sepatu (bisa multiple)
        $uploadedPhotos = [];
        
        // Coba ambil multiple files terlebih dahulu
        $photoFiles = $this->request->getFileMultiple('shoe_photos');
        
        // Jika tidak ada multiple files, coba ambil single file (untuk kompatibilitas dengan input file biasa)
        if (empty($photoFiles) || (count($photoFiles) === 1 && !$photoFiles[0]->isValid())) {
            $singleFile = $this->request->getFile('shoe_photos');
            if ($singleFile && $singleFile->isValid()) {
                $photoFiles = [$singleFile];
            } else {
                $photoFiles = [];
            }
        }
        
        if (!empty($photoFiles)) {
            foreach ($photoFiles as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    // Validate file
                    if ($file->getSize() > 5 * 1024 * 1024) { // 5MB max
                        continue;
                    }
                    
                    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if (!in_array($file->getMimeType(), $allowedTypes)) {
                        continue;
                    }
                    
                    // Buat nama file yang unik
                    $newName = $file->getRandomName();
                    
                    // Pindahkan file ke folder uploads
                    if ($file->move(FCPATH . 'uploads', $newName)) {
                        $uploadedPhotos[] = $newName;
                    }
                }
            }
        }
        
        if (empty($items)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak ada item untuk checkout'
            ]);
        }

        if (empty($pickupDate) || (empty($address) && $deliveryMethod !== 'langsung')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tanggal pickup dan alamat harus diisi'
            ]);
        }

        // Hitung total jumlah untuk perhitungan biaya
        $totalQuantity = 0;
        foreach ($items as $item) {
            $totalQuantity += intval($item['quantity']);
        }

        // Hitung biaya kirim berdasarkan metode pengiriman dan jumlah sepatu
        $biayaKirim = 0;
        if ($totalQuantity === 1) {
            // Rp 5,000 untuk pickup (dijemput)
            if (stripos($deliveryMethod, 'jemput') !== false) {
                $biayaKirim += 5000;
            }
            // Rp 5,000 untuk delivery (diantar)
            if (stripos($deliveryMethod, 'antar') !== false) {
                $biayaKirim += 5000;
            }
            // Possible values:
            // - langsung (antar sendiri + ambil sendiri) = 0
            // - dijemput (pickup only) = 5000
            // - diantar (delivery only) = 5000
            // - dijemput-diantar (pickup + delivery) = 10000
        }

        $fridayDiscountTotal = $this->getFridayDiscount($pickupDate);

        // Simpan setiap item sebagai booking terpisah
        $successCount = 0;
        $bookingIds = [];
        $remainingDiscount = $fridayDiscountTotal;
        $remainingItems = count($items);

        foreach ($items as $item) {
            $serviceCode = $item['service_code'];
            $quantity = intval($item['quantity']);
            $price = $this->getServicePrice($serviceCode);
            $subtotal = $price * $quantity;
            
            // Ambil nama layanan dari database
            $serviceData = $this->db->table('services')
                ->where('kode_layanan', $serviceCode)
                ->where('aktif', 1)
                ->get()
                ->getRowArray();
            
            $serviceName = $serviceData ? $serviceData['nama_layanan'] : $serviceCode;
            
            // Distribusikan biaya kirim secara proporsional jika ada lebih dari 1 item, jika hanya 1 item maka biaya kirim penuh
            $itemBiayaKirim = count($items) === 1 ? $biayaKirim : round($biayaKirim * ($quantity / $totalQuantity));

            // Diskon Jumat Rp5.000 per checkout dibagi ke item secara proporsional.
            $itemDiscount = 0;
            if ($fridayDiscountTotal > 0) {
                if ($remainingItems === 1) {
                    $itemDiscount = $remainingDiscount;
                } else {
                    $itemDiscount = (int) round($fridayDiscountTotal * ($quantity / $totalQuantity));
                    if ($itemDiscount > $remainingDiscount) {
                        $itemDiscount = $remainingDiscount;
                    }
                }
            }

            $remainingDiscount -= $itemDiscount;
            $remainingItems--;

            $total = max(0, $subtotal + $itemBiayaKirim - $itemDiscount);

            $bookingData = [
                'id_user' => $user_id,
                'layanan' => $serviceName,
                'jumlah' => $quantity,
                'subtotal' => $subtotal,
                'biaya_kirim' => $itemBiayaKirim,
                'total' => $total,
                'alamat_kirim' => $address,
                'tanggal_kirim' => $pickupDate,
                'opsi_kirim' => $deliveryMethod,
                'delivery_method' => $deliveryMethod,
                'catatan' => $notes,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s'),
            ];

            if ($this->db->table('bookings')->insert($bookingData)) {
                $successCount++;
                $bookingId = $this->db->insertID();
                $bookingIds[] = $bookingId;
                
                // Simpan foto yang terkait dengan booking ini 
                foreach ($uploadedPhotos as $photo) {
                    $this->db->table('booking_photos')->insert([
                        'booking_id' => $bookingId,
                        'photo_path' => $photo,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
                
                // Buat notifikasi untuk semua admin
                $admins = $this->db->table('users')->where('role', 'admin')->get()->getResultArray();
                
                foreach ($admins as $admin) {
                    $this->db->table('notifications')->insert([
                        'id_user' => $admin['id'],
                        'booking_id' => $bookingId,
                        'judul' => 'Pesanan Baru!',
                        'pesan' => "Ada Pesanan baru dari pelanggan dengan ID #{$bookingId}. Layanan: {$serviceName}, Jumlah: {$quantity} pasang sepatu.",
                        'tipe' => 'new_booking',
                        'dibaca' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        if ($successCount > 0) {
            return $this->response->setJSON([
                'success' => true,
                'message' => "$successCount pesanan berhasil dibuat",
                'booking_ids' => $bookingIds
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal membuat Booking'
            ]);
        }
    }
}

