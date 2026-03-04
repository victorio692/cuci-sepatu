<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class BookingApi extends BaseController
{
    use ResponseTrait;
    
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function create()
    {
        // Check authentication
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return $this->failUnauthorized('Silakan login terlebih dahulu');
        }

        // Get user data
        $user = $this->db->table('users')
            ->select('id, role')
            ->where('id', $user_id)
            ->get()
            ->getRowArray();
        if (!$user) {
            return $this->failUnauthorized('User tidak ditemukan');
        }

        // Check if admin
        if ($user['role'] === 'admin') {
            return $this->failForbidden('Admin tidak bisa membuat booking melalui API ini');
        }

        // Get JSON input
        $json = $this->request->getJSON(true);
        
        // Validation rules
        $rules = [
            'layanan' => 'required|alpha_dash',
            'jumlah' => 'required|integer|greater_than[0]',
            'tanggal_kirim' => 'required|valid_date[Y-m-d]',
            'jam_booking' => 'required|regex_match[/^([01][0-9]|2[0-3]):[0-5][0-9]$/]',
            'opsi_kirim' => 'required|in_list[pickup,delivery,home]',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // Get request data
        $layanan = $json['layanan'] ?? '';
        $kondisi_sepatu = $json['kondisi_sepatu'] ?? 'normal';
        $jumlah = intval($json['jumlah']);
        $tanggal_kirim = $json['tanggal_kirim'];
        $jam_booking = $json['jam_booking'];
        $opsi_kirim = $json['opsi_kirim'];
        $alamat_kirim = $json['alamat_kirim'] ?? $user['alamat'] ?? '';
        $catatan = $json['catatan'] ?? '';

        // Validate delivery address if needed
        if ($opsi_kirim === 'delivery' || $opsi_kirim === 'home') {
            if (empty($alamat_kirim) || strlen($alamat_kirim) < 10) {
                return $this->fail('Alamat kirim minimal 10 karakter untuk opsi delivery');
            }
        }

        // Validate booking time (12:00 - 23:59)
        [$hours, $minutes] = explode(':', $jam_booking);
        $hours = (int)$hours;
        if ($hours < 12 || $hours > 23) {
            return $this->fail('Jam booking harus antara 12:00 - 23:59');
        }

        // Validate delivery date
        if (strtotime($tanggal_kirim) < strtotime(date('Y-m-d'))) {
            return $this->fail('Tanggal pengiriman harus hari ini atau hari berikutnya');
        }

        // Handle file upload (foto sepatu)
        $fileName = null;
        $file = $this->request->getFile('foto_sepatu');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validate file
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return $this->fail('Format foto harus JPG, JPEG, atau PNG');
            }

            // Max 5MB
            if ($file->getSize() > 5 * 1024 * 1024) {
                return $this->fail('Ukuran foto maksimal 5MB');
            }

            // Upload file
            $fileName = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $file->move($uploadPath, $fileName);
        }

        // Get service price
        $serviceData = $this->db->table('services')
            ->where('kode_layanan', $layanan)
            ->where('aktif', 1)
            ->get()
            ->getRowArray();

        if (!$serviceData) {
            return $this->failNotFound('Layanan tidak ditemukan atau tidak aktif');
        }

        $harga_dasar = intval($serviceData['harga_dasar']);
        $namaLayanan = $serviceData['nama_layanan'];
        $subtotal = $harga_dasar * $jumlah;

        // Calculate additional fees
        $biaya_kirim = 0;
        
        // Delivery charge (only for 1 shoe, free for 2+)
        if (($opsi_kirim === 'delivery' || $opsi_kirim === 'home') && $jumlah == 1) {
            $biaya_kirim = 5000;
        } elseif ($opsi_kirim === 'pickup' && $jumlah == 1) {
            // Single shoe pickup charge
            $biaya_kirim = 5000;
        }

        $total = $subtotal + $biaya_kirim;

        // Insert booking
        $booking_data = [
            'id_user' => $user_id,
            'layanan' => $namaLayanan,
            'kondisi_sepatu' => $kondisi_sepatu,
            'jumlah' => $jumlah,
            'tanggal_kirim' => $tanggal_kirim,
            'jam_booking' => $jam_booking,
            'foto_sepatu' => $fileName,
            'opsi_kirim' => $opsi_kirim,
            'alamat_kirim' => $alamat_kirim,
            'catatan' => $catatan,
            'subtotal' => $subtotal,
            'biaya_kirim' => $biaya_kirim,
            'total' => $total,
            'status' => 'pending',
            'dibuat_pada' => date('Y-m-d H:i:s'),
            'diupdate_pada' => date('Y-m-d H:i:s'),
        ];

        try {
            $this->db->table('bookings')->insert($booking_data);
            $booking_id = $this->db->insertID();

            // Create notification for all admins
            $admins = $this->db->table('users')->where('role', 'admin')->get()->getResultArray();
            
            $pelangganName = $user['nama'] ?? $user['username'] ?? $user['email'] ?? 'pelanggan';
            
            foreach ($admins as $admin) {
                $this->db->table('notifications')->insert([
                    'id_user' => $admin['id'],
                    'booking_id' => $booking_id,
                    'judul' => 'Booking Baru!',
                    'pesan' => "Ada booking baru dari pelanggan {$pelangganName} dengan ID #{$booking_id}. Layanan: {$namaLayanan}, Jumlah: {$jumlah} pasang sepatu.",
                    'tipe' => 'new_booking',
                    'dibaca' => 0,
                    'dibuat_pada' => date('Y-m-d H:i:s')
                ]);
            }

            // Get created booking
            $booking = $this->db->table('bookings')->where('id', $booking_id)->get()->getRowArray();

            return $this->respondCreated([
                'success' => true,
                'message' => 'Booking berhasil dibuat',
                'data' => [
                    'booking_id' => $booking_id,
                    'booking' => $booking
                ]
            ]);

        } catch (\Exception $e) {
            return $this->failServerError('Gagal membuat booking: ' . $e->getMessage());
        }
    }

    /**
     * Get customer bookings
     * GET /api/booking/my-bookings
     */
    public function myBookings()
    {
        log_message('debug', '✅ BookingApi::myBookings called');
        
        $user_id = session()->get('user_id');
        log_message('debug', '📌 BookingApi::myBookings - User ID from session: ' . ($user_id ?? 'NULL'));
        
        if (!$user_id) {
            log_message('debug', '❌ BookingApi::myBookings - No user_id in session');
            return $this->failUnauthorized('Silakan login terlebih dahulu');
        }

        $user = $this->db->table('users')->where('id', $user_id)->get()->getRowArray();
        if (!$user || $user['role'] === 'admin') {
            log_message('debug', '❌ BookingApi::myBookings - User validation failed. User exists: ' . (!!$user ? 'yes' : 'no') . ', Role: ' . ($user['role'] ?? 'N/A'));
            return $this->failForbidden('Akses ditolak');
        }
        
        log_message('debug', '✅ BookingApi::myBookings - User validated. Email: ' . ($user['email'] ?? 'N/A') . ', Role: ' . $user['role']);

        // Get query parameters
        $status = $this->request->getGet('status');
        $limit = $this->request->getGet('limit') ?? 20;
        $offset = $this->request->getGet('offset') ?? 0;

        // Get all bookings for status counts
        $allBookings = $this->db->table('bookings')
            ->where('id_user', $user_id)
            ->get()
            ->getResultArray();

        // Count bookings by status
        $statusCounts = [
            'pending' => 0,
            'disetujui' => 0,
            'proses' => 0,
            'selesai' => 0,
            'batal' => 0,
            'ditolak' => 0,
        ];

        foreach ($allBookings as $booking) {
            if (isset($statusCounts[$booking['status']])) {
                $statusCounts[$booking['status']]++;
            }
        }

        $builder = $this->db->table('bookings')
            ->where('id_user', $user_id);

        if ($status) {
            $builder->where('status', $status);
        }

        $total = $builder->countAllResults(false);
        
        $bookings = $builder->orderBy('dibuat_pada', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();

        // Debug logging
        log_message('debug', '📌 BookingApi::myBookings - User ID: ' . $user_id);
        log_message('debug', '📌 BookingApi::myBookings - Status filter: ' . ($status ?? 'none'));
        log_message('debug', '📌 BookingApi::myBookings - Found bookings: ' . count($bookings));
        log_message('debug', '📌 BookingApi::myBookings - Status counts: ' . json_encode($statusCounts));
        if (count($bookings) > 0) {
            log_message('debug', '📌 BookingApi::myBookings - First booking: ' . json_encode($bookings[0]));
        }

        return $this->respond([
            'success' => true,
            'bookings' => $bookings,
            'status_counts' => $statusCounts,
            'total' => $total,
            'limit' => $limit,
            'offset' => $offset
        ]);
    }

    /**
     * Get booking detail
     * GET /api/booking/detail/{id}
     */
    public function detail($id)
    {
        try {
            $user_id = session()->get('user_id');
            if (!$user_id) {
                return $this->failUnauthorized('Silakan login terlebih dahulu');
            }

            // Validate booking ID
            if (!is_numeric($id) || $id <= 0) {
                return $this->fail('ID booking tidak valid');
            }

            $booking = $this->db->table('bookings')
                ->where('id', $id)
                ->where('id_user', $user_id)
                ->get()
                ->getRowArray();

            if (!$booking) {
                return $this->failNotFound('Booking tidak ditemukan atau bukan milik Anda');
            }

           
            $photos = [];
            try {
                $photos = $this->db->table('booking_photos')
                    ->where('booking_id', $id)
                    ->get()
                    ->getResultArray();
            } catch (\Exception $e) {
                
                $photos = [];
            }

            return $this->respond([
                'success' => true,
                'data' => [
                    'booking' => $booking,
                    'photos' => $photos
                ]
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('Gagal mengambil detail booking: ' . $e->getMessage());
        }
    }

    public function cancel($id)
    {
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return $this->failUnauthorized('Silakan login terlebih dahulu');
        }

        $booking = $this->db->table('bookings')
            ->where('id', $id)
            ->where('id_user', $user_id)
            ->get()
            ->getRowArray();

        if (!$booking) {
            return $this->failNotFound('Booking tidak ditemukan');
        }

        if ($booking['status'] !== 'pending') {
            return $this->fail('Booking tidak bisa dibatalkan pada status ini');
        }

        $json = $this->request->getJSON(true);
        $alasan_pembatalan = $json['alasan_pembatalan'] ?? '';

        if (strlen(trim($alasan_pembatalan)) < 10) {
            return $this->fail('Alasan pembatalan minimal 10 karakter');
        }

        $this->db->table('bookings')->update([
            'status' => 'batal',
            'alasan_pembatalan' => trim($alasan_pembatalan),
            'diupdate_pada' => date('Y-m-d H:i:s')
        ], ['id' => $id]);

        return $this->respond([
            'success' => true,
            'message' => 'Booking berhasil dibatalkan'
        ]);
    }
}