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
        $status = $this->request->getVar('status');
        $search = $this->request->getVar('search');

        $query = $this->db->table('bookings')
            ->select('bookings.*, users.full_name, users.email, users.phone')
            ->join('users', 'bookings.user_id = users.id');

        if ($status) {
            $query->where('bookings.status', $status);
        }

        if ($search) {
            $query->groupStart()
                ->like('users.full_name', $search)
                ->orLike('users.email', $search)
                ->orLike('bookings.service', $search)
                ->groupEnd();
        }

        $bookings = $query->orderBy('bookings.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Pesanan - Admin SYH Cleaning',
            'bookings' => $bookings,
            'pager' => $this->db->pager,
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
        $json = $this->request->getJSON(true);
        $status = $json['status'] ?? $this->request->getPost('status');
        $alasan = $json['alasan_penolakan'] ?? $this->request->getPost('alasan_penolakan');

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

        // Update status
        $updateData = ['status' => $status];
        
        if ($status === 'ditolak') {
            $updateData['alasan_penolakan'] = $alasan;
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
                $notificationData['pesan'] = "Booking ID #{$id} sudah selesai dicuci. Silakan ambil sepatu Anda di SYH.CLEANING. Terima kasih!";
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
