<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use Config\Database;

class Bookings extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index()
    {
        // Cek login dan role admin
        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $user = $this->db->table('users')->where('id', $user_id)->get()->getRow();
        if (!$user || $user->role !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak. Anda bukan admin.');
        }

        $status = $this->request->getVar('status');
        $search = $this->request->getVar('search');

        $query = $this->db->table('bookings')
            ->select('bookings.*, users.nama_lengkap as full_name, users.email, users.no_hp')
            ->join('users', 'bookings.id_user = users.id');

        if ($status) {
            $query->where('bookings.status', $status);
        }

        if ($search) {
            $query->groupStart()
                ->like('users.nama_lengkap', $search)
                ->orLike('users.email', $search)
                ->orLike('bookings.layanan', $search)
                ->groupEnd();
        }

        $bookings = $query->orderBy('bookings.dibuat_pada', 'DESC')
            ->get()
            ->getResultArray();
        
        // Map Indonesian columns to English for view
        foreach ($bookings as &$booking) {
            $booking['service'] = $booking['layanan'];
            $booking['created_at'] = $booking['dibuat_pada'];
        }

        $data = [
            'title' => 'Pesanan - Admin SYH Cleaning',
            'bookings' => $bookings,
            'status' => $status,
            'search' => $search,
        ];

        return view('admin/bookings', $data);
    }

    public function detail($id)
    {
        $booking = $this->db->table('bookings')
            ->select('bookings.*, users.nama_lengkap as full_name, users.email, users.no_hp as phone, users.alamat as address')
            ->join('users', 'bookings.id_user = users.id')
            ->where('bookings.id', $id)
            ->get()
            ->getRowArray();

        if (!$booking) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Map Indonesian columns to English for view compatibility
        $booking['service'] = $booking['layanan'];
        $booking['quantity'] = $booking['jumlah'];
        $booking['delivery_date'] = $booking['tanggal_kirim'];
        $booking['delivery_address'] = $booking['alamat_kirim'] ?? $booking['address'];
        $booking['notes'] = $booking['catatan'] ?? '';
        $booking['created_at'] = $booking['dibuat_pada'];
        $booking['city'] = '-';
        $booking['province'] = '-';
        $booking['zip_code'] = '-';
        $booking['shoe_type'] = $booking['tipe_sepatu'] ?? '-';
        $booking['shoe_condition'] = $booking['kondisi_sepatu'] ?? '-';
        $booking['delivery_option'] = $booking['opsi_kirim'] ?? '-';
        $booking['subtotal'] = $booking['subtotal'] ?? $booking['total'];
        $booking['delivery_fee'] = $booking['biaya_kirim'] ?? 0;

        $data = [
            'title' => 'Detail Pesanan - Admin SYH Cleaning',
            'booking' => $booking,
        ];

        return view('admin/booking_detail', $data);
    }

    public function updateStatus($id)
    {
        // Check if this is multipart form data (file upload)
        $contentType = $this->request->getHeaderLine('Content-Type');
        
        if (strpos($contentType, 'multipart/form-data') !== false) {
            // Handle file upload (POST request)
            $status = $this->request->getPost('status');
            $alasan = $this->request->getPost('alasan_penolakan');
        } else {
            // Handle JSON (PUT request)
            $json = $this->request->getJSON(true);
            $status = $json['status'] ?? $this->request->getPost('status');
            $alasan = $json['alasan_penolakan'] ?? $this->request->getPost('alasan_penolakan');
        }

        // Get current booking
        $booking = $this->db->table('bookings')->where('id', $id)->get()->getRowArray();
        
        if (!$booking) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Booking tidak ditemukan'
            ]);
        }

        $currentStatus = $booking['status'];
        
        // Validasi status flow - harus urut, tidak bisa dilompati
        $validTransitions = [
            'pending' => ['disetujui', 'ditolak'],   // pending bisa ke disetujui atau ditolak
            'disetujui' => ['proses'],               // disetujui hanya bisa ke proses
            'proses' => ['selesai'],                 // proses hanya bisa ke selesai
            'selesai' => [],                         // selesai tidak bisa diubah (status final)
            'ditolak' => []                          // ditolak tidak bisa diubah (status final)
        ];

        // Check if current status exists in valid transitions
        if (!isset($validTransitions[$currentStatus])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Status booking tidak valid'
            ]);
        }

        // Check if status is final (selesai or ditolak)
        if ($currentStatus === 'selesai' || $currentStatus === 'ditolak') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Status sudah final, tidak dapat diubah lagi'
            ]);
        }

        // Check if transition is allowed (tidak bisa melompati status)
        if (!in_array($status, $validTransitions[$currentStatus])) {
            $errorMessages = [
                'pending' => 'Dari status Menunggu hanya bisa disetujui atau ditolak',
                'disetujui' => 'Dari status Disetujui harus diproses terlebih dahulu, tidak bisa langsung selesai',
                'proses' => 'Dari status Proses hanya bisa ditandai selesai'
            ];
            
            $message = $errorMessages[$currentStatus] ?? 'Perubahan status tidak valid. Status harus urut: Menunggu → Disetujui → Proses → Selesai';
            
            return $this->response->setJSON([
                'success' => false,
                'message' => $message
            ]);
        }

        // Jika status ditolak, alasan harus diisi
        if ($status === 'ditolak' && empty($alasan)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Alasan penolakan harus diisi'
            ]);
        }

        // Initialize foto hasil variable
        $newName = null;
        
        // Jika status selesai, foto hasil harus diupload
        if ($status === 'selesai') {
            $foto_hasil = $this->request->getFile('foto_hasil');
            
            if (!$foto_hasil) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Foto hasil cucian tidak ditemukan. Pastikan Anda memilih foto.'
                ]);
            }

            if (!$foto_hasil->isValid()) {
                $error = $foto_hasil->getErrorString();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Error upload foto: ' . $error
                ]);
            }

            // Validate file type
            $mimeType = $foto_hasil->getClientMimeType();
            if (!in_array($mimeType, ['image/jpeg', 'image/jpg', 'image/png'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Format foto harus JPG, JPEG, atau PNG. File Anda: ' . $mimeType
                ]);
            }

            // Validate file size (max 5MB)
            $fileSize = $foto_hasil->getSizeByUnit('mb');
            if ($fileSize > 5) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Ukuran foto maksimal 5MB. File Anda: ' . round($fileSize, 2) . ' MB'
                ]);
            }

            // Upload foto
            try {
                $newName = $foto_hasil->getRandomName();
                $foto_hasil->move(FCPATH . 'uploads/', $newName);
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal upload foto: ' . $e->getMessage()
                ]);
            }
        }

        // Update status
        $updateData = ['status' => $status];
        
        if ($status === 'ditolak') {
            $updateData['alasan_penolakan'] = $alasan;
        }

        if ($status === 'selesai' && $newName !== null) {
            $updateData['foto_hasil'] = $newName;
        }

        $this->db->table('bookings')->where('id', $id)->update($updateData);

        // Create notification for customer
        $notificationData = [
            'id_user' => $booking['id_user'],
            'booking_id' => $id,
            'tipe' => 'status_update'
        ];

        switch ($status) {
            case 'disetujui':
                $notificationData['judul'] = 'Booking Disetujui! ✅';
                $notificationData['pesan'] = "Booking ID #{$id} telah disetujui oleh admin. Sepatu Anda akan segera diproses.";
                break;
            case 'proses':
                $notificationData['judul'] = 'Sepatu Sedang Diproses 🧼';
                $notificationData['pesan'] = "Booking ID #{$id} sedang dalam proses pencucian. Mohon ditunggu ya!";
                break;
            case 'selesai':
                $notificationData['judul'] = 'Sepatu Sudah Selesai! 🎉';
                $notificationData['pesan'] = "Booking ID #{$id} sudah selesai dicuci. Silakan lihat hasilnya dan ambil sepatu Anda di SYH.CLEANING. Terima kasih!";
                if (isset($newName)) {
                    $notificationData['foto_hasil'] = $newName;
                }
                break;
            case 'ditolak':
                $notificationData['judul'] = 'Booking Ditolak ❌';
                $notificationData['pesan'] = "Booking ID #{$id} ditolak oleh admin. Alasan: {$alasan}";
                break;
        }

        $this->db->table('notifications')->insert($notificationData);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Status berhasil diubah',
            'show_whatsapp' => ($status === 'selesai') // Show WA button if completed
        ]);
    }

    public function delete($id)
    {
        $booking = $this->db->table('bookings')->where('id', $id)->get()->getRowArray();
        
        if (!$booking) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false, 
                'message' => 'Booking not found'
            ]);
        }

        // Delete associated photo if exists
        if (!empty($booking['foto_sepatu'])) {
            $photoPath = FCPATH . 'uploads/' . $booking['foto_sepatu'];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $this->db->table('bookings')->where('id', $id)->delete();

        return $this->response->setJSON([
            'success' => true, 
            'message' => 'Booking deleted successfully'
        ]);
    }
}
