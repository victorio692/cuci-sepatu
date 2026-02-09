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

    // Show Booking Form
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

        // Get services dari database
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

    // Quick Booking - Direct checkout without cart
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

        // Get service from query parameter
        $serviceCode = $this->request->getGet('service');
        if (!$serviceCode) {
            return redirect()->to('/')->with('error', 'Layanan tidak ditemukan');
        }

        // Get service details
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

    // Submit Quick Booking
    public function submitQuickBooking()
    {
        $user_id = session()->get('user_id');
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();

        // Validate file upload
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

        // Handle file upload
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

        $service = $this->request->getPost('service');
        $shoe_condition = $this->request->getPost('shoe_condition');
        $quantity = $this->request->getPost('quantity');
        $delivery_date = $this->request->getPost('delivery_date');
        $booking_time = $this->request->getPost('booking_time');
        $delivery_option = $this->request->getPost('delivery_option');
        $delivery_address = $this->request->getPost('delivery_address') ?? $user['alamat'];
        $notes = $this->request->getPost('notes');

        // Get service price
        $servicePrice = $this->getServicePrice($service);
        $delivery_fee = $delivery_option === 'home' ? 5000 : 0;
        $subtotal = $servicePrice * $quantity;
        $total = $subtotal + $delivery_fee;

        // Insert booking directly
        $booking_data = [
            'id_user' => $user_id,
            'layanan' => $service,
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
            'dibuat_pada' => date('Y-m-d H:i:s'),
            'diupdate_pada' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('bookings')->insert($booking_data);
        $booking_id = $this->db->insertID();

        // Create notification for all admins
        $admins = $this->db->table('users')->where('role', 'admin')->get()->getResultArray();
        
        foreach ($admins as $admin) {
            $this->db->table('notifications')->insert([
                'id_user' => $admin['id'],
                'booking_id' => $booking_id,
                'judul' => 'Booking Baru! 🔔',
                'pesan' => "Ada booking baru dari customer dengan ID #{$booking_id}. Layanan: {$service}, Jumlah: {$quantity} pasang sepatu.",
                'tipe' => 'new_booking',
                'dibaca' => 0,
                'dibuat_pada' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->to('/my-bookings')->with('success', 'Booking berhasil dibuat! Pesanan Anda akan segera diproses.');
    }

    // Submit Booking
    public function submitBooking()
    {
        $user_id = session()->get('user_id');
        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();

        // Validate file upload
        $validationRule = [
            'shoe_photo' => [
                'label' => 'Foto Sepatu',
                'rules' => 'uploaded[shoe_photo]'
                    . '|is_image[shoe_photo]'
                    . '|mime_in[shoe_photo,image/jpg,image/jpeg,image/png]'
                    . '|max_size[shoe_photo,5120]', // 5MB in KB
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Foto sepatu wajib diupload (format PNG/JPG/JPEG, maksimal 5MB)');
        }

        // Handle file upload
        $file = $this->request->getFile('shoe_photo');
        $fileName = null;
        
        if ($file->isValid() && !$file->hasMoved()) {
            // Generate unique filename
            $fileName = $file->getRandomName();
            // Move to public/uploads directory
            $uploadPath = FCPATH . 'uploads';
            
            // Create directory if not exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $file->move($uploadPath, $fileName);
        }

        $service = $this->request->getPost('service');
        $shoe_condition = $this->request->getPost('shoe_condition');
        $quantity = $this->request->getPost('quantity');
        $delivery_date = $this->request->getPost('delivery_date');
        $booking_time = $this->request->getPost('booking_time');
        $delivery_option = $this->request->getPost('delivery_option');
        $delivery_address = $this->request->getPost('delivery_address') ?? $user['alamat'];
        $notes = $this->request->getPost('notes');

        // Get service price
        $servicePrice = $this->getServicePrice($service);
        $delivery_fee = $delivery_option === 'home' ? 5000 : 0;
        $subtotal = $servicePrice * $quantity;
        $total = $subtotal + $delivery_fee;

        // Insert booking
        $booking_data = [
            'id_user' => $user_id,
            'layanan' => $service,
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
            'dibuat_pada' => date('Y-m-d H:i:s'),
            'diupdate_pada' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('bookings')->insert($booking_data);
        $booking_id = $this->db->insertID();

        // Create notification for all admins
        $admins = $this->db->table('users')->where('role', 'admin')->get()->getResultArray();
        
        foreach ($admins as $admin) {
            $this->db->table('notifications')->insert([
                'id_user' => $admin['id'],
                'booking_id' => $booking_id,
                'judul' => 'Booking Baru! 🔔',
                'pesan' => "Ada booking baru dari customer dengan ID #{$booking_id}. Layanan: {$service}, Jumlah: {$quantity} pasang sepatu.",
                'tipe' => 'new_booking',
                'dibaca' => 0,
                'dibuat_pada' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->to('/my-bookings')->with('success', 'Pesanan berhasil dibuat!');
    }

    // Booking Detail
    public function detail($bookingId)
    {
        $user_id = session()->get('user_id');
        
        $booking = $this->db->table('bookings')
            ->where('id', $bookingId)
            ->where('id_user', $user_id)
            ->get()
            ->getRowArray();

        if (!$booking) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Get uploaded photos
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

    // Cancel Booking
    public function cancelBooking($bookingId)
    {
        $user_id = session()->get('user_id');
        
        $booking = $this->db->table('bookings')
            ->where('id', $bookingId)
            ->where('id_user', $user_id)
            ->get()
            ->getRowArray();

        if (!$booking) {
            return redirect()->to('/my-bookings')->with('error', 'Pesanan tidak ditemukan');
        }

        // Only allow cancel if status is pending
        if ($booking['status'] !== 'pending') {
            return redirect()->back()->with('error', 'Pesanan tidak bisa dibatalkan pada status ini');
        }

        // Get alasan pembatalan from POST request
        $alasan_pembatalan = $this->request->getPost('alasan_pembatalan');
        
        // Validate alasan pembatalan
        if (empty($alasan_pembatalan) || strlen(trim($alasan_pembatalan)) < 10) {
            return redirect()->back()->with('error', 'Alasan pembatalan minimal 10 karakter');
        }

        // Update booking with status batal and alasan pembatalan
        $this->db->table('bookings')->update([
            'status' => 'batal',
            'alasan_pembatalan' => trim($alasan_pembatalan),
            'diupdate_pada' => date('Y-m-d H:i:s')
        ], ['id' => $bookingId]);

        return redirect()->to('/my-bookings')->with('success', 'Pesanan berhasil dibatalkan');
    }

    // Get Service Price
    private function getServicePrice($service)
    {
        // Get price from services table
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

    // Checkout from Cart
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

    // Submit Checkout
    public function submitCheckout()
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Get data from form
        $items = json_decode($this->request->getPost('items'), true);
        $pickupDate = $this->request->getPost('pickup_date');
        $address = $this->request->getPost('address') ?? '';
        $notes = $this->request->getPost('notes') ?? '';
        $deliveryMethod = $this->request->getPost('delivery_method');

        // Handle photo uploads
        $uploadedPhotos = [];
        $photoFiles = $this->request->getFileMultiple('shoe_photos');
        
        if ($photoFiles) {
            foreach ($photoFiles as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    // Validate file
                    if ($file->getSize() > 2 * 1024 * 1024) { // 2MB max
                        continue;
                    }
                    
                    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if (!in_array($file->getMimeType(), $allowedTypes)) {
                        continue;
                    }
                    
                    // Generate unique name
                    $newName = $file->getRandomName();
                    
                    // Move to public uploads folder
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

        // Insert each item as separate booking
        $successCount = 0;
        $bookingIds = [];

        foreach ($items as $item) {
            $serviceCode = $item['service_code'];
            $quantity = intval($item['quantity']);
            $price = $this->getServicePrice($serviceCode);
            $total = $price * $quantity;

            $bookingData = [
                'id_user' => $user_id,
                'layanan' => $serviceCode,
                'jumlah' => $quantity,
                'total' => $total,
                'alamat_kirim' => $address,
                'tanggal_kirim' => $pickupDate,
                'opsi_kirim' => $deliveryMethod,
                'delivery_method' => $deliveryMethod,
                'catatan' => $notes,
                'status' => 'pending',
                'dibuat_pada' => date('Y-m-d H:i:s'),
            ];

            if ($this->db->table('bookings')->insert($bookingData)) {
                $successCount++;
                $bookingId = $this->db->insertID();
                $bookingIds[] = $bookingId;
                
                // Save photos linked to this booking
                foreach ($uploadedPhotos as $photo) {
                    $this->db->table('booking_photos')->insert([
                        'booking_id' => $bookingId,
                        'photo_path' => $photo,
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

