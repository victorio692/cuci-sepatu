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
            ->orderBy('dibuat_pada', 'DESC')
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
            ->orderBy('dibuat_pada', 'DESC')
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

    public function sendWhatsApp($bookingId)
    {
        $userId = session()->get('user_id');
        $userRole = session()->get('role');

        if ($userRole !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        // Get booking and customer info
        $booking = $this->db->table('bookings')
            ->select('bookings.*, users.nama_lengkap, users.no_hp')
            ->join('users', 'bookings.id_user = users.id')
            ->where('bookings.id', $bookingId)
            ->get()
            ->getRowArray();

        if (!$booking) {
            return $this->response->setJSON(['success' => false, 'message' => 'Booking not found']);
        }

        // Format phone number (remove leading 0, add 62)
        $phone = $booking['no_hp'];
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // Create WhatsApp message
        $message = "Halo {$booking['nama_lengkap']},\n\n";
        $message .= "Sepatu Anda dengan booking ID #{$bookingId} sudah selesai dicuci! ✨\n\n";
        $message .= "Layanan: {$booking['layanan']}\n";
        $message .= "Jumlah: {$booking['jumlah_sepatu']} pasang\n";
        $message .= "Total: Rp " . number_format($booking['total'], 0, ',', '.') . "\n\n";
        $message .= "Silakan ambil sepatu Anda di SYH.CLEANING.\n\n";
        $message .= "Terima kasih! 🙏";

        $waLink = "https://wa.me/" . $phone . "?text=" . urlencode($message);

        return $this->response->setJSON([
            'success' => true,
            'whatsapp_link' => $waLink
        ]);
    }
}
