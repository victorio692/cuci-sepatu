<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Notifications extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return redirect()->to('/login');
        }

        $notifications = $this->db->table('notifications')
            ->where('id_user', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit(50)
            ->get()
            ->getResultArray();

        return view('pages/notifications', [
            'notifications' => $notifications
        ]);
    }

    public function getUnread()
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return $this->response->setJSON(['count' => 0, 'notifications' => []]);
        }

        $count = $this->db->table('notifications')
            ->where('id_user', $userId)
            ->where('dibaca', 0)
            ->countAllResults();

        $notifications = $this->db->table('notifications')
            ->where('id_user', $userId)
            ->where('dibaca', 0)
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'count' => $count,
            'notifications' => $notifications
        ]);
    }

    public function markAsRead($id)
    {
        $userId = session()->get('user_id');
        
        $notification = $this->db->table('notifications')
            ->where('id', $id)
            ->where('id_user', $userId)
            ->get()
            ->getRowArray();

        if (!$notification) {
            return $this->response->setJSON(['success' => false, 'message' => 'Notification not found']);
        }

        $this->db->table('notifications')
            ->where('id', $id)
            ->update(['dibaca' => 1]);

        return $this->response->setJSON(['success' => true]);
        
    }

    public function markAllAsRead()
    {
        $userId = session()->get('user_id');
        
        $this->db->table('notifications')
            ->where('id_user', $userId)
            ->where('dibaca', 0)
            ->update(['dibaca' => 1]);

        return $this->response->setJSON(['success' => true]);
    }

    private function generateWhatsAppMessage($booking, $bookingId, $deliveryType = 'pickup')
    {
        $message = "Halo {$booking['nama_lengkap']},\n\n";
        $message .= "Sepatu Anda dengan ID Pesanan #{$bookingId} sudah selesai dicuci!\n\n";
        $message .= "Layanan: {$booking['layanan']}\n";
        $message .= "Jumlah: {$booking['jumlah']} pasang\n";
        $message .= "Total: Rp " . number_format($booking['total'], 0, ',', '.') . "\n\n";
        
        
        if ($deliveryType === 'diantar' || $deliveryType === 'delivery') {
            $message .= "Sepatu Anda akan kami antar ke alamat Anda.\n";
            $message .= "Silakan tunggu konfirmasi jadwal pengiriman dari kami.\n\n";
        } else {
            
            $message .= "Silakan ambil sepatu Anda di SYH.CLEANING.\n\n";
        }
        
        $message .= "Terima kasih!";
        
        return $message;
    }

    public function sendWhatsApp($bookingId)
    {
        $userId = session()->get('user_id');
        
        if (!$userId) {
            return $this->response->setStatusCode(401)->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

       
        $isAdmin = session()->get('role') === 'admin' || session()->get('is_admin') === true;

        if (!$isAdmin) {
            $user = $this->db->table('users')
                ->select('role')
                ->where('id', $userId)
                ->get()
                ->getRowArray();

            $isAdmin = $user && $user['role'] === 'admin';
        }

        if (!$isAdmin) {
            return $this->response->setStatusCode(403)->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $booking = $this->db->table('bookings')
            ->select('bookings.*, users.nama_lengkap, users.no_hp')
            ->join('users', 'bookings.id_user = users.id')
            ->where('bookings.id', $bookingId)
            ->get()
            ->getRowArray();

        if (!$booking) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pesanan tidak ditemukan']);
        }

        $phone = $booking['no_hp'];
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        $deliveryType = isset($booking['opsi_kirim']) ? $booking['opsi_kirim'] : 'pickup';

        $message = $this->generateWhatsAppMessage($booking, $bookingId, $deliveryType);

        $waLink = "https://wa.me/" . $phone . "?text=" . urlencode($message);

        return $this->response->setJSON([
            'success' => true,
            'whatsapp_link' => $waLink
        ]);
    }
}
